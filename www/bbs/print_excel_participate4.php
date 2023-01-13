<?php
$excel = true;
include_once('./_common.php');
$orginizeRow = sql_fetch("select * from g5_organize where og_id = {$og_id}");
$g5['title'] = $orginizeRow['og_name'];

$sql = "select * from g5_member AS a
left JOIN g5_organize AS b ON a.mb_1 = b.og_id
LEFT JOIN g5_organize_team AS c ON a.mb_2 = c.ogt_id AND b.og_id = c.og_id where mb_1 = '{$og_id}' and mb_level = 2
order by a.mb_3 asc";

$result = sql_query($sql);

$headers = ['번호','혁신단명','탐색팀명','역할','학생명','생년월일','성별','핸드폰번호','이메일'];
$excelData[0] = $headers;

for ($i=0; $row=sql_fetch_array($result); $i++) {
	$_i = ($i+1);
	$dd = ($row['mb_sex'] == "m") ? "남" : "여";
	$excelData[$_i] = [$_i,$row['og_name'],$row['ogt_name'],$row['mb_3'],$row['mb_name'],$row['mb_birth'],$dd,$row['mb_hp'],$row['mb_email']];

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
		header("Content-Disposition: attachment; filename=\"memberList_".$og_id."_".date("ymdHi").".xls\"" );
		header("Cache-Control: max-age=0");

		$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		//$writer->save($makeDir."/{$item_rows['num']}.xls");
		$writer->save('php://output');

}
