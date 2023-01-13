<?php 
include_once('_common.php');

$rt_id = $_POST['rt_id'];
$mb_no = $_POST['mb_no'];
$og_id = $_POST['og_id'];
$ogt_id = $_POST['ogt_id'];
$tmp_file = $_FILES['report']['tmp_name'];
$old_file = $_FILES['report']['name'];
$extensions = explode(".",$old_file);
$extension = count($extensions)>1?".".$extensions[count($extensions)-1]:'';
$filename = strtotime(date("Y-m-d H:i:s")).$extension;

$new_file = $mb_no."_".$filename;
$reportDir = '/participate4/'.$rt_id;
$dir = G5_DATA_PATH.'/file'.$reportDir;
@mkdir($dir, G5_DIR_PERMISSION);
$dest_file = $dir.'/'.$new_file;
$error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['report']['error'][$i]);
chmod($dest_file, G5_FILE_PERMISSION);

$insertQuery = "INSERT INTO `g5_report_contents` (`rt_id`, `mb_no`, `og_id`, `team_id`, `filedir`, `filename`, `oldname`,`created_at`) VALUES ('{$rt_id}', '{$mb_no}', '{$og_id}', '{$ogt_id}', '{$reportDir}', '{$new_file}', '{$old_file}',now());";
sql_query($insertQuery);
?>
<script>
alert('과제가 제출되었습니다.');
location.href='./participate4.php?rt_id=<?=$rt_id?>'
</script>
