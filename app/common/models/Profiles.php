<?php

namespace PSMAS\Common\Models;

use Phalcon\Mvc\Model;

/**
 * PSMAS\Common\Models\Profiles
 * All the profile levels in the application. Used in conjenction with ACL lists
 */
class Profiles extends Model {

  /**
   * @var integer
   */
  public $id;

  /**
   * @var string
   */
  public $name;

  /**
   * Define relationships to Users and Permissions
   */
  public function initialize() {
    $this->hasMany('id', __NAMESPACE__ . '\Users', 'profilesId', [
      'alias' => 'users',
      'foreignKey' => [
        'message' => 'Profile cannot be deleted because it\'s used on Users'
      ]
    ]);

    $this->hasMany('id', __NAMESPACE__ . '\Permissions', 'profilesId', [
      'alias' => 'permissions'
    ]);
  }
}
