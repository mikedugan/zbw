<?php

/**
 * Simple Machines Forum(SMF) 'REST' API for SMF 2.0
 *
 * Use this to integrate your SMF version 2.0 forum with 3rd party software
 * If you need help using this script or integrating your forum with other
 * software, feel free to contact andre@r2bconcepts.com
 *
 * @package   SMF 2.0 'REST' API
 * @author    Simple Machines http://www.simplemachines.org
 * @author    Andre Nickatina <andre@r2bconcepts.com>
 * @copyright 2011 Simple Machines
 * @link      http://www.simplemachines.org Simple Machines
 * @link      http://www.r2bconcepts.com Red2Black Concepts
 * @license   http://www.simplemachines.org/about/smf/license.php BSD
 * @version   0.1.0
 *
 * NOTICE OF LICENSE
 ***********************************************************************************
 * This file, and ONLY this file is released under the terms of the BSD License.   *
 *                                                                                 *
 * Redistribution and use in source and binary forms, with or without              *
 * modification, are permitted provided that the following conditions are met:     *
 *                                                                                 *
 * Redistributions of source code must retain the above copyright notice, this     *
 * list of conditions and the following disclaimer.                                *
 * Redistributions in binary form must reproduce the above copyright notice, this  *
 * list of conditions and the following disclaimer in the documentation and/or     *
 * other materials provided with the distribution.                                 *
 * Neither the name of Simple Machines LLC nor the names of its contributors may   *
 * be used to endorse or promote products derived from this software without       *
 * specific prior written permission.                                              *
 *                                                                                 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"     *
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE       *
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE      *
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE        *
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR             *
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE *
 * GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)     *
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT      *
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT   *
 * OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE. *
 **********************************************************************************/

define ('SECRET_KEY', 'WAhZHbLIKNqBZ2nVvHrs'); // set your secret key here

class SmfRestServer
{
    private $secretKey;
    private $format;
    private $route;
    private $method;
    private $error;
    private $data;
    private $return = array();

    public function __construct($request)
    {
        foreach ($request as $k => $v) {
            $this->$k = $v;
        }

        $this->getRoute()->getMethod();
        if ($this->validateSecretKey()) {
            try {
                $this->callMethod();
            } catch(Exception $e) {
                $this->error = $e->getMessage();
            }
        } else {
            $this->error = 'Secret Key invalid';
        }

        $this->renderOutput();
    }

    /**
     * @name         hasData
     * @description
     *
     * @param string $key
     *
     * @return bool
     */
    protected function hasData($key = '')
    {
        if (!isset($this->$key) || empty($this->$key)) {
            return false;
        }

        return true;
    }

    /**
     * @name  getData
     * @description
     *
     * @param $key
     *
     * @return null
     */
    protected function getData($key)
    {
        if ($this->hasData($key)) {
            return $this->$key;
        }

        return null;
    }

    /**
     * @name  setData
     * @description
     *
     * @param $key
     * @param $data
     *
     * @return void
     */
    protected function setData($key, $data)
    {
        $this->$key = $data;

        return;
    }

    /**
     * @name  toJson
     * @description
     *
     * @param $data
     *
     * @return string
     */
    protected function toJson($data)
    {
        return json_encode($data);
    }

    /**
     * @name getRoute
     * @description
     * @return $this
     */
    protected function getRoute()
    {
        $cwd = getcwd();
        $cwd = str_replace($_SERVER['DOCUMENT_ROOT'], '', $cwd);
        $route = str_replace($cwd, '', $_SERVER['REQUEST_URI']);

        if ('/' == substr($route, 0, 1)) {
            $route = substr($route, 1);
        }

        $this->route = $route;

        return $this;
    }

    /**
     * @name getMethod
     * @description
     * @return void
     */
    protected function getMethod()
    {
        $parts = explode('.', $this->route);
        $method = str_replace('/', '_', $parts[0]);
        $this->method = $method;

        if (isset($parts[1]) && 'json' == $parts[1]) {
            $this->format = 'json';
        } else {
            $this->format = 'raw';
        }
    }

    /**
     * @name loadApi
     * @description
     * @throws Exception
     * @return $this
     */
    protected function loadApi()
    {
        //load the API file
        $apiScript = 'smf_2_api.php';
        if (file_exists($apiScript)) {
            extract($GLOBALS, EXTR_REFS);
            ob_start();
            @include($apiScript);
            ob_get_clean();
        } else {
            throw new Exception('API file not found');
        }

        return $this;
    }

    /**
     * @name loadSSI
     * @description
     * @throws Exception
     * @return $this
     */
    protected function loadSSI()
    {
        $saveFile = dirname(__FILE__) . '/smfapi_settings.txt';
        if (file_exists($saveFile)) {
            $settings_path = base64_decode(file_get_contents($saveFile));
        } else {
            try {
                $this->loadApi();
            } catch(Exception $e) {
                throw new Exception($e->getMessage());
            }
            throw new Exception('Try again, the settings path should be saved now.');
        }

        $ssiScript = str_replace('Settings.php', 'SSI.php', $settings_path);

        //load the SSI file
        if (file_exists($ssiScript)) {
            require_once "$ssiScript";
        } else {
            throw new Exception('SSI file not found');
        }

        //loadSession();

        return $this;
    }

    /**
     * @name validateSecretKey
     * @description
     * @return bool
     */
    protected function validateSecretKey()
    {
        if ($this->secretKey != SECRET_KEY) {
            return false;
        }

        return true;
    }

    /**
     * @name callMethod
     * @description
     * @throws Exception
     * @return void
     */
    protected function callMethod()
    {
        if (method_exists('SmfRestServer', $this->method)) {
            try {
                call_user_func(array($this, $this->method));
            } catch(Exception $e) {
                throw new Exception($e->getMessage());
            }
        } else {
            throw new Exception('Unknown method ' . $this->method . ' was called');
        }
    }

    /**
     * @name renderOutput
     * @description
     * @return void
     */
    public function renderOutput()
    {
        if (!isset($this->data) || empty($this->data) || false === $this->data) {
            $this->data = 'false';
        } else {
            if (true === $this->data) {
                $this->data = 'true';
            }
        }

        $this->return['data'] = $this->data;
        $this->return['error'] = $this->error;

        if ('raw' == $this->format) {
            var_dump($this->return);
        } else {
            echo $this->toJson($this->return);
        }
    }

    // ***************
    // Special Methods
    // ***************

    /**
     * @name logout_userRest
     * @description
     * @throws Exception
     * @return void
     */
    protected function logout_userRest()
    {
        try {
            $this->loadApi();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        global $user_info, $smcFunc;

        if (isset($user_info['id']) && 0 != $user_info['id']) {
            // remove from online log
            $smcFunc['db_query'](
              '', '
                DELETE FROM {db_prefix}log_online
                WHERE id_member = {int:current_member}',
              array(
                'current_member' => $user_info['id'],
              )
            );
        }

        // wreck the cookie
        smfapi_setLoginCookie(-3600, 0);

        $this->data = 'true';
    }

    /**
     * @name create_post
     * @description
     * @throws Exception
     * @return void
     */
    protected function create_post()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
        global $sourcedir;
        require_once($sourcedir . '/Subs-Post.php');

        $this->msgOptions = unserialize($this->msgOptions);
        $this->topicOptions = unserialize($this->topicOptions);
        $this->posterOptions = unserialize($this->posterOptions);

        if (!isset($topicOptions['board']) || !isset($msgOptions['subject']) || !isset($msgOptions['body'])) {
            $this->data = 'false';
        } else {
            $this->data = createPost($this->msgOptions, $this->topicOptions, $this->posterOptions);
        }
    }

    /**
     * @name send_pm
     * @description
     * @throws Exception
     * @return void
     */
    protected function send_pm()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
        global $sourcedir;
        require_once($sourcedir . '/Subs-Post.php');

        $this->recipients = unserialize($this->recipients);
        $this->from = unserialize($this->from);

        $this->data = sendpm($this->recipients, $this->subject, $this->message, $this->store_outbox, $this->from, $this->pm_head);
    }

    // ***************
    // API Methods
    // ***************

    /**
     * @name get_user
     * @description
     * @throws Exception
     * @return void
     */
    protected function get_user()
    {
        try {
            $this->loadApi();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->data = smfapi_getUserData($this->identifier);
    }

    /**
     * @name get_userInfo
     * @description
     * @throws Exception
     * @return void
     */
    protected function get_userInfo()
    {
        try {
            $this->loadApi();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        global $user_info;

        $this->data = $user_info;
    }

    /**
     * @name login_user
     * @description
     * @throws Exception
     * @return void
     */
    protected function login_user()
    {
        try {
            $this->loadApi();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->data = smfapi_login($this->identifier, $this->cookieLength);
    }

    /**
     * @name authenticate_user
     * @description
     * @throws Exception
     * @return void
     */
    protected function authenticate_user()
    {
        try {
            $this->loadApi();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->data = smfapi_authenticate($this->username, $this->password, $this->encrypted);
    }

    /**
     * @name logout_user
     * @description
     * @throws Exception
     * @return void
     */
    protected function logout_user()
    {
        try {
            $this->loadApi();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->data = smfapi_logout($this->username);
    }

    /**
     * @name delete_members
     * @description
     * @throws Exception
     * @return void
     */
    protected function delete_members()
    {
        try {
            $this->loadApi();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->users = unserialize($this->users);

        $this->data = smfapi_deleteMembers($this->users);
    }

    /**
     * @name register_member
     * @description
     * @throws Exception
     * @return void
     */
    protected function register_member()
    {
        try {
            $this->loadApi();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->regOptions = unserialize($this->regOptions);

        $this->data = smfapi_registerMember($this->regOptions);
    }

    /**
     * @name log_error
     * @description
     * @throws Exception
     * @return void
     */
    protected function log_error()
    {
        try {
            $this->loadApi();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->data = smfapi_logError($this->error_message, $this->error_type, $this->file, $this->line);
    }

    /**
     * @name update_memberData
     * @description
     * @throws Exception
     * @return void
     */
    protected function update_memberData()
    {
        try {
            $this->loadApi();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->info = unserialize($this->info);

        $this->data = smfapi_updateMemberData($this->member, $this->info);
    }

    /**
     * @name check_ifOnline
     * @description
     * @throws Exception
     * @return void
     */
    protected function check_ifOnline()
    {
        try {
            $this->loadApi();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->data = smfapi_isOnline($this->identifier);
    }

    /**
     * @name log_onlineApi
     * @description
     * @throws Exception
     * @return void
     */
    protected function log_onlineApi()
    {
        try {
            $this->loadApi();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->data = smfapi_logOnline($this->identifier);
    }

    // ***************
    // SSI Methods
    // ***************
    /**
     * @name shutdown_ssi
     * @description
     * @throws Exception
     * @return void
     */
    protected function shutdown_ssi()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        ob_start();
        ssi_shutdown();
        $data = ob_get_contents();
        ob_end_clean();

        $this->data = $data;
    }

    /**
     * @name show_welcome
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_welcome()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_welcome();
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_welcome('array');
        }
    }

    /**
     * @name show_menubar
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_menubar()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_menubar();
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_menubar('array');
        }
    }

    /**
     * @name show_logoutLink
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_logoutLink()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_logout($this->redirect_to);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_logout($this->redirect_to, $this->output_method);
        }
    }

    /**
     * @name show_recentPosts
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_recentPosts()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->include_boards = unserialize($this->include_boards);
        $this->exclude_boards = unserialize($this->exclude_boards);

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_recentPosts($this->num_recent, $this->exclude_boards, $this->include_boards, $this->output_method, $this->limit_body);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_recentPosts($this->num_recent, $this->exclude_boards, $this->include_boards, $this->output_method, $this->limit_body);
        }
    }

    /**
     * @name fetch_posts
     * @description
     * @throws Exception
     * @return void
     */
    protected function fetch_posts()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->post_ids = unserialize($this->post_ids);

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_fetchPosts($this->post_ids, $this->override_permissions, $this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_fetchPosts($this->post_ids, $this->override_permissions, $this->output_method);
        }
    }

    /**
     * @name show_recentTopics
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_recentTopics()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->exclude_boards = unserialize($this->exclude_boards);
        $this->include_boards = unserialize($this->include_boards);

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_recentTopics($this->num_recent, $this->exclude_boards, $this->include_boards, $this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_recentTopics($this->num_recent, $this->exclude_boards, $this->include_boards, $this->output_method);
        }
    }

    /**
     * @name show_topPoster
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_topPoster()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_topPoster($this->topNumber, $this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_topPoster($this->topNumber, $this->output_method);
        }
    }

    /**
     * @name show_topBoards
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_topBoards()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_topBoards($this->num_top, $this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_topBoards($this->num_top, $this->output_method);
        }
    }

    /**
     * @name show_topTopics
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_topTopics()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_topTopics($this->type, $this->num_topics, $this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_topTopics($this->type, $this->num_topics, $this->output_method);
        }
    }

    /**
     * @name show_latestMember
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_latestMember()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_latestMember($this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_latestMember($this->output_method);
        }
    }

    /**
     * @name show_randomMember
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_randomMember()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_randomMember($this->random_type, $this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_randomMember($this->random_type, $this->output_method);
        }
    }

    /**
     * @name fetch_member
     * @description
     * @throws Exception
     * @return void
     */
    protected function fetch_member()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->member_ids = unserialize($this->member_ids);

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_fetchMember($this->member_ids, $this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_fetchMember($this->member_ids, $this->output_method);
        }
    }

    /**
     * @name fetch_groupMembers
     * @description
     * @throws Exception
     * @return void
     */
    protected function fetch_groupMembers()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_fetchGroupMembers($this->group_id, $this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_fetchGroupMembers($this->group_id, $this->output_method);
        }
    }

    /**
     * @name query_members
     * @description
     * @throws Exception
     * @return void
     */
    protected function query_members()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->query_where_params = unserialize($this->query_where_params);

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_queryMembers($this->query_where, $this->query_where_params, $this->query_limit, $this->query_order, $this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_queryMembers($this->query_where, $this->query_where_params, $this->query_limit, $this->query_order, $this->output_method);
        }
    }

    /**
     * @name show_boardStats
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_boardStats()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_boardStats($this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_boardStats($this->output_method);
        }
    }

    /**
     * @name show_whosOnline
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_whosOnline()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_whosOnline($this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_whosOnline($this->output_method);
        }
    }

    /**
     * @name log_online
     * @description
     * @throws Exception
     * @return void
     */
    protected function log_online()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_logOnline($this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_logOnline($this->output_method);
        }
    }

    /**
     * @name show_loginBox
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_loginBox()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_login($this->redirect_to, $this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_login($this->redirect_to, $this->output_method);
        }
    }

    /**
     * @name show_recentPoll
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_recentPoll()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_recentPoll($this->topPollInstead, $this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_recentPoll($this->topPollInstead, $this->output_method);
        }
    }

    /**
     * @name show_poll
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_poll()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_showPoll($this->topic, $this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_showPoll($this->topic, $this->output_method);
        }
    }

    /**
     * @name show_quickSearch
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_quickSearch()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_quickSearch($this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_quickSearch($this->output_method);
        }
    }

    /**
     * @name show_news
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_news()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_news($this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_news($this->output_method);
        }
    }

    /**
     * @name show_todaysBirthdays
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_todaysBirthdays()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_todaysBirthdays($this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_todaysBirthdays($this->output_method);
        }
    }

    /**
     * @name show_todaysHolidays
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_todaysHolidays()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_todaysHolidays($this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_todaysHolidays($this->output_method);
        }
    }

    /**
     * @name show_todaysEvents
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_todaysEvents()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_todaysEvents($this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_todaysEvents($this->output_method);
        }
    }

    /**
     * @name show_todaysCalendar
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_todaysCalendar()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_todaysCalendar($this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_todaysCalendar($this->output_method);
        }
    }

    /**
     * @name show_boardNews
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_boardNews()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_boardNews($this->board, $this->limit, $this->start, $this->length, $this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_boardNews($this->board, $this->limit, $this->start, $this->length, $this->output_method);
        }
    }

    /**
     * @name show_recentEvents
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_recentEvents()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_recentEvents($this->max_events, $this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_recentEvents($this->max_events, $this->output_method);
        }
    }

    /**
     * @name check_password
     * @description
     * @throws Exception
     * @return void
     */
    protected function check_password()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->data = ssi_checkPassword($this->id, $this->password, $this->is_username);
    }

    /**
     * @name show_recentAttachments
     * @description
     * @throws Exception
     * @return void
     */
    protected function show_recentAttachments()
    {
        try {
            $this->loadSSI();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->attachment_ext = unserialize($this->attachment_ext);

        if ('echo' == $this->output_method) {
            ob_start();
            ssi_recentAttachments($this->num_attachments, $this->attachment_ext, $this->output_method);
            $this->data = ob_get_contents();
            ob_end_clean();
        } else {
            $this->data = ssi_recentAttachments($this->num_attachments, $this->attachment_ext, $this->output_method);
        }
    }
}
