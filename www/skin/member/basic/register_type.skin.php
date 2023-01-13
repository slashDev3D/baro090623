<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);


?>


<!-- 회원가입약관 동의 시작 { -->
<div class="register">

    <form  name="regsterType" id="regsterType" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">
		<input type="hidden" name="isAuthorized" value="<?=$isAuthorized?>">
        <ul class="register_type_container">
            <li class="tpS">
                <input type="radio" name="mb_7" id="radioRegisterStudent" value="student"/>
                <label for="radioRegisterStudent">
                    <div class="img"><img src="<?php echo G5_URL ?>/common/images/sub/member_type_student.png" /></div>
                    <div class="txt">
                        <span></span>
                        <p>학생</p>
                    </div>
                </lable>
            </li>
            <li class="tpI">
                <input type="radio" name="mb_7" id="radioRegisterInstructor" value="instructor" />
                <label for="radioRegisterInstructor">
                    <div class="img"><img src="<?php echo G5_URL ?>/common/images/sub/member_type_instructor.png" /></div>
                    <div class="txt">
                        <span></span>
                        <p>인스트럭터</p>
                    </div>
                </lable>
            </li>
        </ul>

        <button type="submit" class="btn_typeSubmit" >가입하기</button>
    </form>

</div>


<script>
    $(document).ready(function () {
        $("#sub_title").addClass("register_tit").append(`<div class="c">회원가입 유형을 선택해주세요.</div>`);        
    });
</script>
<!-- } 회원가입 약관 동의 끝 -->
