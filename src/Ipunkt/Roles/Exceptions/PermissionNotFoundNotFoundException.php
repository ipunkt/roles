<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 26.05.14
 * Time: 13:36
 */

namespace Ipunkt\Roles\Exceptions;


use Exception;

/**
 * Class PermissionNotFoundException
 * @package Ipunkt\Roles\Exceptions
 */
class PermissionNotFoundException extends Exception {

	/**
	 * @param string $message
	 */
    public function __construct($message) {
        $this->message = $message;
    }
}