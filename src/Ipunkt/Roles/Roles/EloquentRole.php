<?php namespace Ipunkt\Roles\Roles;

use Ipunkt\Permissions\HasPermissionInterface;
use Ipunkt\Permissions\HasPermissionTrait;

class EloquentRole extends \Eloquent implements RoleInterface, HasPermissionInterface {
    protected $table = 'roles';

    use EloquentRoleTrait;
    use GenericRoleTrait;
    use HasPermissionTrait;
}