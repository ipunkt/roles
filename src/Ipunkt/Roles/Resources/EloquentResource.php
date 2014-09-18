<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 28.05.14
 * Time: 10:11
 */

namespace Ipunkt\Roles\Resources;


use Ipunkt\Permissions\HasPermissionTrait;
use Ipunkt\Permissions\HasPermissionInterface;

/**
 * Class EloquentResource
 * @property string container
 * @package Ipunkt\Permissions\Models
 *
 * use EloquentResourceTrait to supply an Eloquent implementation of the ResourceInterface
 */
class EloquentResource extends \Eloquent implements ResourceInterface, HasPermissionInterface {
    /**
     * @var string
     */
    protected $table = 'resources';
    public $timestamps = false;

    use EloquentResourceTrait;
    use HasPermissionTrait;


}