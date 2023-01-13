<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

class GMAIL_SMTP_GNU5 {
    private $is_admin_copy = false;
    private $db_table = 'gmail_smtp_config';
    private $provider = 'Google';
    private $config = array();

	public $admin_number = 100928;

    // Hook 포함 클래스 작성 요령
    // https://github.com/Josantonius/PHP-Hook/blob/master/tests/Example.php
    /**
     * Class instance.
     */

    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new self();
        }

        return $instance;
    }

    public static function singletonMethod()
    {
        return self::getInstance();
    }

    public function __construct() {
		$this->config = $this->get_config(true);
        $this->add_hooks();
    }

    public function get_config($is_cache=false){

		static $cache = array();
        
		$cache = run_replace('get_gmail_smtp_config_cache', $cache, $is_cache);

		if( $is_cache && !empty($cache) ){
			return $cache;
		}

		$table_name = G5_TABLE_PREFIX.$this->db_table;
        $sql = "select * from $table_name ";
		
		$cache = run_replace('get_gmail_smtp_config', sql_fetch($sql, false));
        
		if ( ! $cache ){
			$create_sql = get_db_create_replace("CREATE TABLE IF NOT EXISTS `$table_name` (
                  `send_type` varchar(20) NOT NULL DEFAULT '',
				  `google_client_id` varchar(255) NOT NULL DEFAULT '',
				  `google_client_secret` varchar(255) NOT NULL DEFAULT '',
                  `oauth_email` varchar(255) NOT NULL DEFAULT '',
				  `from_email` varchar(255) NOT NULL DEFAULT '',
                  `chk_other_email` tinyint(4) NOT NULL DEFAULT '0',
                  `from_email_name` varchar(255) NOT NULL DEFAULT '',
				  `smtp_encryption` varchar(255) NOT NULL DEFAULT '',
				  `smtp_port` int(11) NOT NULL DEFAULT '0',
                  `access_token` varchar(255) NOT NULL DEFAULT '',
                  `refresh_token` varchar(255) NOT NULL DEFAULT '',
                  `access_token_expires_in` varchar(255) NOT NULL DEFAULT '',
                  `access_token_expires_at` varchar(255) NOT NULL DEFAULT '',
                  `scope` varchar(255) NOT NULL DEFAULT '',
                  `app_password` varchar(255) NOT NULL DEFAULT '',
                  `oauth_update_time` datetime NOT NULL default '0000-00-00 00:00:00'
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

			sql_query($create_sql, false);

            $cache = sql_fetch($sql, false);
		}
        
        if(! isset($cache['app_password'])) $cache['app_password'] = '';

        if(! (isset($cache['redirect_uri']) && $cache['redirect_uri'])){
            $cache['redirect_uri'] = $this->get_redirect_uri($this->provider);
        }

		return $cache;
    }

    public function add_hooks(){
		// 관리자 메뉴 추가
		add_replace('admin_menu', array($this, 'add_admin_menu'), 1, 1);

		// 관리자 페이지 추가
		add_event('admin_get_page_gmail_smtp_config', array($this, 'admin_page_config'), 1, 2);

        add_replace('mailer', array($this, 'gmail_smtp_mailer'), 10, 9);
    }

	public function add_admin_menu($admin_menu){
		
		$admin_menu['menu100'][] = array(
			$this->admin_number, 'Gmail SMTP 설정', G5_ADMIN_URL.'/view.php?call=gmail_smtp_config', 'gmail_smtp_config'
			);
		
		return $admin_menu;
	}

    public function refresh_token($options, $parameters = array()){
        
        global $g5, $phpmailer_errors;

        if( ! class_exists( 'Hybrid_Auth', false ) )
        {
            include_once G5_SOCIAL_LOGIN_PATH . "/Hybrid/Auth.php";
        }

        $provider = 'Google';

        if( ! (isset($g5['hybrid_auth']) && is_object($g5['hybrid_auth'])) ){
            $setting = social_build_provider_config($provider);

            $setting['providers'][$provider] = array(
                'enabled' => true,
                'keys' => array(
                    'id'=>$options['google_client_id'],
                    'secret'=>$options['google_client_secret'],
                ),
                'scope' => 'https://mail.google.com/',
                'access_type'     => 'offline',
            );

            $g5['hybrid_auth'] = new Hybrid_Auth( $setting );
        }

        $adapter = $g5['hybrid_auth']->getAdapter($provider);

        $parameters = array(
            'grant_type' => 'refresh_token',
            'client_id' => $options['google_client_id'],
            'client_secret' => $options['google_client_secret'],
            'refresh_token'=>$options['refresh_token'],
        );
        
        $response = (array) $adapter->adapter->api->refreshToken( $parameters );
        
        if( $options['access_token'] !== $response['access_token'] ){
            $options['access_token'] = $response['access_token'];
            $options['access_token_expires_in'] = $response['expires_in'];
            $options['access_token_expires_at'] = time() + $response['expires_in'];
            $options['scope'] = $response['scope'];
            
            $this->update_token($options);
        }

        return $options;
    }

    public function is_token_expires($expires_at, $expires_in){

        if( $expires_at && $expires_in && (G5_SERVER_TIME >= ((int) $expires_at - 30)) ){
            return true;
        }

        return false;
    }

    public function gmail_smtp_mailer($fname, $fmail, $to, $subject, $content, $type=0, $file="", $cc="", $bcc=""){
        
        global $phpmailer_errors;

        $gmail_smtp_config = $options = $this->get_config(true);
        
        if( ! (isset($gmail_smtp_config['oauth_email']) && $gmail_smtp_config['oauth_email']) ){
            return array('return' => false);
        }

        // smtp or OAuth
        $mail_type = (isset($gmail_smtp_config['send_type']) && in_array($gmail_smtp_config['send_type'], array('smtp', 'oauth')) ) ? $gmail_smtp_config['send_type'] : 'smtp';
        
        if($mail_type === 'smtp') {
            $phpmailer = new PHPMailer();

            $phpmailer->IsSMTP(); // telling the class to use SMTP
            $phpmailer->Host = 'smtp.gmail.com'; // SMTP server
            $phpmailer->Port = (isset($options['smtp_port']) && $options['smtp_port']) ? $options['smtp_port'] : 587;

            $phpmailer->SMTPAuth = true;
            $phpmailer->AuthType = 'LOGIN';
            $phpmailer->SMTPSecure = $gmail_smtp_config['smtp_encryption'] ? $gmail_smtp_config['smtp_encryption'] : 'tls';
            $phpmailer->Username = $gmail_smtp_config['oauth_email'];
            $phpmailer->Password = get_string_decrypt($gmail_smtp_config['app_password']);

        } else {
            require_once(dirname(__FILE__).'/autoload.php');
            
            if(! ($gmail_smtp_config['google_client_id'] && $gmail_smtp_config['google_client_secret'] && $gmail_smtp_config['smtp_encryption'])){
                return false;
            }

            if( $gmail_smtp_config['access_token_expires_at'] && $gmail_smtp_config['access_token_expires_in'] ){
                if( $this->is_token_expires($gmail_smtp_config['access_token_expires_at'], $gmail_smtp_config['access_token_expires_in'])){
                    $gmail_smtp_config = $options = $this->refresh_token($gmail_smtp_config);
                }
            }
            
            $phpmailer = new PHPMailerOAuth; /* this must be the custom class we created */

            // Tell PHPMailer to use SMTP
            $phpmailer->isSMTP();

            //Set the hostname of the mail server
            $phpmailer->Host = 'smtp.gmail.com';

            //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
            $phpmailer->Port = (isset($options['smtp_port']) && $options['smtp_port']) ? $options['smtp_port'] : 587;

            // Set the encryption system to use - ssl (deprecated) or tls
            $phpmailer->SMTPSecure = $gmail_smtp_config['smtp_encryption'] ? $gmail_smtp_config['smtp_encryption'] : 'tls';
            
            // Whether to use SMTP authentication
            $phpmailer->SMTPAuth = true;

            // Set AuthType
            $phpmailer->AuthType = 'XOAUTH2';

            $phpmailer->SMTPAutoTLS = false;

            //disable ssl certificate verification if checked
            if(isset($options['disable_ssl_verification']) && !empty($options['disable_ssl_verification'])){
                $phpmailer->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
            }
            // User Email to use for SMTP authentication - Use the same Email used in Google Developer Console
            $phpmailer->oauthUserEmail = $options['oauth_email'];

            //Obtained From Google Developer Console
            $phpmailer->oauthClientId = $options['google_client_id'];

            //Obtained From Google Developer Console
            $phpmailer->oauthClientSecret = $options['google_client_secret'];

            //$gmail_token = json_decode($options['oauth_access_token'], true);

            //Obtained By running get_oauth_token.php after setting up APP in Google Developer Console.
            //Set Redirect URI in Developer Console as [https/http]://<yourdomain>/<folder>/get_oauth_token.php
            // eg: http://localhost/phpmail/get_oauth_token.php
            //$phpmailer->oauthRefreshToken = $gmail_token['access_token'];
            
            $phpmailer->oauthRefreshToken = $options['access_token'];
        
        }
        
        $is_mail_debug = false;

        // 메일 테스트인 경우 DEBUG 를 사용함
        if( preg_match('~\/sendmail_test\.php$~i', $_SERVER['SCRIPT_NAME']) ){
            $phpmailer->SMTPDebug = 4;
            $phpmailer->Debugoutput = 'html';
            $is_mail_debug = true;
        }

        //$phpmailer->From = $options['from_email'] ? $options['from_email'] : $fmail;
        //$phpmailer->FromName = $options['from_email_name'] ? $options['from_email_name'] : $fname;

        $from_email = $options['from_email'] ? $options['from_email'] : $fmail;
        $from_email_name = $options['from_email_name'] ? $options['from_email_name'] : $fname;

        $phpmailer->setFrom($from_email, $from_email_name);

        $phpmailer->CharSet = 'UTF-8';
        $phpmailer->Subject = $subject;
        $phpmailer->AltBody = ""; // optional, comment out and test

        if( $gmail_smtp_config['chk_other_email'] ){
            if(! ($gmail_smtp_config['oauth_email'] === $fmail || $gmail_smtp_config['from_email'] === $fmail)){
                $content = '<div style="padding:5px 0 5px 5px;border:1px solid #e0e0e0;margin-bottom:10px">보낸사람 : '.$fname.' ['.$fmail.'] </div>'.$content;
            }
        }

        $phpmailer->msgHTML($content);
        $phpmailer->addAddress($to);
        if ($cc)
            $phpmailer->addCC($cc);
        if ($bcc)
            $phpmailer->addBCC($bcc);

        if (! $file) {
            foreach ((array) $file as $f) {
                if (empty($f) ) continue;

                $phpmailer->addAttachment($f['path'], $f['name']);
            }
        }
        
        try {

            $result = $phpmailer->send();
            return array('return' => $result);

        } catch ( IdentityProviderException $e) {
            
            $phpmailer_errors = compact('fname', 'fmail', 'to', 'subject', 'content', 'type', 'file', 'cc', 'bcc');
            $phpmailer_errors['exception_code'] = $e->code();
            $phpmailer_errors['exception_message'] = $e->message();
        } catch ( phpmailerException $e ) {
            $phpmailer_errors = compact('fname', 'fmail', 'to', 'subject', 'content', 'type', 'file', 'cc', 'bcc');
            $phpmailer_errors['exception_message'] = $e->errorMessage();
        } catch (Exception $e) {
            $phpmailer_errors = compact('fname', 'fmail', 'to', 'subject', 'content', 'type', 'file', 'cc', 'bcc');
            $phpmailer_errors['exception_message'] = $e->getMessage();
        }
        
        if( $is_mail_debug ){
            print_r2( $phpmailer_errors );
        }

        return array('return' => false);

        /*
        try {
            $result = $phpmailer->send();
            return array('return' => $result);
        } catch ( IdentityProviderException $e) {
			$phpmailer_errors = compact('fname', 'fmail', 'to', 'subject', 'content', 'type', 'file', 'cc', 'bcc');
            $phpmailer_errors['exception_message'] = $e->getMessage();

            return array('return' => false);
        } catch ( phpmailerException $e ) {
			$phpmailer_errors = compact('fname', 'fmail', 'to', 'subject', 'content', 'type', 'file', 'cc', 'bcc');
            $phpmailer_errors['exception_message'] = $e->getMessage();

            return array('return' => false);
        }
        */
    }

    public function get_redirect_uri($provider){
        return G5_PLUGIN_URL.'/'.G5_GMAIL_SMTP_DIR.'/index.php?hauth.done='.$provider;
    }

    public function update_token($oauths){
        $table_name = G5_TABLE_PREFIX.$this->db_table;

        $add_sql = '';

        $gmail_smtp_config = $this->get_config(true);
        
        if(! isset($gmail_smtp_config['access_token'])){
            $gmail_smtp_config['access_token'] = '';
        }

        if ($oauths['access_token'] && ($oauths['access_token'] !== $gmail_smtp_config['access_token'])){
            $add_sql = "oauth_update_time = '".G5_TIME_YMDHIS."', ";
        }

        $sql = "update `$table_name` set 
                access_token = '".$oauths['access_token']."',
                refresh_token = '".$oauths['refresh_token']."',
                access_token_expires_in = '".$oauths['access_token_expires_in']."',
                access_token_expires_at = '".$oauths['access_token_expires_at']."',
                $add_sql
                scope = '".$oauths['scope']."'
        ";

        sql_query($sql, false);
    }

	public function admin_page_config($arr_query, $token){
		global $is_admin, $auth, $config;
		
		$aws_s3_config = $this->config;

        $gmail_smtp_config = $this->get_config(true);
        
		if( isset($_POST['post_action']) && isset($_POST['token']) ){
			
			auth_check_menu($auth, $this->admin_number, 'w');

			$table_name = G5_TABLE_PREFIX.$this->db_table;

			$tmp = sql_fetch("select * from $table_name limit 1");
            
            $send_type = (isset($_POST['send_type']) && $_POST['send_type']) ? strip_tags($_POST['send_type']) : '';
			$google_client_id = (isset($_POST['google_client_id']) && $_POST['google_client_id']) ? strip_tags($_POST['google_client_id']) : '';
			$google_client_secret = (isset($_POST['google_client_secret']) && $_POST['google_client_secret']) ? strip_tags($_POST['google_client_secret']) : '';
			$oauth_email = (isset($_POST['oauth_email']) && $_POST['oauth_email']) ? strip_tags($_POST['oauth_email']) : '';
			$from_email = (isset($_POST['from_email']) && $_POST['from_email']) ? strip_tags($_POST['from_email']) : '';
			$from_email_name = (isset($_POST['from_email_name']) && $_POST['from_email_name']) ? strip_tags($_POST['from_email_name']) : '';
			$smtp_encryption = (isset($_POST['smtp_encryption']) && $_POST['smtp_encryption']) ? strip_tags($_POST['smtp_encryption']) : '';
			$smtp_port = (isset($_POST['smtp_port']) && $_POST['smtp_port']) ? strip_tags($_POST['smtp_port']) : '';
            $chk_other_email = (isset($_POST['chk_other_email']) && $_POST['chk_other_email']) ? 1 : 0;
            //$access_token = (isset($_POST['access_token']) && $_POST['access_token']) ? strip_tags($_POST['access_token']) : '';
            //$access_token_expires_in = (isset($_POST['access_token_expires_in']) && $_POST['access_token_expires_in']) ? strip_tags($_POST['access_token_expires_in']) : '';
            //$access_token_expires_at = (isset($_POST['access_token_expires_at']) && $_POST['access_token_expires_at']) ? strip_tags($_POST['access_token_expires_at']) : '';
            //$scope = (isset($_POST['scope']) && $_POST['scope']) ? strip_tags($_POST['scope']) : '';

            $app_password = (isset($_POST['app_password']) && $_POST['app_password']) ? strip_tags($_POST['app_password']) : '';

            if($app_password && ($gmail_smtp_config['app_password'] !== $app_password || strlen($app_password) === 16)){
                $app_password = get_string_encrypt($app_password);
            }

			$sql_common = "
				set send_type = '{$send_type}',
                google_client_id = '{$google_client_id}',
				google_client_secret = '{$google_client_secret}',
				oauth_email = '{$oauth_email}',
                app_password = '{$app_password}',
                chk_other_email = '{$chk_other_email}',
				from_email = '{$from_email}',
				from_email_name = '{$from_email_name}',
				smtp_encryption = '{$smtp_encryption}',
				smtp_port = '{$smtp_port}'
			";

			if( $tmp ){
				$sql = " update $table_name $sql_common ";
			} else {
				$sql = " insert into $table_name $sql_common ";
			}

			if( sql_query($sql, false) ){
				$gmail_smtp_config = $this->get_config(false);
			}
		}
        
        $tmps = array(
                'send_type'=>'smtp',
                'redirect_uri'=>'',
                'google_client_id'=>'',
                'google_client_secret'=>'',
                'oauth_email'=>'',
                'from_email'=>'',
                'from_email_name'=>'',
                'smtp_encryption'=>'',
                'smtp_port'=>'587',
                'oauth_update_time'=>'',
                'app_password'=>'',
                'access_token_expires_in'=>'',
                'access_token_expires_at'=>'',
                'chk_other_email'=>0,
            );

        $gmail_smtp_config = array_merge($tmps, $gmail_smtp_config);

        $gmail_smtp_config['send_type'] = (isset($gmail_smtp_config['send_type']) && in_array($gmail_smtp_config['send_type'], array('smtp', 'oauth')) ) ? $gmail_smtp_config['send_type'] : 'smtp';

        $oauth_connect_url = ($gmail_smtp_config['google_client_id'] && $gmail_smtp_config['google_client_secret']) ? G5_PLUGIN_URL.'/'.G5_GMAIL_SMTP_DIR.'/popup.php' : '';
        
        $is_need_auth = 0;

        if( $gmail_smtp_config['send_type'] === 'oauth' ){
            if( $gmail_smtp_config['access_token_expires_at'] && $gmail_smtp_config['access_token_expires_in'] ){
                if( $this->is_token_expires($gmail_smtp_config['access_token_expires_at'], $gmail_smtp_config['access_token_expires_in']) ){
                    $gmail_smtp_config = $options = $this->refresh_token($gmail_smtp_config);
                }

                if( $this->is_token_expires($gmail_smtp_config['access_token_expires_at'], $gmail_smtp_config['access_token_expires_in']) ){
                    $is_need_auth = 1;
                }
            } else {
                $is_need_auth = 1;
            }
        }
        
		include_once( G5_PLUGIN_PATH.'/gmail_smtp/skin/adm.config.php');
	}

}

$GLOBALS['gmail_smtp_gnu5'] = GMAIL_SMTP_GNU5::getInstance();