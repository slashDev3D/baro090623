<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$thumb_width = 412;
$thumb_height = 512;
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<style>
    .VideoLatestSwiper {position:relative; padding-bottom:43px; height:512px; box-sizing:unset; }
    .VideoBox {position:relative;  border-radius:20px; overflow:hidden; width:432px; height:412px; box-sizing:border-box; margin:0 10px;  }
    .VideoBox.swiper-slide-active {height:512px; transition:all 0.7s;}

    .VideoBox .text { cursor: pointer;position:absolute; top:0; left:0; z-index:2; width:100%; height:100%; box-sizing:border-box; padding:40px 30px; display:flex; flex-direction:column; justify-content:flex-end; color:#FFF; gap:15px; background:linear-gradient(1deg, rgb(0 0 0 / 20%), transparent); transition:all 0.5s;}
    .VideoBox .text:before {content:""; position:Absolute; background:url('<?php echo G5_URL?>/common/images/main/icon_play.png') no-repeat center center; display:block; width:100%; height:100%; top:0; left:0; opacity:0.8; transition:all 1s;}
    .VideoBox .text .t {font-size:20px; font-weight:bold; line-height:1em; width:100%; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;}
    .VideoBox .text .n span {font-size:15px; color:rgba(255,255,255,0.72) !important; line-height:1em; width:100%; display:block; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;}
    .VideoBox .bg {width:100%; height:100%; position:Absolute; top:0; left:0; background-repeat:no-repeat; background-size:cover; background-position:center center; transition:all 0.5s;}

    .VideoBox:hover .bg{transform:scale(1.05); transition:all 1s;}
    .VideoBox:hover .text:before {opacity:1; transition:all 1s;}

    .swiper-horizontal>.swiper-pagination-progressbar, .swiper-pagination-progressbar.swiper-pagination-horizontal,
    .mn-vd-scrollbar {position:absolute; top:unset; bottom:0; left:0; }
    .swiper-pagination-progressbar .swiper-pagination-progressbar-fill {background-color:#222222;}
    .swiper-pagination-progressbar {background-color:#dbdbdb}

    @media all and (max-width:1400px) {
        .VideoBox { width:380px; }
    }
    @media all and (max-width:1024px) {
        .VideoLatestSwiper {height:412px;}
        .VideoBox { margin:0; height:312px; }
        .VideoBox.swiper-slide-active { height:412px;}
    }
    @media all and (max-width:768px) {
        .VideoBox {  }
        .VideoBox.swiper-slide-active { }
    } 
    @media all and (max-width:550px) {
        .VideoLatestSwiper,
        .VideoBox,
        .VideoBox.swiper-slide-active { height:300px;}
    }
</style>

<div class="swiper VideoLatestSwiper ">
    <div class="swiper-wrapper">
        <?php
        for ($i=0; $i<$list_count; $i++) {
        $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

        if($thumb['src']) {
            $img = $thumb['src'];
        } else {
            $img = G5_IMG_URL.'/no_img.png';
            $thumb['alt'] = '이미지가 없습니다.';
        }

        $wr_href = get_pretty_url($bo_table, $list[$i]['wr_id']);
        ?>
            <div class="swiper-slide VideoBox">
                <a href="<?php echo $wr_href; ?>">
                    <div class="text">
                        <div class="t">#<?php echo $list[$i]['subject'] ?> <?php echo $list[$i]['wr_1']; ?></div>
                        <div class="n"><?php echo $list[$i]['name'] ?></div>
                    </div>

                    <div class="bg" style="background-image:url(<?php echo $list[$i]['wr_5'] ?>)"></div>
                </a>
            </div>
            
        <?php }  ?>
        <?php if ($list_count == 0) { //게시물이 없을 때  ?>
            <div class="swiper-slide">게시물이 없습니다.</div>
        <?php }  ?>

        
    </div>
    <div class="mn-vd-scrollbar"></div>
</div>



    <!-- Initialize Swiper -->
    <script>
        var VideoLatestSwiper = new Swiper(".VideoLatestSwiper", {
            slidesPerView: 1,
            centeredSlides: true,
            spaceBetween: 20,
            loop:true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".mn-vd-pagination",
                type: "fraction",
            },
            navigation: {
                nextEl: ".mn-vd-next",
                prevEl: ".mn-vd-prev",
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    centeredSlides: true,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    centeredSlides: true,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: "auto",
                    centeredSlides: false,
                    spaceBetween: 0,
                },
            },
        });


        var VideoLatestProgress = new Swiper(".VideoLatestSwiper", {
            slidesPerView: 1,
            centeredSlides: true,
            spaceBetween: 20,
            loop:true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".mn-vd-next",
                prevEl: ".mn-vd-prev",
            },
            breakpoints: {
                550: {
                    slidesPerView: 2,
                    centeredSlides: true,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    centeredSlides: true,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: "auto",
                    centeredSlides: false,
                    spaceBetween: 0,
                },
            },
            pagination: { 
                el: ".mn-vd-scrollbar", 
                type: "progressbar", 
            }, 
        });

        VideoLatestSwiper.controller.control = VideoLatestProgress;

        $('.mn-vd-next, .mn-vd-prev').on('mouseenter', function(e){
            VideoLatestProgress.autoplay.stop();
            VideoLatestSwiper.autoplay.stop()
        })
        $('.mn-vd-next, .mn-vd-prev').on('mouseleave', function(e){
            VideoLatestProgress.autoplay.start();
            VideoLatestSwiper.autoplay.start()
        })

        
    </script>

    <script>
        $(document).ready(function () {
            let winW = $(document).width();
            let slideW = $(".vd_slide").width();
            let innerW = $(".inner").width();
            let sizeW = ( (winW - innerW)/2 ) + slideW;
            
            $(".VideoLatestSwiper").width(sizeW);


            $(window).resize(function(){
                let winW = parseInt($(this).width());
                let slideW = $(".vd_slide").width();
                let innerW = $(".inner").width();
                let sizeW = ( (winW - innerW)/2 ) + slideW;
                
                

                if(winW <= 1024 && winW >= 767) {
                    $(".VideoLatestSwiper").width("calc(100% - 40px)");
                }else if(winW <= 768 && winW >= 551) {
                    $(".VideoLatestSwiper").width("100%");
                }else if(winW <= 550){
                    $(".VideoLatestSwiper").width("calc(100% - 40px)");
                }else{
                    $(".VideoLatestSwiper").width(sizeW);
                }
            }).resize();

            
        });
    </script>


</div>
