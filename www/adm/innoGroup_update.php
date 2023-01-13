<?php
$sub_menu = "200260";
include_once("./_common.php");
include_once(G5_LIB_PATH."/register.lib.php");
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$posts = [];
$check_keys = ['og_name'];
foreach( $check_keys as $key ){
    $posts[$key] = isset($_POST[$key]) ? clean_xss_tags($_POST[$key], 1, 1) : '';
}

$sql_common = "og_name = '{$posts['og_name']}'";

if ($w == '')
{
    sql_query(" insert into g5_organize set  created_at = '".G5_TIME_YMDHIS."', {$sql_common} ");
}
else if ($w == 'u')
{
    $sql = " update g5_organize
                set {$sql_common},
                     updated_at = '".G5_TIME_YMDHIS."'
                where og_id = '{$og_id}' ";
    sql_query($sql);
}
else if ($w == 'ds')
{
	foreach($chk as $key=>$val){
		$sql = "delete from g5_organize where og_id = '{$og_ids[$val]}' ";	
	    sql_query($sql);
		$sql = "delete from g5_organize_team where og_id = '{$og_ids[$val]}' ";	
	    sql_query($sql);
	}
	alert('선택하신 혁신단과 관련팀이 삭제되었습니다.');
}
else
    alert('제대로 된 값이 넘어오지 않았습니다.');


goto_url('./innoGroup_list.php?'.$qstr.'&amp;w=u&amp;mb_id='.$mb_id, false);