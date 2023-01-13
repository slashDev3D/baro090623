<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (!$board['bo_use_sns']) return;

$sns_msg = urlencode(str_replace('\"', '"', $list[$i]['subject']));
//$sns_url = googl_short_url('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
//$msg_url = $sns_msg.' : '.$sns_url;

/*
$facebook_url  = 'http://www.facebook.com/sharer/sharer.php?s=100&p[url]='.$sns_url.'&p[title]='.$sns_msg;
$twitter_url   = 'http://twitter.com/home?status='.$msg_url;
$gplus_url     = 'https://plus.google.com/share?url='.$sns_url;
*/

$sns_send  = G5_BBS_URL.'/sns_send.php?longurl='.urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'&wr_id='.$list[$i]['wr_id']);
$board_send = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'&wr_id='.$list[$i]['wr_id']);

//$sns_send .= '&amp;title='.urlencode(utf8_strcut(get_text($list[$i]['subject']),140));
$sns_send .= '&amp;title='.$sns_msg;

$facebook_url = $sns_send.'&amp;sns=facebook';
$twitter_url  = $sns_send.'&amp;sns=twitter';
$gplus_url    = $sns_send.'&amp;sns=gplus';
$bo_v_sns_class = $config['cf_kakao_js_apikey'] ? 'show_kakao' : '';
?>

<?php if($config['cf_kakao_js_apikey']) { ?>
<script src="//developers.kakao.com/sdk/js/kakao.min.js" charset="utf-8"></script>
<script src="<?php echo G5_JS_URL; ?>/kakaolink.js" charset="utf-8"></script>
<script type='text/javascript'>
    //<![CDATA[
        // 사용할 앱의 Javascript 키를 설정해 주세요.
        Kakao.init("<?php echo $config['cf_kakao_js_apikey']; ?>");

        function Kakao_sendLink() {
            var webUrl = location.protocol+"<?php echo '//'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'&wr_id='.$list[$i]['wr_id']; ?>",
                imageUrl = $("#bo_v_img").find("img").attr("src") || $(".view_image").find("img").attr("src") || '';

            Kakao.Link.sendDefault({
                objectType: 'feed',
                content: {
                    title: "<?php echo str_replace(array('%27', '&#034;' , '\"'), '', strip_tags($list[$i]['subject'])); ?>",
                    description: "<?php echo preg_replace('/\r\n|\r|\n/','', strip_tags(get_text(cut_str(strip_tags($list[$i]['wr_content']), 200), 1))); ?>",
                    imageUrl: imageUrl,
                    link: {
                        mobileWebUrl: webUrl,
                        webUrl: webUrl
                    }
                },
                buttons: [{
                    title: '자세히 보기',
                    link: {
                        mobileWebUrl: webUrl,
                        webUrl: webUrl
                    }
                }]
            });
        }
    //]]>

  
    
</script>
<?php } ?>
<!--
    <li><a href="<?php echo $facebook_url; ?>" target="_blank" class=""><div class="i"><img src="<?php echo G5_SNS_URL; ?>/icon/facebook.png" alt="페이스북으로 공유" width="20"></div><span>페이스북 공유</span></a></li>
    <li><a href="<?php echo $twitter_url; ?>" target="_blank" class=""><div class="i"><img src="<?php echo G5_SNS_URL; ?>/icon/twitter.png" alt="트위터로  공유" width="20"></div><span>트위터 공유</span></a></li>
-->

<?php if($config['cf_kakao_js_apikey']) { ?><div><a href="javascript:Kakao_sendLink();" class="" ><i class="fa fa-commenting" aria-hidden="true"></i><span>카카오톡 공유</span></a></div><?php } ?>
<div class="clipBtn eng" onclick="copyToClipboard('#p1_<?php echo $list[$i]['wr_3'] ?>')"><i class="fa fa-files-o" aria-hidden="true"></i> 주소복사<span id="p1_<?php echo $list[$i]['wr_3'] ?>" class="p1_url"><?php echo $list[$i]['href'] ?></span></div>
<script>
                            function copyToClipboard(element) {
                                var $temp = $("<input>");
                                $("body").append($temp);
                                $temp.val($(element).text()).select();
                                document.execCommand("copy");
                                $temp.remove();
                                alert("영상주소가 복사되었습니다."); //Optional Alert, 삭제해도 됨
                            }
                        </script>