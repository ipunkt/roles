<?php

use Illuminate\Console\Command;
use Ipunkt\Roles\Actions\ActionInterface;
use Ipunkt\Roles\Resources\ResourceInterface;
use Ipunkt\Roles\Roles\RoleRepositoryInterface;
use Ipunkt\Roles\Users\UserRepositoryInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SuperuserCommand extends BaseCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'roles:superuser';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Give a user Superuser privileges, create superuser privilges if they do not exist yet.';

    /**
     * @var RoleRepositoryInterface
     */
    protected $roleRepository;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
        $this->roleRepository = App::make('Ipunkt\Roles\Roles\RoleRepositoryInterface');
        $this->userRepository = App::make('Ipunkt\Roles\Users\UserRepositoryInterface');
	}
    
    protected function getResourceByParameter() {
        $resource = $this->repository->byName('*');
        if($resource === null) {
            $resource = $this->repository->create();
            $resource->setName('*');
            if($this->repository->save($resource) == false)
                $resource = null;
        }
        
        return $resource;
    }
    
    protected function getAction(ResourceInterface $resource) {
        $action = null;

        foreach($resource->getActions() as $resourceAction) {
            if($resourceAction->getName() == '*')
                $action = $resourceAction;
        }

        if($action === null)
            $action = $resource->addAction('*');
        
        return $action;
    }
    
    public function getRole(ActionInterface $action) {

        $role = null;
        foreach($this->roleRepository->all() as $repositoryRole) {

            if($repositoryRole->getName() == "Superuser") {
                $role = $repositoryRole;
            }

        }
        
        if($role === null) {
            $role = $this->roleRepository->create();
            $role->setName('Superuser');
            if($this->roleRepository->save($role) == false)
                $role = null;
            $role->addPermission($action, 1);
        }
        
        return $role;
    }
    
    protected function grantPermission($user, $action) {
        $user->grantPermission($action);
    }
    

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire() {
        $id = $this->argument('user id');
        
        $resource = $this->getResourceByParameter();
        
        $action = $this->getAction($resource);
        
        $role = $this->getRole($action);
        
        $user = $this->userRepository->byId($id);
        
        $user->assignRole($role);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('user id', InputArgument::REQUIRED, 'Id of the user to be made superuser.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
