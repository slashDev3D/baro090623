<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<style>
    .lastest_notice_wrap {width:100%; height:60px; display:flex; align-items:center; flex:none;}
    .lastest_notice_wrap .tit {flex:0 0 88px; text-align:center; font-weight:bold; font-size:16px; }
    .lastest_notice_wrap .bar {flex:0 0 20px; text-align:center;}
    .lastest_notice_wrap .bar span {display:inline-block; width:1px; height:12px; background:rgba(255,255,255,0.5); vertical-align:middle;}
    .lastest_notice_wrap .slide {height:100%; flex:1 1 calc(100% - 196px); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;}
    .lastest_notice_wrap .more {flex: 0 0 88px; margin-left:auto; text-align:center; font-weight:500;}
    .lastest_notice_wrap .more a {display:inline-block; padding-bottom:2px; border-bottom:1px solid transparent}
    .lastest_notice_wrap .more:hover a{border-bottom-color:#FFF;}

    .NoticeLatestSwiper {height:100%;}
    .NoticeLatestSwiper .swiper-slide {display:flex; align-items:center; flex:none; padding-right:20px;}
    .NoticeLatestSwiper a{display:flex; align-items:center; flex:1 1 calc(100% - 70px); min-width:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;}
    .NoticeLatestSwiper strong {border:1px solid rgba(255,255,255,0.5); border-radius:50px; flex:0 0 56px; text-align:center; font-size:14px; font-weight:bold; height: 2em; display: flex; align-items: center; justify-content: center;}
    .NoticeLatestSwiper .t {line-height:1em; font-size:15px; display:inline-block; padding-left:10px; text-overflow:ellipsis; white-space:nowrap; overflow:hidden; display:inline-block;}
    .NoticeLatestSwiper .lt_date {flex:0 0 70px; font-size:14px; margin-left:auto; color:rgba(255,255,255,0.72);}

    @media all and (max-width:768px) { 
        
        .NoticeLatestSwiper a { flex:0 0 100%; }
        .NoticeLatestSwiper .t {font-size:14px;}
        .NoticeLatestSwiper strong {flex:0 0 50px; font-size:13px;}
        .NoticeLatestSwiper .lt_date {display:none;}

        .lastest_notice_wrap {height:55px;}
        .lastest_notice_wrap .tit,
        .lastest_notice_wrap .more {flex:0 0 55px; font-size:14px;}
        .lastest_notice_wrap .tit {text-align:left;}
        .lastest_notice_wrap .more {text-align:right;}
        .lastest_notice_wrap .bar {flex:0 0 10px; text-align:left;}
    }
    @media all and (max-width:380px) { 
        .NoticeLatestSwiper a { flex:0 0 100%; }
        .NoticeLatestSwiper .t {font-size:14px;}
        .NoticeLatestSwiper strong {flex:0 0 50px; font-size:13px;}
        .lastest_notice_wrap .more {display:none;}
    }

</style>
<div class="lastest_notice_wrap">
    <div class="tit"><?php echo $bo_subject ?></div>
    <div class="bar"><span></span></div>
    <div class="slide">
        <div class="swiper NoticeLatestSwiper">
            <div class="swiper-wrapper">
                    <?php for ($i=0; $i<$list_count; $i++) {  ?>
                        <div class="swiper-slide">
                            <?php
                                echo "<a href=\"".get_pretty_url($bo_table, $list[$i]['wr_id'])."\"> ";
                                    if ($list[$i]['is_notice'])
                                        echo "<strong>공지</strong>";

                                    echo "<div class='t'>".$list[$i]['subject']."</div>";
                                echo "</a>";
                            ?>
                            <span class="lt_date"><?=date("Y.m.d", strtotime($list[$i]['wr_datetime']))?> </span>
                        </div>
                    <?php }  ?>
                    
                    <?php if ($list_count == 0) { //게시물이 없을 때  ?>
                        <div class="swiper-slide">게시물이 없습니다.</div>
                    <?php }  ?>
            </div>
        </div>
    </div>
    <div class="more"><a href="<?php echo get_pretty_url($bo_table); ?>"><span>전체보기</span></a></div>
</div>


<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper(".NoticeLatestSwiper", {
        direction: "vertical",
        loop:true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
    });
</script>
