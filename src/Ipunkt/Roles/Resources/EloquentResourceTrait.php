<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 28.05.14
 * Time: 10:47
 */

namespace Ipunkt\Roles\Resources;
use Ipunkt\Roles\Actions\ActionInterface;
use Ipunkt\Roles\Actions\EloquentAction;


/**
 * Class EloquentResourceTrait
 * @package Ipunkt\Permissions\Resources
 *
 * Eloquent implementation of the ResourceInterface
 * Represents a Resource from the 'privileges' table and its actions from the 'actions' table.
 */
trait EloquentResourceTrait {

    /**
     * @param $name
     * @return mixed
     */
    static public function byName($name) {
        return self::whereContainer($name);
    }
    
    /**
     * Return the identification number of this Resource
     *
     * @return int
     */
    public function getid()
    {
        /**
         * @var \Eloquent $this
         */
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        /**
         * @var \Eloquent $this
         */
        return $this->container;
    }

    /**
     * Set the name of the container this privilege manages
     */
    public function setName($name)
    {
        /**
         * @var \Eloquent $this
         */
        $this->container = $name;
    }

    /**
     * @return ActionInterface[]
     */
    public function getActions()
    {
        /**
         * @var \Eloquent $this
         */
        return $this->actions;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actions() {
        /**
         * @var \Eloquent $this
         */
        return $this->hasMany('Ipunkt\Roles\Actions\EloquentAction', 'resource_id');
    }

    /**
     * Attempts to add the given action to this privilege
     *
     * @param Actioninterface $action
     * @return boolean
     */
    public function addAction($action_name)
    {
        $action = new EloquentAction();
        $action->setName($action_name);
        if(!$this->actions()->save($action))
            $action = null;
        
        return $action;
    }

    /**
     * Attempts to remove the given action from this privilege
     *
     * @param ActionInterface $action
     * @return boolean
     */
    public function removeAction(ActionInterface $action)
    {
        /**
         * @var EloquentAction $action
         */
        return $action->delete();
    }
}