<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 사용하지 않을시 아래 코드 return 주석을 해제
//return;

if( version_compare( PHP_VERSION, '5.4' , '>=' ) ){     // PHP 버전이 5.4 이상이어야 가능

    define('G5_GMAIL_SMTP_DIR', 'gmail_smtp');

    require_once G5_PLUGIN_PATH.'/'.G5_GMAIL_SMTP_DIR.'/gmail_smtp.class.php';
}