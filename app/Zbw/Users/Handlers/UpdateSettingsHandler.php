<?php  namespace Zbw\Users\Handlers; 

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Zbw\Bostonjohn\Files\Exceptions\FileNotAllowedException;
use Zbw\Users\Commands\UpdateSettingsCommand;
use Zbw\Bostonjohn\Files\FileValidator;
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

        $data = $command->getInput();
        $success = $this->users->updateSettings($u->cid, $data) === true ?: false;
        if(isset($data['ts_key'])) {
            $key = new \TsKey([
                'cid' => $u->cid,
                'ts_key' => $data['ts_key'],
                'expires' => \Carbon::now()->addDay(),
                'used' => 0,
                'uid' => '',
                'status' => 0
            ]);
            $key->save();
        }
        if(\Input::hasFile('avatar')) {
            $path = public_path().'/uploads/avatars/';
            $avatar = \Input::file('avatar');
            try {
                if ((new FileValidator($avatar))->isValid(['jpg', 'png', 'gif'])) {
                    $avatar->move($path, $u->cid . '.' . $avatar->getClientOriginalExtension());
                    $newPath = '/uploads/avatars/' . $u->cid . '.' . $avatar->getClientOriginalExtension();
                    $success = $this->users->updateAvatar($u, $newPath) === true ?: false;
                } else {
                    throw new FileException;
                }
            } catch (MaxFilesizeExceededException $e) {
                $success = false;
                \Session::flash('flash_error', $e->getMessage());
            } catch (FileNotAllowedException $e) {
                $success = false;
                \Session::flash('flash_error', $e->getMessage());
            }
        }

        return $success;
    }
}
