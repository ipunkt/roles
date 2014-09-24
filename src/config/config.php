<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 27.05.14
 * Time: 11:02
 */

return [
    'set_user_model' => true,
    'set_permission_checker' => true,
    'extends' => [
        'view' => 'roles::nomaster',
        'section' => 'content',
        'script' => 'script'
    ],
];