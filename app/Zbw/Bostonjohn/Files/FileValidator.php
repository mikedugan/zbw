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
     * @param array $ext
     * @throws FileNotAllowedException
     * @throws MaxFilesizeExceededException
     * @throws MimeExtensionMismatchException
     * @return bool
     */
    public function isValid(array $ext = null)
    {
        try {
            if($ext) {
                $matches = in_array($this->file->getExtension(), $ext);
            } else {
                $matches = \Config::get('file.mimes')[$this->file->getClientOriginalExtension()] === $this->file->getMimeType();
            }
        } catch (\ErrorException $e) {
            $ext = $this->file->getClientOriginalExtension();
            throw new FileNotAllowedException("Files with extension $ext not allowed");
        }

        if($matches) {
            $mime_base = explode('/', $this->file->getMimeType())[0];
            $max_filesize = \Config::get('file.max_size')[$mime_base];
            if($this->file->getSize() < $max_filesize) {
                return true;
            }
            throw new MaxFilesizeExceededException("File must be under { $max_filesize/1000 } kbytes");
        } else {
            throw new FileNotAllowedException('This file is not an allowed type or there was a mime type mismatch');
        }
        return ! $this->errors;
    }
} 
