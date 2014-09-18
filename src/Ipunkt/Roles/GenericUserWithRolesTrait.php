<?php namespace Ipunkt\Roles;

use Ipunkt\Roles\Permissions\PermissionField;
use Ipunkt\Roles\Permissions\PermissionString;

/**
 * Class GenericUserWithRolesTrait
 * @package Ipunkt\Roles\Models
 *
 * This trait provides the implementation of canString for use with roles
 */
trait GenericUserWithRolesTrait {
    /**
     * Returns true if this user has permission to do the action described by the permission string.
     *
     * @param string $permission_string description of the permission neccessary.
     *          Format: table.action for global permission.
     *                  table.row_id.action for specific permission
     * @return boolean
     */
    public function canString($action, $resource, $id) {
        $has_permission = true;
        $denied = false;

        if(!$this->isSuperuser()) {
            // Special case: edit your own user
            if( ($action == 'edit' && $resource == 'user' && $id == $this->getId()) == false ) {

                $permission = new PermissionField();
                $permission->setAction($action);
                $permission->setRow($id);
                $permission->setContainer($resource);

                $allowed = false;
                // Test all Roles if they grant this permission
                foreach($this->getRoles() as $role) {
                    $allowed_or_denied =  $role->testPermission($permission);
                    if($allowed_or_denied < 0) {
                        // If the role denies this permission stop looking
                        $denied = true;
                        break;
                    } else if($allowed_or_denied > 0) {
                        $allowed = true;
                    }
                }

                if($denied) {
                    $has_permission = false;
                } else if(!$allowed) {
                    $has_permission = false;
                } // else: we have this permission, continue testing the next permission
            } else { // Edit self
                $has_permission = true;
            }
        } else { // Superuser
            $has_permission = true;
        }

        return $has_permission;
    }
}