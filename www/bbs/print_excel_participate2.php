<?php
$excel = true;
include_once('./_common.php');
$orginizeRow = sql_fetch("select * from g5_organize where og_id = {$og_id}");
$g5['title'] = $orginizeRow['og_name'];

$sql = "SELECT b.*,d.og_name,e.ogt_name FROM g5_member AS b
left JOIN g5_organize AS d ON b.mb_1 = d.og_id
LEFT JOIN g5_organize_team AS e ON b.mb_2 = e.ogt_id AND d.og_id = e.og_id
where b.mb_1 = '{$og_id}' and b.mb_level = 2
order by b.mb_3 asc";

$result = sql_query($sql);

$headers = ['번호','혁신단명','탐색팀명','역할','학생명'];

$participate2query = "select * from g5_write_participate3 where wr_5 = '{$og_id}' order by wr_id asc";
$participate2result = sql_query($participate2query);
$participate2array = [];
for ($i=0; $participate2row=sql_fetch_array($participate2result); $i++) {
	$participate2array[] = [$participate2row['wr_id'],"#".$participate2row['wr_subject']." ".$participate2row['wr_1']];
	$headers[] = "#".$participate2row['wr_subject']." ".$participate2row['wr_1'];
}
$excelData[0] = $headers;

for ($i=0; $row=sql_fetch_array($result); $i++) {
	$_i = ($i+1);
	$contentsRow = sql_fetch("select * from g5_write_{$row['bo_table']} where wr_id = {$row['wr_id']}");

	$ptLogSql = "select * from g5_participated WHERE bo_table = 'participate3' and mb_no = {$row['mb_no']}";
	$ptLogRes = sql_query($ptLogSql);
	$ptLogArray = [];
	for ($j=0; $ptLogRow=sql_fetch_array($ptLogRes); $j++) {
		$ptLogArray[$ptLogRow['wr_id']] = $ptLogRow['pt_datetime'];
	}
	$excelData[$_i] = [$_i,$row['og_name'],$row['ogt_name'],$row['mb_3'],$row['mb_name']];
	foreach($participate2array as $key=>$val){

		$excelData[$_i][] = $ptLogArray[$val[0]];
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
		header("Content-Disposition: attachment; filename=\"liveEduction_".$og_id."_".date("ymdHis", time()).".xls\"");
		header("Cache-Control: max-age=0");

		$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		//$writer->save($makeDir."/{$item_rows['num']}.xls");
		$writer->save('php://output');
	
}