<?php
$sub_menu = "200270";
include_once('./_common.php');

$sql_common = " from g5_organize_team as a left join g5_organize as b on a.og_id = b.og_id";
$sql_search = " where (1) ";
if (!$sst) {
    $sst = "a.created_at";
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

$og_sql = " select * from g5_organize";
$og_result = sql_query($og_sql);

$g5['title'] = "팀관리";
include_once('./admin.head.php');
?>




<style>
    .innoAddWrap {display:flex; gap:10px; align-items:center; justify-content:flex-start; margin-bottom:20px;}
    .innoAddWrap label {font-size:16px; padding:0 12px; font-weight:bold;}
    .innoAddWrap input {width:280px; border:1px solid #dbdbdb; font-size:14px; padding:12px 18px; border-radius:6px; }
    .innoAddWrap button {color:#FFF !important; background:#222; border-radius:6px; font-size:13px; font-weight:600; line-height:1em; padding:14px 19px; border:0;}

</style>
<form name="fmember" id="fmember" action="./innoTeam_update.php" onsubmit="return fmember_submit(this);" method="post" enctype="multipart/form-data">
	<input type="hidden" name="w" value="">
	<div class="innoAddWrap">
        <label for="ogt_name">혁신단</label>
		<select name="og_id">
			<?php for ($i=0; $og_row=sql_fetch_array($og_result); $i++) {?>
				<option value="<?=$og_row['og_id']?>"><?=$og_row['og_name']?></option>
			<?php }?>
		</select>
		<label for="ogt_name">팀 명</label><input type="text" name="ogt_name" id="ogt_name" class="" placeholder="팀명을 입력해주세요" /><button type="submit" class="">등록</button>
	</div>
</form>

<form action="./innoTeam_update.php" method="post">
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
                    <th><input type="checkbox" name="" value="" id="" onclick=""></th>
                    <th>혁신단명</th>
                    <th>팀명</th>
                    <th>수정</th>
                </tr>
            </thead>
        <tbody>
		<?php for ($i=0; $row=sql_fetch_array($result); $i++) {?>
            <tr>
				<td class="td_chk">
					<input type="hidden" name="ogt_ids[<?php echo $i ?>]" value="<?php echo $row['ogt_id'] ?>" id="ogt_id_<?php echo $i ?>">
					<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
				</td>

                <td><?=$row['og_name']?></td>
                <td><?=$row['ogt_name']?></td>
                <td><a href='innoTeam_form.php?w=u&ogt_id=<?=$row['ogt_id']?>'>수정</a></td>
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
        <input type="submit" name="" value="선택삭제" class="btn btn_02">
    </div>
</div>
</form>
<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;page='); ?>

<?php
include_once ('./admin.tail.php');