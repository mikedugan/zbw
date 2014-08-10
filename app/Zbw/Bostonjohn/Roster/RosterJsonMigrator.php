<?php  namespace Zbw\Bostonjohn\Roster;

use Zbw\Users\Contracts\UserRepositoryInterface;
use Curl\Curl;
use Zbw\Base\Helpers;

class RosterJsonMigrator {
    private $url;
    private $users;
    private $curl;
    private $staff;


    public function __construct(UserRepositoryInterface $users, Curl $curl)
    {
        $this->users = $users;
        $this->curl= $curl;
        $this->url = \Config::get('zbw.roster_migrate');
        $this->staff = [
            'atm' => '1029885',
            'datm' => '1093141',
            'ta' => '1134052',
            'fe' => '1256391',
            'ec' => '1120544',
            'wm' => '1240047',
            'mentor' => ['1029885', '1120544','997868', '1015802', '1088911', '1041890', '1120544', '1240047', '1200203', '1004409', '1253785'],
            'instructor' => ['1035677', '1093141', '1134052', '1097238']
        ];
    }


    public function migrate()
    {
        $new = 0;
        $updates = 0;
        $users = $this->retrieve();
        foreach($users as $user) {
            if($this->users->exists($user->cid)) {
                $this->updateUser($user);
                $updates++;
            }
            else {
                $this->createUser($user);
                $new++;
            }
        }
        return [$new, $updates];
    }

    private function retrieve()
    {
        $this->curl->get($this->url);
        return json_decode($this->curl->response);
    }

    private function createUser($user)
    {
        $u = new \User();
        $u->cid = $user->cid;
        $u->first_name = $user->first_name;
        $u->last_name = $user->last_name;
        $u->username = $user->first_name . ' ' . $user->last_name;
        $u->initials = $user->initials;
        $u->password = Helpers::createPassword();
        $u->email = $user->email;
        $rating = \Rating::where('short', $user->rating)->first();
        $u->rating_id = $rating->id;
        $u->artcc = substr($user->home_artcc, 1, 3);
        switch($user->rating) {
            case 'OBS':
                $u->cert = $user->passed_sop ? 1 : 0;
                break;
            case 'S1':
                if($user->gnd_cert == 'cd') $u->cert = 2;
                else if ($user->gnd_cert == 'off') $u->cert = 3;
                else if ($user->gnd_cert == 'yes') $u->cert = 4;
                break;
            case 'S2':
                if($user->twr_cert == 'cd') $u->cert = 5;
                else if ($user->twr_cert == 'off') $u->cert = 6;
                else if ($user->twr_cert == 'yes') $u->cert = 7;
                break;
            case 'S3':
                if($user->app_cert == 'cd') {echo "on\r\n";$u->cert = 8;}
                else if ($user->app_cert == 'off') {echo "off\r\n"; $u->cert = 9;}
                else if ($user->app_cert == 'yes') {echo "yes\r\n"; $u->cert = 10;}
                break;
            case 'C1':
            case 'C3':
            case 'I1':
            case 'I3':
            case 'SUP':
            case 'ADM':
            default:
                if($user->ctr_cert == 'no') $u->cert = 10;
                else if ($user->ctr_cert == 'off') $u->cert = 11;
                else if ($user->ctr_cert == 'yes') $u->cert = 12;
                break;
        }

        return $u->save();
    }

    private function updateUser($user)
    {
        $u = \User::find($user->cid);
        $exec_group = \Sentry::findGroupByName('Executive');
        $mtr_group = \Sentry::findGroupByName('Mentors');
        $fe_group = \Sentry::findGroupByName('Facilities');
        $fe_user = \Sentry::findGroupByName('FE');
        $ta_user = \Sentry::findGroupByName('TA');
        $datm_user = \Sentry::findGroupByName('DATM');
        $atm_user = \Sentry::findGroupByName('ATM');
        $web_user = \Sentry::findGroupByName('WEB');
        $ins_group = \Sentry::findGroupByName('Instructors');
        $staff_group = \Sentry::findGroupByName('Staff');
        $ec_group = \Sentry::findGroupByName('Events');
        if($user->is_chief || $user->is_chief_ins || $user->is_asst_chief) { $u->addGroup($exec_group); }
        if($user->is_mentor || $user->is_instructor) { $u->addGroup($mtr_group); }
        if($user->is_chief) { $u->addGroup($atm_user); }
        if($user->is_asst_chief) { $u->addGroup($datm_user); }
        if($user->is_chief_ins) { $u->addGroup($ta_user); }
        if($user->is_webmaster) { $u->addGroup($web_user); }
        if($user->is_instructor) { $u->addGroup($ins_group); }
        if($user->is_facilities_engineer) { $u->addGroup($fe_group); $u->addGroup($fe_user); }
        if($user->is_event_coordinator) { $u->addGroup($ec_group); }
        if($user->is_chief || $user->is_chief_ins || $user->is_asst_chief || $user->is_mentor || $user->is_instructor || $user->is_facilities_engineer || $user->is_event_coordinator || $user->is_webmaster) {
            $u->addGroup($staff_group);
        }
        $u->artcc = substr($user->home_artcc, 1, 3);
        $u->initials = $user->initials;
        $u->activated = $user->status === 'act' ? 1 : 0;
        switch($user->rating) {
            case 'OBS':
                $u->cert = $user->passed_sop ? 1 : 0;
                break;
            case 'S1':
                if($user->gnd_cert == 'cd') $u->cert = 2;
                else if ($user->gnd_cert == 'off') $u->cert = 3;
                else if ($user->gnd_cert == 'yes') $u->cert = 4;
                break;
            case 'S2':
                if($user->twr_cert == 'cd') $u->cert = 5;
                else if ($user->twr_cert == 'off') $u->cert = 6;
                else if ($user->twr_cert == 'yes') $u->cert = 7;
                break;
            case 'S3':
                if($user->app_cert == 'cd') $u->cert = 8;
                else if ($user->app_cert == 'off') $u->cert = 9;
                else if ($user->app_cert == 'yes') $u->cert = 10;
                break;
            case 'C1':
            case 'C3':
            case 'I1':
            case 'I3':
            case 'SUP':
            case 'ADM':
            default:
                if($user->ctr_cert == 'no') $u->cert = 10;
                else if ($user->ctr_cert == 'off') $u->cert = 11;
                else if ($user->ctr_cert == 'yes') $u->cert = 12;
                break;
        }
        return $u->save();

    }
} 
