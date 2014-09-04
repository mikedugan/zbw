<?php

use Illuminate\Filesystem\Filesystem;
use Illuminate\Session\Store;
use Zbw\Bostonjohn\Files\FileUploader;
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
            return Redirect::back()->with('flash_info', 'No results found');
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

    public function postUploadFile()
    {

    }
} 
