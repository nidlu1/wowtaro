<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 회원정보 찾기 시작 { -->
<div id="find_info" class="w_popup login">
	<h1 class="wp_title text big bold cb">회원정보 찾기</h1>
	<div class="wp_body">
	<?php
	if ( $hp ) {
		echo " <p class='text middle cg'>회원님의 아이디는 '".$mb['mb_id']."' 입니다.</p>";
	}
	else {
	?>
        <form name="fpasswordlost" action="<?php echo $action_url ?>" onsubmit="return fpasswordlost_submit(this);" method="post" autocomplete="off">
        <fieldset class="wpb_wrap">
             <p class="text middle cg">
				회원가입 시 등록하신 핸드폰 번호를 입력해 주세요.
            </p>
            <label for="hp" class="sound_only">핸드폰 번호<strong class="sound_only">필수</strong></label>
            <input type="text" name="hp" id="hp" required class="required wpb_phone input" placeholder="ex) 010-123-4567">
        </fieldset>
        <?php echo captcha_html();  ?>
        <input type="submit" value="확인" class="btn t1 fr">
    </form>
	<?php
	}
	?>
	</div>
	<button type="button" onclick="window.close();" class="wp_btn"><span class="blind">창닫기</span></button>
</div>

<script>
function fpasswordlost_submit(f)
{
    <?php echo chk_captcha_js();  ?>

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
<!-- } 회원정보 찾기 끝 -->