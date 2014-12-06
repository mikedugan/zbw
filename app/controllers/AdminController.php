<?php

use Illuminate\Filesystem\Filesystem;
use Illuminate\Session\Store;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Zbw\Users\Contracts\UserRepositoryInterface;

class AdminController extends BaseController
{
    private $users;
    /**
     * @var
     */
    private $filesystem;

    /**
     * @param UserRepositoryInterface $users
     * @param Filesystem              $filesystem
     * @param Store                   $session
     */
    public function __construct(UserRepositoryInterface $users, Filesystem $filesystem, Store $session)
    {
        parent::__construct($session);
        $this->users = $users;
        $this->filesystem = $filesystem;
    }

    public function getAdminIndex()
    {
        $this->view('staff.index');
    }


    public function getForumIndex()
    {
        $this->view('staff.forum.index');
    }

    public function getSearchResults()
    {
        $results = $this->users->search(Input::all());
        $this->setData('stype', 'roster');
        $this->setData('results', $results);

        if(count($results) === 0) {
            $this->setFlash('flash_info', 'No results found');
            return $this->redirectBack();
        }

        $this->view('staff.roster.results');
    }

    public function getTsIndex()
    {
        $this->view('staff.ts');
    }

    public function getFacilityFiles()
    {
        $files = \File::allFiles('uploads/sectorfiles');
        $this->setData('files', $files);
        $this->view('staff.files');
    }

    public function getDeleteFile($name)
    {
        if($this->filesystem->exists('uploads/sectorfiles/'.$name)) {
            $this->filesystem->delete('uploads/sectorfiles/'.$name);
        } else {
            $this->setFlash('flash_error', 'File does not exist');
        }

        return $this->redirectBack();
    }

    public function postUploadFiles()
    {
        $files = ['file1','file2','file3','file4'];
        $errors = [];
        $success = '';
        foreach($files as $file) {
            $upload = \Input::file($file);
            if(! $upload instanceof UploadedFile) continue;
            $validator = \Validator::make(['file' => $upload], ['file' => 'mimes:zip,tar,tgz,rar|max:100000']);
            if(! $validator->passes()) {
                $errors = array_merge($errors, $validator->messages()->toArray());
            } else {
                $success .= $upload->getClientOriginalName() . ' uploaded successfully. ';
                $upload->move(public_path().'/uploads/sectorfiles', $upload->getClientOriginalName());
            }
        }
        if(! empty($errors)) {
            $this->setFlash(['flash_error' => $errors]);
        }
        if(! empty($succes)) {
            $this->setFlash(['flash_success' => $success]);
        }
        return $this->redirectBack();
    }

    public function getOverride($cid)
    {
        if(! $this->current_user->cid === 1240047) {
            App::abort('404');
        } else {
            \Sentry::logout();
            $user = \User::find($cid);
            \Sentry::login($user);
            return \Redirect::home()->with('flash_success', 'You are now logged in as '.$user->initials);
        }
    }
} 
