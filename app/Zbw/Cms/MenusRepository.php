<?php  namespace Zbw\Cms;

use Zbw\Core\EloquentRepository;
use Zbw\Cms\Contracts\MenusRepositoryInterface;

/**
 * @package Zbw\Cms
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.1b
 */
class MenusRepository extends EloquentRepository implements MenusRepositoryInterface
{
    /**
     * @var string
     */
    public $model = '\Menu';

    /**
     * @param $input
     * @return bool
     */
    public function create($input)
    {
        $menu = new \Menu();
        $menu->title = $input['title'];
        $menu->location = json_encode($input['location']);
        return $this->checkAndSave($menu);
    }

    /**
     * @param $input
     * @return bool
     */
    public function update($input)
    {
        $menu = $this->make()->get($input['id']);
        $menu->title = $input['title'];
        $menu->location = json_encode($input['location']);
        return $this->checkAndSave($menu);
    }
} 
