<?php


namespace Zbw\Core;

interface CommandResponseInterface
{
    public function success();

    public function failed();

    public function setSuccess($status);

    /**
     * Returns an array of flash data which may contain one or more of: flash_success, flash_error, flash_warning, flash_info
     * @return mixed
     */
    public function getFlashData();

    /**
     * Simple transporter for flash data. Should be passed an array containing one or more of: flash_success, flash_error, flash_warning, flash_info
     * @param $flash_data
     * @return void
     */
    public function setFlashData($flash_data);

    /**
     * @return mixed
     */
    public function getErrors();

    /**
     * @param $errors
     * @return void
     */
    public function setErrors($errors);

    /**
     * @return mixed
     */
    public function getData();

    /**
     * @param $data
     * @return void
     */
    public function setData($data);
}
