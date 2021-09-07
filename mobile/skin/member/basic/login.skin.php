<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<div class="c_hero">
	<strong>신선운세 <mark>로그인</mark></strong>
</div>
<div class="c_list">
	<div class="cl_menu">
		<a href='<?php echo G5_URL; ?>/'><i></i><span class="blind">HOME</span></a>
		<span>신선운세</span>
		<span><mark><a href="/bbs/login.php" class="sct_here ">로그인</a></mark></span>
	</div>
</div>
<div class="c_area login"> 
<!-- 로그인 시작 { -->
	<div class="ca_login">
		<h1 class="blind"><?php echo $g5['title'] ?></h1>

		<form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
		<input type="hidden" name="url" value="<?php echo $login_url ?>">

		<fieldset id="cal_fs">
			<legend>회원로그인</legend>
			<label for="login_id" class="sound_only">회원아이디<strong class="sound_only"> 필수</strong></label>
			<input type="text" name="mb_id" id="login_id" required class="cal_input input required" size="14" placeholder="이메일 형식의 아이디를 입력해 주세요">
			<label for="login_pw" class="sound_only">비밀번호<strong class="sound_only"> 필수</strong></label>
			<input type="password" name="mb_password" id="login_pw" required class="cal_input input required" size="14" maxLength="20" placeholder="비밀번호를 입력해 주세요">
			<div class="button_wrap">
				<input type="submit" value="로그인" class="cal_btn login">
				<a href="./register.php"  class="cal_btn join">회원가입</a>
			</div>
		</fieldset>

		<?php
		// 소셜로그인 사용시 소셜로그인 버튼
		@include_once(get_social_skin_path().'/social_login.skin.php');
		?>

		<aside class="cal_info">
			<h2 class="blind">회원로그인 안내</h2>
			<div class="fl cali_check">
				<input type="checkbox" name="auto_login" class="c_check" id="login_auto_login" value="1" /><label for="login_auto_login"><i></i><span>자동로그인</span></label>
			</div>
			<div class="fr">
				<a href="<?php echo G5_BBS_URL ?>/id_lost.php" target="_blank" class="cali_id" id="login_password_lost">아이디 찾기</a>
				<a href="<?php echo G5_BBS_URL ?>/password_lost.php" target="_blank" class="cali_pw" id="login_password_lost">비밀번호 찾기</a>
			</div>
		</aside>
		</form>
	</div>
</div>

<script>
$(function()
    $("#login_auto_login").click(function(){
        if (this.checked) {
            this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
        }
    });
});

function flogin_submit(f)
{
    return true;
}
</script>
