<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 회원가입결과 시작 { -->
<div id="reg_result" class="register">

    <?php if (is_use_email_certify()) {  ?>
    <p class="result_txt">
        회원 가입 시 입력하신 이메일 주소로 인증메일이 발송되었습니다.<br>
        <b style="color:#2e63f6">발송된 인증메일을 인증완료</b>해주세요.<br>
        메일인증 완료 후 관리자 승인처리되면, 사이트를 원활하게 이용하실 수 있습니다.<br>
        <?php
            $lin = explode("@",$mb['mb_email']);
        ?>
        <a href="<?php echo 'http://'.$lin[1] ?>" target="_blank" class="aMail">메일인증하기</a>
    </p>
    <div id="result_email">
        <span>성함</span>
        <strong><?php echo get_text($mb['mb_name']); ?></strong><br>
        <span>아이디</span>
        <strong><?php echo $mb['mb_id'] ?></strong><br>
        <span>이메일 주소</span>
        <strong><?php echo $mb['mb_email'] ?></strong>
    </div>
    <?php }  ?>

    <ul class="list_dot">
        <li>인증메일이 오지 않았다면, 스팸메일함을 확인해주세요</li>
        <li>이메일 주소를 잘못 입력하셨다면, 사이트 관리자에게 문의해주시기 바랍니다.</li>
        <li>회원님의 비밀번호는 아무도 알 수 없는 암호화 코드로 저장되므로 안심하셔도 좋습니다.</li>
        <li>아이디, 비밀번호 분실시에는 회원가입시 입력하신 이메일 주소를 이용하여 찾을 수 있습니다.</li>
        <li>회원 탈퇴는 언제든지 가능하며 일정기간이 지난 후, 회원님의 정보는 삭제하고 있습니다.</li>
    </ul>
</div>
<!-- } 회원가입결과 끝 -->
<div class="btn_confirm_reg">
	<a href="<?php echo G5_URL ?>/" class="reg_btn_submit">메인으로</a>
</div>