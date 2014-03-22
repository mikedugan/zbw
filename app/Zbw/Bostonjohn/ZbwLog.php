<?php  namespace Zbw\Bostonjohn;

class ZbwLog
{
    protected $file;
    public function __construct()
    {
        $this->file = app_path() . '/views/includes/bj/log.blade.php';
    }
    public function addLog($text)
    {
        $text = file_get_contents($this->file) . '<p class="log">' . $text . '</p>';
        file_put_contents($this->file, $text);
    }

    public function addError($text)
    {
        $text = file_get_contents($this->file) . '<p class="error">' . $text . '</p>';
        file_put_contents($this->file, $text);
    }

    public function addOverride($text)
    {
        $text = file_get_contents($this->file) . '<p class="override">' . $text . '</p>';
        file_put_contents($this->file, $text);
    }

    public function eraseLog()
    {
        $fh = fopen($this->file, 'w+');
        fclose($fh);
    }

    public function clearLog()
    {
        $fh = fopen($this->file, 'w+');
        $lines = explode('\n', fread($fh, filesize($this->file)));
        $exclude = [];
        foreach($lines as $l)
        {
            if(strpos($l, 'log') !== false)
            {
                continue;
            }
            array_push($exclude, $l);
        }
        fwrite($fh, implode("\n", $exclude));
        fclose($fh);
    }
} 
