<?php

return [
    'connections' => [
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => getenv('db_name'),
            'username'  => getenv('db_user'),
            'password'  => getenv('db_pass'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],

        'forum' => [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'zbw_forum',
            'username'  => getenv('db_user'),
            'password'  => getenv('db_pass'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]
    ],
];
