<?php 

use Cartalyst\Sentry\Groups\Eloquent\Group as SentryGroup;

class Group extends SentryGroup {

    public function truePermissions()
    {
        $perms = $this->getPermissions();
        $ret = '';
        foreach($perms as $perm => $value) {
            if($value === 1) { $ret .= $perm.','; }
        }
        return explode(',', rtrim($ret, ','));
    }
}
