<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>


<!-- 게시판 목록 시작 { -->
<div id="bo_gall" style="width:<?php echo $width; ?>">

    <?php if ($is_category) { ?>
    <nav id="bo_cate">
        <h2><?php echo $board['bo_subject'] ?> 카테고리</h2>
        <ul id="bo_cate_ul">
            <?php echo $category_option ?>
        </ul>
    </nav>
    <?php } ?>

    <form name="fboardlist"  id="fboardlist" action="<?php echo G5_BBS_URL; ?>/board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <div id="bo_btn_top">
        
         <!-- <div id="bo_list_total">
            <span>Total <?php echo number_format($total_count) ?>건</span>
            <?php echo $page ?> 페이지
        </div> -->
        
        <ul class="btn_bo_user">
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin btn" title="관리자"><i class="fa fa-cog fa-spin fa-fw"></i><span class="sound_only">관리자</span></a></li><?php } ?>
            <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01 btn" title="RSS"><i class="fa fa-rss" aria-hidden="true"></i><span class="sound_only">RSS</span></a></li><?php } ?>
            <!--
            <li>
                <button type="button" class="btn_bo_sch btn_b01 btn" title="게시판 검색"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">게시판 검색</span></button> 
            </li>
            -->
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b01 btn" title="글쓰기"><i class="fa fa-pencil" aria-hidden="true"></i><span class="sound_only">글쓰기</span></a></li><?php } ?>
            <?php if ($is_admin == 'super' || $is_auth) {  ?>
            <li>
                <button type="button" class="btn_more_opt is_list_btn btn_b01 btn" title="게시판 리스트 옵션"><i class="fa fa-ellipsis-v" aria-hidden="true"></i><span class="sound_only">게시판 리스트 옵션</span></button>
                <?php if ($is_checkbox) { ?>    
                <ul class="more_opt is_list_btn">  
                    <li><button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"><i class="fa fa-trash-o" aria-hidden="true"></i> 선택삭제</button></li>
                    <li><button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value"><i class="fa fa-files-o" aria-hidden="true"></i> 선택복사</button></li>
                    <li><button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value"><i class="fa fa-arrows" aria-hidden="true"></i> 선택이동</button></li>
                </ul>
                <?php } ?>
            </li>
            <?php }  ?>
        </ul>
    </div>
    <!-- } 게시판 페이지 정보 및 버튼 끝 -->

    <?php if ($is_checkbox) { ?>
        <div id="gall_allchk" class="all_chk chk_box">
            <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);" class="selec_chk">
            <label for="chkall">
                <span></span>
                <b class="sound_only">현재 페이지 게시물 </b> 전체선택
            </label>
        </div>
    <?php } ?>



<!-- #region 커스텀 -->
    

    <?php
        // 게시판 리스트
        //for ($i=0; $i<count($list); $i++) {
        //    $classes = array();
        //    $classes[] = 'gall_li';
        //    $classes[] = 'col-gn-'.$bo_gallery_cols;
        //if( $i && ($i % $bo_gallery_cols == 0) ){
        //    $classes[] = 'box_clear';
       // }
        //if( $wr_id && $wr_id == $list[$i]['wr_id'] ){
         //   $classes[] = 'gall_now';
       // }
        //    $line_height_style = ($board['bo_gallery_height'] > 0) ? 'line-height:'.$board['bo_gallery_height'].'px' : '';
    ?>

    <?php
        // 대학교 분류 구분자로 나누고
        $ddd = explode('|', $board[bo_1]); // 구분자가 , 로 되어 있음
        
        // for 문 돌리자~
        for ($i=0; $i<count($ddd);g$i++) {
            //echo $i." - ".trim($ddd[$i])." & ".$ca_colleage_name;
        $ca_colleage_name = trim($ddd[$i]);
            
            

        // 해당 분류별로 게시글 가져오기.
        $sql = "select
                *
            from
                $write_table
            where
                wr_1 = '".$ca_colleage_name."' and ca_name = '".$list[$i]['ca_name']."'  and wr_is_comment = 0
            order by
                wr_id desc ";
        
        $result = sql_query($sql, true);


        if(mysqli_num_rows($result)){
            echo "<div class='subPg_box cate_college_box cate_".$category[$i]."_".$i."'>";
            echo "<div class='subPg_tit'><span>".$ca_colleage_name."</span></div>";
            echo "<div class='subPg_con line '>";
        }
        
        // 여기서부터 각 분류별 작성
        while($row=sql_fetch_array($result)) {
            $wr_href = $g5_bbs_url."?bo_table=".$board['bo_table']."&wr_id=".$row['wr_id'];
    ?>

        <div class="cate_college_gall_box">

            <div class="gall_chk chk_box">

                <?php if ($is_checkbox) { ?>
                    <input type="checkbox" name="chk_wr_id[]" value="<?php echo $row['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>" class="selec_chk">
                    <label for="chk_wr_id_<?php echo $i ?>">
                        <span></span>
                        <b class="sound_only">
                            <?php echo $row['wr_subject'] ?>
                        </b>
                    </label>
                <?php } ?>

                <span class="sound_only">
                    <?php
                        if ($wr_id == $row['wr_id'])
                        echo "<span class=\"bo_current\">열람중</span>";
                        else
                        echo $row['num'];
                    ?>
                </span>
            </div>

            <div class="gall_con">
                
                    <?php if ($row['is_notice']) { // 공지사항  ?>
                            <span class="is_notice" style="<?php echo $line_height_style; ?>">공지</span>
                    <?php } else {
                        $thumb = get_list_thumbnail($board['bo_table'], $row['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height'], false, false);
                        
                        if($thumb['src']) {
                            $img_content = "<div class='gall_img'><div class='gall_thum' style='background-image:url(".$thumb['ori'].")'></div></div>";
                        } else {
                            //$img_content = '<div class="gall_thum no_img">No Image</div>';
                            $img_content = '';
                        }
                            echo run_replace('thumb_image_tag', $img_content, $thumb);
                        }
                    ?>
                

                <ul class="gall_text">
                    <?php
                        if($is_admin) {
                            echo "<a href='".$wr_href."'>";
                        }
                    ?>
                        <li class="gall_text_tit">
                            <span class="tt"><?php echo $row['wr_subject'] ?></span>
                            <span class="cc"><?php echo $row['wr_2']?></span>
                        </li>
                        <?php if($row['wr_3']) { ?>
                            <li class="gall_text_con">
                                <?php echo $row['wr_3']?>
                                <?php //echo utf8_strcut(strip_tags($row['wr_content']), 68, '..'); ?>
                            </li>
                        <?php } ?>
                    <?php
                        if($is_admin) {
                            echo "</a>";
                        }
                    ?>
                </ul>
            </div>
        </div>

    <?php
                    } // white 종료
            if(mysqli_num_rows($result)){
                echo "</div>";
                echo "</div>";
            }
        }
    ?>
    <?php 
        //} 
    ?>
    <?php //if (count($list) == 0) { echo "<li class=\"empty_list\">게시물이 없습니다.</li>"; } ?>




<!-- #endregion 커스텀 종료 -->

    <!-- 페이지 -->
    <?php echo $write_pages; ?>
    <!-- 페이지 -->
    
    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx">
        <?php if ($list_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin btn" title="관리자"><i class="fa fa-cog fa-spin fa-fw"></i><span class="sound_only">관리자</span></a></li><?php } ?>
            <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01 btn" title="RSS"><i class="fa fa-rss" aria-hidden="true"></i><span class="sound_only">RSS</span></a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b01 btn" title="글쓰기"><i class="fa fa-pencil" aria-hidden="true"></i><span class="sound_only">글쓰기</span></a></li><?php } ?>
        </ul>   
        <?php } ?>
    </div>
    <?php } ?> 
    </form>

    <!-- 게시판 검색 시작 { -->
    <div class="bo_sch_wrap">   
        <fieldset class="bo_sch">
            <h3>검색</h3>
            <form name="fsearch" method="get">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
            <input type="hidden" name="sca" value="<?php echo $sca ?>">
            <input type="hidden" name="sop" value="and">
            <label for="sfl" class="sound_only">검색대상</label>
            <select name="sfl" id="sfl">
                <?php echo get_board_sfl_select_options($sfl); ?>
            </select>
            <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
            <div class="sch_bar">
                <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="sch_input" size="25" maxlength="20" placeholder="검색어를 입력해주세요">
                <button type="submit" value="검색" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
            </div>
            <button type="button" class="bo_sch_cls"><i class="fa fa-times" aria-hidden="true"></i><span class="sound_only">닫기</span></button>
            </form>
        </fieldset>
        <div class="bo_sch_bg"></div>
    </div>
    <script>
        // 게시판 검색
        $(".btn_bo_sch").on("click", function() {
            $(".bo_sch_wrap").toggle();
        })
        $('.bo_sch_bg, .bo_sch_cls').click(function(){
            $('.bo_sch_wrap').hide();
        });
    </script>
    <!-- } 게시판 검색 끝 -->
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = g5_bbs_url+"/board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == 'copy')
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = g5_bbs_url+"/move.php";
    f.submit();
}

// 게시판 리스트 관리자 옵션
jQuery(function($){
    $(".btn_more_opt.is_list_btn").on("click", function(e) {
        e.stopPropagation();
        $(".more_opt.is_list_btn").toggle();
    });
    $(document).on("click", function (e) {
        if(!$(e.target).closest('.is_list_btn').length) {
            $(".more_opt.is_list_btn").hide();
        }
    });
});
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
