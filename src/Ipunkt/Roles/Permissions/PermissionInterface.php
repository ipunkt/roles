<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 26.05.14
 * Time: 16:27
 */

namespace Ipunkt\Roles\Permissions;

/**
 * Interface PermissionInterface
 * @package Ipunkt\Roles\Permissions
 * 
 * A permission which can be assigned to a role.
 * It can either allow
 * - grantsPermission()
 * or deny
 * - deniesPermission()
 * Permission to do an action.
 */
interface PermissionInterface extends PermissionFieldInterface {
    /**
     * Returns the unique identifier by which this permission is identified
     *
     * @return int
     */
    public function getId();

    /**
     * Returns true if permission is granted on permissions this applies to
     *
     * @return boolean
     */
    public function grantsPermission();

    /**
     * Returns true if permission is denied on permissions this applies to
     *
     * @return boolean
     */
    public function deniesPermission();

    /**
     * Returns 0 if this permission does not apply to the described permission.
     * Returns 1 if this permission applies to the described permission, but is not specific to is.
     *          e.g. 'inventory.new' applies to container='inventory', id=7, action='new' but is not specific to it
     * Returns 2 if this permission applies to the described permission and is specific to it
     *          e.g. 'inventory.7.new' applies to container='inventory', id=7, action='new' and is specific to it
     *               'inventory.new' applies to container='inventory', id=null, action='new' and is specific to it
     *
     * @param string $resource the name of the resource type to check for
     * @param int|null $id the id of resource to check for
     * @param string $action the action for which you wish to know if the permission applies
     * @return int
     */
    public function permissionApplies($resource, $id, $action);

    /**
     * set this permission to grant access
     */
    public function setPermissionGranted();

    /**
     * set this permission to deny access
     */
    public function setPermissionDenied();

    /**
     * Attempts to write the newly set permission to the database.
     *  Returns true on success, false otherwise.
     *
     * @return boolean
     */
    public function updatePermission();
}