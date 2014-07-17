<?php  namespace Zbw\Bostonjohn\Files; 

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{

    private $file;
    private $validator;

    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
        $this->validator = new FileValidator($file);
    }

    public function upload($path = null, $name = null)
    {
        try {
            $this->validator->isValid();
        } catch(MaxFilesizeExceededException $e) {
            return false;
        } catch(MimeExtensionMismatchException $e) {
            return false;
        }

        if(!$path) {
            $this->moveToDefaultPath($name);
        } else {
            $this->moveToPath($path, $name);
        }

    }

    private function moveToPath($path, $name)
    {
        if($name) {
            $this->file->move($path,$name);
        } else {
            $this->file->move($path, $this->file->getClientOriginalName());
        }
    }

    private function moveToDefaultPath($name)
    {
        if($name) {
            $this->file->move(
              public_path() . DIRECTORY_SEPARATOR . \Config::get('file.default_upload_path'),
              $name
            );
        } else {
            $this->file->move(
              public_path() . DIRECTORY_SEPARATOR . \Config::get('file.default_upload_path'),
              $this->file->getClientOriginalName()
            );
        }
    }
} 
