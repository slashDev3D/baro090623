<?php
$sub_menu = "800100";
include_once('./_common.php');
$orginizeRow = sql_fetch("select * from g5_organize where og_id = {$og_id}");
$g5['title'] = $orginizeRow['og_name'];

include_once (G5_ADMIN_PATH.'/admin.head.php');
$sql = "select * from g5_member AS a
left JOIN g5_organize AS b ON a.mb_1 = b.og_id
LEFT JOIN g5_organize_team AS c ON a.mb_2 = c.ogt_id AND b.og_id = c.og_id where mb_1 = '{$og_id}' and mb_level = 2
order by c.ogt_name asc, a.mb_3 asc, a.mb_name asc";

$result = sql_query($sql);
?>

<div class="inno_tp">
    <ul class="inno_cate_ul">
        <li class=""><a href="<?php echo G5_ADMIN_URL ?>/innovation_admin/team1_member.php?og_id=<?=$og_id?>" class="on">회원관리</a></li>
        <li class=""><a href="<?php echo G5_ADMIN_URL ?>/innovation_admin/team1_attendance.php?og_id=<?=$og_id?>" class="">영상교육</a></li>
        <li class=""><a href="<?php echo G5_ADMIN_URL ?>/innovation_admin/team1_liveAtt.php?og_id=<?=$og_id?>" class="">실시간교육</a></li>
        <li class=""><a href="<?php echo G5_ADMIN_URL ?>/innovation_admin/team1_project.php?og_id=<?=$og_id?>" class="">과제현황</a></li>
    </ul>

    <div class="inno_down_box right">
        <button type="button" class="btn_inno_excel_down" onclick="location.href='/bbs/print_excel_participate4.php?og_id=<?=$og_id?>'" >엑셀 다운로드</button>
    </div>
</div>


<div class="inno_bt">

    <div class="tbl_w100 mt30 mb30">
        <table class="tbl_st_01">
            <colgroup>
                <col width="5%">
                <col width="16.25%">
                <col width="16.25%">
                <col width="5%">
                <col width="10%">
                <col width="10%">
                <col width="5%">
                <col width="16.25%">
                <col width="16.25%">
            </colgroup>
            <thead>
                <tr>
                    <th>번호</th>
                    <th>혁신단명</th>
                    <th>탐색팀명</th>
                    <th>역할</th>
                    <th>학생명</th>
                    <th>생년월일</th>
                    <th>성별</th>
                    <th>핸드폰번호</th>
                    <th>이메일</th>
                </tr>
            </thead>
            <tbody>
			<?php for ($i=0; $row=sql_fetch_array($result); $i++) {?>
                <tr>
                    <td><?=$i+1?></td>
                    <td><?=$row['og_name']?></td>
                    <td><?=$row['ogt_name']?></td>
                    <td><?=$row['mb_3']?></td>
                    <td><?=$row['mb_name']?></td>
                    <td><?=$row['mb_birth']?></td>
                    <td><?php if($row['mb_sex'] == "m") {echo "남";} else {echo "여";}?></td>
                    <td><?=$row['mb_hp']?></td>
                    <td><?=$row['mb_email']?></td>
                </tr>
			<?php }?>
            </tbody>
        </table>
    </div>

</div>
