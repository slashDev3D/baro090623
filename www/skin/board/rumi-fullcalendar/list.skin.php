<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
unset($list);
include_once($board_skin_path.'/config.php');

if (empty($board['bo_10'])) {
    $bo_10 = 'dayGridMonth|1|0|ko|dayGridMonth,dayGridWeek,dayGridDay|all';
    sql_query(" UPDATE `{$g5['board_table']}` SET bo_10 = 'dayGridMonth|1|0|ko|dayGridMonth,dayGridWeek,dayGridDay' WHERE bo_table = '{$bo_table}' ", FALSE);
    list($fc_default_view, $fc_display_name, $fc_weeks_number, $fc_lang, $fc_display_types, $fc_list) = explode("|", $bo_10);
}

$fc_lang = $fc_lang ? $fc_lang : 'ko';
$defaultview = ($fc_default_view) ? $fc_default_view : 'dayGridMonth';
$weekNumbers = ($fc_weeks_number) ? true : false;

if($is_category) {
    $category = explode("|", $board['bo_category_list']); // 카테고리
}
$category = json_encode($category, JSON_UNESCAPED_UNICODE);

add_stylesheet('<link rel="stylesheet" href="'.G5_PLUGIN_URL.'/rumiPopup/rumiPopup.css">', 0); // 팝업창 CSS
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/css/style.css?ver='.G5_CSS_VER.'">', 0);
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/css/fullcalendar.css?ver='.G5_CSS_VER.'">', 0);
add_stylesheet('<link rel="stylesheet" href="'.FC_PLUGIN_URL.'/lib/main.css" />', 0);

add_javascript('
<script>
var bbs_write_url = "'.$write_href.'";
var bbs_admin_url = "'.htmlspecialchars_decode($admin_href).'";
var plugin_url = "'.FC_PLUGIN_URL.'";
var fc_lang = "'.$fc_lang.'";
var fc_display_types = "'.$fc_display_types.'";
var g5_time_ymd = "'.G5_TIME_YMD.'";
var defaultview = "'.$defaultview.'";
var weekNumbers = "'.$weekNumbers.'";
var board_skin_url = "'.$board_skin_url.'";
var sca = "'.urlencode($sca).'";
var is_category = "'.$is_category.'";
var category = '.$category.';
</script>
', 0);

add_javascript('<script src="'.G5_PLUGIN_URL.'/rumiPopup/jquery.rumiPopup.js"></script>', 0); // 팝업창
add_javascript('<script src="'.$board_skin_url.'/js/skin.function.js?ver='.G5_JS_VER.'"></script>', 0);
add_javascript('<script src="'.$board_skin_url.'/js/fullcalendar.js?ver='.G5_JS_VER.'"></script>', 0);
add_javascript('<script src="'.FC_PLUGIN_URL.'/lib/main.js"></script>', 0);
add_javascript('<script src="'.FC_PLUGIN_URL.'/lib/locales/'.$fc_lang.'.js"></script>', 0); // 언어파일
?>

<div id="bo_list" style="width:<?php echo $width; ?>">
    <!-- 게시판 카테고리 시작 { -->
    <?php if ($is_category) { ?>
    <nav id="bo_cate">
        <h2><?php echo $board['bo_subject'] ?> 카테고리</h2>
        <ul id="bo_cate_ul"></ul>
    </nav>
    <?php } ?>

    <!-- } 게시판 카테고리 끝 -->
    <input type="hidden" id="sca" class="sca" value="" />
    <div id="calendar"></div>

</div>