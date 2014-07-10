<?php  namespace Zbw\Users\Auth;

class OAuthRequest {
    /**
     *
     */
    protected $parameters;
    /**
     *
     */
    protected $http_method;
    /**
     *
     */
    protected $http_url;
    // for debug purposes
    /**
     *
     */
    public $base_string;
    /**
     *
     */
    public static $version = '1.0';
    /**
     *
     */
    public static $POST_INPUT = 'php://input';

    /**
     * @param      $http_method
     * @param      $http_url
     * @param null $parameters
     */
    function __construct($http_method, $http_url, $parameters=NULL) {

        $parameters = ($parameters) ? $parameters : [];
        $parameters = array_merge( OAuthUtil::parse_parameters(parse_url($http_url, PHP_URL_QUERY)), $parameters);
        $this->parameters = $parameters;
        $this->http_method = $http_method;
        $this->http_url = $http_url;
    }

    /**
     * pretty much a helper function to set up the request
     */
    public static function from_consumer_and_token($consumer, $token, $http_method, $http_url, $parameters=NULL) {
        $parameters = ($parameters) ?  $parameters : [];
        $defaults = ["oauth_version" => OAuthRequest::$version,
                          "oauth_nonce" => OAuthRequest::generate_nonce(),
                          "oauth_timestamp" => OAuthRequest::generate_timestamp(),
                          "oauth_consumer_key" => $consumer->key];
        if ($token)
            $defaults['oauth_token'] = $token->key;

        $parameters = array_merge($defaults, $parameters);

        return new OAuthRequest($http_method, $http_url, $parameters);
    }

    /**
     * @name       set_parameter
     * @description
     *
     * @param      $name
     * @param      $value
     * @param bool $allow_duplicates
     *
     * @return void
     */
    public function set_parameter($name, $value, $allow_duplicates = true) {
        if ($allow_duplicates && isset($this->parameters[$name])) {
            // We have already added parameter(s) with this name, so create to the list
            if (is_scalar($this->parameters[$name])) {
                // This is the first duplicate, so transform scalar (string)
                // into an array so we can create the duplicates
                $this->parameters[$name] = [$this->parameters[$name]];
            }

            $this->parameters[$name][] = $value;
        } else {
            $this->parameters[$name] = $value;
        }
    }

    /**
     * @name  get_parameter
     * @description
     *
     * @param $name
     *
     * @return null
     */
    public function get_parameter($name) {
        return isset($this->parameters[$name]) ? $this->parameters[$name] : null;
    }

    /**
     * @name get_parameters
     * @description
     * @return array
     */
    public function get_parameters() {
        return $this->parameters;
    }

    /**
     * @name  unset_parameter
     * @description
     *
     * @param $name
     *
     * @return void
     */
    public function unset_parameter($name) {
        unset($this->parameters[$name]);
    }

    /**
     * The request parameters, sorted and concatenated into a normalized string.
     * @return string
     */
    public function get_signable_parameters() {
        // Grab all parameters
        $params = $this->parameters;

        // Remove oauth_signature if present
        // Ref: Spec: 9.1.1 ("The oauth_signature parameter MUST be excluded.")
        if (isset($params['oauth_signature'])) {
            unset($params['oauth_signature']);
        }

        return OAuthUtil::build_http_query($params);
    }

    /**
     * Returns the base string of this request
     *
     * The base string defined as the method, the url
     * and the parameters (normalized), each urlencoded
     * and the concated with &.
     */
    public function get_signature_base_string() {
        $parts = [
          $this->get_normalized_http_method(),
          $this->get_normalized_http_url(),
          $this->get_signable_parameters()
        ];

        $parts = OAuthUtil::urlencode_rfc3986($parts);

        return implode('&', $parts);
    }

    /**
     * just uppercases the http method
     */
    public function get_normalized_http_method() {
        return strtoupper($this->http_method);
    }

    /**
     * parses the url and rebuilds it to be
     * scheme://host/path
     */
    public function get_normalized_http_url() {
        $parts = parse_url($this->http_url);

        $scheme = (isset($parts['scheme'])) ? $parts['scheme'] : 'http';
        $port = (isset($parts['port'])) ? $parts['port'] : (($scheme == 'https') ? '443' : '80');
        $host = (isset($parts['host'])) ? strtolower($parts['host']) : '';
        $path = (isset($parts['path'])) ? $parts['path'] : '';

        if (($scheme == 'https' && $port != '443')
          || ($scheme == 'http' && $port != '80')) {
            $host = "$host:$port";
        }
        return "$scheme://$host$path";
    }

    /**
     * builds a url usable for a GET request
     */
    public function to_url() {
        $post_data = $this->to_postdata();
        $out = $this->get_normalized_http_url();
        if ($post_data) {
            $out .= '?'.$post_data;
        }
        return $out;
    }

    /**
     * builds the data one would send in a POST request
     */
    public function to_postdata($array=false) {
        return OAuthUtil::build_http_query($this->parameters, $array);
    }

    /**
     * builds the Authorization: header
     */
    public function to_header($realm=null) {
        $first = true;
        if($realm) {
            $out = 'Authorization: OAuth realm="' . OAuthUtil::urlencode_rfc3986($realm) . '"';
            $first = false;
        } else
            $out = 'Authorization: OAuth';

        $total = [];
        foreach ($this->parameters as $k => $v) {
            if (substr($k, 0, 5) != "oauth") continue;
            if (is_array($v)) {
                throw new OAuthException('Arrays not supported in headers');
            }
            $out .= ($first) ? ' ' : ',';
            $out .= OAuthUtil::urlencode_rfc3986($k) .
              '="' .
              OAuthUtil::urlencode_rfc3986($v) .
              '"';
            $first = false;
        }
        return $out;
    }

    /**
     * @name __toString
     * @description
     * @return string
     */
    public function __toString() {
        return $this->to_url();
    }

    /**
     * @name  sign_request
     * @description
     *
     * @param $signature_method
     * @param $consumer
     * @param $token
     *
     * @return void
     */
    public function sign_request($signature_method, $consumer, $token) {
        $this->set_parameter(
          "oauth_signature_method",
          $signature_method->get_name(),
          false
        );
        $signature = $this->build_signature($signature_method, $consumer, $token);
        $this->set_parameter("oauth_signature", $signature, false);
    }

    /**
     * @name  build_signature
     * @description
     *
     * @param $signature_method
     * @param $consumer
     * @param $token
     *
     * @return mixed
     */
    public function build_signature($signature_method, $consumer, $token) {
        $signature = $signature_method->build_signature($this, $consumer, $token);
        return $signature;
    }

    /**
     * util function: current timestamp
     */
    private static function generate_timestamp() {
        return time();
    }

    /**
     * util function: current nonce
     */
    private static function generate_nonce() {
        $mt = microtime();
        $rand = mt_rand();

        return md5($mt . $rand); // md5s look nicer than numbers
    }
} 
