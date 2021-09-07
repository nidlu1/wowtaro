<?php
$sub_menu = '100700';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "w");

$html_title = "결제상품";
$g5['title'] = $html_title.' 관리';

if ($w == "u")
{
    $html_title .= " 수정";
    $readonly = " readonly";

    $sql = " select * from {$g5['pay_table']} where pa_no = '$pa_no' ";
    $co = sql_fetch($sql);
    if (!$co['pa_no'])
        alert('등록된 자료가 없습니다.');
}
else
{
    $html_title .= ' 입력';
}

include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="frmpayform" action="./payformupdate.php" onsubmit="return frmpayform_check(this);" method="post" enctype="MULTIPART/FORM-DATA" >
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="pa_no" value="<?php echo $co['pa_no']; ?>">
<input type="hidden" name="token" value="">

<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row"><label for="pa_mungu">문구</label></th>
        <td><input type="text" name="pa_mungu" value="<?php echo $co['pa_mungu']; ?>" id="pa_mungu" required class="frm_input required" size="90"></td>
    </tr>
    <tr>
        <th scope="row"><label for="pa_amt">충전금액</label></th>
        <td><input type="text" name="pa_amt" value="<?php echo $co['pa_amt']; ?>" id="pa_amt" required class="frm_input required" size="90"></td>
    </tr>
	<tr>
        <th scope="row"><label for="pa_time">충전시간(분)</label></th>
        <td><input type="text" name="pa_time" value="<?php echo ( $co['pa_time'] / 60 ); ?>" id="pa_time" required class="frm_input required" size="90"></td>
    </tr>
    </tr>
    <tr>
        <th scope="row"><label for="pa_point">적립 코인</label></th>
        <td><input type="text" name="pa_point" value="<?php echo ( $co['pa_point']); ?>" id="pa_time" required class="frm_input required" size="90"></td>
    </tr>
    <tr>
        <th scope="row"><label for="pa_use">사용여부</label></th>
        <td>
            <select id="pa_use" name="pa_use">
                    <option value="1" <?php echo $co['pa_use'] == 1 ? "selected" : ""; ?>>사용</option>
                    <option value="0" <?php echo $co['pa_use'] == 0 ? "selected" : ""; ?>>미사용</option>
            </select>
        </td>
    </tr>
    

    </tbody>
    </table>
    
</div>

<div class="btn_fixed_top">
    <a href="./paylist.php" class="btn btn_02">목록</a>
    <input type="submit" value="확인" class="btn btn_submit" accesskey="s">
</div>

</form>

<?php
// [KVE-2018-2089] 취약점 으로 인해 파일 경로 수정시에만 자동등록방지 코드 사용
?>
<script>
var captcha_chk = false;

function use_captcha_check(){
    $.ajax({
        type: "POST",
        url: g5_admin_url+"/ajax.use_captcha.php",
        data: { admin_use_captcha: "1" },
        cache: false,
        async: false,
        dataType: "json",
        success: function(data) {
        }
    });
}

function frm_check_file(){
    var co_include_head = "<?php echo $co['co_include_head']; ?>";
    var co_include_tail = "<?php echo $co['co_include_tail']; ?>";
    var head = jQuery.trim(jQuery("#co_include_head").val());
    var tail = jQuery.trim(jQuery("#co_include_tail").val());

    if(co_include_head !== head || co_include_tail !== tail){
        // 캡챠를 사용합니다.
        jQuery("#admin_captcha_box").show();
        captcha_chk = true;

        use_captcha_check();

        return false;
    } else {
        jQuery("#admin_captcha_box").hide();
    }

    return true;
}
/*
jQuery(function($){
    if( window.self !== window.top ){   // frame 또는 iframe을 사용할 경우 체크
        $("#co_include_head, #co_include_tail").on("change paste keyup", function(e) {
            frm_check_file();
        });

        use_captcha_check();
    }
});
*/
function frmpayform_check(f)
{
    errmsg = "";
    errfld = "";
/*
    <?php echo get_editor_js('co_pay'); ?>
    <?php echo chk_editor_js('co_pay'); ?>
    <?php echo get_editor_js('co_mobile_pay'); ?>
*/
    //check_field(f.pa_no, "ID를 입력하세요.");
    check_field(f.ht_name, "제목을 입력하세요.");
    //check_field(f.co_pay, "내용을 입력하세요.");

    if (errmsg != "") {
        alert(errmsg);
        errfld.focus();
        return false;
    }
/*
    if( captcha_chk ) {
        <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>
    }
*/
    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
