<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 27.05.14
 * Time: 10:23
 */

namespace Ipunkt\Roles\Permissions;


/**
 * Class PermissionField
 * @package Ipunkt\Roles\Permissions
 * 
 * Plain old Data implementation of the PermissionFieldInterface
 */
class PermissionField implements PermissionFieldInterface {
    protected $container = null, $id = null, $action = null;

    /**
     * @param null $container
     */
    public function setContainer($container)
    {
        $this->container = $container;
    }

    /**
     * @return null
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param null $id
     */
    public function setRow($id)
    {
        $this->id = $id;
    }

    /**
     * @return null
     */
    public function getRow()
    {
        return $this->id;
    }

    /**
     * @param null $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return null
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * returns a single string representation of the permission fields
     *
     * @return string
     */
    public function getStringRepresentation()
    {
        $representation = $this->getContainer();
        if($this->getRow())
            $representation .= '.'.$this->getRow();
        $representation .= '.'.$this->getAction();
        return $representation;
    }

} 