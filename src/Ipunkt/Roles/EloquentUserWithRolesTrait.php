<?php namespace Ipunkt\Roles;

use Ipunkt\Roles\Exceptions\DuplicateRoleException;
use Ipunkt\Roles\Exceptions\UnkownRoleException;
use Ipunkt\Roles\Roles\RoleInterface;

/**
 * Class EloquentUserWithRolesTrait
 * @package Ipunkt\Roles
 *
 * This traits sets up getRoles, assignRole and removeRole for use with an eloquent model.
 * @see GenericUserWithRolesTrait for the canWithString implementation using these functions and RolePermissionChecker
 *  for use of them with canWithObject
 */
trait EloquentUserWithRolesTrait {

    /**
     * @return mixed
     */
    public function roles() {
        return $this->belongsToMany('Ipunkt\Roles\Roles\EloquentRole', 'user_roles', 'user_id', 'role_id');
    }

    /**
     * @return RoleInterface[]
     */
    public function getRoles() {
        return $this->roles;
    }

	/**
	 * Attempt to assign a role to this user.
	 * returns true on success and false otherwise.
	 *
	 * @param RoleInterface $role
	 * @throws DuplicateRoleException
	 * @return boolean
	 */
    public function assignRole(RoleInterface $role) {
        $success = false;
        $eloquent_role = $this->roles()->find($role->getId());

        // Make sure we're not creating a duplicate relationship
        if($eloquent_role == null) {
            $success = $this->roles()->attach($role->getId());
        } else {
            throw new DuplicateRoleException($this->getId().' already has role '.$role->getId().'('.$role->getName().')'
            .' attempting to duplicate role assignment.');
        }

        return $success;
    }

	/**
	 * Attempt to remove the given role from this user.
	 * returns true on success and false otherwise.
	 *
	 * @param RoleInterface $role
	 * @throws UnkownRoleException
	 * @return boolean
	 */
    public function removeRole(RoleInterface $role) {
        $eloquent_role = $this->roles()->whereId($role->getId())->first();

        if(is_null($eloquent_role)) {
	        throw new UnkownRoleException($this->getId().'('.$this->getName().') does not have the role '.$role->getId().
		        '('.$role->getName().')');
        }
	        
	    $success = $this->roles()->detach($role->getId());

        return $success;
    }

}