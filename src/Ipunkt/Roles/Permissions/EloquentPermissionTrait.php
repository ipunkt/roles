<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 26.05.14
 * Time: 16:47
 */

namespace Ipunkt\Roles\Permissions;
use Ipunkt\Roles\Actions\ActionInterface;


/**
 * Class EloquentPermissionTrait
 * @package Ipunkt\Roles\Permissions
 *
 * @property ActionInterface $action
 */
trait EloquentPermissionTrait {

    /**
     * Returns the unique identifier by which this permission is identified
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * name of the container(table) this permission applies to
     *
     * @return string
     */
    public function getContainer()
    {
        return $this->action->getResource()->getName();
    }

    /**
     * Id of the row this permission applies to, or null
     *
     * @return int|null
     */
    public function getRow()
    {
        return $this->specific_to_id;
    }

    /**
     * Sets the row this permission applies to, or that it is for all rows if set to null
     *
     * @param int|null $row
     */
    public function setRow($row)
    {
        $success = true;

        if(is_null($row))
            $this->specific_to_id = null;
        else if(is_numeric($row))
            $this->specific_to_id = $row;
        else
            $success = false;

        return $success;
    }

    /**
     * name of the action this Permission applies to
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action->getName();
    }

    /**
     * field that specifies if we grant or deny the permission
     *
     * @return int
     */
    public function getPermission() {
        return $this->permission;
    }

    /**
     *
     */
    public function setPermissionGranted() {
        $this->permission = 1;
    }

    /**
     *
     */
    public function setPermissionDenied() {
        $this->permission = -1;
    }

    /**
     * @return mixed
     */
    public function updatePermission() {
        return $this->save();
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role() {
        return $this->belongsTo('Ipunkt\Roles\Roles\EloquentRole', 'role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function action() {
        return $this->belongsTo('Ipunkt\Roles\Actions\EloquentAction', 'action_id');
    }
}