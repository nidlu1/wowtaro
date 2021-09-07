<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 회원 비밀번호 확인 시작 { -->
<div id="confirm">
	<div class="c_content">
		<h1><?php echo $g5['title'] ?></h1>

		<p class="cc_txt">
			<span><strong>비밀번호를 한번 더 입력해주세요.</strong></span>
			<?php if ($url == 'member_leave.php') { ?>
			<span>비밀번호를 입력하시면 회원탈퇴가 완료됩니다.</span>
			<?php }else{ ?>
			<span>회원님의 정보를 안전하게 보호하기 위해 비밀번호를 한번 더 확인합니다.</span>
			<?php }  ?>
		</p>
		<p class="blind">
			회원 탈퇴시, 동일한 이메일 주소와 전화번호로 가입이 불가능하며 보유한 포인트가 모조리 삭제됩니다.
		</p>

		<form name="fmemberconfirm" action="<?php echo $url ?>" onsubmit="return fmemberconfirm_submit(this);" method="post">
		<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'] ?>">
		<input type="hidden" name="w" value="u">

		<fieldset>
			<p class="cc_info">
				<span>회원아이디</span>
				<span><mark><?php echo $member['mb_id'] ?></mark></span>
			</p>
			<label for="confirm_mb_password" class="sound_only" placeholder="비밀번호">비밀번호<strong>필수</strong></label>
			<input type="password" name="mb_password" id="confirm_mb_password" required class="required input" maxLength="20" placeholder="비밀번호">
			<input type="submit" value="확인" id="btn_submit" class="cc_btn">
		</fieldset>

		</form>
	</div>
</div>

<script>
function fmemberconfirm_submit(f)
{
    document.getElementById("btn_submit").disabled = true;

    return true;
}
</script>
<!-- } 회원 비밀번호 확인 끝 -->