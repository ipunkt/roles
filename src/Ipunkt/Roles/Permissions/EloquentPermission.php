<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 26.05.14
 * Time: 16:30
 */

namespace Ipunkt\Roles\Permissions;

class EloquentPermission extends \Eloquent implements PermissionInterface {
    use EloquentPermissionTrait;
    use GenericPermissionTrait;

    protected $table = 'permissions';
    public $timestamps = false;

}