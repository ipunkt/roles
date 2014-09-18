<?php

use Illuminate\Console\Command;
use Ipunkt\Roles\Resources\ResourceRepositoryInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ResourceAddActionCommand extends BaseCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'resource:addaction';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';


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
	public function fire() {
            $id = $this->argument('resource id');
            $action_name = $this->argument('actionname');
            $resource = $this->getResource($id);

            if($resource->addAction($action_name)) {
                $this->info("Adding $action_name to {$resource->getName()} was successful.");
            } else {
                $this->info("Failed to add action $action_name to {$resource->getName()}");
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
			array('resource id', InputArgument::REQUIRED, 'The id of the resource to which this action will be added.'),
            array('actionname', InputArgument::REQUIRED, 'The name this action will have.'),
		);
	}
}
