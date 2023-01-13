<?php
include_once('./_common.php');
include_once($board_skin_path.'/config.php');

//--------------------------------------------------------------------------------------------------
// This script reads event data from a JSON file and outputs those events which are within the range
// supplied by the "start" and "end" GET parameters.
//
// An optional "timezone" GET parameter will force all ISO8601 date stings to a given timezone.
//
// Requires PHP 5.2.0 or higher.
//--------------------------------------------------------------------------------------------------

// Require our Event class and datetime utilities
require FC_PLUGIN_PATH.'/examples/php/utils.php';

$sca        = $_POST['sca'];
$stx        = $_POST['stx'];
$start      = $_POST['start'];
$end        = $_POST['end'];
$timezone   = $_POST['timezone'];
$bo_table   = $_POST['bo_table'];

// Short-circuit if the client did not give us a date range.
if (!$start || !$end) {
	die("Please provide a date range.");
}

// Parse the start/end parameters.
// These are assumed to be ISO8601 strings with no time nor timezone, like "2013-12-29".
// Since no timezone will be present, they will parsed as UTC.

$range_start = parseDateTime($start);
$range_end = parseDateTime($end);

// Parse the timezone parameter if it is present.
$timezone = null;
if (isset($timezone)) {
	$timezone = new DateTimeZone($timezone);
}

// Read and parse our events JSON file into an array of event data arrays. ( yyyy-mm-dd )
//$frdate = $start;
//$todate = $end;

//print_r2($_GET);
//$frdate = substr(preg_replace('/[^A-Za-z0-9]/', '', $frdate), 0, 8); // yyyymmdd
//$todate = substr(preg_replace('/[^A-Za-z0-9]/', '', $todate), 0, 8); // yyyymmdd

$sql_where = "";
if ($sca || $stx || $stx === '0') { // 검색이면
    $sql_search = get_sql_search($sca, $sfl, $stx, $sop);
    if ($sql_search) {
        $sql_where = " AND ". $sql_search;
    }
}

if($fc_list == "person") {
    $sql_where .= " AND mb_id = '{$member['mb_id']}' ";
}

$input_arrays = array();
$sql = "SELECT
            *
        FROM 
            {$write_table}
        WHERE
            wr_1 <= '{$end}' AND 
            wr_2 >= '{$start}' AND 
            wr_1 <> '' AND 
            wr_2 <> '' 
            {$sql_where} ";
$result = sql_query($sql, TRUE);

while($row = sql_fetch_array($result)) {

    // 비밀글
    if (strstr($row['wr_option'], "secret")) {
        if ($row['mb_id'] !== $member['mb_id'] && !$is_admin) {
            continue;
        }
    }

    $rows = array();

    $rows['title']      = ($fc_display_name) ? '['.$row['wr_name'].'] '.$row['wr_subject'] : $row['wr_subject']; // 타이틀
    $rows['textColor']  = $row['wr_3']; // 글자색상
    $rows['color']      = $row['wr_4']; // 배경색
    $rows['progress']   = '';
    $rows['repeat']     = '';
    $rows['id']         = $row['wr_id']; // 글번호
    
    if ($row['wr_link1'] && !$is_admin && $row['mb_id'] != $member['mb_id']) {
        $rows['url'] = $row['wr_link1'];
    }

    // if ($rows['start'] != $rows['end'] && !$row['wr_5'] && !$row['wr_6']) {
    //     $rows['end'] = wz_get_addday($rows['end'], 1);
    // }

    $rows['start']  = str_replace(" ", "T", $row['wr_1']);
    $rows['end']    = str_replace(" ", "T", $row['wr_2']);
    // $rows['fr']     = str_replace(" ", "T", $row['wr_1']);
    // $rows['to']     = str_replace(" ", "T", $row['wr_2']);
    // $rows['start']  = $rows['start'] . ($row['wr_5'] ? 'T'.$row['wr_5'] : '');
    // $rows['end']    = $rows['end'] . ($row['wr_6'] ? 'T'.$row['wr_6'] : '');
    $rows['wr_id']  = ($member['mb_id'] == $row['mb_id'] || $is_admin) ? $row['mb_id'] : ""; // 작성자 ID
    $rows['member_id'] = $member['mb_id'];
    $rows['resourceId'] = 'a';

    $rows['allDay'] = false;
    // if ($row['wr_5'] || $row['wr_6']) {
    //     $rows['allDay'] = false;
    // }

    $input_arrays[] = $rows;
}

// Accumulate an output array of event data arrays.
$output_arrays = array();
foreach ($input_arrays as $array) {

	// Convert the input array into a useful Event object
	$event = new Event($array, $timezone);

	// If the event is in-bounds, add it to the output
	if ($event->isWithinDayRange($range_start, $range_end)) {
		$output_arrays[] = $event->toArray();
    }
}
// Send JSON to the client.
echo json_encode($output_arrays);
//echo json_encode($input_arrays);