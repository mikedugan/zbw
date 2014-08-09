<?php  namespace Zbw\Users; 

use Zbw\Base\EloquentRepository;
use Zbw\Users\Contracts\VisitorApplicantRepositoryInterface;

class VisitorApplicantRepository extends EloquentRepository implements VisitorApplicantRepositoryInterface
{
    public $model = '\VisitorApplicant';

    public function accept($staff, $visitor_id)
    {
        $visitor = $this->make()->find($visitor_id);
        $visitor->accepted = 1;
        $visitor->accepted_by = $staff->cid;
        $visitor->accepted_on = \Carbon::now();
        return $this->checkAndSave($visitor);
    }

    public function update($input)
    {

    }

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
