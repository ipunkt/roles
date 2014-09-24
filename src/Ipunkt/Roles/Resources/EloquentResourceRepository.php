<?php namespace Ipunkt\Roles\Resources;


/**
 * Class EloquentResourceRepository
 * @package Ipunkt\Roles\Resources
 */
class EloquentResourceRepository implements ResourceRepositoryInterface {
    /**
     * Get all ResourceInterfaces this Repository contains.
     *
     * @return ResourceInterface[]
     */
    public function all()
    {
        return EloquentResource::all();
    }

    /**
     * @return ResourceInterface
     */
    public function create()
    {
        return new EloquentResource();
    }

    /**
     * Find the Resource with $id or throw an exception if it does not exist
     *
     * @param int $id
     * @return ResourceInterface
     */
    public function findOrFail($id)
    {
        return EloquentResource::findOrFail($id);
    }

    /**
     * Returns the Resource with the given Name or null if none exists with the given name
     *
     * @return ResourceInterface|null
     */
    public function byName($name) {
        return EloquentResource::byName($name)->first();
    }

    /**
     * Attempts to save changes to the privilege
     *
     * @return boolean
     */
    public function save(ResourceInterface $privilege)
    {
        /**
         * @var EloquentResource $privilege
         */
        return $privilege->save();
    }

    /**
     * Attempts to delete the given privilege
     *
     * @param ResourceInterface $privilege
     * @return boolean
     */
    public function delete(ResourceInterface $privilege)
    {
        /**
         * @var EloquentResource $privilege
         */
        return $privilege->delete();
    }

} 