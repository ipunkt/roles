<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 26.05.14
 * Time: 16:25
 */

namespace Ipunkt\Roles\Users;


use Ipunkt\Roles\Roles\RoleInterface;

interface UserWithRolesInterface {
    /**
     * get an array of roles associated with this user
     *
     * @return RoleInterface[]
     */
    public function getRoles();

    /**
     * Attempt to assign a role to this user.
     * returns true on success and false otherwise.
     *
     * @param RoleInterface $role
     * @return boolean
     */
    public function assignRole(RoleInterface $role);

    /**
     * Attempt to remove the given role from this user.
     * returns true on success and false otherwise.
     *
     * @param RoleInterface $role
     * @return boolean
     */
    public function removeRole(RoleInterface $role);
} 