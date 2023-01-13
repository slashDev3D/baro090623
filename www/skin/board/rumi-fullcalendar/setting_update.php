<?php
include_once('./_common.php');
include_once($board_skin_path.'/config.php');

if (!$is_admin) {
    echo '<script type="text/javascript">parent.rumiPopup.close();</script>';
    exit;
}

$bo_table =  $_POST['bo_table'];
$fc_default_view = isset($_POST['fc_default_view']) ? trim($_POST['fc_default_view']) : 'dayGridMonth';
$fc_display_name = isset($_POST['fc_display_name']) ? trim($_POST['fc_display_name']) : 0;
$fc_weeks_number = isset($_POST['fc_weeks_number']) ? trim($_POST['fc_weeks_number']) : 0;
$fc_lang = isset($_POST['fc_lang']) ? trim($_POST['fc_lang']) : 'ko';
$fc_list =  isset($_POST['fc_list']) ? trim($_POST['fc_list']) : 'person';
$fc_display_types = implode(",", $_POST['fc_display_types']);

$bo_10 = $fc_default_view."|".$fc_display_name."|".$fc_weeks_number."|".$fc_lang."|".$fc_display_types."|".$fc_list;
sql_query(" UPDATE `{$g5['board_table']}` SET bo_10 = '{$bo_10}' WHERE bo_table = '{$bo_table}' ", TRUE);
goto_url($board_skin_url."/setting.php?bo_table=".$bo_table);
?>