<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 회원정보 찾기 시작 { -->
<div id="find_info" class="w_popup login">
    <h1 class="wp_title text big bold cb">회원정보 찾기</h1>
    <div class="wp_body">
        <form name="fpasswordlost" action="<?php echo $action_url ?>" onsubmit="return fpasswordlost_submit(this);" method="post" autocomplete="off">
        <fieldset class="wpb_wrap">
            <p class="text middle cg">
                회원가입 시 등록하신 이메일 주소를 입력해 주세요.<br>
                해당 이메일로 아이디와 비밀번호 정보를 보내드립니다.
            </p>
            <label for="mb_email" class="sound_only">E-mail 주소<strong class="sound_only">필수</strong></label>
            <input type="text" name="mb_email" id="mb_email" required class="required wpb_email input" placeholder="E-mail 주소">
        </fieldset>
        <?php echo captcha_html();  ?>
        <input type="submit" value="확인" class="btn t1 fr">

    </div>
    <button type="button" onclick="window.close();" class="wp_btn"><span class="blind">창닫기</span></button>

    </form>
</div>

<script>
function fpasswordlost_submit(f)
{
    <?php echo chk_captcha_js(); ?>

    return true;
}

$(function() {
    var sw = screen.width;
    var sh = screen.height;
    var cw = document.body.clientWidth;
    var ch = document.body.clientHeight;
    var top  = sh / 2 - ch / 2 - 100;
    var left = sw / 2 - cw / 2;
    moveTo(left, top);
});
</script>
