<?php  namespace Zbw\Cms;

/**
 * @package Cms
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.1b
 */
class PageCreator {

    /**
     * @var string
     */
    private $content;

    /**
     * @param null $content
     */
    public function __construct($content = null)
    {
        $this->content = $content;
    }

    /**
     * @param      $input
     * @param null $filenames
     * @return null
     */
    public function create($input, $filenames = null)
    {
        $this->content = $input;
        if(!empty($filenames)) {
            $this->insertImages($filenames);
        }
        return $this->content;
    }

    /**
     * @param $urls
     * @return void
     */
    public function insertImages($urls)
    {
        for($i = 1; $i<5; $i++) {
            if(!isset($urls[$i])) break;
            $url = '<img src="'.\Config::get('app.url') . $urls[$i].'">';
            $this->content = str_replace('{IMAGE'.$i.'}', $url, $this->content);
        }
    }
} 
