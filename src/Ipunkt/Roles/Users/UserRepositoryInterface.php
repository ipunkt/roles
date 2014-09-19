<?php


namespace Ipunkt\Roles\Users;


use Illuminate\Support\Collection;

interface UserRepositoryInterface {
    /**
     * @param $id
     * @return UserWithRolesInterface
     */
    function byId($id);

    /**
     * @param $id
     * @return UserWithRolesInterface
     */
    function findOrFail($id);

    /**
     * @return UserWithRolesInterface[]|Collection
     */
    function all();
} 