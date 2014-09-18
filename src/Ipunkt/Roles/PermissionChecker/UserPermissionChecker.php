<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 03.06.14
 * Time: 10:02
 */

namespace Ipunkt\Roles\PermissionChecker;


use Illuminate\Auth\UserInterface;

class UserPermissionChecker extends RolePermissionChecker {
    public function checkPermission(UserInterface $user, $action)
    {
        $has_permission = false;

        if ($user->getid() == $this->getEntity()->getId())
            $has_permission = true;
        else
            $has_permission = parent::checkPermission($user, $action);

        return $has_permission;
    }

} 