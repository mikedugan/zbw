<?php
return [
    'sso' => [
        'key' => getenv('sso_key'),
        'secret' => getenv('sso_secret'),
        'cert' => getenv('sso_cert'),
        'method' => 'RSA',
        'return' => 'http://bostonartcc.net/auth?return',
        'base' => 'https://cert.vatsim.net/sso/'
    ]
];
