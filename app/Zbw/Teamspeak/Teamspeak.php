<?php namespace Zbw\Teamspeak;

use Zbw\Users\UserRepository;

class Teamspeak
{

    // TS3 server settings
    public $ip = "192.99.252.122";
    public $queryport = 10011;
    public $username = 'serveradmin';
    public $password = 'Mickeyd2!'; //TODO update
    public $port = 9987;
    public $groupIDs = array(
        'OBS' => 9,
        'S1' => 10,
        'S2' => 11,
        'S3' => 12,
        'C1' => 13,
        'C3' => 14,
        'MTR' => 15,
        'I1' => 16,
        'I3' => 17,
        'SUP' => 18
    );
    public $ts3;
    public $conf;
    public $cid;
    public $clid;
    private $users;

    public function __construct()
    {
        $this->ts3 = new Ts3Admin($this->ip, $this->queryport);
        $this->users = \App::make(UserRepository::class);

        // Connect to the TS3 server
        if ($this->ts3->getElement('success', $this->ts3->connect())) {
            // Login to the TS3 server as superadmin
            if ($this->ts3->getElement('success', $this->ts3->login($this->username, $this->password))) {
                // Select the TS3 server and load all connected clients
                $clientList = $this->loadServerClients();
                // Make sure clients (other than superadmin) are connected
                if (count($clientList) > 1)
                    // Loop though each TS3 client individually
                    $this->manageUser($clientList);
            } else echo 'Connection limits exceeded.';
        }
    }

    // Set the user's permissions
    public function set_perms($cldbid, $cid)
    {
        $cldbid = $cldbid['data']['cldbid'];
        echo "setting perms\n";
        // Load the user's data
        $user = $this->users->get($cid);

        // Find all the permissions the TS3 user should have
        if ($user->inGroup(\Sentry::findGroupByName('Mentors'))) {
            $this->ts3->serverGroupAddClient($this->groupIDs['MTR'], $cldbid);
        }

        switch($user->rating_id) {
            case -1: $this->ts3->serverGroupAddClient($this->groupIDs['OBS'], $cldbid); break;
            case 0: $this->ts3->serverGroupAddClient($this->groupIDs['OBS'], $cldbid); break;
            case 1: $this->ts3->serverGroupAddClient($this->groupIDs['OBS'], $cldbid); break;
            case 2: $this->ts3->serverGroupAddClient($this->groupIDs['S1'], $cldbid); break;
            case 3: $this->ts3->serverGroupAddClient($this->groupIDs['S2'], $cldbid); break;
            case 4: $this->ts3->serverGroupAddClient($this->groupIDs['S3'], $cldbid); break;
            case 5: $this->ts3->serverGroupAddClient($this->groupIDs['C1'], $cldbid); break;
            case 6: $this->ts3->serverGroupAddClient($this->groupIDs['C1'], $cldbid); break;
            case 7: $this->ts3->serverGroupAddClient($this->groupIDs['C3'], $cldbid); break;
            case 8: $this->ts3->serverGroupAddClient($this->groupIDs['I1'], $cldbid); break;
            case 9: $this->ts3->serverGroupAddClient($this->groupIDs['I1'], $cldbid); break;
            case 10: $this->ts3->serverGroupAddClient($this->groupIDs['I3'], $cldbid); break;
            case 11: $this->ts3->serverGroupAddClient($this->groupIDs['SUP'], $cldbid); break;
            case 12: $this->ts3->serverGroupAddClient($this->groupIDs['SUP'], $cldbid); break;
            default: $this->ts3->serverGroupAddClient(5, $cldbid); break;
        }

        if(in_array($user->cid, \Config::get('zbw.teamspeak.serveradmins'))) {
            $this->ts3->serverGroupAddClient(6, $cldbid);
        }

    }

    // Tell the user to make a nickname change
    public function notify_nickname_change($roster_id)
    {
        $user = $this->users->get($roster_id);
        $nickname = $user->username . ' ('.$user->initials.')';
        $this->ts3->clientPoke($this->clid, 'Please change your nickname to: ' . $nickname);
    }

    /**
     * nonstatic
     * @name registerKey
     * 
     * @param $current_uid
     * @param $tskey
     * @return void
     */
    private function registerKey($current_uid, $tskey)
    {
        $tskey->uid = $current_uid;
        $tskey->used = 1;
        $tskey->save();
        $cldbid = $this->ts3->clientGetDbIdFromUid($current_uid);
        $this->set_perms($cldbid, $tskey->cid);
        $this->notify_nickname_change($tskey->cid);
    }

    /**
     * @param $client
     * @return array
     */
    private function parseNickname($client)
    {
        $name = $client['client_nickname'];
        $name = explode(' -', $name, 2);
        $name = $name[0];
        $name = explode(' (', $name, 2);
        $name = $name[0];
        $name_parts = explode(' ', $name);
        return array($name, $name_parts);
    }

    /**
     * @return mixed
     */
    private function loadServerClients()
    {
        $this->ts3->selectServer($this->port);
        $this->ts3->setName('Boston John');
        $clientListReturn = $this->ts3->clientList();
        $clientList = $clientListReturn['data'];
        return $clientList;
    }

    /**
     * nonstatic
     * @name manageUsedKey
     * 
     * @param $tskey
     * @param $current_uid
     * @return void
     */
    private function manageUsedKey($tskey, $current_uid)
    {
        $computer_id = $tskey->uid;
        if ($computer_id == $current_uid) {
            // The key is valid, prompt the user for a nickname change
            $this->set_perms($tskey->cid, $this->ts3->clientGetDbIdFromUid($current_uid));
            $this->notify_nickname_change($tskey->cid);
        } else {
            // The key is not valid for this computer
            $this->ts3->clientPoke($this->clid, 'You are using an invalid or expired Teamspeak key!');
        }
    }

    /**
     * @param $current_uid
     * @param $user
     * @return void
     */
    private function validateUser($current_uid, $user)
    {
        echo "validating user\n";
        echo $user->cid."\n";
        echo $current_uid."\n";
        $valid = \TsKey::where('uid', $current_uid)->where('cid', $user->cid)->get();
        echo count($valid)."\n";
        if (count($valid) > 0) {
            echo "user is valid\n";
            // The user is all setup, just update the permissions if neccessary
            $this->set_perms($this->ts3->clientGetDbIdFromUid($current_uid), $user->cid);
        } else {
            // The user is either a fake or is on a new computer. Remind the user
            $this->ts3->clientPoke($this->clid, 'You need to activate vZBW TS3 on this computer. Go here: http://bostonartcc.net/me/profile?v=settings');
        }
    }

    /**
     * @param $clientList
     * @return void
     */
    private function manageUser($clientList)
    {
        foreach ($clientList as $client) {
            echo "updating " . $client['client_nickname'] . ", " . $client['client_database_id'] . "\r\n";
            // Ignore the user if it's the superadmin
            $this->cid = $client['client_database_id'];
            $this->clid = $client['clid'];

            echo "parsing name...\n";

            list($name, $name_parts) = $this->parseNickname($client);

            echo "name: {$name}\n";

            if (count($name_parts) == 1 && strlen($name_parts[0]) <= 8) {
                $key = $name;
            } else {
                $key = false;
                $firstname = array_shift($name_parts);
                $lastname = implode(' ', $name_parts);
            }

            $current_client = $this->ts3->clientInfo($this->clid);
            $current_uid = $current_client['data']['client_unique_identifier'];

            // Treat the user appropriately
            if ($key) {
                // The user has a key as a nickname
                $tskey = \TsKey::where('ts_key', $key)
                    ->where('used', false)
                    ->where('expires', '>', \Carbon::now())
                    ->with('user')->first();

                //search ts3keys table (cid, key, expires)
                if (count($tskey) == 1) {
                    echo $client['client_nickname'] . " has a valid key";
                    // The key hasn't been used yet & has not expired
                    if (!$tskey->used) {
                        $this->registerKey($current_uid, $tskey);
                    } else {
                        $this->manageUsedKey($tskey, $current_uid);
                    }
                } else {
                    // The key doesn't even exist in the DB
                    $this->ts3->clientPoke($this->clid, 'You are using an invalid or expired Teamspeak key!');
                }
            } else {
                // The user is logged in with a full name
                if($firstname === 'serveradmin' || $firstname === 'Boston') { return; }
                echo "First Name: {$firstname}\n";
                echo "Last Name: {$lastname}\n";
                $user = $this->users->findByFirstLastName($firstname, $lastname)[0];
                $this->validateUser($current_uid, $user);
            }

        }
    }

}

//new Teamspeak;
