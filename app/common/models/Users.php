<?php

namespace PSMAS\Common\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * PSMAS\Common\Models\Users
 * All the users registered in the application
 */
class Users extends Model {

  /**
   * @var integer
   */
  public $id;

  /**
   * @var string
   */
  public $name;

  /**
   * @var string
   */
  public $email;

  /**
   * @var string
   */
  public $password;

  /**
   * @var boolean
   */
  public $mustChangePassword;

  /**
   * @var integer
   */
  public $profilesId;

  /**
   * @var boolean
   */
  public $banned;

  /**
   * @var boolean
   */
  public $suspended;

  /**
   * @var boolean
   */
  public $active;

  /**
   * Before create the user assign a password
   */
  public function beforeValidationOnCreate() {
    if (empty($this->password)) {
      // Generate a plain temporary password
      $tempPassword = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(12)));

      // The user must change its password in first login
      $this->mustChangePassword = 1;

      // Use this password as default
      $this->password = $this->getDI()
        ->getSecurity()
        ->hash($tempPassword);
    } else {
      // The user must not change its password in first login
      $this->mustChangePassword = 0;
    }

    // The account must be confirmed via e-mail
    // Only require this if emails are turned on in the config, otherwise account is automatically active
    if ($this->getDI()->get('config')->useMail) {
      $this->active = 0;
    } else {
      $this->active = 1;
    }

    // The account is not suspended by default
    $this->suspended = 0;

    // The account is not banned by default
    $this->banned = 0;
  }

  /**
   * Send a confirmation e-mail to the user if the account is not active
   */
  public function afterSave() {
    // Only send the confirmation email if emails are turned on in the config
    if ($this->getDI()->get('config')->useMail) {
      if ($this->active == false) {
        $emailConfirmation = new EmailConfirmations();
        $emailConfirmation->usersId = $this->id;
        if ($emailConfirmation->save()) {
          $this->getDI()
            ->getFlashSession()
            ->notice('A confirmation mail has been sent to ' . $this->email);
        }
      }
    }
  }

  /**
   * Validate that emails are unique across users
   */
  public function validation() {
    $validator = new Validation();

    $validator->add('email', new Uniqueness([
      "message" => "The email is already registered"
    ]));

    return $this->validate($validator);
  }

  public function initialize() {
    $this->belongsTo('profilesId', __NAMESPACE__ . '\Profiles', 'id', [
      'alias' => 'profile',
      'reusable' => true
    ]);

    $this->hasMany('id', __NAMESPACE__ . '\SuccessLogins', 'usersId', [
      'alias' => 'successLogins',
      'foreignKey' => [
        'message' => 'User cannot be deleted because he/she has activity in the system'
      ]
    ]);

    $this->hasMany('id', __NAMESPACE__ . '\PasswordChanges', 'usersId', [
      'alias' => 'passwordChanges',
      'foreignKey' => [
        'message' => 'User cannot be deleted because he/she has activity in the system'
      ]
    ]);

    $this->hasMany('id', __NAMESPACE__ . '\ResetPasswords', 'usersId', [
      'alias' => 'resetPasswords',
      'foreignKey' => [
        'message' => 'User cannot be deleted because he/she has activity in the system'
      ]
    ]);
  }
}
