<?php
include_once('./_common.php');

define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/index.php');
    return;
}

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/index.php');
    return;
}

include_once(G5_PATH.'/head.php');
?>

<!-- 메인비쥬얼 -->
<div id="main_Visual" style="background-image:url('<?php echo G5_URL ?>/common/images/main/banner_01.png')">

    <div id="" class="main_vs_goBcb">
        <a class="close" href="javascript:popClose('main_vs_goBcb');"></a>
        <div class="in">
            <a href="javascript:GoPage('bcb')">
                <p class="t1">KOEF BCB <br/>System</p>
                <p class="t2">보러가기</p>
            </a>
            <div class="in_bg"></div>
        </div>
    </div>

    <div class="main_vs_inner inner">
        <div class="s"><span class="s1">한국형 아이코어</span></div>
        <div class="t">실험실창업탐색교육</div>
        <div class="c">"과학기술 창업, 혁신의 물결을 일으키다."</div>
    </div>

    <div class="main_vs_notice">
        <div class="main_nt_inner inner">
            <?php echo latest('notice_swipe', 'comm1', 10, 100); ?>
        </div>
    </div>

</div>
<!-- //메인비쥬얼 -->


<style>
    
</style>
<!-- 사전교육영상 -->
<div id="main_Video">
    <div class="main_vd_inner inner">
        <div class="vd_title">
            <div class="tit">실험실창업탐색교육<br/><span>교육영상</span></div>
            <div class="bar"></div>
            <div class="sub">실험실창업탐색교육 교육영상</div>
            <div class="link"><a href="javascript:GoPage('participate2')">교육영상 전체보기</a></div>
            <div class="arrow">
                <div class="mn-vd-pagination"></div>
                <div class="mn-vd-arr mn-vd-prev" style="background-image:url(<?php echo G5_URL?>/common/images/main/icon_prev.png)"></div>
                <div class="mn-vd-arr mn-vd-next" style="background-image:url(<?php echo G5_URL?>/common/images/main/icon_next.png)"></div>
            </div>
        </div>

        <div class="vd_slide">
            <?php echo latest('video_slide', 'participate2', 20, 100); ?>
        </div>
    </div>
</div>
<!-- //사전교육영상 -->


<!-- 인스트럭터 -->
<div id="main_poeple" class="main_people_inner inner">
    <div class="main_pp_inner pp_box" style="background-image:url(<?php echo G5_URL ?>/common/images/main/main_pp_img1_2.png)">
        <div class="textBox">
            <div class="tt">실험실 창업탐색<br />국내교육</div>
            <div class="cc fw6">실험실창업탐색교육 <Br class="mo"/>교육 프로그램을 소개합니다.</div>
            <div class="link"><a href="javascript:GoPage('program1')">자세히보기</a></div>
        </div>
    </div>

    <div class="main_cc_inner pp_box" style="background-image:url(<?php echo G5_URL ?>/common/images/main/main_pp_img3.png)">
        <div class="textBox">
            <div class="ss"><b>실험실 창업 탐색팀</b> <br/>과제제출</div>
            <div class="link link2"><a href="javascript:GoPage('participate4')">과제제출 하러가기</a></div>
        </div>
    </div>
</div>
<!-- //인스트럭터 -->


<!-- 소개영상 -->
<div id="main_intro" style="background-image:url(<?php echo G5_URL ?>/common/images/main/main_intro_bg.png)">
    <div class="main_intro_inner inner">
        <div class="text">
            <div class="tt">LAB START - UP<br/>2022 소개영상 </div>
            <div class="bar"></div>
            <div class="cc">랩스타트업2022 소개영상</div>
        </div>

        <div class="mv">
            <div class="in">
                <video autoplay="" loop="" muted="" controls="true" style="width:100%; height:100%; object-fit:cover; position:absolute; top:0; left:0;" src="https://player.vimeo.com/progressive_redirect/playback/719040498/rendition/1080p/file.mp4?loc=external&signature=b72d9120ed95e93cbd7ba51468a6cb564916ac10e608140736f0195927a0f2ae" >
            </div>
            <!-- <div class="in" style="background-image:url(<?php echo G5_URL?>/common/images/main/main_intro_img1.png)"></div> -->
        </div>
    </div>
</div>
<!-- //소개영상 -->


<!-- 투데이 -->
<div id="main_today" class="main_today_inner inner">
    <div class="main_td_inner">
        <div class="img"><img src="<?php echo G5_URL?>/common/images/main/main_today_img1.png" /></div>
        <div class="text">
            <div class="txt">“가장 창의적인 공간에서 <br class="mo" />가장 혁신적인 방법으로 미래를 바꾸다”</div>
            <div class="count">
                <?php echo visit('main_visit'); // 접속자집계 ?>
            </div>
        </div>
    </div>
</div>
<!-- //투데이 -->


<!-- 참여대학교 -->
<div id="main_college" class="main_college_inner inner">

    <div class="mn_cg_tit">실험실<Br/>창업혁신단</div>
    <div class="mn_cg_btn">
        <div class="mn-cc-arr mn-cc-prev" style="background-image:url(<?php echo G5_URL?>/common/images/main/icon_cc_prev.png)"></div>
        <div class="mn-cc-arr mn-cc-next" style="background-image:url(<?php echo G5_URL?>/common/images/main/icon_cc_next.png)"></div>
        <div class="mn-cc-arr mn-cc-stop" style="background-image:url(<?php echo G5_URL?>/common/images/main/icon_stop.png)"></div>
    </div>
    <div class="mn_cg_slide">

        <div class="swiper CollegeSwiperSlide">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/main/mn_logo1.png" /></div>
                <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/main/mn_logo2.png" /></div>
                <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/main/mn_logo3.png" /></div>
                <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/main/mn_logo4.png" /></div>
                <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/main/mn_logo5.png" /></div>
                <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/main/mn_logo6.png" /></div>
                <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/main/mn_logo7.png" /></div>

                <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/main/mn_logo1.png" /></div>
                <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/main/mn_logo2.png" /></div>
                <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/main/mn_logo3.png" /></div>
                <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/main/mn_logo4.png" /></div>
                <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/main/mn_logo5.png" /></div>
                <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/main/mn_logo6.png" /></div>
                <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/main/mn_logo7.png" /></div>

                <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/main/mn_logo1.png" /></div>
                <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/main/mn_logo2.png" /></div>
                <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/main/mn_logo3.png" /></div>
                <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/main/mn_logo4.png" /></div>
                <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/main/mn_logo5.png" /></div>
                <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/main/mn_logo6.png" /></div>
                <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/main/mn_logo7.png" /></div>
            </div>
        </div>

    </div>
</div>

<script>
    var CollegeSwiper = new Swiper(".CollegeSwiperSlide", {
        spaceBetween: 10,
        slidesPerView: 2,
        breakpoints: {
            420: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 5,
                spaceBetween: 20,
            },
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".mn-cc-next",
            prevEl: ".mn-cc-prev",
        },
    });
</script>
<script>
    $(document).ready(function () {
        const CollegeSwiper = document.querySelector('.CollegeSwiperSlide').swiper;

        $(".mn-cc-stop").click(function () {
            if($(this).hasClass("play")){
                $(this).removeClass("play");
                CollegeSwiper.autoplay.start();
                $(".mn-cc-stop").css("background-image", "url(<?php echo G5_URL?>/common/images/main/icon_stop.png)")
            }else {
                $(this).addClass("play");
                CollegeSwiper.autoplay.stop();
                $(".mn-cc-stop").css("background-image", "url(<?php echo G5_URL?>/common/images/main/icon_cc_play.png)")
            }
        });
    });
</script>
<!-- //참여대학교 -->

<?php
include_once(G5_PATH.'/tail.php');