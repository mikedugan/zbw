<?php  namespace Zbw\Bostonjohn\Files;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Exceptions\MimeExtensionMismatchException;
use Exceptions\MaxFilesizeExceededException;

class FileValidator
{

    private $file;
    private $errors;

    public function __construct(UploadedFile$file)
    {
        $this->file = $file;
    }

    public function isValid()
    {
        $matches = \Config::get('file.mimes')[$this->file->getClientOriginalExtension()] === $this->file->getMimeType();
        if($matches) {
            $mime_base = explode('/', $this->file->getMimeType());
            if($this->file->getSize() < \Config::get('file.max_size')[$mime_base]) {
                return true;
            }
            throw new MaxFilesizeExceededException;
        } else {
            throw new MimeExtensionMismatchException;
        }
        return ! $this->errors;
    }
} 
