<?php
include_once('./_common.php');
header( "Content-type: application/vnd.ms-excel; charset=utf-8");
header( "Content-Disposition: attachment; filename = projectList_".$og_id."_".date("ymdHi").".xls" );
header( "Content-Description: PHP4 Generated Data" );

echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";


$orginizeRow = sql_fetch("select * from g5_organize where og_id = {$og_id}");
$g5['title'] = $orginizeRow['og_name'];

$sql = "SELECT c.*,d.og_name,e.ogt_name,d.og_id,e.ogt_id FROM g5_member AS c
left JOIN g5_organize AS d ON c.mb_1 = d.og_id 
LEFT JOIN g5_organize_team AS e ON c.mb_2 = e.ogt_id AND d.og_id = e.og_id 
where c.mb_1 = '{$og_id}'
GROUP BY e.ogt_id
order by e.ogt_name ASC";

$result = sql_query($sql);

$reportSql = "select * from g5_report order by rt_id asc";
$reportRes = sql_query($reportSql);
for ($i=0; $reportRow=sql_fetch_array($reportRes); $i++) {
	$reportArr[] = [$reportRow['rt_id'],"#".$reportRow['rt_subject']];
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
                    <!-- 과제명 -->
					<?php
					foreach($reportArr as $key=>$val){
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

				$rtLogSql = "select * from g5_report_contents WHERE og_id = {$row['og_id']} and team_id = {$row['ogt_id']}";
				$rtLogRes = sql_query($rtLogSql);
				$rtLogArr = [];
				for ($i=0; $rtLogRow=sql_fetch_array($rtLogRes); $i++) {
					$rtLogArr[$rtLogRow['rt_id']] = ['filedir'=>$rtLogRow['filedir'],'filename'=>$rtLogRow['filename'],'oldname'=>$rtLogRow['oldname'],'created_at'=>$rtLogRow['created_at']];
				}

			?>
                <tr>
                    <td>1</td>
                    <td><?=$row['og_name']?></td>
                    <td><?=$row['ogt_name']?></td>
                    <td><?=$row['mb_3']?></td>
                    <td><?=$row['mb_name']?></td>
                    <!-- 영상교육 -->
					<?php
					foreach($reportArr as $key=>$val){
					?>
                    <th><?php if($rtLogArr[$val[0]]){?>제출완료<?php }?></th>
					<?php
					}
					?>
                </tr>
			<?php }?>
            </tbody>
        </table>