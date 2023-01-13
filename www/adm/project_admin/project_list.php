<?php
$sub_menu = "700100";
include_once('./_common.php');
$g5['title'] = '과제관리';

$sql_common = " from g5_report";
$sql_search = " where (1) ";
if (!$sst) {
    $sst = "created_at";
    $sod = "desc";
}

$sql_order = " order by {$sst} {$sod} ";
$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산

if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함


$sql = " select * {$sql_common} {$sql_search} {$sql_order} ";
$sql .= "limit {$from_record}, {$rows} ";
$result = sql_query($sql);

include_once (G5_ADMIN_PATH.'/admin.head.php');

?>



<div class="inno_tp">
    <ul class="inno_cate_ul">
        <li><span class="inno_ov01"><span class="ov_txt">생성된 과제수</span><span class="ov_num"><?=$total_count?></span></span></li>
    </ul>

    <div class="inno_down_box right">
        <a href="project_form.php" class="btn_inno_link">과제등록</a>
    </div>
</div>




<div class="inno_bt">

    <div class="tbl_w100 mt30 mb30">
        <table class="tbl_st_01">
            <colgroup>
                <col width="10%">
                <col width="">
                <col width="">
                <col width="15%">
                <col width="10%">
            </colgroup>

            <thead>
                <tr>
                    <th>회차</th>
                    <th>과제명</th>
                    <th>간략설명</th>
                    <th>과제파일</th>
                    <th>수정/삭제</th>
                </tr>
            </thead>
            <tbody>
			<?php for ($i=0; $row=sql_fetch_array($result); $i++) {
				$extensions = explode(".",$row['rt_file']);
				$extension = count($extensions)>1?".".$extensions[count($extensions)-1]:'';
				$download_filename = $row['rt_subject'].date("ymdHi").$extension;
			?>
                <tr>
                    <td><?=$row['rt_subject']?></td>
                    <td><a href="project_form.php" class="proTit"><?=$row['rt_descript']?></a></td>
                    <td><?=$row['rt_contents']?></td>
                    <td class="pd0">
						<?php if($row['rt_file']){?>
						<a href="/bbs/download_report.php?path=/participate4/report/<?=$row['rt_file']?>&filename=<?=$download_filename?>" class="proBtn proDown">과제파일 다운</a></td>
						<?php }?>
                    <td class="pd0"><a href="./project_form.php?rt_id=<?=$row['rt_id']?>" class="proBtn proEdit">수정</a><a href="./project_form_update.php?w=d&rt_id=<?=$row['rt_id']?>" class="proBtn proDele">삭제</a></td>
                </tr>
			<?php
			}
			if ($i == 0)
				echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">자료가 없습니다.</td></tr>";

			?>
            </tbody>
        </table>
    </div>
<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;page='); ?>

</div>

<script>
    let tdLen = $(".tbl_st_01  tr:nth-of-type(1) td").length-5;
    let ttW = $(".tbl_w100").width();
    let tblWidth = ( ttW > 550 + (tdLen * 100) ) ? '100%' : 550 + (tdLen * 100) ;
    
    $(".tbl_st_01").width(tblWidth);
</script>