<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

$g5['title'] = '인증메일 다시받기';
include_once('./_head.php');

$mb_id = isset($_GET['mb_id']) ? substr(clean_xss_tags($_GET['mb_id']), 0, 20) : '';
$sql = " select mb_email, mb_datetime, mb_ip, mb_email_certify, mb_id from {$g5['member_table']} where mb_id = '{$mb_id}' ";
$mb = sql_fetch($sql);

if(! (isset($mb['mb_id']) && $mb['mb_id'])){
    alert("해당 회원이 존재하지 않습니다.", G5_URL);
}

if (substr($mb['mb_email_certify'],0,1)!=0) {
    alert("이미 메일인증 하신 회원입니다.", G5_URL);
}

$ckey = isset($_GET['ckey']) ? trim($_GET['ckey']) : '';
$key  = md5($mb['mb_ip'].$mb['mb_datetime']);

if(!$ckey || $ckey != $key)
    alert('올바른 방법으로 이용해 주십시오.', G5_URL);
?>

<p class="rg_em_p line1-6">
    메일인증을 받지 못한 경우 자동등록방지 코드를 입력하여 메일을 다시받아주세요.<br/>
    <span class="fw6">메일을 잘못 기입하셨다면, 다시 회원가입을 진행해주세요.</span>
</p>

<form method="post" name="fregister_email" action="<?php echo G5_HTTPS_BBS_URL.'/register_email_update.php'; ?>" onsubmit="return fregister_email_submit(this);">
<input type="hidden" name="mb_id" value="<?php echo $mb_id; ?>">

<div class="tbl_frm01 tbl_frm rg_em">
    <table>
    <caption>사이트 이용정보 입력</caption>
    <tr class="ma">
        <th scope="row"><label for="reg_mb_email">E-mail<strong class="sound_only">필수</strong></label></th>
        <td><input type="text" name="mb_email" id="reg_mb_email" required class="frm_input email " size="30" maxlength="100" value="<?php echo $mb['mb_email']; ?>" readonly></td>
    </tr>
    <tr>
        <th scope="row">자동등록방지</th>
        <td><?php echo captcha_html(); ?></td>
    </tr>
    </table>
</div>

<div class="btn_confirm">
    <input type="submit" id="btn_submit" class="btn_submit" value="인증메일 다시받기">
    <a href="<?php echo G5_URL ?>" class="btn_cancel">취소</a>
</div>

</form>
<style>
    #sub_title {padding-bottom:20px;}
    .rg_em_p {text-align:center; font-size:16px; color:#8b8b8b; line-height:1.6em; }
    .rg_em_p span {color:#2e63f6;}
    .tbl_frm {width:100%; max-width:630px; margin:80px auto 60px;}
    .tbl_frm table {border-top:2px solid #000}
    .tbl_frm th {width:155px; background:#fff; padding-left:0;}
    .tbl_frm th,
    .tbl_frm td {border:0; padding:10px 0; border-bottom:1px solid #ddd;}
    .tbl_frm td input {box-shadow:0 0 0 ; border-radius:0;}
    .tbl_frm td input.email {width:100%;}
    .tbl_frm tr.ma th,
    .tbl_frm tr.ma td {padding:20px 0; }
    .btn_confirm {text-align:center; width:100%; max-width:630px; display:flex; gap:10px; align-items:center; justify-content:center; margin-right:auto; margin-left:auto;}
    .btn_confirm > * {width:50%; max-width:250px; display:flex; padding:20px 0; border-radius:50px; align-items:center; justify-content:center;}
</style>
<script>
function fregister_email_submit(f)
{
    <?php echo chk_captcha_js();  ?>

    return true;
}
</script>
<?php
include_once('./_tail.php');