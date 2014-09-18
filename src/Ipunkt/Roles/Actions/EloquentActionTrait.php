<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 28.05.14
 * Time: 10:49
 */

namespace Ipunkt\Roles\Actions;


trait EloquentActionTrait {
    /**
     * Return the unique identifier of this action
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return the name of the action
     *
     * @return string
     */
    public function getName()
    {
        return $this->action;
    }

    /**
     * Set name of the action
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->action = $name;
    }

    /**
     * Return the Privilege this action belongs to
     *
     * @return PrivilegeInterface
     */
    public function getResource() {
        return $this->resource;
    }

    /**
     * Eloquent relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function resource() {
        return $this->belongsTo('Ipunkt\Roles\Resources\EloquentResource', 'resource_id');
    }

}