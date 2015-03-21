<?php namespace Zbw\Notifier;

class EmailTemplateRepository 
{
    public function listAll()
    {
        return \File::allFiles(app_path('/views/zbw/emails'));
    }
}
