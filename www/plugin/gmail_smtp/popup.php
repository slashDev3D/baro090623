<?php
include_once('_common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');

auth_check_menu($auth, $gmail_smtp_gnu5->admin_number, 'w');

$provider = 'Google';
$gmail_config = $gmail_smtp_gnu5->get_config(true);

if(! ($gmail_config['google_client_id'] && $gmail_config['google_client_secret'])){
    alert_close('구글 클라이언트ID 와 클라이언트 보안 비밀 키가 입력되지 않았습니다.');
}

if( ! class_exists( 'Hybrid_Auth', false ) )
{
    include_once G5_SOCIAL_LOGIN_PATH . "/Hybrid/Auth.php";
}

//echo Hybrid_Auth::getCurrentUrl();

if( ! (isset($g5['hybrid_auth']) && is_object($g5['hybrid_auth'])) ){
    $setting = social_build_provider_config($provider);

    $setting['providers'][$provider] = array(
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

    $g5['hybrid_auth'] = new Hybrid_Auth( $setting );
}

$params = array(
//'hauth_return_to'=>G5_PLUGIN_URL.'/'.G5_GMAIL_SMTP_DIR.'/index.php',
'login_start'=>G5_PLUGIN_URL.'/'.G5_GMAIL_SMTP_DIR.'/index.php?hauth.start='.$provider.'&hauth.time='.G5_SERVER_TIME,
'login_done'=>G5_PLUGIN_URL.'/'.G5_GMAIL_SMTP_DIR.'/index.php?hauth.done='.$provider,
);

$is_success = false;

try {
    $adapter = $g5['hybrid_auth']->authenticate($provider, $params);

    $oauths = array(
        'access_token'=>'',
        'access_token_expires_in'=>'',
        'refresh_token'=>'',
        'scope'=>'',
        'token_type'=>'',
        'access_token_expires_at'=>'',
    );

    if ($adapter){
        $api = isset($adapter->adapter->api) ? json_decode(json_encode($adapter->adapter->api), true) : array();
        $scope = isset($adapter->adapter->scope) ? $adapter->adapter->scope : '';

        $oauths['access_token'] = (isset($api['access_token']) && $api['access_token']) ? $api['access_token'] : '';
        $oauths['refresh_token'] = (isset($api['refresh_token']) && $api['refresh_token']) ? $api['refresh_token'] : '';
        $oauths['access_token_expires_in'] = (isset($api['access_token_expires_in']) && $api['access_token_expires_in']) ? $api['access_token_expires_in'] : '';
        $oauths['scope'] = $scope;
        $oauths['access_token_expires_at'] = (isset($api['access_token_expires_at']) && $api['access_token_expires_at']) ? $api['access_token_expires_at'] : '';

        $gmail_smtp_gnu5->update_token($oauths);

        $is_success = true;

        if( is_object( $adapter ) ){
            $adapter->logout();
        }
    }

} catch( Exception $e ) {

  	// Display the recived error,
  	// to know more please refer to Exceptions handling section on the userguide
  	switch( $e->getCode() ){
      case 0 : echo "지정되지 않은 오류입니다."; break;
      case 1 : echo "설정 오류입니다."; break;
      case 2 : echo "해당 provider 설정 오류입니다."; break;
      case 3 : echo "알수 없거나 비활성화 된 provider 입니다."; break;
      case 4 : echo "해당 서비스에 접근할수 있는 권한이 없습니다."; break;
      case 5 : echo "인증이 실패되었습니다.. "
                  . "사용자가 인증을 취소했거나, 공급자가 연결을 거부했습니다.";
               break;
      case 6 : echo "사용자 프로필 요청이 실패했습니다.사용자가 해당 서비스에 연결되어 있지 않을 경우도 있습니다. "
                  . "이 경우 다시 인증 요청을 해야 합니다.";
                if( is_object( $adapter ) ){
                    $adapter->logout();
                }
               break;
      case 7 : echo "사용자가 해당 서비스에 연결되어 있지 않습니다.";
                if( is_object( $adapter ) ){
                    $adapter->logout();
                }
               break;
      case 8 : echo "해당 서비스가 기능을 지원하지 않습니다."; break;
  	}
 
  	// well, basically your should not display this to the end user, just give him a hint and move on..
  	echo "<br /><br /><b>Original error message:</b> " . $e->getMessage();
}

if($is_success){
?>
<script>
if( window.opener ){
    (function(){
        window.opener.location.reload();
        window.close();
    })();
}
</script>
<?php
}