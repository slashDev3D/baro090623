<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

run_event('pre_head');

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/head.php');
    return;
}

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/head.php');
    return;
}

include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_PATH.'/common/inc/menu_link.php');
?>


<?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
    }
?>


<div id="headerContainer" class="<?php if (!defined("_INDEX_")) { ?> hd_black<?php }else {?> hd_white <?php } ?>">
    <div class="hd_wrap inner">
        <div class="hd_box hd_logo"><a href="<?php echo G5_URL ?>">실험실창업탐색교육</a></div>

        <ul class="hd_box hd_menu">
            <li><a href="javascript:GoPage('business1')">사업소개</a></li>
            <li><a href="javascript:GoPage('program1')">교육프로그램</a></li>
            <!-- <li><a href="javascript:GoPage('video1')">교육신청</a></li> -->
            <li><a href="javascript:GoPage('participate1')">교육참여</a></li>
            <li class="hd_menu_last"><a href="javascript:GoPage('comm1')">공지사항</a></li>
        </ul>

        <div class="hd_member">
            <?php if ($is_member) {  ?>
                <a href="javascript:void(0)">
                    <?php echo $member[mb_name] ?>님

                    <?php
                        $sql = "select * from g5_organize";
                        $res = sql_query($sql);
                        for ($q=0; $dd=sql_fetch_array($res); $q++) {
                          if($member['mb_1'] == $dd['og_id']){
                            echo "(".$dd['og_name'];
                          }
                        }
                    ?>

                    <?php
                        $sql = "select * from g5_organize_team where og_id = {$member['mb_1']}";
                        $res = sql_query($sql);
                        for ($q=0; $dd=sql_fetch_array($res); $q++) {
                          if($member['mb_2'] == $dd['ogt_id']){
                            echo "/ ".$dd['ogt_name'].")";
                          }
                        }
                    ?>
                </a>
                <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php">정보수정</a>
                <a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a>
                <?php if ($member['mb_level'] == 10) {  ?>
                    <a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>" target="_blank">관리자</a>
                <?php }  ?>
                <?php if ($member['mb_level'] == 3 ) { ?>
                    <a href="javascript:GoPage('instrViewAdm')" class="fw9" >내 혁신단 관리하기</a>
                <?php }  ?>
            <?php } else {  ?>
                <a href="<?php echo G5_BBS_URL ?>/login.php">로그인</a>
                <!-- <a href="<?php echo G5_BBS_URL ?>/register.php">회원가입</a> -->
            <?php }  ?>
        </div>

        <div class="hd_mo_menu">
            <span></span>
        </div>
    </div>
</div>


<div id="GnbContainer" class="">
    <div class="hd_member">
        <?php if ($is_member) {  ?>

            <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php">정보수정</a>
            <a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a>
            <?php if ($is_admin) {  ?>
                <a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>" target="_blank">관리자</a>
            <?php }  ?>
        <?php } else {  ?>
            <a href="<?php echo G5_BBS_URL ?>/login.php">로그인</a>
            <!-- <a href="<?php echo G5_BBS_URL ?>/register.php">회원가입</a> -->
        <?php }  ?>
    </div>

    <div class="inner gnb_inner">
        <!-- gnb_menu -->
        <ul class="gnb_menu_box">
            <li class="gnb_dep1">
                <span class="dep1_tit">사업소개</span>
                <ul class="gnb_dep2">
                    <li class="submenu1"><a class="smenu1 business1" href="javascript:GoPage('business1')">사업소개</a></li>
                    <li class="submenu2"><a class="smenu2 business2" href="javascript:GoPage('business2')">실험실창업탐색팀</a></li>
                    <li class="submenu3"><a class="smenu3 business3" href="javascript:GoPage('business3')">우수성과 소개</a></li>
                    <li class="submenu6"><a class="smenu6 business4" href="javascript:GoPage('business4')">인스트럭터 소개</a></li>
                    <li class="submenu4"><a class="smenu4 business5" href="javascript:GoPage('business5')">홍보 동영상</a></li>
                    <li class="submenu5"><a class="smenu5 business6" href="javascript:GoPage('business6')">재단소개</a></li>
                </ul>
            </li>

            <li class="gnb_dep1">
                <span class="dep1_tit">교육프로그램</span>
                <ul class="gnb_dep2">
                    <li class="submenu1"><a class="smenu1 program1" href="javascript:GoPage('program1')">교육과정 소개</a></li>
                    <li class="submenu2"><a class="smenu2 application2" href="javascript:GoPage('application2')">교육과정 갤러리</a></li>
                </ul>
            </li>


            <!-- <li class="gnb_dep1">
                <span class="dep1_tit">교육신청</span>
                <ul class="gnb_dep2">
                    <li class="submenu1"><a class="smenu1 application1" href="javascript:GoPage('application1')">교육신청</a></li>
                </ul>
            </li> -->

            <li class="gnb_dep1">
                <span class="dep1_tit">교육참여</span>
                <ul class="gnb_dep2">
                    <li class="submenu1"><a class="smenu1 participate1" href="javascript:GoPage('participate1')">커리큘럼</a></li>
                    <li class="submenu2"><a class="smenu2 participate2" href="javascript:GoPage('participate2')">영상교육</a></li>
                    <li class="submenu2"><a class="smenu2 participate3" href="javascript:GoPage('participate3')">실시간강의</a></li>
                    <li class="submenu2"><a class="smenu2 participate4" href="javascript:GoPage('participate4')">과제업로드</a></li>
                </ul>
            </li>

            <li class="gnb_dep1">
                <span class="dep1_tit">공지사항</span>
                <ul class="gnb_dep2">
                    <li class="submenu1"><a class="smenu1 comm1" href="javascript:GoPage('comm1')">공지사항</a></li>
                    <li class="submenu3"><a class="smenu3 comm2" href="javascript:GoPage('comm2')">탐색팀과의 소통방</a></li>
                    <li class="submenu4"><a class="smenu4 comm3" href="javascript:GoPage('comm3')">인스트럭터 소통방</a></li>
                </ul>
            </li>

            <li class="gnb_dep1 none">
                <span class="dep1_tit">멤버쉽</span>
                <ul class="gnb_dep2">
                    <li></li>
                    <li class="submenu1"><a class="smenu1 login" href="javascript:GoPage('login')">로그인</a></li>
                    <!-- <li class="submenu3"><a class="smenu3 register" href="javascript:GoPage('register')">회원가입</a></li> -->
                </ul>
            </li>
        </ul>
        <!-- //gnb_menu -->

        <!-- gnb_banner -->
        <div class="gnb_banner_box">
            <div class="gnb_banner_tit">
                <div class="t">BCB System</div>
                <div class="c"><a href="javascript:GoPage('bcb')">사이트바로가기 <span class="icon-gnb_icon_link"></span></a></div>
            </div>
            <div class="gnb_banner_img"><a href="javascript:GoPage('bcb')"><img src="<?php echo G5_URL ?>/common/images/common/gnb_img1.png" /></a></div>
        </div>
        <!-- //gnb_banner -->

    </div>
</div>


<script>
    //scrolltop
	var jbOffset = $( '#headerContainer' ).offset();
	$( window ).scroll( function() {
		if ( $( document ).scrollTop() > (jbOffset.top+80) ) {
			$( '#headerContainer' ).addClass( 'hd_fix' );
			}
		else {
			$( '#headerContainer' ).removeClass( 'hd_fix' );
		}
	});
</script>




<?php
    $nowFileName = basename($_SERVER['PHP_SELF']);
    $without_extension = substr($nowFileName, 0, strrpos($nowFileName, ".")) == "board" ? $bo_table : substr($nowFileName, 0, strrpos($nowFileName, "."));
    $subMenuView = false;   // 현재 페이지 파일명 추출

?>
<script>
    $(document).ready(function(){
        let nowLoc = $("#GnbContainer .gnb_dep2 .<?php echo $without_extension?>");
        let sub_dep1 = nowLoc.closest('.gnb_dep1').find(".dep1_tit").text();
        let sub_dep2 = nowLoc.text();

        let sub_dep2_menu = nowLoc.closest('.gnb_dep2').html();

        if(sub_dep2 != ""){
            $("#sub_title span").text(sub_dep2);

            $("#sub_nav .dep1").text(sub_dep1);
            $("#sub_nav .dep2").text(sub_dep2);

            $("#sub_menu .sub_menu_tit").text(sub_dep2)
            $("#sub_menu .sub_menu_con").html(sub_dep2_menu)
            $("#sub_menu").addClass("sub_<?php echo $without_extension?>");
            $("#sub_menu .<?php echo $without_extension?>").addClass("on")
            $("#sub_container").addClass("<?php echo $without_extension?>");
        }else {
            $("#sub_nav , #sub_menu").hide();
        }

        if(sub_dep2 == "재단소개") {
            $("#headerContainer").attr("class","");
            $("#headerContainer").addClass("transferHd");
        }
    });
</script>


<!-- 콘텐츠 시작 { -->
<div id="wrapper">
    <?php if (!defined("_INDEX_")) { ?>
        <div id="sub_container" class="">

            <div id="sub_nav" class="inner">
                <span class="icon-icon_home"></span>
                <span class="dep1"></span>
                <span class="dep2"></span>
            </div>

            <div id="sub_title">
                <span title="<?php echo get_head_title($g5['title']); ?>"><?php echo get_head_title($g5['title']); ?></span>
                <?php if($bo_table == "business4") { echo "<div class='d'>우리 멘토단은 여러분과 풍부한 지식과 경험을 <Br>나눌 준비가 되어 있습니다.</div>"; } ?>
            </div>


            <div id="sub_menu" class="inner" style="<?php echo $bo_table ? 'margin-bottom:60px' :  ''; ?>">
                <div class="sub_menu_tit"></div>
                <ul class="sub_menu_con"></ul>
            </div>


            <div id="subPage_Container" class="inner">
    <?php } ?>
