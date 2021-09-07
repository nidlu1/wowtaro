<?php
$sub_menu = '100600';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "w");

$html_title = "추천해시태그";
$g5['title'] = $html_title.' 관리';

if ($w == "u")
{
    $html_title .= " 수정";
    $readonly = " readonly";

    $sql = " select * from {$g5['recommhash_table']} where ht_no = '$ht_no' ";
    $co = sql_fetch($sql);
    if (!$co['ht_no'])
        alert('등록된 자료가 없습니다.');
}
else
{
    $html_title .= ' 입력';
}

include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="frmhashtagform" action="./recommhashformupdate.php" onsubmit="return frmhashtagform_check(this);" method="post" enctype="MULTIPART/FORM-DATA" >
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="ht_no" value="<?php echo $co['ht_no']; ?>">
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
        <th scope="row"><label for="ht_name">추천해시태그</label></th>
        <td><input type="text" name="ht_name" value="<?php echo htmlspecialchars2($co['ht_name']); ?>" id="ht_name" required class="frm_input required" size="90"></td>
    </tr>
	<tr>
        <th scope="row"><label for="ht_link">링크주소</label></th>
        <td><input type="text" name="ht_link" value="<?php echo htmlspecialchars2($co['ht_link']); ?>" id="ht_link" required class="frm_input required" size="90"></td>
    </tr>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <a href="./recommhashlist.php" class="btn btn_02">목록</a>
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
function frmhashtagform_check(f)
{
    errmsg = "";
    errfld = "";
/*
    <?php echo get_editor_js('co_hashtag'); ?>
    <?php echo chk_editor_js('co_hashtag'); ?>
    <?php echo get_editor_js('co_mobile_hashtag'); ?>
*/
    //check_field(f.ht_no, "ID를 입력하세요.");
    check_field(f.ht_name, "추천해시태그를 입력하세요.");
    check_field(f.ht_link, "링크주소를 입력하세요.");

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
