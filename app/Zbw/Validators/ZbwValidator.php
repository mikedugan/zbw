<?php namespace Zbw\Validators;

use Zbw\Helpers;

class ZbwValidator {
    protected $errors;
    protected $cids;
    protected $sids;
    protected $tids;

    public function __construct()
    {
        /*$this->cids = Helpers::getCids(true);
        $this->sids = Helpers::getSids(true);
        $this->tids = Helpers::getTids(true);*/
    }
    /**
     * @param array $input
     * @return bool
     */
    public function validate($input)
    {
        $validator = \Validator::make($input, static::$rules);
        if($validator->fails())
        {
            $this->errors = $validator->messages();
            return false;
        }
        return true;
    }

    public function errors()
    {
        return $this->errors;
    }

    /**
     * static wrapper function that will instantiate and return
     * the validator, or return errors array if validation fails
     *
     * @param string $name - name of the child class
     * @param array $input - Input::all() etc
     * @return mixed
     */
    public static function get($name, $input = null)
    {
        if($input)
        {
            $name = 'Zbw\\Validators\\'.$name.'Validator';
            $validator = new $name;
            return $validator->validate($input) ? true : $validator->errors()->toArray();
        }

        else
        {
            $name = 'Zbw\\Validators\\'.$name.'Validator';
            return new $name;
        }
    }
}
