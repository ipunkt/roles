<?php

use Illuminate\Console\Command;
use Ipunkt\Roles\Resources\ResourceRepositoryInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ResourceListCommand extends BaseCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'resource:list';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'List all known resources with their id.';

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
        $resources = $this->repository->all();
        $count = count($resources);
        $this->info('{$count resources found:}');
        foreach($resources as $resource) {
            $this->info("{$resource->getId()}: {$resource->getName()}");
        }
	}
}
