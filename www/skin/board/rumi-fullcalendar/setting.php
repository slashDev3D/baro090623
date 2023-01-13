<?php
include_once('./_common.php');
include_once(G5_PATH.'/head.sub.php');

if (!$is_admin) {
    echo '<script type="text/javascript">parent.rumiPopup.close();</script>';
    exit;
}

include_once($board_skin_path.'/config.php');
//include_once($board_skin_path.'/carinfo.class.extend.php');

/* 옵션으로 사용될 배열 선언 */
$default_view_array = array(
    'dayGridMonth' => '월간',
    'dayGridWeek' => '주간',
    'dayGridDay' => '일간'
);
$display_types_array = array(
    'dayGridMonth' => '월간',
    'dayGridWeek' => '주간',
    'timeGridWeek' => '주간(시간)',
    'dayGridDay' => '일간',
    'timeGridDay' => '일간(시간)',
    'listDay' => '목록(일)',
    'listWeek' => '목록(주)',    
    'listMonth' => '목록(월)',
    'listYear' => '목록(년)'

);
$display_name_array = array(
    0 => '숨기기',
    1 => '표시'
);
$week_number_array = array(
    0 => '숨기기',
    1 => '표시'
);
$lang_array = array(
    'ko' => '한국어',
    'en' => '영어',
    'zh-cn' => '중국어(간체)',
    'zh-tw' => '중국어(번체)',
    'ja' => '일어',
    'vi' => '베트남어',
    'id' => '인도네시아어'
);
$list_array = array(
    'person' => '자신이 등록한 자료만 보기',
    'all' => '모든 자료 보기'
);

if (empty($board['bo_10'])) {
    $bo_10 = 'dayGridMonth|1|0|ko|dayGridMonth,dayGridWeek,dayGridDay|all';
    sql_query(" UPDATE `{$g5['board_table']}` SET bo_10 = 'dayGridMonth|1|0|ko|dayGridMonth,dayGridWeek,dayGridDay' WHERE bo_table = '{$bo_table}' ", FALSE);
    list($fc_default_view, $fc_display_name, $fc_weeks_number, $fc_lang, $fc_display_types, $fc_list) = explode("|", $bo_10);
}

add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/css/style.css?ver='.G5_CSS_VER.'">', 0);
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/css/fullcalendar.css?ver='.G5_CSS_VER.'">', 0);
$option = new form_option(); // Selectbox, Checkbox, Radiobutton Class
?>

<div id="scrap" class="new_win">
    <h1 id="win_title"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo $g5['title'] ?></h1>
    <div class="new_win_con">
        <form name="frm" id="frm" action="<?php echo $board_skin_url; ?>/setting_update.php" method="post" enctype="multipart/form-data" onsubmit="return getAction(document.forms.frm);">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table;?>" />
            <div class="wz_tbl_1">

                <div style="text-align:left;padding:0 0 10px;"><h3>기본설정</h3></div>
                <table>
                <tbody>
                <tr>
                    <th>기본보기설정<span class="sound_only">필수</span></th>
                    <td><?php
                        $option->var_mode("A", $default_view_array);
                        echo $option->Radio('', 'fc_default_view', 'fc_default_view', 'fc_default_view', $fc_default_view);
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>화면버튼종류<span class="sound_only">필수</span></th>
                    <td><?php
                        $option->var_mode("A", $display_types_array);
                        echo $option->Checkbox('', 'fc_display_types', 'fc_display_types', 'fc_display_types', $fc_display_types);
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>작성자명노출<span class="sound_only">필수</span></th>
                    <td><?php
                        $option->var_mode("A", $display_name_array);
                        echo $option->Radio('', 'fc_display_name', 'fc_display_name', 'fc_display_name', $fc_display_name);
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>주차표시<span class="sound_only">필수</span></th>
                    <td><?php
                        $option->var_mode("A", $week_number_array);
                        echo $option->Radio('', 'fc_weeks_number', 'fc_weeks_number', 'fc_weeks_number', $fc_weeks_number);
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>언어설정<span class="sound_only">필수</span></th>
                    <td><?php
                        $option->var_mode("A", $lang_array);
                        echo $option->Select('', 'fc_lang', 'fc_lang', 'fc_lang', $fc_lang);
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>일정목록<span class="sound_only">필수</span></th>
                    <td><?php
                        $option->var_mode("A", $list_array);
                        echo $option->Select('', 'fc_list', 'fc_list', 'fc_list', $fc_list);
                        ?>
                    </td>
                </tr>
                </table>
            </div>
            <div style="display:none;">
                <input type="submit" value="저장하기" id="btn_submit" class="btn_submit" style="float:none">
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    
    $(document).on('click', '.add-tr', function() {
        $('.empty').remove();
        tbl_tr_add();
    });
    
    $(document).on('click', '.del-tr', function() {
        var wrr_id = $(this).attr('data-wrr-id');
        if (wrr_id) {
            $('#frm').prepend('<input type="hidden" name="wrr_id[]" value="'+wrr_id+'">');
        }

        $(this).closest('tr').remove();
        var tr_cnt = $('#wrap-tbl-color tbody tr').length;
        if (tr_cnt == 0) {
            $('#wrap-tbl-color').append('<tr class="empty"><td colspan="3">추가버튼을 클릭하여 색상을 등록해주세요.</td></tr>');
        }
    });
});

function tbl_tr_add() {
    var tbl_tr_html = '';
        tbl_tr_html += '<tr>';
        tbl_tr_html += '    <td><input type="text" name="wrr_color_bg[]" value="#ffffff" id="wrr_color_bg" class="frm_input jscolor {hash:true}" size="8"></td>';
        tbl_tr_html += '    <td><input type="text" name="wrr_color_tx[]" value="#919191" id="wrr_color_tx" class="frm_input jscolor {hash:true}" size="8"></td>';
        tbl_tr_html += '    <td style="text-align:center;"><a href="#none" class="btn-set del-tr">삭제</a></td>';
        tbl_tr_html += '</tr>';

    $('#wrap-tbl-color').append(tbl_tr_html);
    jscolor.installByClassName("jscolor");
}
</script>

<?php
include_once(G5_PATH.'/tail.sub.php');
?>

