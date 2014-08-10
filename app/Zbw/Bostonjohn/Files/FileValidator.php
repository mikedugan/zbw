<?php  namespace Zbw\Bostonjohn\Files;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Zbw\Bostonjohn\Files\Exceptions\MimeExtensionMismatchException;
use Zbw\Bostonjohn\Files\Exceptions\MaxFilesizeExceededException;
use Zbw\Bostonjohn\Files\Exceptions\FileNotAllowedException;

/**
 * @package Bostonjohn
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.1b
 */
class FileValidator
{

    private $file;
    private $errors;

    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
    }

    /**
     * @throws Exceptions\FileNotAllowedException
     * @throws Exceptions\MaxFilesizeExceededException
     * @throws Exceptions\MimeExtensionMismatchException
     * @return bool
     */
    public function isValid()
    {
        try {
            $matches = \Config::get('file.mimes')[$this->file->getClientOriginalExtension()] === $this->file->getMimeType();
        } catch (\ErrorException $e) {
            throw new FileNotAllowedException('Files with extension '.$this->file->getClientOriginalExtension().' not allowed');
        }

        if($matches) {
            $mime_base = explode('/', $this->file->getMimeType());
            $max_filesize = \Config::get('file.max_size')[$mime_base];
            if($this->file->getSize() < $max_filesize) {
                return true;
            }
            throw new MaxFilesizeExceededException('File must be under '.$max_filesize.' bytes');
        } else {
            throw new MimeExtensionMismatchException('Detected mime does not match the file extension');
        }
        return ! $this->errors;
    }
} 
