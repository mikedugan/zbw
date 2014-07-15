<?php  namespace Zbw\Cms; 

class PageCreator {

    private $content;

    public function __construct($content = null)
    {
        $this->content = $content;
    }

    public function create($input, $filenames)
    {
        $this->content = $input;
        $this->insertImages($filenames);
        return $this->content;
    }

    public function insertImages($urls)
    {
        for($i = 1; $i<5; $i++) {
            if(!isset($urls[$i])) break;
            $url = '<img src="'.\Config::get('app.url') . $urls[$i].'">';
            $this->content = str_replace('{IMAGE'.$i.'}', $url, $this->content);
        }
    }
} 
