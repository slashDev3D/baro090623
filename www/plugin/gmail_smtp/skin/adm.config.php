<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

auth_check_menu($auth, $this->admin_number, 'r');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_PLUGIN_URL.'/gmail_smtp/skin/adm.style.css">', 0);
?>
<div class="gmail_smtp_area">
	<form name="gmail_smtp_config" id="f_gmail_smtp_config" method="post" onsubmit="return gmail_smtp_config_submit(this);">
	<input type="hidden" name="post_action" value="save" >
    <input type="hidden" id="send_type" name="send_type" value="<?php echo $gmail_smtp_config['send_type']; ?>">
	<input type="hidden" name="token" value="" id="token">
		<button id="anc_cf_basic" type="button" class="tab_tit close">Gmail SMTP 설정</button>
		<section class="tab_con">
			<h2 class="h2_frm">Gmail SMTP 설정</h2>

            <div>
                <h3>둘 중 택일</h3>
                <dd class="smtp-type-tabs">
                    <dl <?php echo ($gmail_smtp_config['send_type'] === 'smtp') ? 'class="active"' : ''; ?>><a href="#google_smtp" data-value="smtp">Gmail SMTP 로 메일보내기</a></dl>
                    <dl <?php echo ($gmail_smtp_config['send_type'] === 'oauth') ? 'class="active"' : ''; ?>><a href="#google_oauth" data-value="oauth">Google OAUTH 로 메일보내기</a></dl>
                </dd>
            </div>
            
            <ul class="frm_ul smtp-common">
				<li>
					<span class="lb_block"><label for="oauth_email">Gmail SMTP 이메일주소</label>
                    <?php echo help('Gmail SMTP 설정과 같은 메일이어야 합니다.반드시 @gmail.com 형식인 지메일을 입력해야 합니다.<br>이 입력값이 없으면 메일은 기본설정으로 보냅니다.'); ?>
					</span>
					<input type="text" name="oauth_email" value="<?php echo $gmail_smtp_config['oauth_email']; ?>" id="oauth_email" class="frm_input" size="50">
				</li>
				<li>
					<span class="lb_block"><label for="from_email_name">메일 발송이름</label>
					<?php echo help('메일을 보내는 이름을 입력합니다.'); ?>
					</span>
					<input type="text" name="from_email_name" value="<?php echo $gmail_smtp_config['from_email_name']; ?>" id="from_email_name" class="frm_input" size="50">
				</li>
				<li>
					<span class="lb_block"><label for="from_email">보내는 메일주소</label>
					<?php echo help('보내는 메일주소를 입력합니다.<br>Gmail > 설정 > 계정 및 가져오기 > 다른 주소에서 메일 보내기 에 아래 입력한 이메일이 등록되어 있어야 합니다.<br>등록되어 있지 않으면 보내는 메일주소는 항상 지메일로 보내게 됩니다.'); ?>
					</span>
                    <input type="text" name="from_email" value="<?php echo $gmail_smtp_config['from_email']; ?>" id="from_email" class="frm_input" size="50">
				</li>
				<li>
					<span class="lb_block"><label for="chk_other_email">다른 메일주소를 내용에 넣기 여부</label>
					<?php echo help('체크시 실제로 보내는 이메일주소가 위의 Gmail SMTP 이메일주소, 보내는 메일주소의 입력값과 다르면<br>메일내용에 실제로 보낼려고 하는 이메일주소와 보내는 이름이 출력됩니다.'); ?>
					</span>
					<input type="checkbox" name="chk_other_email" value="1" id="chk_other_email" <?php echo $gmail_smtp_config['chk_other_email'] ? 'checked' : ''; ?>> <label for="chk_other_email">체크시 내용에 이메일주소 출력</label>
				</li>
				<li>
					<span class="lb_block"><label for="gmail_smtp_encryption">SMTP 전송 타입</label>
					<?php echo help('전송타입은 TLS 와 SSL 이 있습니다. (TLS 를 추천)'); ?>
					</span>
                    <select name="smtp_encryption" id="gmail_smtp_encryption">
                        <option value="tls" <?php if($gmail_smtp_config['smtp_encryption'] === 'tls'){ echo 'selected="selected"'; } ?>>TLS</option>
                        <option value="ssl" <?php if($gmail_smtp_config['smtp_encryption'] === 'ssl'){ echo 'selected="selected"'; } ?>>SSL</option>
                    </select>
				</li>
				<li>
					<span class="lb_block"><label for="gmail_smtp_port">SMTP Port</label>
					<?php echo help('GMAIL SMTP의 기본 port는 전송타입이 TLS 인 경우 587이며, 전송타입이 SSL인 경우 465 입니다.'); ?>
					</span>
					<input type="text" name="smtp_port" value="<?php echo $gmail_smtp_config['smtp_port']; ?>" id="gmail_smtp_port" class="frm_input" size="50">
				</li>
            </ul>
            <ul class="frm_ul gmail-tab" id="google_smtp">
                <li>
					<span class="lb_block"><label for="app_password">앱 비밀번호</label>
					<?php echo help('<a href="https://myaccount.google.com/security" target="_blank">https://myaccount.google.com/security</a><br>Google 계정에서 Gmail SMTP 이메일주소 계정의 구글 앱 비밀번호를 입력해 주세요. (2단계 인증 필요)'); ?>
					</span>
					<input type="password" name="app_password" value="<?php echo $gmail_smtp_config['app_password']; ?>" id="app_password" class="frm_input" size="50">
                </li>
            </ul>
			<ul class="frm_ul oauth-tab" id="google_oauth">
                <?php if($oauth_connect_url) { ?>
                <li>
                    <span class="lb_block"><label for="google_oauth_connect">구글 계정과 연결하기</label>
                    <?php echo help('구글 계정과 oauth로 연결합니다.'); ?>
                    </span>
                    <?php if($is_need_auth){ ?>
                    <p style="color:red;font-weight:bold">구글 계정이 연결되지 않았거나 Refresh_token이 만료되었습니다. 위의 구글 계정와 oauth 로 연결하기 실행이 필요합니다.</p>
                    <?php } else { ?>
                    <p style="color:green;font-weight:bold">구글 계정이 정상적으로 연결된 상태입니다.</p>
                    <?php } ?>
                    <a href="<?php echo $oauth_connect_url; ?>" class="btn_frmline google_oauth_popup">구글 계정와 oauth 로 연결하기</a>
                </li>
                <?php } ?>
                <?php if($gmail_smtp_config['access_token_expires_at'] && $gmail_smtp_config['access_token_expires_in']) { ?>
                <li>
					<span class="lb_block"><label for="redirect_uri">Refresh_token 만료 시간</label>
                    <?php echo help('정상적으로 연결되었다면 Refresh_token은 만료시 자동으로 연장됩니다.'); ?>
					</span>
                    <p><?php echo date('Y-m-d H:i:s', (int) $gmail_smtp_config['access_token_expires_at']); ?></p>
                </li>
                <?php } ?>
				<li>
					<span class="lb_block"><label for="redirect_uri">승인된 리디렉션 URI</label>
                    <?php echo help('<a href="https://console.developers.google.com/" target="_blank">구글 개발자 API 콘솔</a> >> 사용자 인증정보 >> 웹 애플리케이션 에서 승인된 리디렉션 URI 를 반드시 아래 정보로 입력해 주셔야 합니다.'); ?>
					</span>
					<p><?php echo $gmail_smtp_config['redirect_uri']; ?></p>
				</li>
				<li>
					<span class="lb_block"><label for="google_client_id">클라이언트 ID</label>
					</span>
                    <input type="text" name="google_client_id" value="<?php echo $gmail_smtp_config['google_client_id']; ?>" id="google_client_id" class="frm_input" size="80">
				</li>
				<li>
					<span class="lb_block"><label for="google_client_secret">클라이언트 보안 비밀</label>
					</span>
					<input type="text" name="google_client_secret" value="<?php echo $gmail_smtp_config['google_client_secret']; ?>" id="google_client_secret" class="frm_input" size="50">
				</li>
			</ul>
		</section>

		<div class="btn_fixed_top btn_confirm">
			<input type="submit" value="저장" class="btn_submit btn" accesskey="s">
		</div>
	</form>
</div>
<script>

function gmail_smtp_config_submit(f){

    var send_type = f.send_type.value;

    if(send_type == "smtp"){
        if(! f.app_password.value ){
            alert("앱 비밀번호 16자리를 반드시 입력해야 합니다.");
            f.app_password.focus();
            return false;
        }
    } else {
        if(! f.google_client_id.value ){
            alert("클라이언트 ID를 반드시 입력해야 합니다.");
            f.google_client_id.focus();
            return false;
        }
        if(! f.google_client_secret.value ){
            alert("클라이언트 보안 비밀을 반드시 입력해야 합니다.");
            f.google_client_secret.focus();
            return false;
        }

    }

	return true;
}

(function($){
    $(document).on("click", ".smtp-type-tabs a", function(e){
        var smtp_val = $(this).attr("data-value"),
            class_name = "active";

        $("#send_type").val(smtp_val);
        $(this).parent("dl").addClass(class_name).siblings().removeClass(class_name);
        
        if( smtp_val == "smtp" ){
            $("#google_smtp").show();
            $("#google_oauth").hide();
        } else {
            $("#google_smtp").hide();
            $("#google_oauth").show();
        }
    });

    $(document).on("click", "a.google_oauth_popup", function(e){
        e.preventDefault();

        var pop_url = $(this).attr("href");
        var newWin = window.open(
            pop_url, 
            "google_oauth_popup", 
            "location=0,status=0,scrollbars=1,width=600,height=500"
        );

        if(!newWin || newWin.closed || typeof newWin.closed=='undefined')
             alert('브라우저에서 팝업이 차단되어 있습니다. 팝업 활성화 후 다시 시도해 주세요.');

        return false;
    });

<?php
if($gmail_smtp_config['send_type'] === 'smtp') {
    echo '$("#google_smtp").show();'.PHP_EOL.'$("#google_oauth").hide();';
} else {
    echo '$("#google_smtp").hide();'.PHP_EOL.'$("#google_oauth").show();';
}
?>

})(jQuery);
</script>