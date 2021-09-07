<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 회원정보 찾기 시작 { -->
<div id="find_info" class="new_win">
    <h1 id="win_title">회원정보 찾기</h1>
    <div class="new_win_con">
	<?php
	if ( $hp ) {
		echo "<p>회원님의 아이디는 '".$mb['mb_id']."' 입니다.</p>";
	}
	else {
	?>
        <form name="fpasswordlost" action="<?php echo $action_url ?>" onsubmit="return fpasswordlost_submit(this);" method="post" autocomplete="off">
        <fieldset id="info_fs">
            <p>
				회원가입 시 등록하신 핸드폰 번호를 입력해 주세요.
            </p>
            <label for="hp" class="sound_only">핸드폰 번호<strong class="sound_only">필수</strong></label>
            <input type="text" name="hp" id="hp" required class="required frm_input full_input" size="30" placeholder="핸드폰 번호">
        </fieldset>
        <?php echo captcha_html();  ?>
        <input type="submit" value="확인" class="btn_submit">

    </div>
    <button type="button" onclick="window.close();" class="btn_close">창닫기</button>

    </form>
	<?php
	}
	?>
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