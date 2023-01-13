<?php
$sub_menu = "200270";
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

$sound_only = '';
$required_mb_id_class = '';
$required_mb_password = '';

if ($w == '')
{
    $html_title = '추가';
}
else if ($w == 'u')
{
    $html_title = '추가';
}
else
    alert('제대로 된 값이 넘어오지 않았습니다.');

$g5['title'] .= '혁신단 '.$html_title;
include_once('./admin.head.php');

// add_javascript('js 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js

$sql = " select * from g5_organize_team where ogt_id = {$ogt_id} ";
$og = sql_fetch($sql);


?>

<form name="fmember" id="fmember" action="./innoTeam_update.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="og_id" value="<?php echo $og['og_id'] ?>">
<input type="hidden" name="ogt_id" value="<?php echo $og['ogt_id'] ?>">
<input type="hidden" name="token" value="">

<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4">
        <col>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row"><label for="ogt_name">팀명<?php echo $sound_only ?></label></th>
        <td>
            <input type="text" name="ogt_name" value="<?php echo $og['ogt_name'] ?>" id="ogt_name" class="frm_input" size="15"  maxlength="20">
        </td>
        <th scope="row"></th>
        <td></td>
    </tr>
    <tr>
        <th scope="row"></th>
        <td></td>
        <th scope="row"></th>
        <td></td>
    </tr>

    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <input type="submit" value="확인" class="btn_submit btn" accesskey='s'>
</div>
</form>
<?php

include_once('./admin.tail.php');