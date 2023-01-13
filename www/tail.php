<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/tail.php');
    return;
}

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/tail.php');
    return;
}
?>


        </div><!-- #subPage_Continer.inner -->
    </div>  <!-- #sub_Container -->
</div><!-- #wrapper -->
<!-- } 콘텐츠 끝 -->


<div id="footerContainer">
    <div class="ft_tp_inner">
        <div class="inner">
            <a href="<?php echo G5_BBS_URL ?>/content.php?co_id=provision">이용약관</a><span class="bar"></span>
            <a href="<?php echo G5_BBS_URL ?>/content.php?co_id=privacy" class="orange">개인정보처리방침</a><span class="bar mo"></span>
            <a href="<?php echo G5_BBS_URL ?>/content.php?co_id=email">이메일무단수집거부</a>
            <!-- <span class="bar"></span> <a href="javascript:void(0)">사이트맵</a> -->
        </div>
    </div>

    <div class="ft_bt_inner">
        <div class="inner">

            <div class="box box1">
                <div class="t">실험실창업탐색교육</div>
                <div class="c">(06595) 서울 서초구 서초대로45길 16, 202호 <br class="mo" />(서초동,  브이알빌딩)</div>
                <div class="s">
                    <!-- <b>전화 : </b><span class="ss">(02) 2156-2280</span><span class="bar"></span><b>팩스 : </b><span class="ss">(02) 2156-2290</span> -->
                    <b>문의 : </b><span class="ss">icorps.team@gmail.com</span>
                </div>
                <div class="r">COPYRIGHT © 2022 실험실창업탐색교육. <br class="mo" />ALL RIGHTS RESERVED.</div>
            </div>
            <div class="box box2"><img src="<?php echo G5_URL?>/common/images/sub/busi1_logo4.png" /></div>
        </div>
    </div>
</div>

<div id="sns_Container">
    <!--
        <div class="ic_kakao"><a href="#" class="ico"><img src="<?php echo G5_URL?>/common/images/common/icon_kakao.png" /></a></div>
        <div class="ic_sns">
            <p class="ic_k face"><a href="#" class="ico"><img src="<?php echo G5_URL?>/common/images/common/icon_facebook.png" /></a></p>
            <p class="ic_k inst"><a href="#" class="ico"><img src="<?php echo G5_URL?>/common/images/common/icon_instagram.png" /></a></p>
            <p class="ic_k blog"><a href="#" class="ico"><img src="<?php echo G5_URL?>/common/images/common/icon_naver.png" /></a></p>
        </div>
        <div id="icon_top" class="ic_top ico"><img src="<?php echo G5_URL?>/common/images/common/icon_top.png" /></div>
    -->

    <div class="ic_arr">
        <div id="icon_top" class="ic_top ico"><img src="<?php echo G5_URL?>/common/images/common/icon_top.png" /></div>
        <div id="icon_bt" class="ic_bt ico"><img src="<?php echo G5_URL?>/common/images/common/icon_top.png" /></div>
    </div>
</div>

<script>
$(function() {
    $("#icon_top").on("click", function() {
        $("html, body").animate({scrollTop:0}, '500');
        return false;
    });
    $("#icon_bt").on("click", function() {
        $("html, body").animate({scrollTop: $(document).height()-$(window).height()}, '500');
        return false;
    });
});
</script>


<?php
if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { ?>
<?php
}

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<!-- } 하단 끝 -->

<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>

<?php
include_once(G5_PATH."/tail.sub.php");
