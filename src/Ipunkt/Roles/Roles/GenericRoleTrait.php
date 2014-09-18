<?php  namespace Ipunkt\Roles\Roles;
use Ipunkt\Roles\Permissions\PermissionFieldInterface;

/**
 * Class GenericRoleTrait
 * @package Ipunkt\Permissions\Models
 *
 * Brings the default implementation of the generic part of the RoleInterface.
 * It relies on getPermissions() being implemented
 */
trait GenericRoleTrait {
    /**
     * @param PermissionFieldInterface $test_permission
     * @return int
     */
    public function testPermission(PermissionFieldInterface $test_permission) {
        $has_permission = 0;

        // Check all our permissions to see if they apply
        foreach($this->getPermissions() as $owned_permission) {
            /**
             * @var PermissionInterface $owned_permission
             */
            $applies = $owned_permission->permissionApplies($test_permission->getContainer(),
                $test_permission->getRow(),
                $test_permission->getAction());
            if($applies >= 1) {

                if($owned_permission->deniesPermission()) {
                    $has_permission = -1 * $applies;
                } else if($owned_permission->grantsPermission()) {
                    $has_permission = 1 * $applies;
                }

                // If the owned_permission is specific to the one we're looking for, then we can stop looking
                if($applies >= 2)
                    break;
            }
        }

        return $has_permission;
    }
}