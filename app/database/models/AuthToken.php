<?php

use Zbw\Bostonjohn\ZbwLog;
use Zbw\Users\UserRepository;

/**
 * AuthToken
 *
 * @property integer $id
 * @property string $key
 * @property string $secret
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\AuthToken whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\AuthToken whereKey($value) 
 * @method static \Illuminate\Database\Query\Builder|\AuthToken whereSecret($value) 
 * @method static \Illuminate\Database\Query\Builder|\AuthToken whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\AuthToken whereUpdatedAt($value) 
 */
class AuthToken extends BaseModel {
    protected $guarded = [''];
    protected $table = '_tokens';
    static $rules = [];

    public static function checkLogin($input, $sso)
    {
        if(! \Input::has('oauth_verifier')) return 'No verification code!';
        $token = \AuthToken::where('key', $input['oauth_token'])->first();
        $users = new UserRepository();
        $user = $sso->checkLogin($token->key, $token->secret, $input['oauth_verifier']);
        if ($user) {
            $token->delete();
            $loggedinuser = \Sentry::findUserById($user->user->id);
            $userStatus = $users->checkUser($loggedinuser);
            if(!is_null($userStatus)) return $userStatus;
            else {
                \Sentry::login($loggedinuser, true);
                $users->authUpdate($user);
            }
            return true;
        } else {
            ZbwLog::error($sso->error());
            return $sso->error();
        }
    }

    public static function setupToken($sso)
    {
        $ssotoken = $sso->requestToken(\Config::get('zbw.sso.return'), false, false);
        if ($ssotoken) {
            $token = new \AuthToken();
            $token->key = $ssotoken->token->oauth_token;
            $token->secret = $ssotoken->token->oauth_token_secret;
            $token->save();
            $sso->sendToVatsim();
        } else {
            ZbwLog::error($sso->error());
            return $sso->error();
        }
    }
}
