<script language="javascript">
function GoPage(code) {
	if ( !code )						{	window.location = "/";	}

	else if ( code == "main" )			{	window.location = "<?php echo G5_URL ?>/index.php"; } //메인
	
	else if ( code == "business1" )		{	window.location = "<?php echo G5_URL ?>/doc/business1.php"; } //사업소개
	else if ( code == "business2" )		{	window.location = "<?php echo G5_BBS_URL ?>/board.php?bo_table=business2"; }
	else if ( code == "business3" )		{	window.location = "<?php echo G5_BBS_URL ?>/board.php?bo_table=business3"; }
	else if ( code == "business4" )		{	window.location = "<?php echo G5_BBS_URL ?>/board.php?bo_table=business4"; }
	else if ( code == "business5" )		{	window.location = "<?php echo G5_BBS_URL ?>/board.php?bo_table=business5"; }
    else if ( code == "business6" )		{	window.location = "<?php echo G5_URL ?>/doc/business6.php"; }

	else if ( code == "program1" )		{	window.location = "<?php echo G5_URL ?>/doc/program1.php"; } //교육프로그램

	else if ( code == "application1" )		{	window.location = "<?php echo G5_BBS_URL ?>/board.php?bo_table=application1"; } //교육신청
	else if ( code == "application2" )		{	window.location = "<?php echo G5_BBS_URL ?>/board.php?bo_table=application2"; }

	else if ( code == "participate1" )		{	window.location = "<?php echo G5_BBS_URL ?>/board.php?bo_table=participate1"; } //교육참여
    else if ( code == "participate2" )		{	window.location = "<?php echo G5_BBS_URL ?>/board.php?bo_table=participate2"; }
    else if ( code == "participate3" )		{	window.location = "<?php echo G5_BBS_URL ?>/board.php?bo_table=participate3&sfl=wr_5&stx=<?=$member['mb_1']?>"; }
    else if ( code == "participate4" )		{	window.location = "<?php echo G5_BBS_URL ?>/participate4.php"; }

	else if ( code == "comm1" )		{	window.location = "<?php echo G5_BBS_URL ?>/board.php?bo_table=comm1"; }   //공지사항
	else if ( code == "comm2" )		{	window.location = "<?php echo G5_BBS_URL ?>/board.php?bo_table=comm2"; }
	else if ( code == "comm3" )		{	window.location = "<?php echo G5_BBS_URL ?>/board.php?bo_table=comm3"; }

    
    else if ( code == "login" )		{	window.location = "<?php echo G5_BBS_URL ?>/login.php"; }   //공지사항
	else if ( code == "register" )		{	window.location = "<?php echo G5_BBS_URL ?>/register.php"; }

    else if ( code == "instrViewAdm" )		{	window.open('about:blank').location.href="<?php echo G5_URL ?>/adm/innovation_admin/team1_member.php?og_id=<?php echo $member['mb_1']?>"; }

	else if ( code == "bcb" )		{	window.open('about:blank').location.href="http://www.bcb.or.kr/"} //BCB 사이트 바로가기
}
</script>