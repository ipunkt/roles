<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 27.05.14
 * Time: 09:57
 */

namespace Ipunkt\Roles\Roles;


use Ipunkt\Roles\Actions\ActionInterface;
use Ipunkt\Roles\Exceptions\PermissionNotFoundException;
use Ipunkt\Roles\Permissions\EloquentPermission;
use Ipunkt\Roles\Permissions\PermissionInterface;

trait EloquentRoleTrait {
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions() {
        /**
         * @var \Eloquent $this
         */
        return $this->hasMany('Ipunkt\Roles\Permissions\EloquentPermission', 'role_id')->with('action');
    }

    /**
     * @return PermissionInterface[]
     */
    public function getPermissions() {
        /**
         * @var \Eloquent $this
         */

        /*
         * Sort the permissions by table
         */
        return $this->permissions()
            // Join the tables together, and sort by the connected privilege_id
            ->join('actions', 'permissions.action_id' , '=', 'actions.id')->orderby('actions.resource_id')
            // but only get the fields from permissions, otherwise the role->action relationship breaks for some reason
            ->get(['permissions.*']);
    }

    public function setName($name) {
        /**
         * @var \Eloquent $this
         */
        $this->name = $name;
    }

    public function getId() {
        /**
         * @var \Eloquent $this
         */
        return $this->id;
    }

    public function getName() {
        /**
         * @var \Eloquent $this
         */
        return $this->name;
    }

    public function addPermission(ActionInterface $action, $grant_deny = 0) {
        $permission = new EloquentPermission();
        $permission->action_id = $action->getId();
        $permission->permission = $grant_deny;
        return $this->permissions()->save($permission);
    }


    public function removePermission(PermissionInterface $permission)
    {
        $local_permission = null;
        foreach($this->getPermissions() as $permission_to_test) {
            if($permission->getId() == $permission_to_test->getId()) {
                $local_permission = $permission_to_test;
                break;
            }
        }
        /**
         * @var EloquentPermission $local_permission
         */


        if(!is_null($local_permission))
            $success = $local_permission->delete();
        else
            throw new PermissionNotFoundException('Permission '.$permission->getId().' not part of role '.$this->getName().'/'.$this->getId());

        return $success;
    }


    /**
     * Attempts to assign this role to the given user
     *
     * @return boolean
     */
    public function assignToUser(UserInterface $new_user)
    {
        $found = false;
        $success = false;

        foreach($this->users as $user_to_test) {
            if($user_to_test->getId() == $new_user->getId()) {
                $found = true;
                break;
            }
        }

        if(!$found) {
            // attach does not seem to return a success / failure state
            $this->users()->attach($new_user->getId());
            $success = true;
        }

        return $success;
    }

    /**
     * Attempts to remove this role from the given user
     *
     * @param UserInterface $user
     * @return boolean
     */
    public function removeFromUser(UserInterface $user) {
        $this->users()->detach($user->getId());
        return true;
    }

}