<?php
include_once('./_common.php');
header( "Content-type: application/vnd.ms-excel; charset=utf-8");
header( "Content-Disposition: attachment; filename = memberList_".$og_id."_".date("ymdHi").".xls" );
header( "Content-Description: PHP4 Generated Data" );

echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";

$sql = "select * from g5_member AS a
left JOIN g5_organize AS b ON a.mb_1 = b.og_id
LEFT JOIN g5_organize_team AS c ON a.mb_2 = c.ogt_id AND b.og_id = c.og_id where mb_1 = '{$og_id}' and mb_level = 2
order by c.ogt_name asc, a.mb_3 asc, a.mb_name asc";

$result = sql_query($sql);
?>

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
                <?php if($row['mb_sex'] == "m") { $sexKor =  "남";} else { =   "여";} ?>
                <tr>
                    <td>1</td>
                    <td><?=$row['og_name']?></td>
                    <td><?=$row['ogt_name']?></td>
                    <td><?=$row['mb_3']?></td>
                    <td><?=$row['mb_name']?></td>
                    <td><?=$row['mb_birth']?></td>
                    <td><?=$sexKor?></td>
                    <td><?=$row['mb_hp']?></td>
                    <td><?=$row['mb_email']?></td>
                </tr>
			<?php }?>
            </tbody>
        </table>
