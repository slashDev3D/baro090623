<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.view.css">', 0);
?>


<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 게시물 읽기 시작 { -->

<article id="bo_v" style="width:<?php echo $width; ?>">

    <div class="video_wrap">
        <?php if ($view['wr_4']) { ?>
            <video class="video-real"  src="<?php echo $view['wr_4'] ?>"   controls ></video>
        <?php } else if ($view['wr_3']) { ?>
            <div class="video-container">
                <div class="in">
                    <iframe width="100%" src="https://player.vimeo.com/video/<?php echo $view['wr_3']; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="vdo_title_wrap">
        <div class="t">#<?php echo $view['subject'] ?> <?php echo $view['wr_1']?></div>
        <ul class="c">
            <li>조회수 <?php echo number_format($view['wr_hit']) ?></li>
            <li class="dot"></li>
            <li>스트리밍시간 <?php echo $view['wr_2']?></li>
        </ul>
        <div class="mt10"><?php echo get_view_thumbnail($view['content']); ?></div>
        <div class="icon_share"><embed  class="ic" src="<?php echo G5_URL ?>/common/images/common/icon_share.svg" type="image/svg+xml" aria-label="공유버튼"> 공유</div>
        <div class="icon_share_con">
            <?php include(G5_SNS_PATH."/view.sns.par2.php"); ?>
        </div>
    </div>

    <section id="bo_v_atc" style="display:none">
        <h2 id="bo_v_atc_title">본문</h2>

        <?php
        // 파일 출력
        $v_img_count = count($view['file']);
        if($v_img_count) {
            echo "<div id=\"bo_v_img\">\n";

            foreach($view['file'] as $view_file) {
                echo get_file_thumbnail($view_file);
            }

            echo "</div>\n";
        }
        ?>

        <!-- 본문 내용 시작 { -->
        <!-- <div id="bo_v_con"><?php //echo get_view_thumbnail($view['content']); ?></div> -->
        <?php //echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
        <!-- } 본문 내용 끝 -->


        <!--  추천 비추천 시작 { -->
        <?php if ( $good_href || $nogood_href) { ?>
        <div id="bo_v_act">
            <?php if ($good_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $good_href.'&amp;'.$qstr ?>" id="good_button" class="bo_v_good"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i><span class="sound_only">추천</span><strong><?php echo number_format($view['wr_good']) ?></strong></a>
                <b id="bo_v_act_good"></b>
            </span>
            <?php } ?>
            <?php if ($nogood_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $nogood_href.'&amp;'.$qstr ?>" id="nogood_button" class="bo_v_nogood"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i><span class="sound_only">비추천</span><strong><?php echo number_format($view['wr_nogood']) ?></strong></a>
                <b id="bo_v_act_nogood"></b>
            </span>
            <?php } ?>
        </div>
        <?php } else {
            if($board['bo_use_good'] || $board['bo_use_nogood']) {
        ?>
        <div id="bo_v_act">
            <?php if($board['bo_use_good']) { ?><span class="bo_v_good"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i><span class="sound_only">추천</span><strong><?php echo number_format($view['wr_good']) ?></strong></span><?php } ?>
            <?php if($board['bo_use_nogood']) { ?><span class="bo_v_nogood"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i><span class="sound_only">비추천</span><strong><?php echo number_format($view['wr_nogood']) ?></strong></span><?php } ?>
        </div>
        <?php
            }
        }
        ?>
        <!-- }  추천 비추천 끝 -->
    </section>

    <?php
    $cnt = 0;
    if ($view['file']['count']) {
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                $cnt++;
        }
    }
	?>

    <?php //if($cnt) { ?>
    <!-- 첨부파일 시작 { bo_v_file -->
    <section id="" class="vdo_file_wrap">
        <div class="vdo_file_tit">⏰&nbsp;&nbsp;강의자료</div>
        <ul class="vdo_file_con">
        <?php
            if($cnt) {
                // 가변 파일
                for ($i=0; $i<count($view['file']); $i++) {
                    if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
                ?>
                    <li class="data">
                        <a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download">
                            <strong><?php echo $view['file'][$i]['source'] ?></strong> <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                        </a>
                    </li>
                <?php
                    }
                }
            } else {
            ?>
            <li class="no-data" >
                <div class="">이번 강의 자료는 없어요!</div>
                <div class=""><img src="<?php echo G5_URL ?>/common/images/common/icon_noFile.png" /></div>
            </li>
            <?php } ?>
        </ul>
    </section>
    <!-- } 첨부파일 끝 -->
    <?php //} ?>

    <?php if(isset($view['link']) && array_filter($view['link'])) { ?>
    <!-- 관련링크 시작 { -->
    <section id="bo_v_link">
        <h2>관련링크</h2>
        <ul>
        <?php
        // 링크
        $cnt = 0;
        for ($i=1; $i<=count($view['link']); $i++) {
            if ($view['link'][$i]) {
                $cnt++;
                $link = cut_str($view['link'][$i], 70);
            ?>
            <li>
                <i class="fa fa-link" aria-hidden="true"></i>
                <a href="<?php echo $view['link_href'][$i] ?>" target="_blank">
                    <strong><?php echo $link ?></strong>
                </a>
                <br>
                <span class="bo_v_link_cnt"><?php echo $view['link_hit'][$i] ?>회 연결</span>
            </li>
            <?php
            }
        }
        ?>
        </ul>
    </section>
    <!-- } 관련링크 끝 -->
    <?php } ?>
    
    <!-- <?php if ($prev_href || $next_href) { ?>
    <ul class="bo_v_nb">
        <?php if ($prev_href) { ?><li class="btn_prv"><span class="nb_tit"><i class="fa fa-chevron-up" aria-hidden="true"></i> 이전글</span><a href="<?php echo $prev_href ?>"><?php echo $prev_wr_subject;?></a> <span class="nb_date"><?php echo str_replace('-', '.', substr($prev_wr_date, '2', '8')); ?></span></li><?php } ?>
        <?php if ($next_href) { ?><li class="btn_next"><span class="nb_tit"><i class="fa fa-chevron-down" aria-hidden="true"></i> 다음글</span><a href="<?php echo $next_href ?>"><?php echo $next_wr_subject;?></a>  <span class="nb_date"><?php echo str_replace('-', '.', substr($next_wr_date, '2', '8')); ?></span></li><?php } ?>
    </ul>
    <?php } ?> -->

    <?php
    // 코멘트 입출력
    //include_once(G5_BBS_PATH.'/view_comment.php');
	?>



    <?php if($is_admin) {?>
        <!-- 게시물 상단 버튼 시작 { -->
	    <div id="bo_v_top">
	        <?php ob_start(); ?>

	        <ul class="btn_bo_user bo_v_com">
				<li><a href="<?php echo $list_href ?>" class="btn_b01 btn" title="목록"><i class="fa fa-list" aria-hidden="true"></i><span class="sound_only">목록</span></a></li>
	            <?php if ($reply_href) { ?><li><a href="<?php echo $reply_href ?>" class="btn_b01 btn" title="답변"><i class="fa fa-reply" aria-hidden="true"></i><span class="sound_only">답변</span></a></li><?php } ?>
	            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b01 btn" title="글쓰기"><i class="fa fa-pencil" aria-hidden="true"></i><span class="sound_only">글쓰기</span></a></li><?php } ?>
	        	<?php if($update_href || $delete_href || $copy_href || $move_href || $search_href) { ?>
	        	<li>
	        		<button type="button" class="btn_more_opt is_view_btn btn_b01 btn" title="게시판 리스트 옵션"><i class="fa fa-ellipsis-v" aria-hidden="true"></i><span class="sound_only">게시판 리스트 옵션</span></button>
		        	<ul class="more_opt is_view_btn"> 
			            <?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>">수정<i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></li><?php } ?>
			            <?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" onclick="del(this.href); return false;">삭제<i class="fa fa-trash-o" aria-hidden="true"></i></a></li><?php } ?>
			            <?php if ($copy_href) { ?><li><a href="<?php echo $copy_href ?>" onclick="board_move(this.href); return false;">복사<i class="fa fa-files-o" aria-hidden="true"></i></a></li><?php } ?>
			            <?php if ($move_href) { ?><li><a href="<?php echo $move_href ?>" onclick="board_move(this.href); return false;">이동<i class="fa fa-arrows" aria-hidden="true"></i></a></li><?php } ?>
			            <?php if ($search_href) { ?><li><a href="<?php echo $search_href ?>">검색<i class="fa fa-search" aria-hidden="true"></i></a></li><?php } ?>
			        </ul> 
	        	</li>
	        	<?php } ?>
	        </ul>
	        <script>

            jQuery(function($){
                // 게시판 보기 버튼 옵션
				$(".btn_more_opt.is_view_btn").on("click", function(e) {
                    e.stopPropagation();
				    $(".more_opt.is_view_btn").toggle();
				});
                $(document).on("click", function (e) {
                    if(!$(e.target).closest('.is_view_btn').length) {
                        $(".more_opt.is_view_btn").hide();
                    }
                });
            });
            </script>
	        <?php
	        $link_buttons = ob_get_contents();
	        ob_end_flush();
	         ?>
	    </div>
	    <!-- } 게시물 상단 버튼 끝 -->
    <?php } ?>



</article>
<!-- } 게시판 읽기 끝 -->

<script>
// 더보기 클릭시
$(".vdo_title_wrap .icon_share").on("click", function(){
    if($(this).siblings(".icon_share_con").hasClass("on")){
        $(this).siblings(".icon_share_con").removeClass("on");
    }else{
        $(".icon_share_con").removeClass("on");
        $(this).siblings(".icon_share_con").addClass("on");
    }
});

$(".vdo_title_wrap  .icon_share_con").on("mouseleave", function(){
    $(this).removeClass("on");
});



<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }

        var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

        if(confirm(msg)) {
            var href = $(this).attr("href")+"&js=on";
            $(this).attr("href", href);

            return true;
        } else {
            return false;
        }
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<script>
$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("이 글을 비추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                } else {
                    $tx.text("이 글을 추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                }
            }
        }, "json"
    );
}
</script>
<!-- } 게시글 읽기 끝 -->








<div class="side_nextVideo_Wrap">
    <div class="tpBox">
        <div class="title_wrap"><img src="<?php echo G5_URL; ?>/common/images/common/icon_pen.png" /> 다음 교육영상</div>

        <div class="order_box">
            <div class="order_btn order_asc on" data-order="asc">오름차순</div>
            <div class="order_btn order_desc" data-order="desc">내림차순</div>
        </div>
</div>

    <?php //include('view.order.post.php'); ?>
    <?php //include('view.desc.post.php'); ?>

    <div class="nextVideo_list ">
        
    </div>


</div>

<script>

    $(document).ready(function () {


        getSelectList ("asc");

        $(".order_desc").click(function () {

            
            $(".order_asc").removeClass("on");
            $(".order_desc").addClass("on")

            $(".nextVideo_list.list_desc").css({"display": "flex"});
            $(".nextVideo_list.list_asc").css({"display": "none"});

            getSelectList("desc");
        });
        $(".order_asc").click(function () {

            $(".order_desc").removeClass("on");
            $(".order_asc").addClass("on")

            $(".nextVideo_list.list_desc").css({"display": "none"});
            $(".nextVideo_list.list_asc").css({"display": "flex"});

            getSelectList("asc");
        });

        
    
        $(window).resize(function(){
            let bovH = $("#bo_v").height();
            let tpH = $(".side_nextVideo_Wrap .tpBox").height();
            $(".nextVideo_list").css('height', bovH-tpH);
        }).resize();

		const video = document.querySelector('video');
		if(video){
			video.onplay = (event) => {
				$.ajax({
						url:"/bbs/ajax.mb_daily.php",
						type:"post",
						data:{"mb_no":"<?=$member[mb_no]?>","bo_table":"<?=$bo_table?>","wr_id":"<?=$wr_id?>"},
						success:function(res){
							console.log("res",res);
						}
				  });
			};
		}

    });
    
</script>



<script>
    
function vimeoLoadingThumb(id){ 
    var url = "http://vimeo.com/api/v2/video/" + id + ".json?callback=showThumb";
    var id_img = "#vimeo-" + id;
    var script = document.createElement( 'script' );
    script.type = 'text/javascript';
    script.src = url;
    $(id_img).before(script);
}


function showThumb(data){
    var id_img = "#vimeo-" + data[0].id;
    $(id_img).css('background-image',`url(${data[0].thumbnail_large})`);
}


function getSelectList (orderText){

    $(".nextVideo_list").html("");

    $.ajax({
        type:"POST",
        cache : false,
        url : "<?php echo G5_URL ?>/sql_select.php",
        //dataType : "json",
        data : {
            tbl : "<?php echo $bo_table ?>",
            order : orderText
        },
        success : function (data) {
            
            let dataSet = JSON.parse(data);
            let dataSet_row = dataSet.length;
            
            console.log(data);
            for(key in dataSet) {

                let wr_href = `<?php echo $g5_bbs_url?>?bo_table=<?php echo $board['bo_table']?>&wr_id=${dataSet[key].wr_id}`;;
                
                let addon = "";
                if(dataSet[key].wr_id == <?php echo $view['wr_id']?>)  addon = "on";

                let texts = 
                `
                <li class="vdo_box box_${dataSet[key].wr_id} ${addon}">
                    <a href="${wr_href}">
                        <div class="img"> <div class="vimeo-img" style="background-size:cover; background-image:url(${dataSet[key].wr_5})" ></div></div>
                        <div class="txt">
                            <p class="t">#${dataSet[key].wr_subject} ${dataSet[key].wr_1}</p>
                            <p class="c">
                                ${dataSet[key].wr_hit}명<br/>
                                ${dataSet[key].wr_2}
                            </p>
                        </div>
                    </a>
                </li>
                `;
                
                $(".nextVideo_list").append(texts);
                // vimeoLoadingThumb(`${dataSet[key].wr_3}`); id="vimeo-${dataSet[key].wr_3}"
            }
            
        }
    });
    
}

</script>

