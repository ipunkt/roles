<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 27.05.14
 * Time: 12:03
 */

use Ipunkt\Roles\Roles\RoleRepositoryInterface;

Route::bind('role', function($id) {
    $repository = App::make('Ipunkt\Roles\Roles\RoleRepositoryInterface');
    /**
     * @var RoleRepositoryInterface $repository
     */
    return $repository->findOrFail($id);
});
Route::bind('resource', function($id) {
    $repository = App::make('Ipunkt\Roles\Resources\ResourceRepositoryInterface');
    /**
     * @var RoleRepositoryInterface $repository
     */
    return $repository->findOrFail($id);
});

/**
 * Permissions
 * These connect a Role to a Resource and either grant or deny it said resource
 */
Route::post('roles/permission/{role}/{resource}/{action}', [
    'uses' => 'Ipunkt\Roles\PermissionController@store',
    'as' => 'roles.permission.store'

]);
Route::delete('roles/permission/{role}/{permission}', [
    'uses' => 'Ipunkt\Roles\PermissionController@destroy',
    'as' => 'roles.permission.destroy'

]);
Route::patch('roles/permission/{role}/{permission}', [
    'uses' => 'Ipunkt\Roles\PermissionController@update',
    'as' => 'roles.permission.update'

]);
Route::put('roles/permission/{role}/{permission}', [
    'uses' => 'Ipunkt\Roles\PermissionController@update',
    'as' => 'roles.permission.update'

]);

Route::resource('roles/role', 'Ipunkt\Roles\RoleController');

/**
 * Resource
 * A resource is an action which can be done on a container.
 * Usualy a container will mean a table
 */
Route::post('roles/resource/{resource}/store_action',
    ['uses' =>'Ipunkt\Roles\ResourceController@storeAction',
        'as' => 'roles.resource.store_action',
        'before' => 'auth'
    ]
);
Route::post('roles/resource/{resource}/destroy_action/{action}',
    ['uses' =>'Ipunkt\Roles\ResourceController@destroyAction',
        'as' => 'roles.resource.destroy_action',
        'before' => 'auth'
    ]
);
Route::resource('roles/resource', 'Ipunkt\Roles\ResourceController');
