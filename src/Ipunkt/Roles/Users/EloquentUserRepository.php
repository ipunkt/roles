<?php namespace Ipunkt\Roles\Users;

use Config;

class EloquentUserRepository implements UserRepositoryInterface {
    /**
     * @param $id
     * @return UserWithRolesInterface
     */
    function byId($id) {
        $model = Config::get('auth.model');
        return $model::find($id)->first();
    }

} 