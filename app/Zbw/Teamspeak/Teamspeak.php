<?php namespace Zbw\Teamspeak;

use Ts3Admin;
use Zbw\Users\UserRepository;

class Teamspeak
{

    // TS3 server settings
    public $ip = "192.241.125.73";
    public $queryport = 10011;
    public $username = 'serveradmin';
    public $password = 'foobarbaz'; //TODO update
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

    public function __construct()
    {
        $this->ts3 = new Ts3Admin($this->ip, $this->queryport);
        $this->conf = $conf;

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
    public function set_perms($roster_id)
    {

        // Load the user's data
        $user = new DBRecord('roster_member', $this->conf);
        $user->load_by_id($roster_id);

        // Find all the permissions the TS3 user should have
        $userGroups = array();
        $userGroups[] = $this->groupIDs[$user->get_field('rating')];
        if ($user->get_field('is_mentor') == 1) $userGroups[] = $this->groupIDs['MTR'];

        // Remove user from expired groups
        $currentUserGroups = $this->ts3->serverGroupsByClientID($this->cid);
        $cugs = array(); // cugs stands for currentUserGroup

        // Add user to new groups
        foreach ($userGroups as $userGroup) {
            if (!in_array($userGroup, $cugs)) {
                $this->ts3->serverGroupAddClient($userGroup, $this->cid);
                echo "Done setting user permissions\r\n";
            }
        }

    }

    // Tell the user to make a nickname change
    public function notify_nickname_change($roster_id)
    {
        $user = new DBRecord('roster_member', $this->conf);
        $user->load_by_id($roster_id);
        $nickname = $user->get_field('first_name') . ' ' . $user->get_field('last_name') . ' (' . $user->get_field('initials') . ')';
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
        $this->set_perms($tskey->cid);
        $this->notify_nickname_change($tskey->cid);
    }

    /**
     * nonstatic
     * @name parseNickname
     * 
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
     * nonstatic
     * @name loadServerClients
     * 
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
            $this->set_perms($tskey->cid);
            $this->notify_nickname_change($tskey->cid);
        } else {
            // The key is not valid for this computer
            $this->ts3->clientPoke($this->clid, 'You are using an invalid or expired Teamspeak key!');
        }
    }

    /**
     * nonstatic
     * @name validateUser
     * 
     * @param $current_uid
     * @param $user
     * @return void
     */
    private function validateUser($current_uid, $user)
    {
        $valid = \TsKey::where('uid', $current_uid)->where('cid', $user->cid);
        if ($valid->count() > 0) {
            // The user is all setup, just update the permissions if neccessary
            $this->set_perms($user->cid);
        } else {
            // The user is either a fake or is on a new computer. Remind the user
            $this->ts3->clientPoke($this->clid, 'You need to activate vZBW TS3 on this computer. Go here: http://bostonartcc.net/ts/');
        }
    }

    /**
     * nonstatic
     * @name manageUser
     * 
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

            echo "parsing name...\r\n";

            list($name, $name_parts) = $this->parseNickname($client);

            echo "done parsing name...\r\n";

            if (count($name_parts) == 1 && strlen($name_parts[0]) == 8) {
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
                $tskey = \TsKey::where('key', $key)
                    ->where('used', false)
                    ->where('expired', '>', \Carbon::now())
                    ->with('User')->get();

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

                $user = UserRepository::findByFirstLastName($firstname, $lastname);
                if ($user->count() == 1)
                    $this->validateUser($current_uid, $user);
            }

        }
    }

}

new Teamspeak;
