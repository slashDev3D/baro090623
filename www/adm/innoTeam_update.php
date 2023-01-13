<?php
$sub_menu = "200270";
include_once("./_common.php");
include_once(G5_LIB_PATH."/register.lib.php");
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$posts = [];
$check_keys = ['og_id','ogt_name'];
foreach( $check_keys as $key ){
    $posts[$key] = isset($_POST[$key]) ? clean_xss_tags($_POST[$key], 1, 1) : '';
}

$sql_common = "og_id = '{$posts['og_id']}', ogt_name = '{$posts['ogt_name']}'";

if ($w == '')
{
    sql_query(" insert into g5_organize_team set  created_at = '".G5_TIME_YMDHIS."', {$sql_common} ");
}
else if ($w == 'u')
{
    $sql = " update g5_organize_team
                set {$sql_common},
                     updated_at = '".G5_TIME_YMDHIS."'
                where ogt_id = '{$ogt_id}' ";
    sql_query($sql);
}
else if ($w == 'ds')
{
	foreach($chk as $key=>$val){
		$sql = "delete from g5_organize_team where ogt_id = '{$ogt_ids[$val]}' ";	
	    sql_query($sql);
	}
	alert('선택하신 혁신팀이 삭제되었습니다.');
}
else
    alert('제대로 된 값이 넘어오지 않았습니다.');


goto_url('./innoTeam_list.php?', false);