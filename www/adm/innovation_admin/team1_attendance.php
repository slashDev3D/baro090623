<?php
$sub_menu = "800100";
include_once('./_common.php');
$orginizeRow = sql_fetch("select * from g5_organize where og_id = {$og_id}");
$g5['title'] = $orginizeRow['og_name'];

include_once (G5_ADMIN_PATH.'/admin.head.php');
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


?>

<div class="inno_tp">
    <ul class="inno_cate_ul">
        <li class=""><a href="<?php echo G5_ADMIN_URL ?>/innovation_admin/team1_member.php?og_id=<?=$og_id?>" class="">회원관리</a></li>
        <li class=""><a href="<?php echo G5_ADMIN_URL ?>/innovation_admin/team1_attendance.php?og_id=<?=$og_id?>" class="on">영상교육</a></li>
        <li class=""><a href="<?php echo G5_ADMIN_URL ?>/innovation_admin/team1_liveAtt.php?og_id=<?=$og_id?>" class="">실시간교육</a></li>
        <li class=""><a href="<?php echo G5_ADMIN_URL ?>/innovation_admin/team1_project.php?og_id=<?=$og_id?>" class="">과제현황</a></li>
    </ul>

    <div class="inno_down_box right">
        <button type="button" class="btn_inno_excel_down" onclick="location.href='/bbs/print_excel_participate1.php?og_id=<?=$og_id?>'" >엑셀 다운로드</button>
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
                    <th rowspan="2" width="50px">역할</th>
                    <th rowspan="2" width="150px">학생명</th>
                    <th colspan="<?=count($participate2array)?>">영상교육</th>
                </tr>
                <tr>
                    <!-- 영상교육 -->
					<?php
					foreach($participate2array as $key=>$val){
					?>
                        <th class="tdVd"><?=$val[1]?></th>
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
				for ($j=0; $ptLogRow=sql_fetch_array($ptLogRes); $j++) {
					$ptLogArray[$ptLogRow['wr_id']] = $ptLogRow['pt_datetime'];
				}
				
			?>
                <tr>
                    <td><?=$i+1?></td>
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