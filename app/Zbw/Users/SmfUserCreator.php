<?php  namespace Zbw\Users;

class SmfUserCreator {

    public function create(\User $user)
    {
        $password = str_random(8);
        $member_id = smfapi_registerMember([
              'member_name' => $user->username,
              'email' => $user->email,
              'password' => $password,
              'real_name' => $user->initials
        ]);
        echo "\nmember id\n";
        echo $member_id;
        echo "\n\n";
        if($member_id) {
            $data = [
                'user' => $user->cid,
                'password' => $password
            ];
            \Queue::push('Zbw\Queues\QueueDispatcher@usersNewForumAccount', $data);
            return $member_id;
        } else {
            return false;
        }
    }
}
