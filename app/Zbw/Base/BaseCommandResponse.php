<?php  namespace Zbw\Base;

class BaseCommandResponse implements CommandResponseInterface
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @var array
     */
    private $flash_data;

    /**
     * @var MessageBag|array
     */
    private $errors;

    /**
     * @var bool
     */
    private $success;

    /**
     * @param mixed $data
     */
    function __construct($data = null)
    {
        $this->data = $data;
    }

    public function success()
    {
        return $this->success;
    }

    public function failed()
    {
        return ! $this->success;
    }

    public function setSuccess($status)
    {
        $this->success = $status;
    }

    /**
     * Returns an array of flash data which may contain one or more of: flash_success, flash_error, flash_warning, flash_info
     *
     * @return mixed
     */
    public function getFlashData()
    {
        return $this->flash_data;
    }

    /**
     * Simple transporter for flash data. Should be passed an array containing one or more of: flash_success, flash_error, flash_warning, flash_info
     *
     * @param $flash_data
     * @return void
     */
    public function setFlashData($flash_data)
    {
        $this->flash_data = $flash_data;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param $errors
     * @return void
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $data
     * @return void
     */
    public function setData($data)
    {
        $this->data = $data;
    }
} 
