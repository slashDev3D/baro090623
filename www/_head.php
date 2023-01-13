<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_PATH.'/head.php');

$nowFileName2 = basename($_SERVER['PHP_SELF']);
$without_extension2 = substr($nowFileName, 0, strrpos($nowFileName, ".")) == "board" ? $bo_table : substr($nowFileName, 0, strrpos($nowFileName, "."));


if ($member['mb_level'] < 2 
    && get_head_title($g5['title']) != "로그인" 
    && get_head_title($g5['title']) != "회원가입" 
    && get_head_title($g5['title']) != "인증메일 다시받기"
    && $bo_table != "business3" && $bo_table != "business4" && $bo_table != "business5"  && $bo_table != "business2" 
    && $without_extension2 != "business1" && $without_extension2 != "business6"
    ) {
    if ($is_member)
        alert('관리자 승인 후 사이트 이용 가능합니다.', G5_URL);
    else
        alert('회원만 이용가능한 사이트입니다.\\n회원이시라면 로그인 후 이용해 보십시오.', G5_BBS_URL.'/login.php');
}