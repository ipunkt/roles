<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 27.05.14
 * Time: 15:27
 */

namespace Ipunkt\Roles\Roles;


class EloquentRoleRepository implements RoleRepositoryInterface {
    protected $errors;

    /**
     * @return RoleInterface
     */
    public function create()
    {
        return new EloquentRole();
    }

    /**
     * @return RoleInterface[]
     */
    public function all()
    {
        return EloquentRole::all();
    }

    /**
     * @param int $id
     * @return RoleInterface
     */
    public function findOrFail($id)
    {
        return EloquentRole::findOrFail($id);
    }

    public function save(RoleInterface $role)
    {
        /**
         * @var EloquentRole $role
         */
        return $role->save();
    }

    /**
     * Attempt to delete the given role
     *
     * @param RoleInterface $role
     * @return boolean
     */
    public function delete(RoleInterface $role)
    {
        /**
         * @var EloquentRole $role
         */
        return $role->delete();
    }

    /**
     * @return string[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param int $id
     * @return RoleInterface[]
     */
    public function allByUserId($id)
    {
        //return EloquentRole::all()->where('', '=', $id);
        // FIXME: find a better way to hand over user <-> role integration
        return [];
    }


} 