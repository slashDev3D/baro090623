<?php
include_once("../../common.php");

$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];

if(!$startDate || !$endDate) {
    exit;
}

$sql = "SELECT
            *
        FROM
            cm_lunar
        WHERE
            soldate BETWEEN '{$startDate}' AND '{$endDate}' ";
$result = sql_query($sql, TRUE);
$list = array();
while($row=sql_fetch_array($result)) {
    $lunleap = ($row['lunleap'] == 1) ? "윤" : "";
    $list[] = array(
        "day" => $row['lunmonth'].".".$row['lunday'].$lunleap,
        "holiday" => $row['holiday1']
    );
}

echo json_encode($list);
?>