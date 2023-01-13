<?php
$sub_menu = "800100";
include_once('./_common.php');
$orginizeRow = sql_fetch("select * from g5_organize where og_id = {$og_id}");
$g5['title'] = $orginizeRow['og_name'];

include_once (G5_ADMIN_PATH.'/admin.head.php');
$sql = "SELECT d.og_name,e.ogt_name,d.og_id,e.ogt_id FROM 
g5_organize AS d LEFT JOIN g5_organize_team AS e ON d.og_id = e.og_id 
where d.og_id = '{$og_id}'
GROUP BY e.ogt_id
order by e.ogt_name asc";

$result = sql_query($sql);

$reportSql = "select * from g5_report order by rt_id asc";
$reportRes = sql_query($reportSql);
for ($i=0; $reportRow=sql_fetch_array($reportRes); $i++) {
	$reportArr[] = [$reportRow['rt_id'],"#".$reportRow['rt_subject']];
}
?>

<div class="inno_tp">
    <ul class="inno_cate_ul">
        <li class=""><a href="<?php echo G5_ADMIN_URL ?>/innovation_admin/team1_member.php?og_id=<?=$og_id?>" class="">회원관리</a></li>
        <li class=""><a href="<?php echo G5_ADMIN_URL ?>/innovation_admin/team1_attendance.php?og_id=<?=$og_id?>" class="">영상교육</a></li>
        <li class=""><a href="<?php echo G5_ADMIN_URL ?>/innovation_admin/team1_liveAtt.php?og_id=<?=$og_id?>" class="">실시간교육</a></li>
        <li class=""><a href="<?php echo G5_ADMIN_URL ?>/innovation_admin/team1_project.php?og_id=<?=$og_id?>" class="on">과제현황</a></li>
    </ul>

    <div class="inno_down_box right">
        <button type="button" onclick="location.href='/report/download_team_report.php?og_id=<?=$og_id?>'" class="btn_inno_zip_down">전체 과제 다운로드</button>
        <button type="button" class="btn_inno_excel_down" onclick="location.href='/bbs/print_excel_participate3.php?og_id=<?=$og_id?>'" >엑셀 다운로드</button>
    </div>
</div>




<div class="inno_bt">


    <div class="tbl_w100 scroll mt30 mb30">
        <table class="tbl_st_01" style="">
            <thead>
                <tr>
                    <th rowspan="2" width="50px">번호</th>
                    <th rowspan="2" width="150px">혁신단명</th>
                    <th rowspan="2" width="150px">탐색팀명</th>
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

				$rtLogSql = "select * from g5_report_contents WHERE og_id = {$row['og_id']} and team_id = {$row['ogt_id']} order by rtc_id asc";
				$rtLogRes = sql_query($rtLogSql);
				$rtLogArr = [];
				for ($j=0; $rtLogRow=sql_fetch_array($rtLogRes); $j++) {
					$rtLogArr[$rtLogRow['rt_id']] = ['filedir'=>$rtLogRow['filedir'],'filename'=>$rtLogRow['filename'],'oldname'=>$rtLogRow['oldname'],'created_at'=>$rtLogRow['created_at']];
				}

			?>
                <tr>
                    <td><?=$i+1?></td>
                    <td><?=$row['og_name']?></td>
                    <td><?=$row['ogt_name']?></td>
                    <!-- 영상교육 -->
					<?php
					foreach($reportArr as $key=>$val){
					?>
                    <th><?php if($rtLogArr[$val[0]]){?><a href="/bbs/download_report.php?path=<?=$rtLogArr[$val[0]]['filedir'].'/'.$rtLogArr[$val[0]]['filename']?>&filename=<?=$rtLogArr[$val[0]]['oldname']?>" class="btn_assi_down">과제다운로드</a><?php }?></th>
					<?php
					}
					?>
                </tr>
			<?php }?>
            </tbody>
        </table>
    </div>


</div>

<script>
    let tdLen = $(".tbl_st_01  tr:nth-of-type(1) td").length-5;
    let ttW = $(".tbl_w100").width();
    let tblWidth = ( ttW > 550 + (tdLen * 100) ) ? '100%' : 550 + (tdLen * 100) ;
    
    $(".tbl_st_01").width(tblWidth);
</script>