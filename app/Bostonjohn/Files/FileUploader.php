<?php  namespace Zbw\Bostonjohn\Files; 

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @author  Mike Dugan <mike@mjdugan.com>
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

    public function uploadFiles()
    {
        $filesnames = [];
        if (\Input::hasFile('image1')) {
            for ($i = 1; $i < 5; $i++) {
                $file = \Input::hasFile('image' . $i) ? \Input::file('image' . $i) : null;
                if (is_null($file)) break;
                if (!$file->isValid()) continue;
                $dir = 'uploads/sectorfiles';
                $file->move($dir, $file->getClientOriginalName());
                $filesnames[$i] = $dir . '/' . $file->getClientOriginalName();
            }
            return $filesnames;
        }
        return $filesnames;
    }
} 
