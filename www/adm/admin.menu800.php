<?php
$sql = " select * from g5_organize order by og_id asc ";

$result = sql_query($sql);
$menulist = [];
$menulist[] = ['800000', "혁신단관리", ''.G5_ADMIN_URL.'/innovation_admin/team1_member.php', 'innovation'];

$menulist[] = ['800001', "내 혁신단관리", ''.G5_ADMIN_URL.'/innovation_admin/team1_member.php?og_id='.$member["mb_1"].'', 'project_list'];

for ($i=0; $row=sql_fetch_array($result); $i++) {
	if($og_id==$row['og_id']){$active='800100';}else{$active='800200';}
	$menulist[] = [$active, $row['og_name'], ''.G5_ADMIN_URL.'/innovation_admin/team1_member.php?og_id='.$row['og_id'], 'innovation'];
}

$menu['menu800'] = $menulist;


?>


<?