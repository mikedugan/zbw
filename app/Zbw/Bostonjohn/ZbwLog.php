<?php  namespace Zbw\Bostonjohn;

class ZbwLog {
    protected $file;
    public function __construct()
    {
        $this->file = app_path() . '/views/includes/bj/log.blade.php';
    }

    /**
     * static wrapper function for the addLog function
     * @param string log message
     * @param string log type (CSS class)
     * @return void
     */
    public static function log($text, $type = '')
    {
        $log = new ZbwLog();
        $log->addLog($text, $type);
    }

    /**
     * static wrapper function for the addError function
     * @param string error message
     * @return void
     */
    public static function error($text)
    {
        $log = new ZbwLog();
        $log->addError($text);
    }

    /**
     * @param string override message
     * @return void
     */
    public static function override($text)
    {
        $log = new ZbwLog();
        $log->addOverride($text);
    }

    /**
     * @param string log message
     * @param string log type (css class)
     * @return void
     */
    public function addLog($text, $type = '')
    {
        $text = file_get_contents($this->file) . '<p class="log '.$type.'">' . $text . '('. \Carbon::now() . ')</p>';
        file_put_contents($this->file, $text);
    }

    /**
     * @param string error message
     * @return void
     */
    public function addError($text)
    {
        $text = file_get_contents($this->file) . '<p class="error">' . $text . '</p>';
        file_put_contents($this->file, $text);
    }

    /**
     * @param string override message
     * @return void
     */
    public function addOverride($text)
    {
        $text = file_get_contents($this->file) . '<p class="override">' . $text . '</p>';
        file_put_contents($this->file, $text);
    }
} 
