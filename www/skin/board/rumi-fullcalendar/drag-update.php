<?php
include_once('./_common.php');

// 게시판 글쓰기 레벨보다 낮다면 변경 불가.
if($member['mb_level'] < $board['bo_write_level']) {
    die();
}

include_once($board_skin_path.'/config.php');
//include_once(FC_PLUGIN_PATH.'/lib/function.lib.php');

$wr_id = $_POST['wr_id'];
$start = $_POST['start'];
$end = $_POST['end'];

// Short-circuit if the client did not give us a date range.
if (!isset($start) || !isset($end) || !isset($wr_id) ) {
	die("Please provide a date range.");
}

$wr_1 = date("Y-m-d H:i:s", strtotime($start." - 9 hours"));  // 시작날짜
$wr_2 = date("Y-m-d H:i:s", strtotime($end." - 9 hours"));  // 시작날짜

$mb_id = $member['mb_id']; // 자신이 등록한 자료만 변경
$sql = "UPDATE
            {$write_table}
        SET
            wr_1 = '{$wr_1}',
            wr_2 = '{$wr_2}'
        WHERE
            wr_id = '{$wr_id}' AND mb_id = '{$mb_id}' ";
sql_query($sql, TRUE);
$response = new stdClass();
$response->editDate['startDate'] = $wr_1;
$response->editDate['endDate'] = $wr_2;
echo json_encode($response);
?>