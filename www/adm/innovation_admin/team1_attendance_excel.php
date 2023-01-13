<?php
include_once('./_common.php');
$orginizeRow = sql_fetch("select * from g5_organize where og_id = {$og_id}");
$g5['title'] = $orginizeRow['og_name'];

$sql = "SELECT b.*,d.og_name,e.ogt_name FROM g5_member AS b
left JOIN g5_organize AS d ON b.mb_1 = d.og_id
LEFT JOIN g5_organize_team AS e ON b.mb_2 = e.ogt_id AND d.og_id = e.og_id
where b.mb_1 = '{$og_id}' and b.mb_level = 2
order by e.ogt_name asc, b.mb_3 asc, b.mb_name asc";

$result = sql_query($sql);

$participate2query = "select * from g5_write_participate2 order by wr_id asc";
$participate2result = sql_query($participate2query);
$participate2array = [];
for ($i=0; $participate2row=sql_fetch_array($participate2result); $i++) {
	$participate2array[] = [$participate2row['wr_id'],"#".$participate2row['wr_subject']." ".$participate2row['wr_1']];
}

$participate3query = "select * from g5_write_participate3 where wr_5 = '{$og_id}' order by wr_id asc";
$participate3result = sql_query($participate3query);
$participate3array = [];
for ($i=0; $participate3row=sql_fetch_array($participate3result); $i++) {
	$participate3array[] = [$participate3row['wr_id'],"#".$participate3row['wr_subject']." ".$participate3row['wr_1']];
}

?>
<table class="tbl_st_01" style="">
	<thead>
		<tr>
			<th width="50px">번호</th>
			<th width="150px">혁신단명</th>
			<th width="150px">탐색팀명</th>
			<th width="50px">역할</th>
			<th width="150px">학생명</th>
			<?php
			foreach($participate2array as $key=>$val){
			?>
			<th><?=$val[1]?></th>
			<?php
			}
			?>
			<!-- 실시간교육 -->
			<!-- 영상교육 -->
			<?php
			foreach($participate3array as $key=>$val){
			?>
			<th><?=$val[1]?></th>
			<?php
			}
			?>
		</tr>
	</thead>
	<tbody>
	<?php 
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$contentsRow = sql_fetch("select * from g5_write_{$row['bo_table']} where wr_id = {$row['wr_id']}");

		$ptLogSql = "select * from g5_participated WHERE bo_table = 'participate2' and mb_no = {$row['mb_no']}";
		$ptLogRes = sql_query($ptLogSql);
		$ptLogArray = [];
		for ($i=0; $ptLogRow=sql_fetch_array($ptLogRes); $i++) {
			$ptLogArray[$ptLogRow['wr_id']] = $ptLogRow['pt_datetime'];
		}
		
		$ptLog2Sql = "select * from g5_participated WHERE bo_table = 'participate3' and mb_no = {$row['mb_no']}";
		$ptLog2Res = sql_query($ptLog2Sql);
		$ptLogArray2 = [];
		for ($i=0; $ptLog2Row=sql_fetch_array($ptLog2Res); $i++) {
			$ptLogArray2[$ptLog2Row['wr_id']] = $ptLog2Row['pt_datetime'];
		}
	?>
		<tr>
			<td>1</td>
			<td><?=$row['og_name']?></td>
			<td><?=$row['ogt_name']?></td>
			<td><?=$row['mb_3']?></td>
			<td>
				<?=$row['mb_name']?>		
			</td>
			<?php
			foreach($participate2array as $key=>$val){
			?>
				<td><?=$ptLogArray[$val[0]]?></td>
			<?php
			}
			?>
			<!-- 실시간교육 -->
			<!-- 영상교육 -->
			<?php
			foreach($participate3array as $key=>$val){
			?>
				<td><?=$ptLogArray2[$val[0]]?></td>
			<?php
			}
			?>
		</tr>
	<?php }?>
	</tbody>
</table>
<?php

header("Content-Description: File Transfer");
header('Content-Type:text/csv;charset=UTF-8;');
header('Content-Transfer-Encoding: binary');
header("Content-Disposition: attachment; filename=" . $export_file_name);
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

$handle = fopen('php://output', 'w');

ob_clean(); // clean slate


echo "\xEF\xBB\xBF";

$header_array = array('일련번호', 'ftc.go.kr 고유번호', '업종', '상호', '영업표지', '대표', '사업자등록번호', '주소', '대표번호', '매출액(n-1)', '매출액(n-2)', '매출액(n-3)', '가맹점(n-1)', '가맹점(n-2)', '가맹점(n-3)', '최근등록일' , '최초등록일', '최종업데이트', '링크');


ob_flush(); // dump buffer

fclose($handle);

die();


?>