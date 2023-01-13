<?php
$sub_menu = "700100";
include_once('./_common.php');
$g5['title'] = '과제 등록';


if($rt_id){
	$reports = "select * from g5_report";
	$select = $reports;
	$select .= " where rt_id = {$rt_id}";	
	$select .= " order by rt_id desc limit 1";
	$rt_row = sql_fetch($select);

}
include_once (G5_ADMIN_PATH.'/admin.head.php');

?>

<div class="inno_tp">
    <div></div>
    <div class="inno_down_box right">
        <a href="project_form.php" class="btn_inno_link">과제등록</a>
    </div>
</div>


<form method="post" enctype="multipart/form-data" action="project_form_update.php">
<input name="w" type="hidden" value="<?=$rt_row['rt_id']>0?"u":""?>">
<input name="rt_id" type="hidden" value="<?=$rt_row['rt_id']?>">
<div class="inno_bt">

    <div class="tbl_w100 mt30 mb30">
        
        <ul class="proj_list">
            <li>
                <p class="t">과제회차 <span class="im"></span></p>
                <p class="ipt">
                    <input type="text" name="rt_subject" value="<?=$rt_row['rt_subject']?>" id="" class="iptSt01" placeholder="과제회차">
                </p>
            </li>
            <li>
                <p class="t">과제제목 <span class="im"></span></p>
                <p class="ipt">
                    <input type="text" name="rt_descript" value="<?=$rt_row['rt_descript']?>" id="" class="iptSt01" placeholder="과제제목">
                </p>
            </li>
            <li>
                <p class="t">간략설명 <span class="im"></span></p>
                <p class="ipt">
                    <textarea name="rt_contents" id="" class="iptSt01" placeholder="과제설명을 입력해주세요."><?=$rt_row['rt_contents']?></textarea>
                </p>
            </li>
            <li>
                <p class="t">첨부파일 <span class="im"></span></p>
                <p class="ipt proj_fileBox">
					<?php if($rt_row['rt_file']){?>
					<a href="/bbs/download_report.php?path=/participate4/report/<?=$rt_row['rt_file']?>&filename=<?=$rt_row['rt_file']?>" class="proBtn proDown"><?=$rt_row['rt_file']?></a>
					<?php }?>
                    <label for="proj_fileUp">과제파일업로드</label>
                    <input type="text" name="" class="proj_fileText" value="과제를 업로드해주세요!" readonly />
                    <input type="file" name="rt_file" value="" id="proj_fileUp" class="iptSt01" placeholder="과제회차">
                </p>
            </li>
        </ul>

        <div class="btn_confirm_wrap"><!-- btn_confirm-->
            <a href="project_list.php" class="btn_close">취소</a>
            <button type="submit" id="" class="">과제등록</button>
        </div>
        


    </div>

</div>
</form>
<script>
    $(document).ready(function(){
        // fileName
        var fileTarget = $('.proj_fileBox #proj_fileUp');

        fileTarget.on('change', function(){
            if(window.FileReader){
                var filename = $(this)[0].files[0].name;
            } else {
                var filename = $(this).val().split('/').pop().split('\\').pop();
            }

            $(this).siblings('.proj_fileText').val(filename);
        });

        // Table Width
        let tdLen = $(".tbl_st_01  tr:nth-of-type(1) td").length-5;
        let ttW = $(".tbl_w100").width();
        let tblWidth = ( ttW > 550 + (tdLen * 100) ) ? '100%' : 550 + (tdLen * 100) ;
        
        $(".tbl_st_01").width(tblWidth);


    }); 
</script>