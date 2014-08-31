<?php  namespace Zbw\Cms;

use Zbw\Core\EloquentRepository;
use Zbw\Cms\Contracts\PagesRepositoryInterface;

/**
 * @package Zbw\Cms
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.b
 */
class PagesRepository extends EloquentRepository implements PagesRepositoryInterface
{
    /**
     * @var PageCreator
     */
    private $creator;

    /**
     * @param PageCreator $creator
     */
    public function __construct(PageCreator $creator)
    {
        $this->creator = $creator;
    }

    /**
     * @var string
     */
    public $model = '\Page';

    /**
     * @param $input
     * @return bool
     */
    public function update($input)
    {
        $page = $this->get($input['pid']);
        $filenames = [];
        $page->title = $input['title'];
        $page->slug = \Str::slug($input['title']);
        $page->published = $input['published'];
        $page->author = $input['author'];
        $page->content = ' ';
        $page->audience_type_id = isset($input['audience_type']) ? $input['audience_type'] : 1;
        $page->save();
        $filenames = $this->parseInputFiles($filenames);
        $page->is_official = 0;
        $page->content = $this->creator->create(\Input::get('content'), $filenames);
        return $this->checkAndSave($page);

    }

    /**
     * @param $slug
     * @return mixed
     */
    public function slug($slug)
    {
        return $this->make()->where('slug', $slug)->first();
    }

    /**
     * @param $input
     * @return bool
     */
    public function create($input)
    {
        $page = new \Page();

        $filesnames = [];

        $page->title = $input['title'];
        $page->slug = \Str::slug($input['title']);
        $page->published = $input['published'];
        $page->author = $input['author'];
        $page->content = ' ';
        $page->audience_type_id = isset($input['audience_type']) ? $input['audience_type'] : 1;
        $page->save();
        $filesnames = $this->parseInputFiles($filesnames);
        $page->is_official = 0;
        $page->content = $this->creator->create(\Input::get('content'), $filesnames);
        return $this->checkAndSave($page);
    }

    /**
     * @return array
     */
    private function makeUploadDirectory()
    {
        $month = date('m');
        $year = date('Y');
        $path = '/uploads/cms/'.$year.'/'.$month;
        $directory = public_path().$path;
        if(! \File::isDirectory($directory)) {
            \File::makeDirectory($directory, 755, true);
        }
        return [$directory, $path];
    }

    /**
     * @static * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function orphaned()
    {
        return \Page::where('menu_id', null)->get();
    }

    /**
     * 
     * @param $filesnames
     * @return mixed
     */
    private function parseInputFiles($filesnames)
    {
        if (\Input::hasFile('image1')) {
            for ($i = 1; $i < 5; $i++) {
                $file = \Input::hasFile('image' . $i) ? \Input::file('image' . $i) : null;
                if (is_null($file)) break;
                if (!$file->isValid()) continue;
                $dir = $this->makeUploadDirectory();
                $file->move($dir[0], $file->getClientOriginalName());
                $filesnames[$i] = $dir[1] . '/' . $file->getClientOriginalName();
            }
            return $filesnames;
        }
        return $filesnames;
    }
} 
