<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>


<!-- 회원정보 입력/수정 시작 { -->
<?php
echo $member['level'];
    $memLevel = ( $member['mb_7'] == "student" || $member['mb_level'] == 2) ? "student" : "instructor";
?>

<div class="register register_st_<?php echo $memLevel ?>">
    <script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
    <?php if($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
        <script src="<?php echo G5_JS_URL ?>/certify.js?v=<?php echo G5_JS_VER; ?>"></script>

    <?php } ?>

	<form id="fregisterSkinForm" name="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="w" value="<?php echo $w ?>">
        <input type="hidden" name="url" value="<?php echo $urlencode ?>">
        <input type="hidden" name="agree" value="<?php echo $agree ?>">
        <input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
        <input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
        <input type="hidden" name="cert_no" value="">
        <?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면  ?>
            <input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick']) ?>">
            <input type="hidden" name="mb_nick" value="<?php echo get_text($member['mb_nick']) ?>">
        <?php }  ?>


	<div id="register_form" class="form_01">

        <div class="register_title_wrap <?php echo $memLevel ?>">
            <span>
                <?php if( $memLevel == "student") { ?>
                    학생
                <?php } else { ?>
                    인스트럭터
                <?php } ?>
                <?php if ($w == 'u' ) { echo "정보수정"; } else { echo "가입"; } ?>
            </span>
            <p><img src="<?php echo G5_URL?>/common/images/sub/register_tit_<?php echo $memLevel; ?>.png" /></p>
        </div>





        <div class="register_cert_wrap">
            <?php
            if($config['cf_cert_use']) {
                if($config['cf_cert_ipin'])
                    echo '<button type="button" id="win_ipin_cert" class="btn_frmline">아이핀 본인확인</button>'.PHP_EOL;
                if($config['cf_cert_hp']){
                    echo '<div class="cert_box">';
                    echo '<div class="ss"><span class="color">휴대폰</span> 본인 인증</div>';
                    echo '<div class="tt">휴대폰인증 서비스는 본인명의의 휴대폰으로 <Br>누구나 간편하게 인증을 진행할 수 있는 서비스입니다.</div>';
                    echo '<div><button type="button" id="win_hp_cert" class="btn_frmline">휴대폰 본인확인</button></div>'.PHP_EOL;
                    echo '<div class="img"><img src="'.G5_URL.'/common/images/sub/member_mobile.png" /></div>';
                    echo '</div>';
                }
                echo '<noscript>본인확인을 위해서는 자바스크립트 사용이 가능해야합니다.</noscript>'.PHP_EOL;
            }
            ?>

            <?php
            if ($config['cf_cert_use'] && $member['mb_certify']) {
                if($member['mb_certify'] == 'ipin')
                    $mb_cert = '아이핀';
                else
                    $mb_cert = '휴대폰';
            ?>
                <div id="msg_certify">
                    <strong><?php echo $mb_cert; ?> 본인확인</strong><?php if ($member['mb_adult']) { ?> 및 <strong>성인인증</strong><?php } ?> 완료
                </div>
            <?php } ?>

            <?php //if ($config['cf_cert_use']) { ?>
            <!--
                <button type="button" class="tooltip_icon"><i class="fa fa-question-circle-o" aria-hidden="true"></i><span class="sound_only">설명보기</span></button>
                <span class="tooltip">아이핀 본인확인 후에는 이름이 자동 입력되고 휴대폰 본인확인 후에는 이름과 휴대폰번호가 자동 입력되어 수동으로 입력할수 없게 됩니다.</span>
            -->
	        <?php //} ?>
        </div>












        <div class="regi_box">
            <div class="tit">개인 정보 입력</div>
            <div class="con">
                <div class="ss">(<span class="im"></span>) 표시는 필수입력 사항입니다.</div>

                <ul class="regi_ipt_list">
                    <li>
                        <p class="t">
                            <label for="reg_mb_id">아이디 <span class="im"></span></label>
                        </p>
                        <p class="ipt">
                            <input type="text" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" <?php echo $required ?> <?php echo $readonly ?> class="frm_input full_input <?php echo $required ?> <?php echo $readonly ?>" placeholder="이메일 형식으로 입력해 주세요">
                        </p>
                    </li>
                    <li>
                        <p class="t"><label for="reg_mb_password">비밀번호 <span class="im"></span></label></p>
                        <p class="ipt">
                            <input type="password" name="mb_password" id="reg_mb_password" <?php echo $required ?> class="frm_input full_input <?php echo $required ?>" minlength="3" maxlength="20" placeholder="비밀번호 (8~32자)">
                            <span class="color cc">입력 가능한 특수문자 !@#$%^&*)(-+=~`{}|\";':>_<],.[?/</span>
                        </p>
                    </li>
                    <li>
                        <p class="t"><label for="reg_mb_password_re">비밀번호 확인 <span class="im"></span></label></p>
                        <p class="ipt"><input type="password" name="mb_password_re" id="reg_mb_password_re" <?php echo $required ?> class="frm_input full_input <?php echo $required ?>" minlength="3" maxlength="20" placeholder="비밀번호 재확인"></p>
                    </li>

                    <li>
                        <p class="t"><label for="reg_mb_name">이름 <span class="im"></span></label></p>
                        <p class="ipt"><input type="text" id="reg_mb_name" name="mb_name" value="<?php echo get_text($member['mb_name']) ?>" <?php echo $required ?> <?php echo $readonly; ?> class="frm_input full_input <?php echo $required ?> <?php echo $readonly ?>" placeholder="한글만 입력 가능"></p>
                        <script>
                            $("#reg_mb_name").change(function () {
                                let now = new Date();
                                var month=now.getMonth()+1;//월
                                var date=now.getDate();//일
                                var hr=now.getHours();//시간
                                var min=now.getMinutes();//분
                                var sec=now.getSeconds();//초

                                $("#reg_mb_nick").val( $(this).val()+month+date+hr+min+sec )
                            })
                        </script>
                    </li>
                    <?php if ($req_nick) {  ?>
                    <li style="display:none">
                        <p class="t">
                            <label for="reg_mb_nick">
                                닉네임 <span class="im"></span>
                            </label>
                        </p>
                        <p class="ipt">
                            <input type="hidden" name="mb_nick_default" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>">
                            <input type="text" name="mb_nick" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>" id="reg_mb_nick" required class="frm_input required nospace full_input" size="10" maxlength="20" placeholder="닉네임">
                        </p>
                    </li>
                    <?php }  ?>
					<!--

                    <li>
                        <p class="t">
                            <label for="reg_mb_email">E-mail <span class="im"></span></label>
                        </p>
                        <p class="ipt">
                            <input type="hidden" name="old_email" value="<?php echo $member['mb_email'] ?>">
                            <input type="text" name="mb_email" value="<?php echo isset($member['mb_email'])?$member['mb_email']:''; ?>" id="reg_mb_email" required class="frm_input email full_input required" size="70" maxlength="100" placeholder="E-mail">
                            <?php if ($config['cf_use_email_certify']) {  ?>
                                <span class="color cc">
                                <?php if ($w=='') { echo "E-mail 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다.<br/>인증메일을 받지 못 하셨다면, 스팸메일함을 확인해주세요."; }  ?>
                                <?php if ($w=='u') { echo "E-mail 주소를 변경하시면 다시 인증하셔야 합니다."; }  ?>
                                </span>
                            <?php }  ?>
                        </p>
                    </li>
					-->


                    <?php if ($config['cf_use_homepage']) {  ?>
                        <li>
                            <label for="reg_mb_homepage">홈페이지<?php if ($config['cf_req_homepage']){ ?> <span class="im"></span><?php } ?></label>
                            <input type="text" name="mb_homepage" value="<?php echo get_text($member['mb_homepage']) ?>" id="reg_mb_homepage" <?php echo $config['cf_req_homepage']?"required":""; ?> class="frm_input full_input <?php echo $config['cf_req_homepage']?"required":""; ?>" size="70" maxlength="255" placeholder="홈페이지">
                        </li>
                    <?php }  ?>
                    <?php if ($config['cf_use_tel']) {  ?>
                        <li>
                            <label for="reg_mb_tel">전화번호<?php if ($config['cf_req_tel']) { ?> <span class="im"></span><?php } ?></label>
                            <input type="text" name="mb_tel" value="<?php echo get_text($member['mb_tel']) ?>" id="reg_mb_tel" <?php echo $config['cf_req_tel']?"required":""; ?> class="frm_input full_input <?php echo $config['cf_req_tel']?"required":""; ?>" maxlength="20" placeholder="전화번호">
                            </li>
                    <?php }  ?>


                    <li>
                        <?php if ($config['cf_use_hp'] || $config['cf_cert_hp']) {  ?>
                            <p class="t"><label for="reg_mb_hp">휴대폰번호<?php if ($config['cf_req_hp']) { ?> <span class="im"></span><?php } ?></label></p>

                            <p class="ipt">
                                <input type="text" name="mb_hp" value="<?php echo get_text($member['mb_hp']) ?>" id="reg_mb_hp" <?php echo ($config['cf_req_hp'])?"required":""; ?> class="frm_input full_input <?php echo ($config['cf_req_hp'])?"required":""; ?> <?php echo $readonly; ?>" maxlength="20" placeholder="휴대폰번호" <?php echo $readonly; ?>>
                                <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
                                <input type="hidden" name="old_mb_hp" value="<?php echo get_text($member['mb_hp']) ?>">
                                <?php } ?>
                            </p>
                        <?php }  ?>
                    </li>

                    <li style="display:<?php if($w == "") {echo 'flex'; } else {echo 'none'; } ?>;">
                        <p class="t">생년월일 <span class="im"></span></p>
                        <ul class="ipt iptBirth">
                            <li>
                                <select name="yy" id="year" class="iptSt01 iptBirth">
                                    <option>생년월일</option>
                                </select>
                            </li>
                            <li>년</li>
                            <li>
                                <select name="mm" id="month" class="iptSt01 iptBirth">
                                    <option>월</option>
                                </select>
                            </li>
                            <li>월</li>
                            <li>
                                <select name="dd" id="day" class="iptSt01 iptBirth">
                                    <option>일</option>
                                </select>
                            </li>
                            <li>일</li>
                        </ul>
                    </li>
                    <?php if ($w == "") { ?>
                        <script>
                            $(document).ready(function(){
                                var now = new Date();
                                var year = now.getFullYear();
                                var mon = (now.getMonth() + 1) > 9 ? ''+(now.getMonth() + 1) : '0'+(now.getMonth() + 1);
                                var day = (now.getDate()) > 9 ? ''+(now.getDate()) : '0'+(now.getDate());
                                //년도 selectbox만들기
                                for(var i = 1900 ; i <= year ; i++) {
                                    $('#year').append('<option value="' + i + '">' + i + '년</option>');
                                }

                                // 월별 selectbox 만들기
                                for(var i=1; i <= 12; i++) {
                                    var mm = i > 9 ? i : "0"+i ;
                                    $('#month').append('<option value="' + mm + '">' + mm + '월</option>');
                                }

                                // 일별 selectbox 만들기
                                for(var i=1; i <= 31; i++) {
                                    var dd = i > 9 ? i : "0"+i ;
                                    $('#day').append('<option value="' + dd + '">' + dd+ '일</option>');
                                }
                                $("#year  > option[value="+year+"]").attr("selected", "true");
                                // $("#month  > option[value="+mon+"]").attr("selected", "true");
                                // $("#day  > option[value="+day+"]").attr("selected", "true");
                                //$("#mb_birth").val(`${year}-${mon}-${day}`)

                                $(".iptBirth").change(function () {

                                    let yy = $("#year option:selected").val();
                                    let mm = $("#month option:selected").val();
                                    let dd = $("#day option:selected").val();

                                    $("#mb_birth").val(`${yy}-${mm}-${dd}`)
                                })
                            })
                        </script>
                    <?php } ?>
                    <li style="display:<?php if($w == "") {echo 'none'; } else {echo 'flex'; } ?>;">
                        <p class="t">생년월일</p>
                        <p class="ipt">
                            <input type="text" name="mb_birth" value="<?php echo get_text($member['mb_birth']) ?>" id="mb_birth" class="frm_input full_inp " maxlength="20" readonly>
                        </p>
                    </li>


                    <li>
                        <p class="t">성별<span class="im"></span></p>
                        <p class="ipt">
                            <?php if($w == 'u') {
                                if($member['mb_sex'] == "m") {
                                    echo '<input type="text" name="" value="남성" id="" class="frm_input full_inp " maxlength="20" readonly>';
                                }else {
                                    echo '<input type="text" name="" value="여성" id="" class="frm_input full_inp " maxlength="20" readonly>';
                                }
                            } ?>
                            <select name="mb_sex" id="mb_sex" class="iptSt01" <?php echo $required;?> style="<?php if($w == 'u') { echo 'display:none';} ?>">
                                <option value=''>성별을 선택해주세요.</option>
                                <option <?php echo get_selected($member['mb_sex'], "m");?> value="m">남성</option>
                                <option <?=$member['mb_sex']=='f'?"selected=true":""?> value="f">여성</option>
                            </select>
                        </p>
                    </li>

                    <?php if ($config['cf_use_addr']) { ?>
                    <li>
                        <label>주소</label>
                        <?php if ($config['cf_req_addr']) { ?> <span class="im"></span><?php }  ?>
                        <label for="reg_mb_zip" class="sound_only">우편번호<?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
                        <input type="text" name="mb_zip" value="<?php echo $member['mb_zip1'].$member['mb_zip2']; ?>" id="reg_mb_zip" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input twopart_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="5" maxlength="6"  placeholder="우편번호">
                        <button type="button" class="btn_frmline" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소 검색</button><br>
                        <input type="text" name="mb_addr1" value="<?php echo get_text($member['mb_addr1']) ?>" id="reg_mb_addr1" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input frm_address full_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="50"  placeholder="기본주소">
                        <label for="reg_mb_addr1" class="sound_only">기본주소<?php echo $config['cf_req_addr']?'<strong> 필수</strong>':''; ?></label><br>
                        <input type="text" name="mb_addr2" value="<?php echo get_text($member['mb_addr2']) ?>" id="reg_mb_addr2" class="frm_input frm_address full_input" size="50" placeholder="상세주소">
                        <label for="reg_mb_addr2" class="sound_only">상세주소</label>
                        <br>
                        <input type="text" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']) ?>" id="reg_mb_addr3" class="frm_input frm_address full_input" size="50" readonly="readonly" placeholder="참고항목">
                        <label for="reg_mb_addr3" class="sound_only">참고항목</label>
                        <input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>">
                    </li>
                    <?php }  ?>




                            <li>
                                <p class="t">혁신단명<span class="im"></span></p>
                                <p class="ipt">
                                    <?php if($w == 'u') {
                                        $sql = "select * from g5_organize";
                                        $res = sql_query($sql);
                                        for ($i=0; $row=sql_fetch_array($res); $i++) {
                                            if($row['og_id']==$member['mb_1']) { echo '<input type="text" name="" value="'.$row['og_name'].'" id="" class="frm_input full_inp " maxlength="20" readonly>'; }
                                        }
                                    }  ?>
                                    <select name="mb_1" id="mb_1" onchange="getTeamInfo(this.value)" class="iptSt01" <?php echo $required;?> style="<?php if($w == 'u'){ echo 'display:none';} ?>">
                                        <option value="">혁신단을 선택해주세요.</option>
                                        <?php
                                            $sql = "select * from g5_organize";
                                            $res = sql_query($sql);
                                            for ($i=0; $row=sql_fetch_array($res); $i++) {
                                        ?>
                                            <option <?=$row['og_id']==$member['mb_1']?"selected=true":""?> value="<?=$row['og_id']?>"><?=$row['og_name']?></option>
                                        <?php

                                        }?>
                                    </select>

                                </p>
                            </li>
                    <?php if( $memLevel == "student" ) { ?>
                            <li>
                                <p class="t">팀명<span class="im"></span></p>
                                <p class="ipt">

                                    <?php if($w == 'u') {
                                        $sql = "select * from g5_organize_team where og_id = {$member['mb_1']}";
                                        $res = sql_query($sql);
                                        for ($i=0; $row=sql_fetch_array($res); $i++) {
                                            if($row['ogt_id']==$member['mb_2']) { echo '<input type="text" name="" value="'.$row['ogt_name'].'" id="" class="frm_input full_inp " maxlength="20" readonly>'; }
                                        }
                                    }  ?>
                                        <select name="mb_2" id="mb_2" class="iptSt01" <?php echo $required;?> style="<?php if($w == 'u') { echo 'display:none';} ?>">
                                            <?php
                                                $sql = "select * from g5_organize_team where og_id = {$member['mb_1']}";
                                                $res = sql_query($sql);
                                                for ($i=0; $row=sql_fetch_array($res); $i++) {
                                            ?>
                                                <option <?=$row['ogt_id']==$member['mb_2']?"selected=true":""?> value="<?=$row['ogt_id']?>"><?=$row['ogt_name']?></option>
                                            <?php }?>
                                        </select>

                                </p>
                            </li>
                            <li>
                                <p class="t">역할<span class="im"></span></p>
                                <p class="ipt">
                                    <?php if($w == 'u') {
                                            echo '<input type="text" name="" value="'.$member['mb_3'].'" id="" class="frm_input full_inp " maxlength="20" readonly>';

                                    }  ?>
                                        <select name="mb_3" id="mb_3" class="iptSt01" <?php echo $required;?> style="<?php if($w == 'u') { echo 'display:none';} ?>">
                                            <option value="">역할을 선택해주세요.</option>
                                            <option <?php echo get_selected($member['mb_3'], "EL");?> value="EL">EL</option>
                                            <option <?php echo get_selected($member['mb_3'], "EM");?> value="EM">EM</option>
                                        </select>
                                </p>
                            </li>
                        <?php } else { ?>

                            <li>
                                <p class="t">소속<span class="im"></span></p>
                                <p class="ipt">
                                    <input type="text" name="mb_5" value="<?php echo get_text($member['mb_5']) ?>" id="mb_5" <?php echo $required;?> class="iptSt01" placeholder="소속회사명" />
                                </p>
                            </li>
                            <li>
                                <p class="t">직위<span class="im"></span></p>
                                <p class="ipt">
                                    <input type="text" name="mb_6" value="<?php echo get_text($member['mb_6']) ?>" id="mb_6" <?php echo $required;?> class="iptSt01" placeholder="직위" />
                                </p>
                            </li>
                        <?php } ?>




                </ul>
            </div>
        </div>

	    <div class="tbl_frm01 tbl_wrap register_form_inner" style="display:none" >
	        <h2>기타 개인설정</h2>
	        <ul>
	            <?php if ($config['cf_use_signature']) {  ?>
	            <li>
	                <label for="reg_mb_signature">서명<?php if ($config['cf_req_signature']){ ?> <span class="im"></span><?php } ?></label>
	                <textarea name="mb_signature" id="reg_mb_signature" <?php echo $config['cf_req_signature']?"required":""; ?> class="<?php echo $config['cf_req_signature']?"required":""; ?>"   placeholder="서명"><?php echo $member['mb_signature'] ?></textarea>
	            </li>
	            <?php }  ?>

	            <?php if ($config['cf_use_profile']) {  ?>
	            <li>
	                <label for="reg_mb_profile">자기소개</label>
	                <textarea name="mb_profile" id="reg_mb_profile" <?php echo $config['cf_req_profile']?"required":""; ?> class="<?php echo $config['cf_req_profile']?"required":""; ?>" placeholder="자기소개"><?php echo $member['mb_profile'] ?></textarea>
	            </li>
	            <?php }  ?>

	            <?php if ($config['cf_use_member_icon'] && $member['mb_level'] >= $config['cf_icon_level']) {  ?>
	            <li>
	                <label for="reg_mb_icon" class="frm_label">
	                	회원아이콘
	                	<button type="button" class="tooltip_icon"><i class="fa fa-question-circle-o" aria-hidden="true"></i><span class="sound_only">설명보기</span></button>
	                	<span class="tooltip">이미지 크기는 가로 <?php echo $config['cf_member_icon_width'] ?>픽셀, 세로 <?php echo $config['cf_member_icon_height'] ?>픽셀 이하로 해주세요.<br>gif, jpg, png파일만 가능하며 용량 <?php echo number_format($config['cf_member_icon_size']) ?>바이트 이하만 등록됩니다.</span>
	                </label>
	                <input type="file" name="mb_icon" id="reg_mb_icon">

	                <?php if ($w == 'u' && file_exists($mb_icon_path)) {  ?>
	                <img src="<?php echo $mb_icon_url ?>" alt="회원아이콘">
	                <input type="checkbox" name="del_mb_icon" value="1" id="del_mb_icon">
	                <label for="del_mb_icon" class="inline">삭제</label>
	                <?php }  ?>

	            </li>
	            <?php }  ?>

	            <?php if ($member['mb_level'] >= $config['cf_icon_level'] && $config['cf_member_img_size'] && $config['cf_member_img_width'] && $config['cf_member_img_height']) {  ?>
	            <li class="reg_mb_img_file">
	                <label for="reg_mb_img" class="frm_label">
	                	회원이미지
	                	<button type="button" class="tooltip_icon"><i class="fa fa-question-circle-o" aria-hidden="true"></i><span class="sound_only">설명보기</span></button>
	                	<span class="tooltip">이미지 크기는 가로 <?php echo $config['cf_member_img_width'] ?>픽셀, 세로 <?php echo $config['cf_member_img_height'] ?>픽셀 이하로 해주세요.<br>
	                    gif, jpg, png파일만 가능하며 용량 <?php echo number_format($config['cf_member_img_size']) ?>바이트 이하만 등록됩니다.</span>
	                </label>
	                <input type="file" name="mb_img" id="reg_mb_img">

	                <?php if ($w == 'u' && file_exists($mb_img_path)) {  ?>
	                <img src="<?php echo $mb_img_url ?>" alt="회원이미지">
	                <input type="checkbox" name="del_mb_img" value="1" id="del_mb_img">
	                <label for="del_mb_img" class="inline">삭제</label>
	                <?php }  ?>

	            </li>
	            <?php } ?>

	            <li class="chk_box">
		        	<input type="checkbox" name="mb_mailling" value="1" id="reg_mb_mailling" <?php echo ($w=='' || $member['mb_mailling'])?'checked':''; ?> class="selec_chk">
		            <label for="reg_mb_mailling">
		            	<span></span>
		            	<b class="sound_only">메일링서비스</b>
		            </label>
		            <span class="chk_li">정보 메일을 받겠습니다.</span>
		        </li>

				<?php if ($config['cf_use_hp']) { ?>
		        <li class="chk_box">
		            <input type="checkbox" name="mb_sms" value="1" id="reg_mb_sms" <?php echo ($w=='' || $member['mb_sms'])?'checked':''; ?> class="selec_chk">
		        	<label for="reg_mb_sms">
		            	<span></span>
		            	<b class="sound_only">SMS 수신여부</b>
		            </label>
		            <span class="chk_li">휴대폰 문자메세지를 받겠습니다.</span>
		        </li>
		        <?php } ?>

		        <?php if (isset($member['mb_open_date']) && $member['mb_open_date'] <= date("Y-m-d", G5_SERVER_TIME - ($config['cf_open_modify'] * 86400)) || empty($member['mb_open_date'])) { // 정보공개 수정일이 지났다면 수정가능 ?>
		        <li class="chk_box">
		            <input type="checkbox" name="mb_open" value="1" id="reg_mb_open" <?php echo ($w=='' || $member['mb_open'])?'checked':''; ?> class="selec_chk">
		      		<label for="reg_mb_open">
		      			<span></span>
		      			<b class="sound_only">정보공개</b>
		      		</label>
		            <span class="chk_li">다른분들이 나의 정보를 볼 수 있도록 합니다.</span>
		            <button type="button" class="tooltip_icon"><i class="fa fa-question-circle-o" aria-hidden="true"></i><span class="sound_only">설명보기</span></button>
		            <span class="tooltip">
		                정보공개를 바꾸시면 앞으로 <?php echo (int)$config['cf_open_modify'] ?>일 이내에는 변경이 안됩니다.
		            </span>
		            <input type="hidden" name="mb_open_default" value="<?php echo $member['mb_open'] ?>">
		        </li>
		        <?php } else { ?>
	            <li>
	                정보공개
	                <input type="hidden" name="mb_open" value="<?php echo $member['mb_open'] ?>">
	                <button type="button" class="tooltip_icon"><i class="fa fa-question-circle-o" aria-hidden="true"></i><span class="sound_only">설명보기</span></button>
	                <span class="tooltip">
	                    정보공개는 수정후 <?php echo (int)$config['cf_open_modify'] ?>일 이내, <?php echo date("Y년 m월 j일", isset($member['mb_open_date']) ? strtotime("{$member['mb_open_date']} 00:00:00")+$config['cf_open_modify']*86400:G5_SERVER_TIME+$config['cf_open_modify']*86400); ?> 까지는 변경이 안됩니다.<br>
	                    이렇게 하는 이유는 잦은 정보공개 수정으로 인하여 쪽지를 보낸 후 받지 않는 경우를 막기 위해서 입니다.
	                </span>

	            </li>
	            <?php }  ?>

	            <?php
	            //회원정보 수정인 경우 소셜 계정 출력
	            if( $w == 'u' && function_exists('social_member_provider_manage') ){
	                social_member_provider_manage();
	            }
	            ?>

	            <?php if ($w == "" && $config['cf_use_recommend']) {  ?>
	            <li>
	                <label for="reg_mb_recommend" class="sound_only">추천인아이디</label>
	                <input type="text" name="mb_recommend" id="reg_mb_recommend" class="frm_input" placeholder="추천인아이디">
	            </li>
	            <?php }  ?>

	            <li class="is_captcha_use">
	                자동등록방지
	                <?php //echo captcha_html(); ?>
	            </li>
	        </ul>
	    </div>


        <?php  { ?>
            <div class="regi_box">
                <div class="tit line">약관 및 개인정보처리방침</div>
                <div class="con">

                    <ul class="regi_agree_list">
                        <li class="agree_all">
                            <div class="t">
                                <div class="chkBox allchkBox">
                                    <label for="chk_all">
                                        <div class="chkCont">
                                            <input type="checkbox" name="chk_all" id="chk_all" class="chkInp" />
                                            <span class="chkBtn"></span>
                                        </div>
                                        모든 약관에 동의합니다.
                                    </label>
                                </div>
                            </div>
                        </li>

                        <li class="on">
                            <div class="t">
                                <div class="chkBox">
                                    <label for="agree11">
                                        <div class="chkCont">
                                            <input type="checkbox" name="agree" value="1"  id="agree11" class="chkInp"  <?php if($w == 'u') {echo "checked";} ?> />
                                            <span class="chkBtn"></span>
                                        </div>
                                        이용약관 동의(필수)
                                    </label>
                                </div>

                                <div class="conBox">내용보기<span></span></div>
                            </div>
                            <div class="c">
                                <div class="in"><?php echo ($config['cf_stipulation']) ?></div>
                            </div>
                        </li>

                        <li class="">
                            <div class="t">
                                <div class="chkBox">
                                    <label for="agree21">
                                        <div class="chkCont">
                                            <input type="checkbox" name="agree2" id="agree21" value="1"  class="chkInp" <?php if($w == 'u') {echo "checked";} ?> />
                                            <span class="chkBtn"></span>
                                        </div>
                                        회원가입을 위한 개인정보 수집 · 이용 동의 (필수)
                                    </label>
                                </div>

                                <div class="conBox">내용보기<span></span></div>
                            </div>
                            <div class="c">
                                <div class="in"><?php echo ($config['cf_privacy']) ?></div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        <?php } ?>


	</div>
	<div class="btn_confirm_wrap"><!-- btn_confirm-->
	    <a href="<?php echo G5_URL ?>" class="btn_close">취소</a>
	    <button type="submit" id="btn_submit" class="btn_submit" accesskey="s"><?php echo $w==''?'회원가입':'정보수정'; ?></button>
	</div>
	</form>
</div>
<script>
$(function() {

    $("#sub_nav").css({"display":"block"});
    $("#sub_nav .dep1").text("멤버쉽");
    $("#sub_nav .dep2").text("회원가입");
    $("#sub_title").css({"display":"none"});

    $(".regi_agree_list .conBox").on("click", function () {
        $(this).closest("li").toggleClass("on")
    });


    $("input[name=chk_all]").click(function() {
        if ($(this).prop('checked')) {
            $("input[name^=agree]").prop('checked', true);
        } else {
            $("input[name^=agree]").prop("checked", false);
        }
    });

    $("input[name^=agree]").click(function () {
        if($("input[name^=agree]").prop('checked') && $("input[name=chk_all]").prop('checked')){
            $("input[name=chk_all]").prop("checked", false);
        }
    });


    $("#reg_zip_find").css("display", "inline-block");


    <?php if($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
    // 아이핀인증
    $("#win_ipin_cert").click(function() {
        if(!cert_confirm())
            return false;

        var url = "<?php echo G5_OKNAME_URL; ?>/ipin1.php";
        certify_win_open('kcb-ipin', url);
        return;
    });

    <?php } ?>
    <?php if($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
    // 휴대폰인증
    $("#win_hp_cert").click(function() {
        if(!cert_confirm())
            return false;

        <?php
        switch($config['cf_cert_hp']) {
            case 'kcb':
                $cert_url = G5_OKNAME_URL.'/hpcert1.php';
                $cert_type = 'kcb-hp';
                break;
            case 'kcp':
                $cert_url = G5_KCPCERT_URL.'/kcpcert_form.php';
                $cert_type = 'kcp-hp';
                break;
            case 'lg':
                $cert_url = G5_LGXPAY_URL.'/AuthOnlyReq.php';
                $cert_type = 'lg-hp';
                break;
            default:
                echo 'alert("기본환경설정에서 휴대폰 본인확인 설정을 해주십시오");';
                echo 'return false;';
                break;
        }
        ?>

        certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>");
        return;
    });
    <?php } ?>
});

// submit 최종 폼체크
function fregisterform_submit(f)
{


    // 회원아이디 검사
    if (f.w.value == "") {
        var msg = reg_mb_id_check();
        if (msg) {
            alert(msg);
            f.mb_id.select();
            return false;
        }
    }

    if (f.w.value == "") {
        if (f.mb_password.value.length < 3) {
            alert("비밀번호를 3글자 이상 입력하십시오.");
            f.mb_password.focus();
            return false;
        }
    }

    if (f.mb_password.value != f.mb_password_re.value) {
        alert("비밀번호가 같지 않습니다.");
        f.mb_password_re.focus();
        return false;
    }

    if (f.mb_password.value.length > 0) {
        if (f.mb_password_re.value.length < 3) {
            alert("비밀번호를 3글자 이상 입력하십시오.");
            f.mb_password_re.focus();
            return false;
        }
    }

    // 이름 검사
    if (f.w.value=="") {
        if (f.mb_name.value.length < 1) {
            alert("이름을 입력하십시오.");
            f.mb_name.focus();
            return false;
        }

        /*
        var pattern = /([^가-힣\x20])/i;
        if (pattern.test(f.mb_name.value)) {
            alert("이름은 한글로 입력하십시오.");
            f.mb_name.select();
            return false;
        }
        */
    }

    if(!$("#mb_birth").val()) {
        alert("생년월일을 확인해주세요.");
        return false;
    }


    if(!$("#mb_sex option:selected").val()) {
        alert("성별을 확인해주세요.");
        return false;
    }

    <?php if($memLevel == "student") { ?>
        if(!$("#mb_1 option:selected").val()) {
            alert("혁신단을 선택해주세요.");
            return false;
        }

        if(!$("#mb_2 option:selected").val()) {
            alert("팀을 선택해주세요.");
            return false;
        }

        if(!$("#mb_3 option:selected").val()) {
            alert("역할을 선택해주세요.");
            return false;
        }

    <?php }?>


    if(!$("input:checkbox[name='agree']:checked").val()){
        alert("이용약관에 동의하지 않으신다면 홈페이지 이용에 어려움이 있을 수 있습니다.");
        return false;
    }
    if(!$("input:checkbox[name='agree2']:checked").val()){
        alert("개인정보 수집 및 이용에 동의하지 않으신다면 홈페이지 이용에 어려움이 있을 수 있습니다.");
        return false;
    }


//     <?php if($memLevel == "student") { ?>
//         let mName = $("#reg_mb_name").val();
//         let mEmail = $("#reg_mb_id").val();
//         let mMb1 = $("#mb_1 option:selected").text();
//         let mMb2 = $("#mb_2 option:selected").text();
//         let mMb3 = $("#mb_3 option:selected").text();
//         if(confirm(`${mName}님, 아래 정보가 맞으십니까?
// - 이메일 : ${mEmail}
// - 혁신단명 : ${mMb1}
// - 팀명 : ${mMb2}
// - 역할 : ${mMb3}`)){
//             alert("회원가입이 완료되었습니다.\n메일인증 후 관리자승인 완료되면 홈페이지 이용가능합니다.")
//         }else{
//             alert("회원정보를 확인해주세요.")
//             return false;
//         }

//     <?php } else if($memLevel == "instructor") {  ?>
//         let mName = $("#reg_mb_name").val();
//         let mEmail = $("#reg_mb_id").val();
//         let mMb1 = $("#mb_4").val();
//         let mMb2 = $("#mb_5").val();
//         let mMb3 = $("#mb_6").val();
//         if(confirm(`${mName}님, 아래 정보가 맞으십니까?
// - 이메일 : ${mEmail}
// - 최종학력 : ${mMb1}
// - 소속 : ${mMb2}
// - 직위 : ${mMb3}`)){
//             alert("회원가입이 완료되었습니다.\n메일인증 후 관리자승인 완료되면 홈페이지 이용가능합니다.")
//         }else{
//             alert("회원정보를 확인해주세요.")
//             return false;
//         }

//     <?php } ?>


    // if (!f.agree.checked) {
    //     alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
    //     f.agree.focus();
    //     return false;
    // }

    // if (!f.agree2.checked) {
    //     alert("개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
    //     f.agree2.focus();
    //     return false;
    // }



    <?php if($w == '' && $config['cf_cert_use'] && $config['cf_cert_req']) { ?>
    // 본인확인 체크
    if(f.cert_no.value=="") {
        alert("회원가입을 위해서는 본인확인을 해주셔야 합니다.");
        return false;
    }
    <?php } ?>

    // 닉네임 검사
    if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
        var msg = reg_mb_nick_check();
        if (msg) {
            alert(msg);
            f.reg_mb_nick.select();
            return false;
        }
    }
	/*
    // E-mail 검사
    if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
        var msg = reg_mb_email_check();
        if (msg) {
            alert(msg);
            f.reg_mb_email.select();
            return false;
        }
    }*/

    <?php if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) {  ?>
    // 휴대폰번호 체크
    var msg = reg_mb_hp_check();
    if (msg) {
        alert(msg);
        f.reg_mb_hp.select();
        return false;
    }
    <?php } ?>

    if (typeof f.mb_icon != "undefined") {
        if (f.mb_icon.value) {
            if (!f.mb_icon.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
                alert("회원아이콘이 이미지 파일이 아닙니다.");
                f.mb_icon.focus();
                return false;
            }
        }
    }

    if (typeof f.mb_img != "undefined") {
        if (f.mb_img.value) {
            if (!f.mb_img.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
                alert("회원이미지가 이미지 파일이 아닙니다.");
                f.mb_img.focus();
                return false;
            }
        }
    }

    if (typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
        if (f.mb_id.value == f.mb_recommend.value) {
            alert("본인을 추천할 수 없습니다.");
            f.mb_recommend.focus();
            return false;
        }

        var msg = reg_mb_recommend_check();
        if (msg) {
            alert(msg);
            f.mb_recommend.select();
            return false;
        }
    }


    <?php echo chk_captcha_js();  ?>

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}

jQuery(function($){
	//tooltip
    $(document).on("click", ".tooltip_icon", function(e){
        $(this).next(".tooltip").fadeIn(400).css("display","inline-block");
    }).on("mouseout", ".tooltip_icon", function(e){
        $(this).next(".tooltip").fadeOut();
    });
});

function getTeamInfo($val){
	$.ajax({
			url:"/bbs/ajax.team.php",
			type:"get",
			data:{"og_id":$val},
			success:function(res){
				$("#mb_2").html(res);
			}
	  });
}

</script>

<!-- } 회원정보 입력/수정 끝 -->
