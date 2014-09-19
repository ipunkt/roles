<?php namespace Ipunkt\Roles;

use Auth;
use Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\MessageBag;
use Input;
use Ipunkt\Roles\Users\UserRepositoryInterface;
use Ipunkt\Roles\UserWithRolesInterface;

use Ipunkt\Auth\Repositories\EloquentRepository;
use Ipunkt\Roles\Resources\ResourceRepositoryInterface;
use Ipunkt\Roles\Roles\RoleInterface;
use Ipunkt\Roles\Roles\RoleRepositoryInterface;
use Response;
use Session;
use View;

/**
 * Class RoleController
 * @package Ipunkt\Roles
 */
class RoleController extends \BaseController {

    /**
     * @var RoleRepositoryInterface
     */
    protected $role_repository;
    /**
     * @var ResourceRepositoryInterface
     */
    private $privilege_repository;
    /**
     * @var UserRepositoryInterface
     */
    private $user_repository;

    /**
     * Get the Simpleauth\UserInterface matching the logged in user
     *
     * @return \Ipunkt\Auth\models\UserInterface
     */
    protected function getUser() {
        $user_id = Auth::user()->getAuthIdentifier();
        return $user = $this->user_repository->findOrFail($user_id);
    }

    /**
     * @param RoleRepositoryInterface $repository
     * @param ResourceRepositoryInterface $privilege_repository
     * @param EloquentRepository $user_repository
     */
    public function __construct(RoleRepositoryInterface $repository, ResourceRepositoryInterface $privilege_repository, UserRepositoryInterface $user_repository) {
        $this->role_repository = $repository;
        $this->privilege_repository = $privilege_repository;
        $this->user_repository = $user_repository;
        $this->beforeFilter('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $response = null;
        $dummy_role = $this->role_repository->create();
        $user = $this->getuser();
        if($user->can('list', $dummy_role)) {
            $variables = [];
            $variables['extends'] = Config::get('roles::extends');
            $variables['roles'] = $this->role_repository->all();

            $response = View::make('roles::role/index', $variables);
        } else
            $response = Redirect::to('/');
        return $response;
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $dummy_role = $this->role_repository->create();
        $user = $this->getUser();
        if($user->can($dummy_role, 'create')) {
            $variables = [];
            $variables['extends'] = Config::get('roles::extends');
            $response = View::make('roles::role/create', $variables);
        } else
            $response = Redirect::home();

        return $response;
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $name = Input::get('name');
        $role = $this->role_repository->create();

        $user = $this->getUser();
        if($user->can($role, 'create')) {

            $role->setName($name);

        $this->role_repository->save($role);
            $response = Redirect::route('roles.role.index');
        } else {
            $response = Redirect::home();
        }

        return $response;
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(RoleInterface $role)
	{
        $user = $this->getUser();
        if($user->can($role, 'show')) {
            $variables = [];
            $variables['extends'] = Config::get('roles::extends');
            $variables['role'] = $role;
            $response = View::make('roles::role/show', $variables);
        } else {
            $response = Redirect::home();
        }
        return  $response;
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(RoleInterface $role)
	{
        $user = $this->getUser();
        if($user->can($role, 'edit')) {
            $variables = [];
            $variables['extends'] = Config::get('roles::extends');
            $variables['role'] = $role;
            $variables['privileges'] = $this->privilege_repository->all();
            $variables['users'] = $this->user_repository->all();

            /*
             * categorize permissions by their container name to fold them up into an accordion
             */
            $variables['permission_categories'] = [];
            foreach($role->getPermissions() as $permission) {


                // Set up info for the view if this accordion is open upon loading or not
                if(Session::get('permission_container_open') == $permission->getContainer())
                    $variables['permission_container'][$permission->getContainer()] = 'in';
                else
                    $variables['permission_container'][$permission->getContainer()] = '';

                if(! isset( $variables['permission_categories'][$permission->getContainer()] ))
                    $variables['permission_categories'][$permission->getContainer()] = [];
                $variables['permission_categories'][$permission->getContainer()][] = $permission;
            }

            /**
             * Set up which privilege accordions are open and which are closed upon loading
             */
            foreach($variables['privileges'] as $privilege) {
                if(Session::get('permission_add_container_open') == $privilege->getName())
                    $variables['permission_add_container'][$privilege->getName()] = 'in';
                else
                    $variables['permission_add_container'][$privilege->getName()] = '';
            }

            $variables['privilege_open'] = Session::has('privilege_open') ? 'in' : '';
            $variables['users_open'] = Session::has('users_open') ? 'in' : '';
            $variables['edit_open'] = (!$variables['users_open'] && !$variables['privilege_open']) ? 'in' : '';
            $response = View::make('roles::role/edit', $variables);
        } else {
            $response = Redirect::home();
        }

        return $response;
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(RoleInterface $role)
	{
        if(Auth::user()->can('edit',$role)) {
            $response = null;

            $name = Input::get('name');
            $role->setName($name);
            if($this->role_repository->save($role)) {
                $response = Redirect::back()->with('name', trans('roles::role.rename success'));
            } else {
                $errors = new MessageBag();
                $errors->add('name', trans('roles::role.rename failed'));
                $response = Redirect::back()->withErrors($errors);
            }
        } else {
            $response = Redirect::home();
        }

        return $response;
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param RoleInterface $role
     * @internal param int $id
     * @return Response
     */
	public function destroy(RoleInterface $role)
	{
        $response = null;

        $user = $this->getUser();
        if($user->can($role, 'delete')) {
            if($this->role_repository->delete($role)) {
                $response = Redirect::route('roles.role.index')->with('success', trans('roles::role.delete_success'));
            } else {
                $response = Redirect::back()->withErrors($this->role_repository->getErrors());
            }
        } else {
            $response = Redirect::home();
        }

        return $response;
	}
}
