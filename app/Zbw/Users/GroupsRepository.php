<?php namespace Zbw\Users;
use Zbw\Base\EloquentRepository;

class GroupsRepository extends EloquentRepository {

    public $model = '\Cartalyst\Sentry\Groups\Eloquent\Group';
    private $permission_groups;
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->permission_groups = \Config::get('zbw.permission_groups');
        $this->users = $users;
    }

    public function update($input)
    {
        $new_permissions = [];
        $group = \Sentry::findGroupByName('group_id');
        $group->name = $input['name'];
        foreach($this->permission_groups as $perm) {
            if(isset($input[$perm])) {
                array_push($new_permissions, $this->convertInputValueToPermissionsArray($input[$perm], $perm));
            }
        }
        $group->permissions = $new_permissions;
        return $group->save();
    }

    public function create($input)
    {
        $new_permissions = [];
        foreach($this->permission_groups as $perm) {
            if(isset($input[$perm])) {
                array_push($new_permissions, $this->convertInputValueToPermissionsArray($input[$perm], $perm));
            }
        }
        $group = \Sentry::createGroup([
              'name' => $input['name'],
              'permissions' => $this->flattenPermissions($new_permissions)
          ]);

        if(!empty($input['members']) && $group instanceof $this->model) {
            $members = explode(',', str_replace(' ', '', strtoupper($input['members'])));
            foreach($members as $member) {
                $user = $this->users->findByInitials($member);
                $user->addGroup($group);
            }
        }

        return $group instanceof $this->model ? true : false;
    }

    private function flattenPermissions($array, $prefix = '')
    {
        $result = array();

        foreach ($array as $key => $value)
        {
            $new_key = '';
            if(! is_int($key)) {
                $new_key = $prefix . (empty($prefix) ? '' : '.') . $key;
            }
            else {
                $new_key = $prefix;
            }

            if (is_array($value))
            {
                $result = array_merge($result, $this->flattenPermissions($value, $new_key));
            }
            else
            {
                $result[$new_key] = $value;
            }
        }
        return $result;
    }

    private function convertInputValueToPermissionsArray($select, $name)
    {
        $ret = [];
        if($name !== 'files') {
            switch ($select) {
                case 0:
                    $ret = [$name . '.view' => 0];
                    break;
                case 1:
                    $ret = [$name . '.view' => 1];
                    break;
                case 2:
                    $ret = [$name . '.view' => 1, $name . '.create' => 1];
                    break;
                case 3:
                    $ret = [$name . '.view'   => 1,
                            $name . '.create' => 1,
                            $name . '.update' => 1
                    ];
                    break;
                case 4:
                    $ret = [$name . '.view'   => 1,
                            $name . '.create' => 1,
                            $name . '.update' => 1,
                            $name . '.delete' => 1
                    ];
                    break;
                case 5:
                    $ret = [$name . '.all' => 1];
                    break;
            }
        }
        elseif($name === 'files') {
            switch($select) {
                case 0:
                    $ret = ['files.none' => 1];
                    break;
                case 1:
                    $ret = ['files.forum' => 1];
                    break;
                case 2:
                    $ret = ['files.sector' => 1, 'files.forum' => 1];
                    break;
                case 3:
                    $ret = ['files.upload' => 1, 'files.forum' => 1, 'files.sector' => 1];
                    break;
            }
        }
        elseif($name === 'sessions') {
            switch($select) {
                case 3:
                    $ret = ['sessions.cancel' => 1];
                    break;
                case 2:
                    $ret = ['sessions.drop' => 1, 'sessions.accept' => 1, 'sessions.view' => 1];
                    break;
                case 1:
                    $ret = ['sessions.drop' => 1, 'sessions.accept' => 1];
                    break;
                case 0:
                    $ret = ['sessions.none' => 1];
                    break;
            }
        }
        return $ret;
    }

}
