<?php namespace Ipunkt\Roles\Roles;


/**
 * Interface RoleRepositoryInterface
 * @package Ipunkt\Roles\Roles
 */
interface RoleRepositoryInterface {
    /**
     * @return RoleInterface
     */
    public function create();

    /**
     * @return RoleInterface[]
     */
    public function all();

    /**
     * Find the role with the given id or throw an exception if none is found
     *
     * @param int $id
     * @return RoleInterface
     */
    public function findOrFail($id);

    /**
     * Attempt to save the changes to the given role
     *
     * @param RoleInterface $role
     * @return boolean
     */
    public function save(RoleInterface $role);

    /**
     * Attempt to delete the given role
     *
     * @param RoleInterface $role
     * @return boolean
     */
    public function delete(RoleInterface $role);

    /**
     * @return string[]
     */
    public function getErrors();

    /**
     * @param int $id
     * @return RoleInterface[]
     */
    public function allByUserId($id);
}