<?php
$sub_menu = "200260";
include_once('./_common.php');

$sql_common = " from g5_organize";
$sql_search = " where (1) ";
if (!$sst) {
    $sst = "created_at";
    $sod = "desc";
}

$rows = $config['cf_page_rows'];

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];


$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} ";
$sql .= "limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$g5['title'] = "혁신단관리";
include_once('./admin.head.php');
?>




<style>
    .innoAddWrap {display:flex; gap:10px; align-items:center; justify-content:flex-start; margin-bottom:20px;}
    .innoAddWrap label {font-size:16px; padding:0 12px; font-weight:bold;}
    .innoAddWrap input {width:280px; border:1px solid #dbdbdb; font-size:14px; padding:12px 18px; border-radius:6px; }
    .innoAddWrap button {color:#FFF !important; background:#222; border-radius:6px; font-size:13px; font-weight:600; line-height:1em; padding:14px 19px; border:0;}

</style>
<form name="fmember" id="fmember" action="./innoGroup_update.php" onsubmit="return fmember_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="">

<div class="innoAddWrap">
    <label for="og_name">혁신단명</label><input type="text" name="og_name" id="og_name" class="" placeholder="혁신단명을 입력해주세요" /><button type="submit" class="">등록</button>
</div>
</form>

<form action="./innoGroup_update.php" method="post">
<input type="hidden" name="w" value="ds">
	<div class="inno_bt">
		<div class="tbl_head01 tbl_wrap">
			<table>
				<colgroup>
					<col width="100px" />
					<col width="" />
				</colgroup>
				<thead>
					<tr>
						<th><input type="checkbox" name="" value="" id="" onclick="check_all(this.form)"></th>
						<th>혁신단명</th>
						<th>수정</th>
					</tr>
				</thead>
			<tbody>
			
			<?php for ($i=0; $row=sql_fetch_array($result); $i++) {?>
				<tr>
					<td class="td_chk">
						<input type="hidden" name="og_ids[<?php echo $i ?>]" value="<?php echo $row['og_id'] ?>" id="og_id_<?php echo $i ?>">
						<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
					</td>
					<td><?=$row['og_name']?></td>
					<td><a href='innoGroup_form.php?w=u&og_id=<?=$row['og_id']?>'>수정</a></td>
					</tr>
				<?php
				}
				if ($i == 0)
					echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">자료가 없습니다.</td></tr>";
				?>
				</tbody>
			</table>
		</div>

		<div class="btn_list01 btn_list">
			<input type="button" onclick="if(confirm('혁신단을 삭제하면 해당 팀도 모두 삭제됩니다. 삭제하시겠습니까?')){this.form.submit()}" name="" value="선택삭제" class="btn btn_02">
            <div style="margin-top:10px;">혁신단을 삭제하시면, 해당 혁신단에 등록된 팀이모두 삭제됩니다.<br>삭제에 유의해주세요</div>
		</div>

	</div>

</form>
<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;page='); ?>


<div class="btn_fixed_top">
    <?php if ($is_admin == 'super') { ?>
    <a href="./innoGroup_form.php" id="member_add" class="btn btn_01">혁신단추가</a>
    <?php } ?>

</div>
<?php
include_once ('./admin.tail.php');