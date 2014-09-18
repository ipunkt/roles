<?php namespace Ipunkt\Roles;

use Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\MessageBag;
use Input;
use Ipunkt\Roles\Permissions\PermissionInterface;
use Ipunkt\Roles\Resources\ResourceInterface;
use Ipunkt\Roles\Resources\ResourceRepositoryInterface;
use Ipunkt\Roles\Roles\RoleInterface;
use Ipunkt\Roles\Roles\RoleRepositoryInterface;
use Response;
use View;

/**
 * Class PermissionController
 * @package Ipunkt\Roles
 *
 * Takes care of adding, removing and updating privileges of a role
 */
class PermissionController extends \BaseController {

    /**
     * @var RoleRepositoryInterface
     */
    protected $role_repository;
    /**
     * @var Resources\ResourceRepositoryInterface
     */
    private $privilege_repository;

    /**
     * @param RoleRepositoryInterface $role_repository
     * @param ResourceRepositoryInterface $privilege_repository
     */
    public function __construct(RoleRepositoryInterface $role_repository, ResourceRepositoryInterface $privilege_repository) {
        $this->role_repository = $role_repository;
        $this->privilege_repository = $privilege_repository;
        $this->beforeFilter('auth');
    }

    /**
     * Helper function which loops through all permissions of a role and returns the one with
     * id == $permission_id. If no matching permission is found, null is returned instead
     *
     * @param RoleInterface $role
     * @param int $permission_id
     * @return PermissionInterface|null
     */
    static function permission_from_role(RoleInterface $role, $permission_id) {
        $permission = null;

        foreach ($role->getPermissions() as $permission_to_test) {
            if($permission_to_test->getId() == $permission_id) {
                $permission = $permission_to_test;
                break;
            }

        }

        return $permission;
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(RoleInterface $role, $permission_id)
	{
        $response = Redirect::back();

        $permission_input = Input::get('permission');
        $specific_to_id = Input::get('specific_to_id');
        $specific_id = Input::get('specific_id');
        $row_set_failed = false;

        // Find the permission
        $permission = static::permission_from_role($role, $permission_id);
        if($permission !== null) {

            // This decides which permission bootstrap accordion is open upon load
            $response->with('permission_container_open', $permission->getContainer());

            // if found

            // set granted or denied
            if($permission_input > 0)
                $permission->setPermissionGranted();
            else if($permission_input < 0)
                $permission->setPermissionDenied();

            // Update the row field of the permission
            if($specific_to_id == 'all' ||  $specific_to_id == 'specific') {

                // default to null, meaning permission belongs to the whole table
                $final_specific_id = null;

                // If input says specific
                if($specific_to_id == 'specific')
                    // set id to the id given in the input
                    $final_specific_id = $specific_id;

                // Attempt to set the id
                if( $permission->setRow($final_specific_id) ) {
                    $row_text = ($final_specific_id === NULL) ? trans('roles::permission.all') : $final_specific_id;
                    $response->with('permission edit', trans('roles::permission.row set',
                            ['row' => $row_text, 'action' => $permission->getAction(),
                                'container' => $permission->getContainer()]));
                } else {
                    $row_set_failed = true;
                }
            }

            if(!$row_set_failed) {

                if($permission->updatePermission()) {
                    $response->with('permission', trans('roles::permission.update success'));
                } else {
                    $errors = new MessageBag();
                    $errors->add('permission', trans('roles::permission.update failed',
                        ['action' => $permission->getAction(), 'container' => $permission->getContainer()]));
                    $response->withErrors($errors);
                }

            } else {
                $errors = new MessageBag();
                $errors->add('permission', trans('roles::permission.row set failed',
                    ['action' => $permission->getAction(), 'container' => $permission->getContainer()]));
                $response->withErrors($errors);
            }

        } else {
            $errors = new MessageBag();
            $errors->add('permission', trans('roles::permission.not found', ['id' => $permission_id]));
            $response->withErrors($errors);
        }

        // Info to the edit view: open privilege tab of the accordion
        $response->with('privilege_open', true);

        return $response;
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(RoleInterface $role, $permission_id)
	{
        $response = Redirect::back();

        $permission = static::permission_from_role($role, $permission_id);
        $errors = null;
        if($permission !== null) {

            // This decides which permission bootstrap accordion is open upon load
            $response->with('permission_container_open', $permission->getContainer());

            if($role->removePermission($permission)) {
                $response->with('permission', trans('roles::permission.remove success',
                    ['representation' => $permission->getStringRepresentation(), 'id' => $permission_id]));
            } else {
                $errors = new MessageBag();
                $errors->add('permission', trans('roles::permission.remove failed',
                    ['representation' => $permission->getStringRepresentation(), 'id' => $permission_id]));
            }
        } else {
            $errors = new MessageBag();
            $errors->add('permission', trans('roles::permission.not found', ['id' => $permission_id]));
        }

        if($errors !== null)
            $response->withErrors($errors);

        // Info to the edit view: open privilege tab of the accordion
        $response->with('privilege_open', true);

        return $response;
	}


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(RoleInterface $role, ResourceInterface $privilege, $action_id) {
        $response = Redirect::back();

        // find the action we are trying to give tot he role
        $action = null;
        foreach($privilege->getActions() as &$check_action) {
            if($check_action->getId() == $action_id) {
                $action = $check_action;
                break;
            }
        }

        if($action) {
            $container = $action->getResource()->getName();

            // This decides which add permission bootstrap accordion is open upon load
            $response->with('permission_add_container_open', $container);
            // This decides which permission bootstrap accordion is open upon load
            $response->with('permission_container_open', $container);

            if($role->addPermission($action, 0)) {
                $response->with('permission', trans('roles::permission.add success',
                    ['representation' => $action->getResource()->getName().'.'.$action->getName()]) );
            } else {
                $errors = new MessageBag();
                $errors->add('permission', trans('roles::permission.add fail',
                ['representation' => $action->getResource()->getName().'.'.$action->getName(),
                    'action_id' => $action_id]) );
                $response->withErrors($errors);
            }
        } else {
            $errors = new MessageBag();
            $errors->add('permission', trans('roles::action.not found', ['action_id' => $action_id]));
            $response->withErrors($errors);
        }

        // Info to the edit view: open privilege tab of the accordion
        $response->with('privilege_open', true);

        return $response;
    }
}
