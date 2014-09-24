<?php namespace Ipunkt\Roles\Exceptions;
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 26.05.14
 * Time: 13:36
 */

namespace Ipunkt\Roles\Exceptions;


use Exception;

/**
 * Class DuplicateRoleException
 * @package Ipunkt\Roles\Exceptions
 * 
 * This exception is thrown when trying to assign a role to a user who already has this role assigned
 */
class DuplicateRoleException extends Exception {
	/**
	 * @param string $message
	 */
    public function __construct($message) {
        $this->message = $message;
    }
}