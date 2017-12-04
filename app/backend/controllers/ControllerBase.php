<?php

namespace PSMAS\Backend\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

/**
 * ControllerBase
 * This is the base controller for all controllers in the application
 *
 * @property \PSMAS\Common\Library\Auth\Auth auth
 */
class ControllerBase extends Controller {
  /**
   * Execute before the router so we can determine if this is a private controller, and must be authenticated, or a
   * public controller that is open to all.
   *
   * @param Dispatcher $dispatcher
   * @return boolean
   */
  public function beforeExecuteRoute(Dispatcher $dispatcher) {
    $moduleName = $dispatcher->getModuleName();
    $controllerName = $dispatcher->getControllerName();

    // Only check permissions on private controllers
    if ($this->acl->isPrivate($moduleName, $controllerName)) {
      // Get the current identity
      $identity = $this->auth->getIdentity();

      // If there is no identity available the user is redirected to index/index
      if (!is_array($identity)) {
        $this->flashSession->notice('You don\'t have access to this section. Please log in or sign up.');
        return $this->response->redirect('/index/index');
      }

      // Check if the user have permission to the current option
      $actionName = $dispatcher->getActionName();
      if (!$this->acl->isAllowed($identity['profile'], $moduleName, $controllerName, $actionName)) {
        $this->flash->notice('You don\'t have access to this module: ' . $controllerName . ':' . $actionName);

        if ($this->acl->isAllowed($identity['profile'], $moduleName, $controllerName, 'index')) {
          $dispatcher->forward([
            'controller' => $controllerName,
            'action' => 'index'
          ]);
        } else {
          $dispatcher->forward([
            'controller' => 'user_control',
            'action' => 'index'
          ]);
        }

        return false;
      }
    }
  }
}
