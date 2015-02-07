<?php

return [
    'default' => 'sync',
    'connections' => [
      'sync' => [
        'driver' => 'sync',
      ],
      'beanstalkd' => [
        'driver' => 'beanstalkd',
        'host'   => 'localhost',
        'queue'  => 'default',
      ],
    ],
    'failed' => [
      'database' => 'mysql', 'table' => 'failed_jobs'
    ]
];
