<?php

use Illuminate\Console\Command;
use Ipunkt\Roles\Resources\ResourceInterface;
use Ipunkt\Roles\Resources\ResourceRepositoryInterface;

class BaseCommand extends Command {
    /**
     * @var ResourceRepositoryInterface
     */
    protected $repository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->repository = App::make('Ipunkt\Roles\Resources\ResourceRepositoryInterface');
    }

    /**
     * @param int $id
     * @return ResourceInterface
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getResource() {
        $resource = null;
        try {
	        $id_or_name = $this->argument('resource');
	        if(is_numeric($id_or_name)) {
		        $resource = $this->repository->findOrFail($id_or_name);
		        $this->info("Resource $id_or_name -> {$resource->getName()} found.");
	        } else {
		        $resource = $this->repository->byName($id_or_name);
		        $this->info("Resource {$resource->getId()} -> {$id_or_name} found.");
	        }
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $this->info("Failed to find resource with id $id_or_name");
            throw $e;
        }
        return $resource;
    }
}