<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 26.05.14
 * Time: 16:30
 */

namespace Ipunkt\Roles\Permissions;

/**
 * Class EloquentPermission
 * @package Ipunkt\Roles\Permissions
 * 
 * Implementation of the PermissionInterface using the Eloquent ORM
 * Represents a permission in the Database
 */
class EloquentPermission extends \Eloquent implements PermissionInterface {
    use EloquentPermissionTrait;
    use GenericPermissionTrait;

    protected $table = 'permissions';
    public $timestamps = false;

}