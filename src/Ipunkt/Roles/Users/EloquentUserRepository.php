<?php namespace Ipunkt\Roles\Users;

use Config;
use Illuminate\Support\Collection;

class EloquentUserRepository implements UserRepositoryInterface {
    /**
     * @param $id
     * @return UserWithRolesInterface
     */
    function byId($id) {
        $model = Config::get('auth.model');
        return $model::find($id)->first();
    }

    /**
     * @param $id
     * @return UserWithRolesInterface
     */
    function findOrFail($id) {
        $model = Config::get('auth.model');
        return $model::findOrFail($id);
    }

    /**
     * @return UserWithRolesInterface[]|Collection
     */
    function all() {
        $model = Config::get('auth.model');
        return $model::all();
    }


} 