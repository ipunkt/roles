<?php namespace Ipunkt\Roles;

use App;
use Auth;
use Config;
use Illuminate\Support\MessageBag;
use Input;
use Ipunkt\Roles\Resources\ResourceInterface;
use Ipunkt\Roles\Resources\ResourceRepositoryInterface;
use Redirect;
use Response;
use View;

/**
 * Class ResourceController
 * @package Ipunkt\Roles
 *
 * Handles all requests concerning Resource management, including adding and removing, and thus creating and
 *  destroying, actions.
 */
class ResourceController extends \BaseController {

    /**
     * @var Resources\ResourceRepositoryInterface
     */
    private $repository;

    /**
     * @param ResourceRepositoryInterface $repository
     */
    function __construct(ResourceRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->beforeFilter('auth');
    }


    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

        $resource = $this->repository->create();
        if(Auth::user()->can('list', $resource)) {

            $variables = [];
            $variables['extends'] = Config::get('roles::extends');
            $variables['resources'] = $this->repository->all();
            //
            $response =  View::make('roles::resource/index', $variables);
        } else {
            $errors = new MessageBag();
            $errors->add('error', trans('roles::resource.list permission denied'));
            $response = Redirect::back()->withErrors($errors);
        }
        return $response;
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $resource = $this->repository->create();
        if(Auth::user()->can('create', $resource)) {
            $variables = [];
            $variables['extends'] = Config::get('roles::extends');
            $response = View::make('roles::resource/create', $variables);
        } else {
            $errors = new MessageBag();
            $errors->add('error', trans('roles::resource.create permission denied'));
            $response = Redirect::back()->withErrors($errors);
        }

        return $response;
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $response = Redirect::back();
        $errors = new MessageBag();

        $resource = $this->repository->create();
        if(Auth::user()->can('create', $resource)) {
            $container_name = Input::get('container');

            $resource->setName($container_name);
            if($this->repository->save($resource))
                $response = Redirect::route('roles.resource.index')->with('message',
                    trans('roles::resource.create success', ['name' => $container_name]));
            else
                $errors->add('error', trans('roles::resource.create failed', ['name' => $container_name]));

        } else {
            $errors->add('error', trans('roles::resource.create permission denied'));
        }

        $response->withErrors($errors);

        return $response;
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(ResourceInterface $resource)
	{
        if(Auth::user()->can('show', $resource)) {
            $variables = [];
            $variables['extends'] = Config::get('roles::extends');
            $variables['resource'] = $resource;
            $response = View::make('roles::resource.show', $variables);
        } else {
            $errors = new MessageBag();
            $errors->add('error', trans('roles::resource.show permission denied'));
            $response = Redirect::back()->withErrors($errors);
        }

        return $response;
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(ResourceInterface $resource)
	{
        if(Auth::user()->can('edit',$resource)) {
            $variables = [];
            $variables['extends'] = Config::get('roles::extends');
            $variables['resource'] = $resource;
            $response = View::make('roles::resource.edit', $variables);
        } else {
            $errors = new MessageBag();
            $errors->add('error', trans('roles::resource.edit permission denied'));
            $response = Redirect::back()->withErrors($errors);
        }

        return $response;
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(ResourceInterface $resource)
	{
        $response = Redirect::back();
        $errors = new MessageBag();

        if(Auth::user()->can('edit',$resource)) {
            $resource->setName(Input::get('container'));
            if( $this->repository->save($resource) ) {
                $response->with('success', trans('roles::privlege.edit success'));
            } else {
                $errors->add('message', trans('roles::resource.edit failed'));
            }
        } else {
            $errors->add('error', trans('roles::resource.edit permission denied'));
        }

        $response->withErrors($errors);

        return $response;
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(ResourceInterface $resource)
	{
        $response = null;

        if (Auth::user()->can('delete',$resource)) {
            if($this->repository->delete($resource)) {
                $response = Redirect::route('roles.resource.index')-> with('message',
                    trans('roles::privileg.delete success', ['name' => $resource->getName()]));
            } else {
                $errors = new MessageBag();
                $errors->add('error', trans('roles::resource.delete failed'));
                $response = Redirect::back()->withErrors($errors);
            }
        } else {
            $errors = new MessageBag();
            $errors->add('error', trans('roles::resource.delete permission denied'));
            $response = Redirect::back()->withErrors($errors);
        }

        return $response;
	}

    /**
     * @param ResourceInterface $resource
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAction(ResourceInterface $resource) {
        $response = Redirect::back();
        $action = Input::get('name');

        if( Auth::user()->can('add action',$resource) ) {
            if($resource->addAction($action)) {
                $response->with('success', trans('roles::action.create success'));
            } else {
                $errors = new MessageBag();
                $errors->add('action', trans('roles::action.create failed'));
                $response->withErrors($errors);
            }
        } else {
            $errors = new MessageBag();
            $errors->add('action', trans('roles::action.create permission denied'));
            $response->withErrors($errors);
        }

        return $response;
    }

    /**
     * @param ResourceInterface $resource
     * @param $action_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyAction(ResourceInterface $resource, $action_id) {
        $response = Redirect::back();

        $action = null;
        foreach($resource->getActions() as $check_action) {
            if($check_action->getId() == $action_id) {
                $action = $check_action;
                break;
            }
        }

        if(Auth::user()->can("remove action", $resource)) {
            if(!is_null($action)) {
                if($resource->removeAction($action)) {
                } else {
                    $errors = new MessageBag();
                    $errors->add('error', trans('roles::action.delete failed'));
                    $response->withErrors($errors);
                }
            } else {
                $errors = new MessageBag();
                $errors->add('error', trans('roles::action.delete find failed'));
                $response->withErrors($errors);
            }
        } else {
            $errors = new MessageBag();
            $errors->add('error', trans('roles::action.delete permission denied'));
            $response->withErrors($errors);
        }

        return $response;
    }
}
