<?php
include_once('./_common.php');

// 로그인중인 경우 회원가입 할 수 없습니다.

if (!$isAuthorized) {
	alert('인증받은 회원만 가입을 진행할 수 있습니다.');
    goto_url(G5_URL);
}

if ($is_member) {
    goto_url(G5_URL);
}

// 세션을 지웁니다.
set_session("ss_mb_reg", "");

$g5['title'] = '회원가입';
include_once('./_head.php');

// $register_action_url = G5_BBS_URL.'/register_form.php';
// include_once($member_skin_path.'/register.skin.php');


$register_action_url = G5_BBS_URL.'/register_form.php';
include_once($member_skin_path.'/register_type.skin.php');

include_once('./_tail.php');