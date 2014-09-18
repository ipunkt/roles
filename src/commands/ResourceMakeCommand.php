<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ResourceMakeCommand extends BaseCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'resource:make';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Make a new resource for the roles system.';

    /**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
    }

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $resource = $this->repository->create();
        $name = $this->argument('resourcename');
        $resource->setName($name);
        if($this->repository->save($resource)) {
            $this->info("Resource $name created.");
            $this->info("Id:{$resource->getId()}");
        } else{
            $this->info("Resource creating failed");
        }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('resourcename', InputArgument::REQUIRED, 'Name of the resource to be created.'),
		);
	}
}
