<?php  namespace Zbw\Users\Handlers; 

use Zbw\Users\Commands\SearchUsersCommand;
use Zbw\Users\Contracts\UserRepositoryInterface;

class SearchUsersHandler
{
    /**
     * @var UserRepositoryInterface
     */
    private $users;

    /**
     * @param UserRepositoryInterface $users
     */
    public function __construct(UserRepositoryInterface $users)
    {

        $this->users = $users;
    }

    public function handle(SearchUsersCommand $command)
    {
        return $this->users->search([
          'cid' => $command->cid,
          'email' => $command->email,
          'rating' => $command->rating,
          'fname' => $command->fname,
          'lname' => $command->lname,
          'oi' => $command->oi
        ]);
    }
} 
