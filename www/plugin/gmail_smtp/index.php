<?php
/**
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2015, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/

// ------------------------------------------------------------------------
//	HybridAuth End Point
// ------------------------------------------------------------------------

include_once('_common.php');

$gmail_config = $gmail_smtp_gnu5->get_config(true);

if(! ($gmail_config['google_client_id'] && $gmail_config['google_client_secret'])){
    alert_close('구글 클라이언트ID 와 클라이언트 보안 비밀 키가 입력되지 않았습니다.');
}

if( ! class_exists('G5_Hybrid_Authentication') ) {

    require_once( G5_SOCIAL_LOGIN_PATH.'/Hybrid/Auth.php' );
    require_once( G5_SOCIAL_LOGIN_PATH.'/Hybrid/Endpoint.php' );

    class G5_Hybrid_Authentication {

        public static function hybridauth_endpoint() {

            if( defined('G5_SOCIAL_LOGIN_START_PARAM') && G5_SOCIAL_LOGIN_START_PARAM !== 'hauth.start' && isset($_REQUEST[G5_SOCIAL_LOGIN_START_PARAM]) ){
                $_REQUEST['hauth_start'] = preg_replace('/[^a-zA-Z0-9\-\._]/i', '', $_REQUEST[G5_SOCIAL_LOGIN_START_PARAM]);
            }

            if( defined('G5_SOCIAL_LOGIN_DONE_PARAM') && G5_SOCIAL_LOGIN_DONE_PARAM !== 'hauth.done' && isset($_REQUEST[G5_SOCIAL_LOGIN_DONE_PARAM]) ){
                $_REQUEST['hauth_done'] = preg_replace('/[^a-zA-Z0-9\-\._]/i', '', $_REQUEST[G5_SOCIAL_LOGIN_DONE_PARAM]);
            }

            /*
            $key = 'hauth.' . $action; // either `hauth_start` or `hauth_done`

            $_REQUEST[ $key ] = $provider; // provider will be something like `facebook` or `google`
            */
            
            G5_Hybrid_Endpoint::process();
        }

    }

    class G5_Hybrid_Endpoint extends Hybrid_Endpoint
    {
        protected function authInit() {
            global $gmail_config;

            if (!$this->initDone) {
                $this->initDone = true;

                // Init Hybrid_Auth
                try {
                    if (!class_exists("Hybrid_Storage", false)) {
                        require_once G5_SOCIAL_LOGIN_PATH. "/Hybrid/Storage.php";
                    }
                    if (!class_exists("Hybrid_Exception", false)) {
                        require_once G5_SOCIAL_LOGIN_PATH. "/Hybrid/Exception.php";
                    }
                    if (!class_exists("Hybrid_Logger", false)) {
                        require_once G5_SOCIAL_LOGIN_PATH. "/Hybrid/Logger.php";
                    }

                    $storage = new Hybrid_Storage();
                    $provider_id = ucfirst(trim(strip_tags($this->request["hauth_start"])));
                    if(!$provider_id) $provider_id = ucfirst(trim(strip_tags($this->request["hauth_done"])));
                    
                    $setting = social_build_provider_config($provider_id);

                    $setting['providers'][$provider_id] = array(
                        'enabled' => true,
                        'keys' => array(
                            'id'=>$gmail_config['google_client_id'],
                            'secret'=>$gmail_config['google_client_secret'],
                        ),
                        'redirect_uri' => $gmail_config['redirect_uri'],
                        'scope' => 'https://mail.google.com/',
                        'access_type'     => 'offline',
                        'approval_prompt' => 'force'
                    );

                    $storage->config("CONFIG", $setting);
                    // Check if Hybrid_Auth session already exist
                    if (!$storage->config("CONFIG")) {
                        $this->dieError("CONFIG FAILED: ", "Unable to get config", array());
                    }

                    Hybrid_Auth::initialize($storage->config("CONFIG"));
                } catch (Exception $e) {
                    Hybrid_Logger::error("Endpoint: Error while trying to init Hybrid_Auth: " . $e->getMessage());
                    $this->dieError("Endpoint Error: ", $e->getMessage(), $e);
                }
            }
        }

        protected function processAuthStart(){
            try {
                parent::processAuthStart();
            }
            catch( Exception $e ){
                $this->dieError( "412 Precondition Failed", $e->getMessage(), $e );
            }
        }

        protected function processAuthDone()
        {
            try {
                parent::processAuthDone();
            }
            catch( Exception $e ){
                $this->dieError( "410 Gone", $e->getMessage(), $e );
            }
        }

        public function dieError( $code, $message, $e )
        {
            $get_error = $message;
            include_once(G5_SOCIAL_LOGIN_PATH.'/error.php');
            die();
        }
    }

}

error_reporting(0); // Turn off all error reporting

G5_Hybrid_Authentication::hybridauth_endpoint();