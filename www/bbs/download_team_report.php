<?php
include_once('./_common.php');
$teamReportQuery = "select * from g5_report_contents where team_id = {$ogt_id}";
$teamReportResult = sql_query($teamReportQuery);
$teamName = 'team'.$ogt_id;
$reportDir = '/participate4/team'.$ogt_id;
$dir = G5_DATA_PATH.'/file'.$reportDir;
@mkdir($dir, G5_DIR_PERMISSION);
$zip = new ZipArchive;
$zipName = $teamName.'.zip';
$openZip = $zip->open($zipName, ZipArchive::CREATE);
for ($i=0; $teamReportRow=sql_fetch_array($teamReportResult); $i++) {
	$origin = G5_DATA_PATH.'/file'.$teamReportRow['filedir']."/".$teamReportRow['filename'];
	$newFile = "./".$teamReportRow['filename'];
	copy($origin, $newFile);
	$zip->addFile($newFile);
	//unlink($newFile);
}
$zip->close();


for ($i=0; $teamReportRow=sql_fetch_array($teamReportResult); $i++) {
	$newFile = "./".$teamReportRow['filename'];
	unlink($newFile);
}
//unlink($zipName);