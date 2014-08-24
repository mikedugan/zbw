<?php  namespace Zbw\Users\Presenters; 

use Zbw\Base\BasePresenter;

class StaffingPresenter extends BasePresenter
{
    public function timeOnline()
    {
        $minutes = $this->created_at->diffInMinutes($this->stop);
        $hours = 0;
        if($minutes > 60) {
            $hours = floor($minutes / 60); $minutes = $minutes % 60;
        }
        return $hours > 0 ? $hours . ' hour(s) ' . $minutes . ' minutes' : $minutes . ' minutes';
    }
} 
