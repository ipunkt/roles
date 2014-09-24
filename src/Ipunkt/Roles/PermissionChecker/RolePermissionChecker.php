<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 03.06.14
 * Time: 10:02
 */

namespace Ipunkt\Roles\PermissionChecker;


use App;
use Illuminate\Auth\UserInterface;
use Ipunkt\Permissions\CanInterface;
use Ipunkt\Permissions\PermissionChecker\PermissionCheckerInterface;
use Ipunkt\Roles\Permissions\PermissionField;
use Ipunkt\Roles\Roles\EloquentRoleRepository;
use Ipunkt\Permissions\HasPermissionInterface;
use Ipunkt\Permissions\PermissionChecker\PermissionChecker;

/**
 * Class RolePermissionChecker
 * @package Ipunkt\Permissions\PermissionChecker
 * 
 * This PermissionChecker replaces the default Ipunkt\Permissions\PermissionChecker\DummyPermissionChecker as the default
 * permission checker unless set otherwise in the config.
 * It checks if the CanInterface $object has a role assigned which gives it permission to do $action on the resource with
 * the same name as the eloquent table
 */
class RolePermissionChecker extends PermissionChecker {
    /**
     * @var EloquentRoleRepository
     */
    private $repository;

	/**
	 * @param HasPermissionInterface $checker
	 */
    function __construct(HasPermissionInterface $checker)
    {
        parent::__construct($checker);
        $this->repository =  App::make('Ipunkt\Roles\Roles\RoleRepositoryInterface');
    }


    /**
     * Check if the given User has permission to do action on this objects assigned model
     *
     * @param UserInterface $object
     * @param string $action
     * @return boolean
     */
    public function checkPermission(CanInterface $object, $action) {
        $has_permission = false;

        $container_name = $this->getEntity()->getTable();
        $row_id = $this->getEntity()->getKey();

        $permission_field = new PermissionField();
        $permission_field->setContainer($container_name);
        $permission_field->setAction($action);
        $permission_field->setRow($row_id);

        $roles = $this->repository->allByUserId($object->getAuthIdentifier());
        foreach($roles as $role) {
            $result = $role->testPermission($permission_field);
            if($result > 0) {
                $has_permission = true;
                if($result >= 5)
                    break;
            } if($result < 0) {
                $has_permission = false;
                if($result <= -5)
                    break;
            }
        }

        return $has_permission;
    }

} 