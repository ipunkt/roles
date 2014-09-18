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
    public function getResource($id) {
        $resource = null;
        try {
            $resource = $this->repository->findOrFail($id);
            $this->info("Resource $id -> {$resource->getName()} found.");
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $this->info("Failed to find resource with id $id");
            throw $e;
        }
        return $resource;
    }
}