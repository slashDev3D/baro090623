<?php
$sub_menu = "200100";
include_once("./_common.php");
include_once(G5_LIB_PATH."/register.lib.php");
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$new_file = "";
if($_FILES['rt_file']['name']){
	$tmp_file = $_FILES['rt_file']['tmp_name'];
	$old_file = $_FILES['rt_file']['name'];
	$extensions = explode(".",$old_file);
	$extension = $extensions[count($extensions)-1];
	$filename = strtotime(date("Y-m-d H:i:s")).".".$extension;

	$new_file = $mb_no."_".$filename;
	$dir = G5_DATA_PATH.'/file/participate4/report';
	@mkdir($dir, G5_DIR_PERMISSION);
	$dest_file = $dir.'/'.$new_file;
	$error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['rt_file']['error'][$i]);
	chmod($dest_file, G5_FILE_PERMISSION);
}

$posts = [];
$check_keys = ['rt_subject','rt_descript','rt_contents'];
foreach( $check_keys as $key ){
    $posts[$key] = isset($_POST[$key]) ? clean_xss_tags($_POST[$key], 1, 1) : '';
}

$sql_common = "
rt_subject = '{$posts['rt_subject']}',
rt_descript = '{$posts['rt_descript']}',
rt_contents = '{$posts['rt_contents']}'
";

if ($w == '')
{
    sql_query(" insert into g5_report set  rt_file = '{$new_file}',created_at = '".G5_TIME_YMDHIS."', {$sql_common} ");
}
else if ($w == 'u')
{
	$new_file_sql = $new_file?"rt_file = '{$new_file}',":"";
    $sql = " update g5_report
                set {$sql_common},
					{$new_file_sql}
                     updated_at = '".G5_TIME_YMDHIS."'
                where rt_id = '{$rt_id}' ";
    sql_query($sql);
}
else if ($w == 'd')
{
    $sql = " delete from g5_report where rt_id = '{$rt_id}' ";
    sql_query($sql);
}
else
    alert('제대로 된 값이 넘어오지 않았습니다.');


goto_url('./project_list.php?', false);