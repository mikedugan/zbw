<?php

return [
    'teamspeak' => [
        'host' => 'foo',
        'user' => 'bar',
        'password' => 'bazbam',
        'query_port' => 9001,
        'port' => 1121
    ],

    'sso' => [
        'key' => 'foo',
        'secret' => 'bar',
        'cert' => 'baz',
        'method' => 'RSA',
        'return' => 'http://zbw.dugandev.com/auth?return',
        'base' => 'http://sso.hardern.net/server/'
    ],

    'vatsim_status' => 'http://status.vatsim.net/status.txt',

    'airports' => [
        //B and C
        'KMHT', 'KBOS', 'KBTV', 'KBDL', 'KPVD', 'KSYR', 'KALB', 'KBGR', 'KPWM',

        //D
        'KACK', 'KASH', 'KBAF', 'KBED', 'KBVY', 'KCEF', 'KEWB', 'KFMH', 'KGON',
        'KHFD', 'KHYA', 'KLEB', 'KLWM', 'KMVY', 'KNHZ', 'KOQU', 'KORH', 'KOWD',
        'KPSM', 'KSCH',

        //E
        'K0B5', 'K0B8', 'K0G7', 'K1B0', 'K1B1', 'K1B6', 'K1B9', 'K2B7', 'K3B0',
        'K3B1', 'K3B2', 'K3B4', 'K4B0', 'K4B6', 'K4V8', 'K52B', 'K5B2', 'K5B9',
        'K6B6', 'K6B8', 'K6B9', 'K7B2', 'K81B', 'K8B0', 'KAFN', 'KART', 'KAUG',
        'KB16', 'KB19', 'KBHB', 'KBID', 'KBML', 'KBST', 'KBXM', 'KCAR', 'KCNH',
        'KCON', 'KCQX', 'KDAW', 'KDDH', 'KEEN', 'KEFK', 'KEPM', 'KFIT', 'KFSO',
        'KFVE', 'KFZY', 'KGBR', 'KGDM', 'KGFL', 'KGTB', 'KHIE', 'KHUL', 'KIJD',
        'KIWI', 'KIZG', 'KLCI', 'KLEW', 'KLKP', 'KLRG', 'KLZD', 'KMAL', 'KMLT',
        'KMMK', 'KMPV', 'KMSS', 'KMTP', 'KMVL', 'KMVM', 'KN04', 'KN23', 'KN66',
        'KNY0', 'KOGS', 'KOIC', 'KOLD', 'KORE', 'KOWK', 'KOXC', 'KPBG', 'KPLB',
        'KPNN', 'KPQI', 'KPSF', 'KPTD', 'KPVC', 'KPYM', 'KRKD', 'KRME', 'KRUT',
        'KSFM', 'KSFZ', 'KSLK', 'KTAN', 'KUUU', 'KVGC', 'KVSF', 'KWST', 'KWVL'
    ],

    'metar_airports' => [
      'KMHT', 'KBOS', 'KBTV', 'KBDL', 'KPVD', 'KSYR', 'KALB', 'KBGR', 'KPWM',

      //D
      'KACK', 'KASH', 'KBAF', 'KBED', 'KBVY', 'KCEF', 'KEWB', 'KFMH', 'KGON',
      'KHFD', 'KHYA', 'KLEB', 'KLWM', 'KMVY', 'KOQU', 'KORH', 'KOWD',
      'KPSM', 'KSCH'
    ],

    'iatas' => [
      //B and C
      'MHT', 'BOS', 'BTV', 'BDL', 'PVD', 'SYR', 'ALB', 'BGR', 'PWM',

      //D
      'ACK', 'ASH', 'BAF', 'BED', 'BVY', 'CEF', 'EWB', 'FMH', 'GON',
      'HFD', 'HYA', 'LEB', 'LWM', 'MVY', 'NHZ', 'OQU', 'ORH', 'OWD',
      'PSM', 'SCH',

      //E
      '0B5', '0B8', '0G7', '1B0', '1B1', '1B6', '1B9', '2B7', '3B0',
      '3B1', '3B2', '3B4', '4B0', '4B6', '4V8', '52B', '5B2', '5B9',
      '6B6', '6B8', '6B9', '7B2', '81B', '8B0', 'AFN', 'ART', 'AUG',
      'B16', 'B19', 'BHB', 'BID', 'BML', 'BST', 'BXM', 'CAR', 'CNH',
      'CON', 'CQX', 'DAW', 'DDH', 'EEN', 'EFK', 'EPM', 'FIT', 'FSO',
      'FVE', 'FZY', 'GBR', 'GDM', 'GFL', 'GTB', 'HIE', 'HUL', 'IJD',
      'IWI', 'IZG', 'LCI', 'LEW', 'LKP', 'LRG', 'LZD', 'MAL', 'MLT',
      'MMK', 'MPV', 'MSS', 'MTP', 'MVL', 'MVM', 'N04', 'N23', 'N66',
      'NY0', 'OGS', 'OIC', 'OLD', 'ORE', 'OWK', 'OXC', 'PBG', 'PLB',
      'PNN', 'PQI', 'PSF', 'PTD', 'PVC', 'PYM', 'RKD', 'RME', 'RUT',
      'SFM', 'SFZ', 'SLK', 'TAN', 'UUU', 'VGC', 'VSF', 'WST', 'WVL'
    ],


    'front_page_metars' => ['KBOS', 'KMHT', 'KBDL', 'KPVD']
];
