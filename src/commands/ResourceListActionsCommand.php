<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ResourceListActionsCommand extends BaseCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'resource:listactions';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'List all actions on a specific resource.';

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
        $resource = $this->getResource();
        $count = 1;
        foreach($resource->getActions() as $action) {
            $this->info("{$count} {$action->getName()}");
            $count++;
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
			array('resource', InputArgument::REQUIRED, 'The id of the resource for which all actions should be shown.'),
		);
	}

}
