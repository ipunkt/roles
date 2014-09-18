<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 26.05.14
 * Time: 13:36
 */

namespace Ipunkt\Roles\Exceptions;


use Exception;

class MalformedPermissionException extends Exception {
    public function __construct($message, $string) {
        $this->message = $message.': '.$string;
    }
}