<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 26.05.14
 * Time: 13:36
 */

namespace Ipunkt\Roles\Exceptions;


use Exception;

class PermissionNotFoundException extends Exception {
    public function __construct($message) {
        $this->message = $message;
    }
}