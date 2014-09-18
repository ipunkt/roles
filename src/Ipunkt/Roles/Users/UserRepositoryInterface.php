<?php


namespace Ipunkt\Roles\Users;


interface UserRepositoryInterface {
    /**
     * @param $id
     * @return UserWithRolesInterface
     */
    function byId($id);
} 