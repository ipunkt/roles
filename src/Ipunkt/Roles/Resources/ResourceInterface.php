<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 28.05.14
 * Time: 09:58
 */

namespace Ipunkt\Roles\Resources;


use Illuminate\Container\Container;
use Ipunkt\Roles\Actions\ActionInterface;

/**
 * Interface ResourceInterface
 * @package Ipunkt\Roles\Resources
 * 
 * A resource known to the roles system.
 * Has actions for which a role can get permission which allows or forbids them.
 */
interface ResourceInterface {
    /**
     * Get the unique identifier by which this resource can be loaded from the repository
     *
     * @return int
     */
    public function getId();

    /**
     * Get the name of this resource
     *
     * @return string
     */
    public function getName();

    /**
     * Set the name of this resource
     */
    public function setName($name);

    /**
     * Returns all actions which this resource currently knows
     *
     * @return ActionInterface[]|Container
     */
    public function getActions();

    /**
     * Add a new action with the given name to this resource.
     * If successful, an ActionInterface representing the new action is returned
     *
     * @param string $action
     * @return ActionInterface|null
     */
    public function addAction($action);

    /**
     * Attempts to remove the given action from this resource
     *
     * @param ActionInterface $action
     * @return boolean
     */
    public function removeAction(ActionInterface $action);
}