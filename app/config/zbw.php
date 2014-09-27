<?php

return [
    'version' => '2.0.0RC1',

    'teamspeak' => [
        'host' => $_ENV['ts_host'],
        'user' => $_ENV['ts_user'],
        'password' => $_ENV['ts_pass'],
        'query_port' => $_ENV['ts_queryport'],
        'port' => $_ENV['ts_port']
    ],

    'off_peak' =>
        '<ul>
            <li>Monday-Thursday: You may not control from 7pm to 10pm, Eastern Standard Time</li>
            <li>Friday-Sunday: You may not control from 4pm to 10pm, Eastern Standard Time</li>
            </ul>',

    'roster_migrate' => 'http://bostonartcc.net/roster/export.php',

    'vatusa' => [
        'roster' => 'http://www.vatusa.net/feeds/roster.php?a=VATID&key=VATKEY',
        'controller' => 'http://www.vatusa.net/feeds/cidlookup.php?a=VATID&key=VATKEY&cid=CCID',
        'artcc' => 'http://www.vatusa.net/feeds/cidack.php?a=VATID&key=VATKEY&cid=CCID',
        'division' => 'http://www.vatusa.net/feeds/ciddck.php?a=VATID&key=VATKEY&cid=CCID'
    ],

    'sso' => [
        'base' => 'http://sso.vatsim.net/sso/'
    ],

    'permission_groups' => [
        'roster', 'news', 'sops', 'pages', 'reports', 'sessions', 'files'
    ],

    'exam_length' => [
        'SOP' => 20,
        'C_S1' => 30,
        'O_S1' => 25,
        'C_S2' => 30,
        'O_S2' => 30,
        'C_S3' => 30,
        'O_S3' => 30,
        'C_C1' => 30
    ],

    'permission_sets' => [
        'cvuda' => [0 => 'none', 1 => 'view', 2 => 'create', 3 => 'update', 4 => 'update', 5 => 'manage'],
        'files' => [0 => 'none', 1 => 'forum', 2 => 'sector', 3 => 'uploads', 4 => 'delete', 5=> 'manage'],
        'sessions' => [0 => 'none', 1 => 'view', 2 => 'accept', 3 => 'cancel']
    ],

    'permission_group_info' => [
        'roster' => ['roster', 'Roster', 'cvuda'],
        'news' => ['news', 'News & Events', 'cvuda'],
        'sops' => ['sops', 'SOPs', 'cvuda'],
        'reports' => ['reports', 'Training Reports', 'cvuda'],
        'sessions' => ['sessions', 'Training Sessions', 'sessions'],
        'files' => ['files', 'Files', 'files']
    ],

    'vatsim_status' => 'http://status.vatsim.net/status.txt',

    'controller_status' => 'https://cert.vatsim.net/cert/vatsimnet/idstatus.php?cid=',

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


    'front_page_metars' => ['KBOS', 'KMHT', 'KBDL', 'KPVD'],

    'live_training_performance' => [
      ['label' => 'Sign-On Brief', 'review_name' => 'brief', 'grade_name' => 'brief', 'subject' => 'sign on briefs'],
      ['label' => 'Runway Selection', 'review_name' => 'runway', 'grade_name' => 'runway', 'subject' => 'runway selection'],
      ['label' => 'Weather Conditions', 'review_name' => 'weather', 'grade_name' => 'weather', 'subject' => 'weather conditions'],
      ['label' => 'Controller Coordination', 'review_name' => 'coordination', 'grade_name' => 'coordination', 'subject' => 'controller coordination'],
      ['label' => 'Traffic Flow & Delays', 'review_name' => 'flow', 'grade_name' => 'flow', 'subject' => 'traffic flow'],
      ['label' => 'Aircraft Identity', 'review_name' => 'identity', 'grade_name' => 'identity', 'subject' => 'maintaining aircraft identity'],
      ['label' => 'Separation', 'review_name' => 'separation', 'grade_name' => 'separation', 'subject' => 'aircraft separation'],
      ['label' => 'Pointouts & Alerts', 'review_name' => 'pointouts', 'grade_name' => 'pointouts', 'subject' => 'pointouts and alerts'],
      ['label' => 'Airspace Knowledge', 'review_name' => 'airspace', 'grade_name' => 'airspace', 'subject' => 'airspace knowledge'],
      ['label' => 'LOA Knowledge', 'review_name' => 'loa', 'grade_name' => 'loa', 'subject' => 'SOP and LOA knowledge'],
      ['label' => 'Phraseology', 'review_name' => 'phraseology', 'grade_name' => 'phraseology', 'subject' => 'controller phraseology'],
      ['label' => 'Duty Priority', 'review_name' => 'priority', 'grade_name' => 'priority', 'subject' => 'duty priorities'],
    ],

    'live_training_criteria' => [
        'down' => [
            'wafdof' => 'Wrong altitude for direction',
            'squawk' => 'Wrong squawk code',
            'cl_late' => 'Late clearance',
            'cl_wrong' => 'Incorrect clearance',
            'taxi' => 'Incorrect taxi instructions',
            'landing' => 'Invalid landing clearance',
            'takeoff' => 'Invalid takeoff clearance',
            'luaw' => 'Invalid line up and wait',
            'waketurb' => 'Wake turbulence violation',
            'cl_approach' => 'Incorrect approach clearance',
            'mva' => 'Vectors below MVA',
            'sop' => 'SOP violation',
            'fix' => 'Incorrect/invalid fix',
            'final' => 'Late/incorrect vectors to final',
            'flow' => 'Inadequate traffic flow',
            'separation' => 'Insufficient separation',
            'phraseology' => 'Incorrect phraseology',
            'near_incident' => 'Near incident',
            'incident' => 'Aircraft incident',
            'coordination' => 'Lack of coordination',
            'readback' => 'Invalid/missing readback',
        ],
        //UP
        'up' => [
            'phraseology' => 'Good phraseology',
            'flow' => 'Good traffic flow',
            'separation' => 'Good separation',
            'situation' => 'Good situational awareness',
            'pointouts' => 'Good pointouts',
            'sequencing' => 'Good sequencing'
        ]

    ],

    'poker' => [
        'initial_draw' => 2,
        'max_hand' => 5,
        'card_weights' => [
          '2' => 12,
          '3' => 13,
          '4' => 14,
          '5' => 15,
          '6' => 16,
          '7' => 17,
          '8' => 18,
          '9' => 19,
          '1' => 20,
          'J' => 21,
          'Q' => 22,
          'K' => 23,
          'A' => 24
        ],
        'card_names' => [
          '2C' => '2 of Clubs',
          '2D' => '2 of Diamonds',
          '2H' => '2 of Hearts',
          '2S' => '2 of Spades',
          '3C' => '3 of Clubs',
          '3D' => '3 of Diamonds',
          '3H' => '3 of Hearts',
          '3S' => '3 of Spades',
          '4C' => '4 of Clubs',
          '4D' => '4 of Diamonds',
          '4H' => '4 of Hearts',
          '4S' => '4 of Spades',
          '5C' => '5 of Clubs',
          '5D' => '5 of Diamonds',
          '5H' => '5 of Hearts',
          '5S' => '5 of Spades',
          '6C' => '6 of Clubs',
          '6D' => '6 of Diamonds',
          '6H' => '6 of Hearts',
          '6S' => '6 of Spades',
          '7C' => '7 of Clubs',
          '7D' => '7 of Diamonds',
          '7H' => '7 of Hearts',
          '7S' => '7 of Spades',
          '8C' => '8 of Clubs',
          '8D' => '8 of Diamonds',
          '8H' => '8 of Hearts',
          '8S' => '8 of Spades',
          '9C' => '9 of Clubs',
          '9D' => '9 of Diamonds',
          '9H' => '9 of Hearts',
          '9S' => '9 of Spades',
          '10C' => '10 of Clubs',
          '10D' => '10 of Diamonds',
          '10H' => '10 of Hearts',
          '10S' => '10 of Spades',
          'JC' => 'Jack of Clubs',
          'JD' => 'Jack of Diamonds',
          'JH' => 'Jack of Hearts',
          'JS' => 'Jack of Spades',
          'QC' => 'Queen of Clubs',
          'QD' => 'Queen of Diamonds',
          'QH' => 'Queen of Hearts',
          'QS' => 'Queen of Spades',
          'KC' => 'King of Clubs',
          'KD' => 'King of Diamonds',
          'KH' => 'King of Hearts',
          'KS' => 'King of Spades',
          'AC' => 'Ace of Clubs',
          'AD' => 'Ace of Diamonds',
          'AH' => 'Ace of Hearts',
          'AS' => 'Ace of Spades'
        ],
    ],

];
