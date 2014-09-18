<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 28.05.14
 * Time: 10:40
 */

namespace Ipunkt\Roles\Actions;


/**
 * Class EloquentAction
 * @property string action
 * @package Ipunkt\Permissions\Models
 *
 * Eloquent implementation of the ActionInterface
 */
class EloquentAction extends \Eloquent implements ActionInterface {
    /**
     *
     * @var string
     */
    protected $table = 'actions';
    public $timestamps = false;
    use EloquentActionTrait;
}