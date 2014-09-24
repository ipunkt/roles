<?php namespace Ipunkt\Roles\Users;

use Config;
use Illuminate\Support\Collection;

/**
 * Class EloquentUserRepository
 * @package Ipunkt\Roles\Users
 * 
 * This implementation of UserRepositoryInterface assumes a User was implemented using the Eloquent ORM and its classpath
 * was set in the config file config/auth.php as model to authenticate with.
 */
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