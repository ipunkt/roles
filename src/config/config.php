<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 27.05.14
 * Time: 11:02
 */

return [
    'set user model' => true,
    'set permission checker' => true,
    'extends' => [
        'view' => 'roles::nomaster',
        'section' => 'content',
        'script' => 'script'
    ],
];