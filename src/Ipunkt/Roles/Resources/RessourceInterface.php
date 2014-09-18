<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 28.05.14
 * Time: 09:58
 */

namespace Ipunkt\Roles\Resources;


use Ipunkt\Roles\Actions\ActionInterface;

interface ResourceInterface {
    /**
     * Return the identification number of this Resource
     *
     * @return int
     */
    public function getId();

    /**
     * Return the name of the container this privilege manages
     *
     * @return string
     */
    public function getName();

    /**
     * Set the name of the container this privilege manages
     */
    public function setName($name);

    /**
     * Return an array with actions this container has
     *
     * @return ActionInterface[]
     */
    public function getActions();

    /**
     * Attempts to add the given action to this privilege and return it if successful
     *
     * @param string $action
     * @return ActionInterface|null
     */
    public function addAction($action);

    /**
     * Attempts to remove the given action from this privilege
     *
     * @param ActionInterface $action
     * @return boolean
     */
    public function removeAction(ActionInterface $action);
}