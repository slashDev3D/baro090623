<?php 
include_once('_common.php');
include_once('_head.php');
$rt_id = $_GET['rt_id'];
$reports = "select * from g5_report";
$select = $reports;
if($rt_id){
	$select .= " where rt_id = {$rt_id}";	
}
$select .= " order by rt_id desc limit 1";
$rt_row = sql_fetch($select);
$extensions = explode(".",$rt_row['rt_file']);
$extension = count($extensions)>1?".".$extensions[count($extensions)-1]:'';

$download_filename = $rt_row['rt_subject'].date("ymdHi").$extension;
?>

<style>
    #report {display:none;}
</style>

<div class="participate4_container">


    <div id="parti4_cate">
        <ul id="cate_ul">
			<?php 
			$reportRes = sql_query($reports." order by rt_id desc");
			for ($i=0; $reportRow=sql_fetch_array($reportRes); $i++) {
				$thisCate = $reportRow['rt_id']==$rt_row['rt_id']?'id="cate_on"':'';
			?>
            <li><a href="/bbs/participate4.php?rt_id=<?=$reportRow['rt_id']?>" <?=$thisCate?>><?=$reportRow['rt_subject']?></a></li>
			<?php }?>
        </ul>
    </div>

    <div class="parti4_contents_wrap" style="">
    
    <?php if($rt_row['rt_subject'] == "") { echo "<div style='text-align:center; color:#8b8b8b;'>등록된 과제가 없습니다.</div>"; }; ?>

	<form method="post" action="./participate4_update.php" enctype="multipart/form-data" style="<?php if($rt_row['rt_subject'] == "") { echo "display:none"; }; ?>">
		<input type="hidden" name="rt_id" value="<?=$rt_row['rt_id']?>" />
		<input type="hidden" name="og_id" value="<?=$member['mb_1']?>" />
		<input type="hidden" name="ogt_id" value="<?=$member['mb_2']?>" />
		<input type="hidden" name="mb_no" value="<?=$member['mb_no']?>" />
		<input type="file" name="report" id="report" onchange="this.form.submit()"/>
        <div class="parti4_tit_wrap">
            <div class="tit"><?=$rt_row['rt_subject']?></div>
            <div class="con">
                <div class="t"><?=$rt_row['rt_descript']?></div>
                <div class="c"><?=$rt_row['rt_contents']?></div>
                <div class="b">
                    <button type="button" onclick="location.href='/bbs/download_report.php?path=/participate4/report/<?=$rt_row['rt_file']?>&filename=<?=$download_filename?>'" class="btn_file btn_file_download">과제 다운로드 <span class="material-symbols-outlined">download</span></button>

                    <?php if($member['mb_level'] == 2) { ?>
                        <button type="button" class="btn_file btn_file_upload" onclick="document.getElementById('report').click();">
                        과제 제출하기 <span class="material-symbols-outlined">file_upload</span></button>
                    <?php } else {?>
                        <a href="javascript:GoPage('instrViewAdm')" class="btn_file btn_link_upload">혁신단 제출과제 확인하기</a>
                    <?php } ?>

                </div>
            </div>
        </div>
	</form>

        

        
        
        <div id="" class="parti4_cont_wrap">
            <!--
            <div class="parti4_cont_order">
                <button type="button" class="btn_order btn_order_asc order_on">오름차순</button>
                <span class="Bar"></span>
                <button type="button" class="btn_order btn_order_desc">내림차순</button>
            </div>
            -->

            <ul id="" class="parti4_list_wrap">
				<?php
				$contentsSql = "SELECT a.*,b.rt_subject,b.rt_descript,c.mb_id,c.mb_name FROM `g5_report_contents` as a left join `g5_report` as b on a.rt_id = b.rt_id left join `g5_member` as c on a.mb_no = c.mb_no where a.og_id = '{$member['mb_1']}' and a.team_id = '{$member['mb_2']}' and b.rt_id = '{$rt_row['rt_id']}' order by a.rtc_id desc";
				//where og_id = '{$member['mb_1']}' and ogt_id = '{$member['mb_2']}'
				$contentsResult = sql_query($contentsSql);
                
				for ($i=0; $cRow=sql_fetch_array($contentsResult); $i++) {
                ?>

                    <li class="list_box">
                        <div class="num"><?=str_pad(($i+1),2,'0',STR_PAD_LEFT)?></div>
                        <div class="tit">
                            <div class="tit_team"><?=$cRow['rt_subject']?></div>
                            <div class="tit_name"><?=$cRow['rt_descript']?> <span class="gray1">(제출 : <?=$cRow['mb_name']?>)</span></div>
                        </div>
                        <div class="date"><span>Update </span><?=date("y.m.d H:i:s",strtotime($cRow['created_at']))?></div>
                        <div class="file"><button type="button" onclick="location.href='/bbs/download_report.php?path=<?=$cRow['filedir'].'/'.$cRow['filename']?>&filename=<?=urlencode($cRow['oldname'])?>'" class="btn_file_down">다운받기</button></div>
                    </li>
                    <?php
				}
				?>
            </ul>
        </div>

    </div>



</div>




<?php include_once('_tail.php'); ?>