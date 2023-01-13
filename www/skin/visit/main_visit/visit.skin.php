<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

global $is_admin;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$visit_skin_url.'/style.css">', 0);
?>

<!-- 접속자집계 시작 { -->
<span>TODAY</span><b><?php echo number_format($visit[1]) ?></b>
<span>TOTAL</span><b><?php echo number_format($visit[4] + 783426) ?></b>
<!-- } 접속자집계 끝 -->