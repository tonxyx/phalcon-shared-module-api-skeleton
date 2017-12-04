<?php

namespace PSMAS\Common\Library\Acl;

use Phalcon\Mvc\User\Component;
use Phalcon\Acl\Adapter\Memory as AclMemory;
use Phalcon\Acl\Role as AclRole;
use Phalcon\Acl\Resource as AclResource;
use PSMAS\Common\Models\Profiles;

/**
 * PSMAS\Common\Library\Acl\Acl
 */
class Acl extends Component {

  /**
   * The ACL Object
   *
   * @var \Phalcon\Acl\Adapter\Memory
   */
  private $acl;

  /**
   * The file path of the ACL cache file from APP_DIR
   *
   * @var string
   */
  private $filePath;

  /**
   * Define the resources that are considered "private".
   * These controller => actions require authentication.
   *
   * @var array
   */
  private $privateResources = array();

  /**
   * Human-readable descriptions of the actions used in {@see $privateResources}
   *
   * @var array
   */
  private $actionDescriptions = [
    'index' => 'Access',
    'search' => 'Search',
    'create' => 'Create',
    'edit' => 'Edit',
    'delete' => 'Delete',
    'changePassword' => 'Change password',
  ];

  public function __construct() {
    $this->filePath = $this->getFilePath();
  }

  /**
   * Checks if a controller is private or not
   *
   * @param string $controllerName
   *
   * @return boolean
   */
  public function isPrivate ($moduleName, $controllerName) {
    $moduleName = strtolower($moduleName);
    $controllerName = strtolower($controllerName);

    return isset($this->privateResources[$moduleName][$controllerName]);
  }

  /**
   * Checks if the current profile is allowed to access a resource
   *
   * @param string $profile
   * @param string $module
   * @param string $controller
   * @param string $action
   *
   * @return boolean
   */
  public function isAllowed ($profile, $module, $controller, $action) {
    return $this->getAcl()->isAllowed($profile, $module . '_' . $controller, $action);
  }

  /**
   * Returns the ACL list
   *
   * @return \Phalcon\Acl\Adapter\Memory
   */
  public function getAcl () {
    // Check if the ACL is already created
    if (is_object($this->acl)) {
      return $this->acl;
    }

    // Check if the ACL is in APC
    if (function_exists('apc_fetch')) {
      $acl = apc_fetch('auth-acl');
      if (is_object($acl)) {
        $this->acl = $acl;

        return $acl;
      }
    }

    // Check if the ACL is already generated
    if (!file_exists($this->filePath)) {
      $this->acl = $this->rebuild();
      return $this->acl;
    }

    // Get the ACL from the data file
    $data = file_get_contents($this->filePath);
    $this->acl = unserialize($data);

    // Store the ACL in APC
    if (function_exists('apc_store')) {
      apc_store('auth-acl', $this->acl);
    }

    return $this->acl;
  }

  /**
   * Returns the permissions assigned to a profile
   *
   * @param Profiles $profile
   * @return array
   */
  public function getPermissions (Profiles $profile) {
    $permissions = [];
    foreach ($profile->getPermissions() as $permission) {
      $permissions[$permission->resource . '.' . $permission->action] = true;
    }

    return $permissions;
  }

  /**
   * Returns all the resources and their actions available in the application
   *
   * @return array
   */
  public function getResources () {
    return $this->privateResources;
  }

  /**
   * Returns the action description according to its simplified name
   *
   * @param string $action
   *
   * @return string
   */
  public function getActionDescription ($action) {
    if (isset($this->actionDescriptions[$action])) {
      return $this->actionDescriptions[$action];
    } else {
      return $action;
    }
  }

  /**
   * Rebuilds the access list into a file
   *
   * @return \Phalcon\Acl\Adapter\Memory
   */
  public function rebuild () {
    $acl = new AclMemory();

    $acl->setDefaultAction(\Phalcon\Acl::DENY);

    // Register roles
    $profiles = Profiles::find([
      'active = :active:',
      'bind' => [
        'active' => true
      ]
    ]);

    foreach ($profiles as $profile) {
      $acl->addRole(new AclRole($profile->name));
    }

    foreach ($this->privateResources as $module => $resources) {
      foreach ($resources as $resource => $action) {
        $acl->addResource(new AclResource($module . '_' . $resource), $action);
      }
    }

    // Grant access to private area to role Users
    foreach ($profiles as $profile) {
      // Grant permissions in "permission" model
      foreach ($profile->getPermissions() as $permission) {
        $acl->allow($profile->name, $permission->resource, $permission->action);
      }

      // Always grant these permissions
      $acl->allow($profile->name, 'backend_users', 'changePassword');
    }

    if (touch($this->filePath) && is_writable($this->filePath)) {

      file_put_contents($this->filePath, serialize($acl));

      // Store the ACL in APC
      if (function_exists('apc_store')) {
        apc_store('auth-acl', $acl);
      }
    } else {
      $this->flash->error(
        'The user does not have write permissions to create the ACL list at ' . $this->filePath
      );
    }

    return $acl;
  }

  /**
   * Set the acl cache file path
   *
   * @return string
   */
  protected function getFilePath() {
    if (!isset($this->filePath)) {
      $this->filePath = rtrim($this->config->application->cacheDir, '\\/') . '/acl/data.txt';
    }
    return $this->filePath;
  }

  /**
   * Adds an array of private resources to the ACL object.
   *
   * @param array $resources
   */
  public function addPrivateResources(array $resources) {
    if (count($resources) > 0) {
      $this->privateResources = array_merge($this->privateResources, $resources);
      if (is_object($this->acl)) {
        $this->acl = $this->rebuild();
      }
    }
  }
}
