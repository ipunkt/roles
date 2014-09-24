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
 * Class UnkownRoleException
 * @package Ipunkt\Roles\Exceptions
 * 
 * This esception is thrown when trying to remove a role from a user where the role does not exist in the database;
 */
class UnkownRoleException extends Exception {

	/**
	 * @param string $message
	 */
    public function __construct($message) {
        $this->message = $message;
    }
}