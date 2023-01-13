<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

define('FC_DIR', 'fullcalendar-5.1.0');
define('FC_PLUGIN_URL', G5_PLUGIN_URL.'/'.FC_DIR);
define('FC_PLUGIN_PATH', G5_PLUGIN_PATH.'/'.FC_DIR);

// 기본보기설정. 작성자명노출, 주차표시, 언어설정, 화면버튼종류, 일정목록보기종류 
list($fc_default_view, $fc_display_name, $fc_weeks_number, $fc_lang, $fc_display_types, $fc_list) = explode("|", $board['bo_10']);

// 태이블 속성 변경
/*
ALTER TABLE `g5_write_schedule`
    CHANGE `wr_1` `wr_1` DATETIME NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '시작일시', 
    CHANGE `wr_2` `wr_2` DATETIME NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '종료일시';
*/