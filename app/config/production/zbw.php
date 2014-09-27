<?php
return [
    'sso' => [
        'key' => $_ENV['sso_key'],
        'secret' => $_ENV['sso_secret'],
        'cert' => $_ENV['sso_cert'],
        'method' => 'RSA',
        'return' => 'http://bostonartcc.net/auth?return',
        'base' => 'https://cert.vatsim.net/sso/'
    ]
];
