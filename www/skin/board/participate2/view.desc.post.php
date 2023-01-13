<?php
include_once('./_common.php');


$tbl = $_POST['tbl'];
$order = $_POST['order'];

$sql = "select * from g5_write_".$tbl." order by wr_subject ".$order;

$result = sql_query($sql, true);

$rows = array();
$inc = 0;
while($row=sql_fetch_array($result)) {
    $rows[$inc] = $row;
    $inc++;
}
echo json_encode($rows);


?>


