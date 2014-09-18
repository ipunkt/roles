<?php namespace Ipunkt\Roles\Resources;

/**
 * Interface ResourceRepositoryInterface
 * @package Ipunkt\Roles\Resources
 */
interface ResourceRepositoryInterface {

    /**
     * Get all ResourceInterfaces this Repository contains.
     *
     * @return ResourceInterface[]
     */
    public function all();

    /**
     * @return ResourceInterface
     */
    public function create();

    /**
     * Find the Resource with $id or throw an exception if it does not exist
     *
     * @param int $id
     * @return ResourceInterface
     */
    public function findOrFail($id);

    /**
     * Attempts to save changes to the privilege
     *
     * @param ResourceInterface
     * @return boolean
     */
    public function save(ResourceInterface $privilege);

    /**
     * Attempts to delete the given privilege
     *
     * @param ResourceInterface $privilege
     * @return boolean
     */
    public function delete(ResourceInterface $privilege);

    /**
     * Returns the Resource with the given Name or null if none exists with the given name
     * 
     * @return ResourceInterface|null
     */
    function byName($name);
}