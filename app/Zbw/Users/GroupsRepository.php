<?php namespace Zbw\Users;
use Zbw\Core\EloquentRepository;
use Zbw\Users\Contracts\GroupsRepositoryInterface;
use Zbw\Users\Contracts\UserRepositoryInterface;

class GroupsRepository extends EloquentRepository implements GroupsRepositoryInterface
{

    public $model = '\Group';
    private $permission_groups;
    private $users;

    public function __construct(UserRepositoryInterface $users)
    {
        $this->permission_groups = \Config::get('zbw.permission_groups');
        $this->users = $users;
    }

    public function update($input)
    {
        $new_permissions = [];
        $group = \Sentry::findGroupByName($input['group_id']);
        $group->name = $input['name'];
        foreach($this->permission_groups as $perm) {
            if(isset($input[$perm])) {
                array_push($new_permissions, $this->convertInputValueToPermissionsArray($input[$perm], $perm));
            }
        }
        $group->permissions = $this->flattenPermissions($new_permissions);
        dd($group->permissions);
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
        $result = [];

        foreach ($array as $key => $value)
        {
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

    public function updateGroup($input)
    {
        $group = \Sentry::findGroupById($input['group_id']);
        $remove_initials = null;
        $new_initials = null;
        if(!empty($input['remove_users'])) {
            $remove_initials = explode(
              ',',
              str_replace(' ', '', $input['remove_users'])
            );
        }
        if(!empty($input['new_users'])) {
            $new_initials = explode(
              ',',
              str_replace(' ', '', $input['new_users'])
            );
        }
        if($remove_initials || $new_initials) {
            $max = count($new_initials) >= count(
              $remove_initials
            ) ? count($new_initials) : count($remove_initials);
            for ($i = 0; $i <= $max; $i++) {
                if (isset($new_initials[$i])) {
                    $user = $this->users->findByInitials($new_initials[$i]);
                    $user->addGroup($group);
                }
                if (isset($remove_initials[$i])) {
                    $user = $this->users->findByInitials($remove_initials[$i]);
                    $user->removeGroup($group);
                }
            }
        }
        $new_permissions = [];
        foreach($this->permission_groups as $perm) {
            if(isset($input[$perm])) {
                array_push($new_permissions, $this->convertInputValueToPermissionsArray($input[$perm], $perm));
            }
        }
        $group->permissions = $this->flattenPermissions($new_permissions);
        $group->name = $input['name'];
        return $group->save();
    }

}
