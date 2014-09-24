<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 03.06.14
 * Time: 10:02
 */

namespace Ipunkt\Roles\PermissionChecker;


use Ipunkt\Permissions\CanInterface;

/**
 * Class UserPermissionChecker
 * @package Ipunkt\Roles\PermissionChecker
 * 
 * This PermissionChecker extends RolePermissionChecker for the User model this package brings when used together with
 * ipunkt/auth. It allows the user to do everything on its own user, and falls back to the RolePermissionChecker for all
 * other users.
 */
class UserPermissionChecker extends RolePermissionChecker {
	/**
	 * Check if the $object is the same as $entity.
	 * - If it is: allow everything.
	 * - If it is not: fall back to role based permissions.
	 * 
	 * @param CanInterface $object
	 * @param string $action
	 * @return bool
	 */
    public function checkPermission(CanInterface $object, $action)
    {
        $has_permission = false;

        if ($object->getid() == $this->getEntity()->getId())
            $has_permission = true;
        else
            $has_permission = parent::checkPermission($object, $action);

        return $has_permission;
    }

} 