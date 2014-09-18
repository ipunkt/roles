<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 26.05.14
 * Time: 15:58
 */

namespace Ipunkt\Roles\Permissions;


/**
 * Class PermissionString
 * @package Ipunkt\Permissions
 */
class PermissionString {
    /**
     * @var string
     */
    protected $string;

    /**
     * @param string $string
     */
    public function __construct($string) {
        $this->string = $string;
    }

    /**
     * @return PermissionFieldInterface[]
     */
    public function split() {
        $necessary_permissions = [];

        $string_parts = explode('.', $this->string);
        while($string_parts) {
            $permission_object = new PermissionField();

            $permission_object->setContainer( array_shift($string_parts) );

            $id_or_action = array_shift($string_parts);
            if (is_numeric($id_or_action)) {
                $permission_object->setRow($id_or_action);
                $permission_object->setAction( array_shift($string_parts) );
            } else {
                $permission_object->setAction($id_or_action);
            }
            $necessary_permissions[] = $permission_object;
        }

        return $necessary_permissions;
    }
} 