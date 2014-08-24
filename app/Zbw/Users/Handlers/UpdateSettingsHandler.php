<?php  namespace Zbw\Users\Handlers; 

use Zbw\Users\Commands\UpdateSettingsCommand;
use Zbw\Users\Contracts\UserRepositoryInterface;

class UpdateSettingsHandler
{
    private $users;

    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
    }

    public function handle(UpdateSettingsCommand $command)
    {
        $u = \Sentry::getUser();
        $success = true;

        $data = $command->getInput();
        $success = $this->users->updateSettings($u->cid, $data) === true ?: false;

        if(\Input::hasFile('avatar')) {
            $path = public_path().'/uploads/avatars/';
            $avatar = \Input::file('avatar');
            if((new FileValidator($avatar))->isValid()) {
                $avatar->move($path, $u->cid . '.' . $avatar->getClientOriginalExtension());
                $newPath = '/uploads/avatars/' . $u->cid . '.' . $avatar->getClientOriginalExtension();
                $success = $this->users->updateAvatar($u, $newPath) === true ?: false;
            }
        }

        return $success;
    }
}
