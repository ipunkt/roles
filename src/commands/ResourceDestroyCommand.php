<?php

use Illuminate\Console\Command;
use Ipunkt\Roles\Resources\ResourceRepositoryInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ResourceDestroyCommand extends BaseCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'resource:destroy';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Destroy a named resource.';

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
        $id = $this->argument('resourceid');

        $resource = $this->getResource($id);

        if ($this->option('yes') || $this->confirm("Are you sure you want to delete $id -> {$resource->getName()}? [yes/no]")) {
            if($this->repository->delete($resource)) {
                $this->info("Deleting resource success.");
            } else {
                $this->info("Deleting resource failed.");
            }
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
			array('resourceid', InputArgument::REQUIRED, 'The name of the resource to be destroyed.'),
		);
	}

    protected function getOptions() {
        return [
            ['yes', 'y', InputOption::VALUE_NONE, 'Assume yes instead of asking to confirm the destruction.']
        ];
    }
}
