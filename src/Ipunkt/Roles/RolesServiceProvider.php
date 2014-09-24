<?php namespace Ipunkt\Roles;

use App;
use Config;
use Illuminate\Support\ServiceProvider;
use ResourceAddActionCommand;
use ResourceDestroyCommand;
//use ResourceListCommand;
use ResourceListActionsCommand;
use ResourceListCommand;
use ResourceMakeCommand;
use ResourceRemoveActionCommand;

class RolesServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('ipunkt/roles');

        if(Config::get('roles::set_permission_checker')) {
            Config::set('auth::set_permission_checker', false);
            App::bind('Ipunkt\Auth\PermissionChecker\PermissionCheckerInterface',
                    'Ipunkt\Roles\PermissionChecker\RolePermissionChecker');
            App::bind('Ipunkt\Permissions\PermissionChecker\PermissionCheckerInterface',
                    function($app, $parameters) {
                        $checker = new \Ipunkt\Roles\PermissionChecker\RolePermissionChecker( $parameters['associated_object'] );
                        return $checker;
                    }
                );
        }

        require_once __DIR__.'/../../routes.php';
        App::bind('Ipunkt\Roles\Roles\RoleRepositoryInterface', 'Ipunkt\Roles\Roles\EloquentRoleRepository');
        App::bind('Ipunkt\Roles\Resources\ResourceRepositoryInterface', 'Ipunkt\Roles\Resources\EloquentResourceRepository');
        App::bind('Ipunkt\Roles\Actions\ActionInterface', 'Ipunkt\Roles\Actions\EloquentAction');
        App::bind('Ipunkt\Roles\Users\UserRepositoryInterface', 'Ipunkt\Roles\Users\EloquentUserRepository');

        $this->makeCommands();
        $this->registerCommands();


	}

    /**
     * Register the commands with the IoC
     */
    public function makeCommands() {
        $this->app['command.roles.superuser'] = $this->app->share(function($app)
        {
            return new \SuperuserCommand();
        });
        $this->app['command.roles.resourcemake'] = $this->app->share(function($app)
        {
            return new ResourceMakeCommand();
        });
        $this->app['command.roles.resourcedestroy'] = $this->app->share(function($app)
        {
            return new ResourceDestroyCommand();
        });
        $this->app['command.roles.resourcelist'] = $this->app->share(function($app)
        {
            return new ResourceListCommand();
        });
        $this->app['command.roles.resourceaddaction'] = $this->app->share(function($app)
        {
            return new ResourceAddActionCommand();
        });
        $this->app['command.roles.resourcelistaction'] = $this->app->share(function($app)
        {
            return new ResourceListActionsCommand();
        });
        $this->app['command.roles.resourceremoveaction'] = $this->app->share(function($app)
        {
            return new ResourceRemoveActionCommand();
        });
    }

    /**
     * Register the commands made by makeCommands with Artisan
     */
    public function registerCommands() {
        $this->commands('command.roles.superuser');
        $this->commands('command.roles.resourcemake');
        $this->commands('command.roles.resourcedestroy');
        $this->commands('command.roles.resourcelist');
        $this->commands('command.roles.resourceaddaction');
        $this->commands('command.roles.resourcelistaction');
        $this->commands('command.roles.resourceremoveaction');
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
