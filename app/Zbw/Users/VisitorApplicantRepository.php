<?php  namespace Zbw\Users; 

use Zbw\Core\EloquentRepository;
use Zbw\Users\Contracts\VisitorApplicantRepositoryInterface;

/**
 * @package Users
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.8b
 */
class VisitorApplicantRepository extends EloquentRepository implements VisitorApplicantRepositoryInterface
{
    /**
     * @var string
     */
    public $model = '\VisitorApplicant';

    /**
     * @param $staff
     * @param $visitor_id
     * @return bool|mixed
     */
    public function accept($staff, $visitor_id)
    {
        $visitor = $this->make()->find($visitor_id);
        $visitor->accepted = 1;
        $visitor->accepted_by = $staff->cid;
        $visitor->accepted_on = \Carbon::now();
        if($this->checkAndSave($visitor)) {
            return $visitor->cid;
        } else {
            return false;
        }
    }

    /**
     * @param $staff
     * @param $input
     * @return array|bool
     */
    public function deny($staff, $input)
    {
        $visitor = $this->make()->find($input['visitor']);
        $visitor->accepted = -1;
        $visitor->accepted_by = $staff->cid;
        $visitor->accepted_on = \Carbon::now();
        $visitor->comments = $visitor->comments . '<br>'.$input['reason'];
        if($this->checkAndSave($visitor)) {
            return [$visitor->cid, $input['reason']];
        } else {
            return false;
        }
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return \VisitorApplicant::destroy($id);
    }

    /**
     * @param $staff
     * @param $input
     * @return bool
     */
    public function comment($staff, $input)
    {
        $visitor = $this->make()->find($input['visitor']);
        $visitor->comments = $visitor->comments .'<br>'.$staff->initials .': '.$input['comment'] . ' ('.\Carbon::now()->toDayDateTimeString().')';
        return $this->checkAndSave($visitor);
    }

    /**
     * @param $staff
     * @param $input
     * @return bool
     */
    public function addLor($staff, $input)
    {
        $visitor = $this->make()->find($input['visitor']);
        $visitor->lor = $input['lor'];
        $visitor->lor_submitted = 1;
        $visitor->lor_submitted_on = \Carbon::now();
        $visitor->comments = $visitor->comments . '<br>LOR uploaded by ' . $staff->initials;
        return $this->checkAndSave($visitor);
    }

    /**
     * @param $input
     * @return void
     */
    public function update($input)
    {

    }

    /**
     * @param $input
     * @return bool
     */
    public function create($input)
    {
          $visitor = $this->make();
          $visitor->email = $input['email'];
          $visitor->first_name = $input['fname'];
          $visitor->last_name = $input['lname'];
          $visitor->division = $input['home'];
          $visitor->home = $input['artcc'];
          $visitor->rating = \Rating::whereLong($input['rating'])->firstOrFail()->id;
          $visitor->message = $input['message'];
          $visitor->cid = $input['cid'];
          return $this->checkAndSave($visitor);
    }
}
