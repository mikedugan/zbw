<?php 

use Cartalyst\Sentry\Groups\Eloquent\Group as SentryGroup;

/**
 * Group
 *
 * @property integer $id
 * @property string $name
 * @property string $permissions
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\static::$userModel[] $users
 * @method static \Illuminate\Database\Query\Builder|\Group whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Group whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Group wherePermissions($value)
 * @method static \Illuminate\Database\Query\Builder|\Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Group whereUpdatedAt($value)
 */
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
