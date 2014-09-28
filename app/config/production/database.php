<?php

return [
    'connections' => [
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => $_ENV['db_name'],
            'username'  => $_ENV['db_user'],
            'password'  => $_ENV['db_pass'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],

        'forum' => [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'zbw_forum',
            'username'  => $_ENV['db_user'],
            'password'  => $_ENV['db_pass'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]
    ],
];
