<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 26.05.14
 * Time: 16:48
 */

namespace Ipunkt\Roles\Permissions;
use Log;


/**
 * Class GenericPermissionTrait
 * @package Ipunkt\Permissions\Models
 *
 * This Trait makes a generic PermissionInterface Implementation available.
 * It expects $this to implement PermissionFieldInterface
 */
trait GenericPermissionTrait {
    /**
     * Returns true if permission is granted on permissions this applies to
     *
     * @return boolean
     */
    public function grantsPermission()
    {
        return ($this->getPermission() > 0);
    }

    /**
     * Returns true if permission is denied on permissions this applies to
     *
     * @return boolean
     */
    public function deniesPermission()
    {
        return ($this->getPermission() < 0);
    }

    /**
     * returns a single string representation of the permission fields
     *
     * @return string
     */
    public function getStringRepresentation()
    {
        $string_representation = $this->getContainer();
        if( !is_null($this->getRow()) )
            $string_representation .= '.'.$this->getRow();
        $string_representation .= '.'.$this->getAction();
        return $string_representation;
    }

    /**
     * Returns true if this permission applies to this action on the container, or the object with given id in container
     *
     * @param string $container
     * @param int|null $id
     * @param string $action
     * @return boolean
     */
    public function permissionApplies($container, $id, $action)
    {
        $permission_applies = 0;

        // Test if the container(table) and action apply
        // We always have to check for this
        $universal_action = $this->getAction() == '*';
        $action_matches = $this->getAction() == $action;
        $container_matches = $this->getContainer() == $container;
        $universal_container = $this->getContainer() == '*';

        $matches = ( $container_matches || $universal_container ) &&
            ( $action_matches || $universal_action );

        if ( $matches ) {
            /*
             * Test how well we match the requested action
             * 1: *.*
             * 2: *.action
             * 3: res.*
             * 4: res.action
             */
            $permission_applies = 4;
            if( $universal_container )
                $permission_applies -= 2;

            if( $universal_action)
                $permission_applies -= 1;
        }

        // Test if the object in the container matches
        // We only have to do this if we have a column set. Otherwise this permission applies to the whole container
        if(( ($this->getRow() !== null) && ($this->getRow() != $id) ))
            $permission_applies = 0;

        // Check if the ids match(both equal or both null)
        if($permission_applies == 4 && ($id == $this->getRow()) )
            $permission_applies = 5;

        return $permission_applies;
    }
}