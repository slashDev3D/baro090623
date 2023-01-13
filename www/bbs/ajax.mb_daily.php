<?php
include_once('./_common.php');

$participateSql = "INSERT INTO `g5_participated` (`bo_table`, `wr_id`, `mb_no`, `pt_datetime`) VALUES ('{$_REQUEST['bo_table']}',  {$_REQUEST['wr_id']}, {$_REQUEST['mb_no']}, now());";
sql_query($participateSql);
?>