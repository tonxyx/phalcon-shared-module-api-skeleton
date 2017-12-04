<?php

namespace PSMAS\Common\Library\Auth;

use Phalcon\Mvc\User\Component;
use PSMAS\Common\Models\Users;
use PSMAS\Common\Models\RememberTokens;
use PSMAS\Common\Models\SuccessLogins;
use PSMAS\Common\Models\FailedLogins;

/**
 * PSMAS\Common\Library\Auth\Auth
 * Manages Authentication/Identity Management in PSMAS
 */
class Auth extends Component {

  const REMEMBER_ME_USER = 'RememberMeUser';

  const REMEMBER_ME_TOKEN = 'RememberMeToken';

  /**
   * Checks the user credentials
   *
   * @param array $credentials
   *
   * @return boolean
   * @throws Exception
   */
  public function check ($credentials) {
    // Check if the user exist
    $user = Users::findFirstByEmail($credentials['email']);
    if ($user == false) {
      $this->registerUserThrottling(0);
      throw new Exception('Wrong email/password combination');
    }

    // Check the password
    if (!$this->security->checkHash($credentials['password'], $user->password)) {
      $this->registerUserThrottling($user->id);
      throw new Exception('Wrong email/password combination');
    }

    // Check if the user was flagged
    $this->checkUserFlags($user);

    // Register the successful login
    $this->saveSuccessLogin($user);

    // Check if the remember me was selected
    if (isset($credentials['remember'])) {
      $this->createRememberEnvironment($user);
    }

    $this->session->set('auth-identity', [
      'id' => $user->id,
      'name' => $user->name,
      'profile' => $user->profile->name,
    ]);
  }

  /**
   * Creates the remember me environment settings the related cookies and generating tokens
   *
   * @param \PSMAS\Common\Models\Users $user
   *
   * @throws Exception
   */
  public function saveSuccessLogin ($user) {
    $successLogin = new SuccessLogins();
    $successLogin->usersId = $user->id;
    $successLogin->ipAddress = $this->request->getClientAddress();
    $successLogin->userAgent = $this->request->getUserAgent();
    if (!$successLogin->save()) {
      $messages = $successLogin->getMessages();
      throw new Exception($messages[0]);
    }
  }

  /**
   * Implements login throttling
   * Reduces the effectiveness of brute force attacks
   *
   * @param int $userId
   */
  public function registerUserThrottling ($userId) {
    $failedLogin = new FailedLogins();
    $failedLogin->usersId = $userId;
    $failedLogin->ipAddress = $this->request->getClientAddress();
    $failedLogin->attempted = time();
    $failedLogin->save();

    $attempts = FailedLogins::count([
      'ipAddress = ?0 AND attempted >= ?1',
      'bind' => [
        $this->request->getClientAddress(),
        time() - 3600 * 6,
      ],
    ]);

    switch ($attempts) {
      case 1:
      case 2:
        // no delay
        break;
      case 3:
      case 4:
        sleep(2);
        break;
      default:
        sleep(4);
        break;
    }
  }

  /**
   * Creates the remember me environment settings the related cookies and generating tokens
   *
   * @param \PSMAS\Common\Models\Users $user
   */
  public function createRememberEnvironment (Users $user) {
    $userAgent = $this->request->getUserAgent();
    $token = md5($user->email . $user->password . $userAgent);

    $remember = new RememberTokens();
    $remember->usersId = $user->id;
    $remember->token = $token;
    $remember->userAgent = $userAgent;

    if ($remember->save() != false) {
      $expire = time() + 86400 * 8;
      $this->cookies->set(self::REMEMBER_ME_USER, $user->id, $expire);
      $this->cookies->set(self::REMEMBER_ME_TOKEN, $token, $expire);
    }
  }

  /**
   * Check if the session has a remember me cookie
   *
   * @return boolean
   */
  public function hasRememberMe () {
    return $this->cookies->has(self::REMEMBER_ME_USER);
  }

  /**
   * Logs on using the information in the cookies
   *
   * @return \Phalcon\Http\Response
   */
  public function loginWithRememberMe () {
    $userId = $this->cookies->get(self::REMEMBER_ME_USER)->getValue();
    $cookieToken = $this->cookies->get(self::REMEMBER_ME_TOKEN)->getValue();

    $user = Users::findFirstById($userId);
    if ($user) {
      $userAgent = $this->request->getUserAgent();
      $token = md5($user->email . $user->password . $userAgent);

      if ($cookieToken == $token) {
        $remember = RememberTokens::findFirst([
          'userId = ?0 AND token = ?1',
          'bind' => [
            $user->id,
            $token,
          ],
        ]);

        if ($remember) {
          // Check if the cookie has not expired
          if ((time() - (86400 * 8)) < $remember->createdAt) {

            // Check if the user was flagged
            $this->checkUserFlags($user);

            // Register identity
            $this->session->set('auth-identity', [
              'id' => $user->id,
              'name' => $user->name,
              'profile' => $user->profile->name,
            ]);

            // Register the successful login
            $this->saveSuccessLogin($user);

            return $this->response->redirect('users');
          }
        }
      }
    }

    $this->cookies->get(self::REMEMBER_ME_USER)->delete();
    $this->cookies->get(self::REMEMBER_ME_TOKEN)->delete();

    return $this->response->redirect('session/login');
  }

  /**
   * Checks if the user is banned/inactive/suspended
   *
   * @param \PSMAS\Common\Models\Users $user
   *
   * @throws Exception
   */
  public function checkUserFlags (Users $user) {
    if ($user->active != true) {
      throw new Exception('The user is inactive');
    }

    if ($user->banned != false) {
      throw new Exception('The user is banned');
    }

    if ($user->suspended != false) {
      throw new Exception('The user is suspended');
    }
  }

  /**
   * Returns the current identity
   *
   * @return array
   */
  public function getIdentity () {
    return $this->session->get('auth-identity');
  }

  /**
   * Returns the current identity
   *
   * @return string
   */
  public function getName () {
    $identity = $this->session->get('auth-identity');
    return $identity['name'];
  }

  /**
   * Removes the user identity information from session
   */
  public function remove () {
    if ($this->cookies->has(self::REMEMBER_ME_USER)) {
      $this->cookies->get(self::REMEMBER_ME_USER)->delete();
    }

    if ($this->cookies->has(self::REMEMBER_ME_TOKEN)) {
      $token = $this->cookies->get(self::REMEMBER_ME_TOKEN)->getValue();
      UserRememberTokens::findFirstByToken($token)->delete();

      $this->cookies->get(self::REMEMBER_ME_TOKEN)->delete();
    }

    $this->session->remove('auth-identity');
  }

  /**
   * Auths the user by his/her id
   *
   * @param int $id
   *
   * @throws Exception
   */
  public function authUserById ($id) {
    $user = Users::findFirstById($id);
    if ($user == false) {
      throw new Exception('The user does not exist');
    }

    $this->checkUserFlags($user);

    $this->session->set('auth-identity', [
      'id' => $user->id,
      'name' => $user->name,
      'profile' => $user->profile->name,
    ]);
  }

  /**
   * Get the entity related to user in the active identity
   *
   * @return \PSMAS\Models\Users
   * @throws Exception
   */
  public function getUser () {
    $identity = $this->session->get('auth-identity');
    if (isset($identity['id'])) {

      $user = Users::findFirstById($identity['id']);
      if ($user == false) {
        throw new Exception('The user does not exist');
      }

      return $user;
    }

    return false;
  }
}
