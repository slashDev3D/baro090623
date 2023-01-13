<?php
$excel = true;
include_once('./_common.php');
$orginizeRow = sql_fetch("select * from g5_organize where og_id = {$og_id}");

$sql = "SELECT d.og_name,e.ogt_name,d.og_id,e.ogt_id FROM 
g5_organize AS d LEFT JOIN g5_organize_team AS e ON d.og_id = e.og_id 
where d.og_id = '{$og_id}'
GROUP BY e.ogt_id
order by e.ogt_id ASC";

$result = sql_query($sql);

$reportSql = "select * from g5_report order by rt_id asc";
$reportRes = sql_query($reportSql);
$headers = ['번호','혁신단명','탐색팀명'];
for ($i=0; $reportRow=sql_fetch_array($reportRes); $i++) {
	$reportArr[] = [$reportRow['rt_id'],"#".$reportRow['rt_subject']];
	$headers[] = "#".$reportRow['rt_subject'];
}
$excelData[0] = $headers;

for ($i=0; $row=sql_fetch_array($result); $i++) {
	$rtLogSql = "select * from g5_report_contents WHERE og_id = {$row['og_id']} and team_id = {$row['ogt_id']} order by rtc_id asc";
	$rtLogRes = sql_query($rtLogSql);
	$rtLogArr = [];
	for ($j=0; $rtLogRow=sql_fetch_array($rtLogRes); $j++) {
		$rtLogArr[$rtLogRow['rt_id']] = ['filedir'=>$rtLogRow['filedir'],'filename'=>$rtLogRow['filename'],'oldname'=>$rtLogRow['oldname'],'created_at'=>$rtLogRow['created_at']];
	}
	$_i = ($i+1);
	$excelData[$_i] = [$_i,$row['og_name'],$row['ogt_name']];

	foreach($reportArr as $key=>$val){
		$does_reported = $rtLogArr[$val[0]]?"제출함":"제출안함";
		$excelData[$_i][] = $does_reported;
	}

}


include_once(G5_LIB_PATH.'/PHPExcel.php');
if(! function_exists('column_char')) {
	function column_char($i) {
		return chr( 65 + $i );
	}
}
$last_char = column_char(count($headers) - 1);
if($test==false){
	$excel = new PHPExcel();
	$excel->setActiveSheetIndex(0)->getStyle( "A:$last_char" )->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setWrapText(true);
	$excel->setActiveSheetIndex(0)->getColumnDimension( column_char($i) )->setWidth(20);
	$rowIndex = 0;
	foreach($excelData as $data){
		$rowIndex++;
		foreach($data as $k=>$column){
			$rowSubIndex = $rowIndex;
			$column_char = column_char($k);
			$cellIndex = $column_char.$rowIndex;
			$cellIndex." :: ".$column."<br />";
			$column = $column?$column:" ";
			$excel->setActiveSheetIndex(0)->setCellValue($cellIndex, $column);
		}
		$rowIndex = $rowSubIndex;
	}
	$excel->setActiveSheetIndex(0)->getStyle("A1:".$last_char.$rowIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"projectList_".$og_id."_".date("ymdHi").".xls\"" );
		header("Cache-Control: max-age=0");

		$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		//$writer->save($makeDir."/{$item_rows['num']}.xls");
		$writer->save('php://output');
	
}