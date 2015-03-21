<?php  namespace Zbw\Users; 

use Robbo\Presenter\Presenter;
use Zbw\Core\Helpers;

class UserPresenter extends Presenter
{

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param int    $s
     * @param string $d
     * @param string $r
     * @param bool   $img
     * @param array  $atts
     *
     * @return string
     */
    public function avatar($s = 100, $d = 'mm', $r = 'r', $img = false, $atts = [] ) {
        if(empty($this->settings->avatar)) {
            $url = 'https://www.gravatar.com/avatar/';
            $url .= md5(strtolower(trim($this->email)));
            $url .= "?s=$s&d=$d&r=$r";
            if ($img) {
                $url = '<img src="' . $url . '"';
                foreach ($atts as $key => $val)
                    $url .= ' ' . $key . '="' . $val . '"';
                $url .= ' />';
            }
            return $url;
        }
        else return $this->settings->avatar;
    }

    public function nextCert()
    {

        return Helpers::readableCert($this->cert + 1);
    }

    public function lastCert()
    {
        return Helpers::readableCert($this->cert - 1);
    }
} 
