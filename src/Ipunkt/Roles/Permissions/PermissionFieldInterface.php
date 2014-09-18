<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 26.05.14
 * Time: 16:50
 */

namespace Ipunkt\Roles\Permissions;


/**
 * Interface PermissionFieldInterface
 * @package Ipunkt\Permissions
 */
interface PermissionFieldInterface {
    /**
     * name of the container(table) this permission applies to
     *
     * @return string
     */
    public function getContainer();

    /**
     * Id of the row this permission applies to, or null
     *
     * @return int|null
     */
    public function getRow();

    /**
     * Sets the row this permission applies to, or that it is for all rows if set to null
     *
     * @param int|null $row
     */
    public function setRow($row);

    /**
     * name of the action this Permission applies to
     *
     * @return string
     */
    public function getAction();

    /**
     * returns a single string representation of the permission fields
     *
     * @return string
     */
    public function getStringRepresentation();
} 