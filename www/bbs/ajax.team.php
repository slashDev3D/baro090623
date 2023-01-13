<?php
include_once('./_common.php');
$sql = "select * from g5_organize_team where og_id = {$og_id}";
$res = sql_query($sql);
$html = "";
for ($i=0; $row=sql_fetch_array($res); $i++) {
	$html .= "<option value='{$row['ogt_id']}'>{$row['ogt_name']}</option>";
}
echo $html;
?>