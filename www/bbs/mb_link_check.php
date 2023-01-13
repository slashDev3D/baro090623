<?php
include_once('./_common.php');
$boardData = "select * from g5_write_{$_REQUEST['bo_table']} where wr_id = {$_REQUEST['wr_id']}";
$boardRow = sql_fetch($boardData);
$startDate = strtotime($boardRow['wr_1']." ".$boardRow['wr_2']);
$endDate = strtotime($boardRow['wr_3']." ".$boardRow['wr_4']);
$now = strtotime(date("Y-m-d H:i:s"));
if($startDate<=$now&&$endDate>=$now){
	$participateSql = "INSERT INTO `g5_participated` (`bo_table`, `wr_id`, `mb_no`, `pt_datetime`) VALUES ('{$_REQUEST['bo_table']}',  {$_REQUEST['wr_id']}, {$_REQUEST['mb_no']}, now());";
	sql_query($participateSql);
	?>
	<script>
	location.href="<?=$_REQUEST['link']?>";
	</script>
<?php
}else{
?>
	<script>
	alert("출석허용일이 지났습니다.");
	self.close();
	</script>
<?php
}
?>
