<?php namespace Ipunkt\Roles\Roles;

use Ipunkt\Roles\Actions\ActionInterface;
use Ipunkt\Roles\Permissions\PermissionFieldInterface;
use Ipunkt\Roles\Permissions\PermissionInterface;


/**
 * Interface RoleInterface
 * @package Ipunkt\Permissions
 *
 * This Interface represents a role which has a name, an id and permissions
 * Permissions can be tested through the testPermission function
 *
 * TODO: Split into MakeRoleInterface with setter functions and GetRoleInterface with setter functions and have
 *          RoleInterface extend both?
 */
interface RoleInterface {
    /**
     * @return PermissionInterface[]
     */
    public function getPermissions();

    /**
     * Set a new name for this role object
     *
     * @param string $name
     */
    public function setName($name);

    /**
     * Get the current name of this role object
     *
     * @return string
     */
    public function getName();

    /**
     * Get the unique identifier number of this role object
     *
     * @return int
     */
    public function getId();

    /**
     * Test if this role has permissions to do whats described in the $permission
     * returns 2 if this role grants the permission specificaly
     * returns 1 if this role grants the permission on the container
     * returns 0 if the role does not grant the permission
     * returns -1 if the role denies the permission for the table
     * returns -2 if the role denies the permission specificaly
     *
     * @param PermissionFieldInterface $permission
     * @return int
     */
    public function testPermission(PermissionFieldInterface $permission);

    /**
     * Attempt to attach a new permission to this role
     * returns true on success and false otherwise
     *
     * @param ActionInterface $action
     * @return boolean
     */
    public function addPermission(ActionInterface $action, $grant_deny = 0);

    /**
     * Attempt to remove a permission from this role
     * returns true on success and false otherwise
     *
     * @param PermissionInterface $permission
     * @return boolean
     */
    public function removePermission(PermissionInterface $permission);
}