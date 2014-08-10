<?php  namespace Zbw\Bostonjohn\Files; 

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @package Bostonjohn
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.1b
 */
class FileUploader
{

    private $file;
    private $validator;

    /**
     * @param UploadedFile $file
     */
    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
        $this->validator = new FileValidator($file);
    }

    /**
     * Main function that uploads the file
     *
     * @param null $path
     * @param null $name
     * @throws \Zbw\Bostonjohn\Files\Exceptions\MaxFilesizeExceededException
     * @throws \Zbw\Bostonjohn\Files\Exceptions\MimeExtensionMismatchException
     * @return void
     */
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

    /**
     * @param $path
     * @param $name
     * @return void
     */
    private function moveToPath($path, $name)
    {
        if($name) {
            $this->file->move($path,$name);
        } else {
            $this->file->move($path, $this->file->getClientOriginalName());
        }
    }

    /**
     * @param $name
     * @return void
     */
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
