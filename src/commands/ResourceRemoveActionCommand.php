<?php

use Illuminate\Console\Command;
use Ipunkt\Roles\Actions\ActionInterface;
use Ipunkt\Roles\Resources\ResourceInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class ResourceRemoveActionCommand
 */
class ResourceRemoveActionCommand extends BaseCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'resource:removeaction';

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
     * Attempt to find an action on the resource with the given name
     *
     * @param ResourceInterface $resource
     * @param $action_name
     * @return ActionInterface|null
     */
    public function findAction(ResourceInterface $resource, $action_name) {
        $found_action = null;
        foreach( $resource->getActions() as &$action) {
            if($action->getName() == $action_name) {
                $found_action = $action;
                break;
            }
        }
        return $found_action;
    }

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire() {
        $action_name = $this->argument('action name');

        $resource = $this->getResource();
        /**
         * @var ResourceInterface $resource
         */
        $action = $this->findAction($resource, $action_name);

        if($action !== null) {
            if($resource->removeAction($action)) {
                $this->info("Removed action $action_name from resource {$resource->getId()}:{$resource->getName()}");
            } else {
                $this->error("Failed to remove action $action_name from resource {$resource->getId()}:{$resource->getName()}");
            }
        } else {
            $this->error("Action $action_name not found on resource {$resource->getId()}:{$resource->getName()}");
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
			array('resource', InputArgument::REQUIRED, 'The id of the resource from which this action is removed.'),
            array('action name', InputArgument::REQUIRED, 'The name of the action to remove from the ressource.'),
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
