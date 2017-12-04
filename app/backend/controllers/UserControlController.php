<?php

namespace PSMAS\Backend\Controllers;

use PSMAS\Common\Models\EmailConfirmations;
use PSMAS\Common\Models\ResetPasswords;

/**
 * UserControlController
 * Provides help to users to confirm their passwords or reset them
 */
class UserControlController extends ControllerBase {

    public function initialize() {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
    }

    public function indexAction() {

    }

    /**
     * Confirms an e-mail, if the user must change thier password then changes it
     */
    public function confirmEmailAction()
    {
        $code = $this->dispatcher->getParam('code');

        $confirmation = EmailConfirmations::findFirstByCode($code);

        if (!$confirmation) {
            return $this->dispatcher->forward([
                'controller' => 'index',
                'action' => 'index'
            ]);
        }

        if ($confirmation->confirmed != false) {
            return $this->dispatcher->forward([
                'controller' => 'session',
                'action' => 'login'
            ]);
        }

        $confirmation->confirmed = true;

        $confirmation->user->active = true;

        /**
         * Change the confirmation to 'confirmed' and update the user to 'active'
         */
        if (!$confirmation->save()) {

            foreach ($confirmation->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward([
                'controller' => 'index',
                'action' => 'index'
            ]);
        }

        /**
         * Identify the user in the application
         */
        $this->auth->authUserById($confirmation->user->id);

        /**
         * Check if the user must change his/her password
         */
        if ($confirmation->user->mustChangePassword == true) {

            $this->flash->success('The email was successfully confirmed. Now you must change your password');

            return $this->dispatcher->forward([
                'controller' => 'users',
                'action' => 'changePassword'
            ]);
        }

        $this->flash->success('The email was successfully confirmed');

        return $this->dispatcher->forward([
            'controller' => 'users',
            'action' => 'index'
        ]);
    }

    public function resetPasswordAction()
    {
        $code = $this->dispatcher->getParam('code');

        $resetPassword = ResetPasswords::findFirstByCode($code);

        if (!$resetPassword) {
            return $this->dispatcher->forward([
                'controller' => 'index',
                'action' => 'index'
            ]);
        }

        if ($resetPassword->reset != false) {
            return $this->dispatcher->forward([
                'controller' => 'session',
                'action' => 'login'
            ]);
        }

        $resetPassword->reset = true;

        /**
         * Change the confirmation to 'reset'
         */
        if (!$resetPassword->save()) {

            foreach ($resetPassword->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward([
                'controller' => 'index',
                'action' => 'index'
            ]);
        }

        /**
         * Identify the user in the application
         */
        $this->auth->authUserById($resetPassword->usersId);

        $this->flash->success('Please reset your password');

        return $this->dispatcher->forward([
            'controller' => 'users',
            'action' => 'changePassword'
        ]);
    }
}
