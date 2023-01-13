<?php
$sub_menu = "200300";
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

$html_title = '회원메일 발송';

check_demo();

check_admin_token();

include_once('./admin.head.php');
include_once(G5_LIB_PATH.'/mailer.lib.php');

$countgap = 10; // 몇건씩 보낼지 설정
$maxscreen = 500; // 몇건씩 화면에 보여줄건지?
$sleepsec = 200;  // 천분의 몇초간 쉴지 설정

echo "<span style='font-size:9pt;'>";
echo "<p>메일 발송중 ...<p><font color=crimson><b>[끝]</b></font> 이라는 단어가 나오기 전에는 중간에 중지하지 마세요.<p>";
echo "</span>";
?>

<span id="cont"></span>

<?php
include_once('./admin.tail.php');

flush();
ob_flush();

$ma_id = isset($_POST['ma_id']) ? (int) $_POST['ma_id'] : 0;
$select_member_list = isset($_POST['ma_list']) ? trim($_POST['ma_list']) : '';

//print_r2($_POST); EXIT;
$member_list = explode("\n", conv_unescape_nl($select_member_list));

// 메일내용 가져오기
$sql = "select ma_subject, ma_content from {$g5['mail_table']} where ma_id = '$ma_id' ";
$ma = sql_fetch($sql);

$subject = $ma['ma_subject'];

$cnt = 0;
for ($i=0; $i<count($member_list); $i++)
{
    list($to_email, $mb_id, $name, $nick, $datetime) = explode("||", trim($member_list[$i]));

    $sw = preg_match("/[0-9a-zA-Z_]+(\.[0-9a-zA-Z_]+)*@[0-9a-zA-Z_]+(\.[0-9a-zA-Z_]+)*/", $to_email);
    // 올바른 메일 주소만
    if ($sw == true)
    {
        $cnt++;

        $mb_md5 = md5($mb_id.$to_email.$datetime);

        $content = $ma['ma_content'];
        $content = preg_replace("/{이름}/", $name, $content);
        $content = preg_replace("/{닉네임}/", $nick, $content);
        $content = preg_replace("/{회원아이디}/", $mb_id, $content);
        $content = preg_replace("/{이메일}/", $to_email, $content);

        if($subject == "메일미인증 가입자 안내"){
            $sql = " select mb_id, mb_email_certify2 from {$g5['member_table']} where mb_id = '{$mb_id}' ";
            $row = sql_fetch($sql);
            $content = $content . "<div style='margin:30px auto;width:600px;border:10px solid #f7f7f7'><div style='border:1px solid #dedede'><h1 style='padding:30px 30px 0;background:#f7f7f7;color:#555;font-size:1.4em'>회원 인증 메일입니다.</h1><span style='display:block;padding:10px 30px 30px;background:#f7f7f7;text-align:right'><a href='https://icorps.or.kr' target='_blank' data-saferedirecturl='https://www.google.com/url?q=https://icorps.or.kr&amp;source=gmail&amp;ust=1655356259464000&amp;usg=AOvVaw3zSQtZTCHVF3TRT1BnTE2g'>실험실창업탐색교육</a></span><p style='margin:20px 0 0;padding:30px 30px 50px;min-height:200px;height:auto!important;height:200px;border-bottom:1px solid #eee'>아래의 주소를 클릭하시면 인증이 완료됩니다.<br><a href='https://icorps.or.kr/bbs/email_certify.php?mb_id=".$row['mb_id']."&amp;mb_md5=".$row['mb_email_certify2']."' target='_blank' data-saferedirecturl='https://www.google.com/url?q=https://icorps.or.kr/bbs/email_certify.php?mb_id%3D".$row['mb_id']."%26mb_md5%3D".$row['mb_email_certify2']."&amp;source=gmail&amp;ust=1655356259464000&amp;usg=AOvVaw1BThWda5mn1aXOTcgGHdgF'><b>회원가입인증[클릭]</b></a><br><br>회원님의 성원에 보답하고자 더욱 더 열심히 하겠습니다.<br>감사합니다.</p><a href='https://icorps.or.kr/bbs/login.php' style='display:block;padding:30px 0;background:#484848;color:#fff;text-decoration:none;text-align:center' target='_blank' data-saferedirecturl='https://www.google.com/url?q=https://icorps.or.kr/bbs/login.php&amp;source=gmail&amp;ust=1655356259464000&amp;usg=AOvVaw0ca0EgzMOxfm5J96m5Bqux'>실험실창업탐색교육 로그인</a><div class='yj6qo'></div><div class='adL'></div></div><div class='adL'></div></div>";
        }

        $content = $content . "<hr size=0><p><span style='font-size:9pt; font-family:굴림'>▶ 더 이상 정보 수신을 원치 않으시면 [<a href='".G5_BBS_URL."/email_stop.php?mb_id={$mb_id}&amp;mb_md5={$mb_md5}' target='_blank'>수신거부</a>] 해 주십시오.</span></p>";

        

        

        mailer($config['cf_admin_email_name'], $config['cf_admin_email'], $to_email, $subject, $content, 1);

        echo "<script> document.all.cont.innerHTML += '$cnt. $to_email ($mb_id : $name)<br>'; </script>\n";
        //echo "+";
        flush();
        ob_flush();
        ob_end_flush();
        usleep($sleepsec);
        if ($cnt % $countgap == 0)
        {
            echo "<script> document.all.cont.innerHTML += '<br>'; document.body.scrollTop += 1000; </script>\n";
        }

        // 화면을 지운다... 부하를 줄임
        if ($cnt % $maxscreen == 0)
            echo "<script> document.all.cont.innerHTML = ''; document.body.scrollTop += 1000; </script>\n";
    }
}
?>
<script> document.all.cont.innerHTML += "<br><br>총 <?php echo number_format($cnt) ?>건 발송<br><br><font color=crimson><b>[끝]</b></font>"; document.body.scrollTop += 1000; </script>
