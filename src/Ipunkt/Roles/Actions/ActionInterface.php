<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 28.05.14
 * Time: 10:18
 */

namespace Ipunkt\Roles\Actions;
use Ipunkt\Roles\Resources\ResourceInterface;


/**
 * Interface ActionInterface
 * @package Ipunkt\Permissions
 *
 * Part of the privilege system, this represents one action that can be taken on a container
 */
interface ActionInterface {
    /**
     * Return the unique identifier of this action
     *
     * @return int
     */
    public function getId();

    /**
     * Return the name of the action
     *
     * @return string
     */
    public function getName();

    /**
     * Set name of the action
     *
     * @param string $name
     */
    public function setName($name);

    /**
     * Return the Resource this action belongs to
     *
     * @return ResourceInterface
     */
    public function getResource();
} 