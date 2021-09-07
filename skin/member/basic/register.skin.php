<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div class="c_hero">
	<strong>신선운세 <mark>회원가입</mark></strong>
</div>
<div class="c_list">
	<div class="cl_menu">
		<a href='<?php echo G5_URL; ?>/'><i></i><span class="blind">HOME</span></a>
		<span>신선운세</span>
		<span><mark><a href="/bbs/register.php" class="sct_here ">회원가입</a></mark></span>
	</div>
</div>
<!-- 회원가입약관 동의 시작 { -->
<div class="wrap small">
	<div class="c_area">
    <?php
    // 소셜로그인 사용시 소셜로그인 버튼
    //@include_once(get_social_skin_path().'/social_register.skin.php');
    ?>
		<form name="ca_register" id="ca_register" class="ca_register" action="<?php echo $register_action_url ?>" onsubmit="return ca_register_submit(this);" method="POST" autocomplete="off">
			<div class="ca_checkall">
				<input type="checkbox" name="chk_all"  value="1" id="cac_all" class="radio">
				<i class="ca_i"></i>
				<label for="cac_all">
					<strong>모든 약관에 동의합니다.</strong>
					<p>이용약관 및 개인정보처리방침 내용에 동의하셔야 회원가입 하실 수 있습니다.</p>
				</label>
			</div>
			<section class="ca_wrap term">
				<h2 class="blind">회원가입약관</h2>
				<fieldset class="fieldset_agree">
					<input type="checkbox" name="agree" value="1" id="agree11" class="radio">
					<i class="ca_i"></i>
					<label for="agree11">신선운세 이용약관에 동의합니다.</label>
				</fieldset>
				<div class="ca_content">
					<textarea readonly><?php echo get_text($config['cf_stipulation']) ?></textarea>
				</div>
			</section>
			<section class="ca_wrap private">
				<fieldset class="fieldset_agree">
					<input type="checkbox" name="agree2" value="1" id="agree21" class="radio">
					<i class="ca_i"></i>
					<label for="agree21">개인정보처리방침에 동의합니다.</label>
				</fieldset>
				<h2 class="blind">개인정보처리방침안내</h2>
				<div class="ca_content">
					<table>
						<caption class="blind">개인정보처리방침안내</caption>
						<thead>
						<tr>
							<th>목적</th>
							<th>항목</th>
							<th>보유기간</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>이용자 식별 및 본인여부 확인</td>
							<td>아이디, 이름, 비밀번호</td>
							<td>회원 탈퇴 시까지</td>
						</tr>
						<tr>
							<td>고객서비스 이용에 관한 통지,<br>CS대응을 위한 이용자 식별</td>
							<td>연락처 (이메일, 전화번호)</td>
							<td>회원 탈퇴 시까지</td>
						</tr>
						</tbody>
					</table>
					<span><mark>-</mark>휴대폰 본인확인 시 타인 명의를 도용할 경우, "정보통신망법 제 49조"에 의거하여 5년 이하의 징역 또는 5천만원 이하의 벌금에 처할 수 있습니다.</span>
				</div>
			</section>
			<div class="ca_submit">
				<input type="submit" value="회원가입">
			</div>
		</form>
	</div>
	<script>
	function ca_register_submit(f)
	{
		if (!f.agree.checked) {
			alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
			f.agree.focus();
			return false;
		}

		if (!f.agree2.checked) {
			alert("개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
			f.agree2.focus();
			return false;
		}

		return true;
	}
	jQuery(function($){
		// 모두선택
		$("input[name=chk_all]").click(function() {
			if ($(this).prop('checked')) {
				$("input[name^=agree]").prop('checked', true);
			} else {
				$("input[name^=agree]").prop("checked", false);
			}
		});
	});

	</script>
</div>
<!-- } 회원가입 약관 동의 끝 -->
