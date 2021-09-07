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
		<span><mark><a href="/bbs/register_form.php" class="sct_here ">회원가입</a></mark></span>
	</div>
</div>

<!-- 회원가입결과 시작 { -->
<div class="c_area registerform">
	<div class="wrap small">
		<div class="ca_result">
			<?php
			if ( !$mb['mb_id'] ) {
			?>
			<!-- 상담사 회원일 때 -->
			<h2><strong>상담사 신청</strong>이 완료되었습니다.</h2>
			<p>
			  관리자가 승인 후 이용이 가능합니다.
			</p>
			<?php
			}
			else {
			?>
			<!-- 일반 회원일 때 -->
			<h2><strong>회원가입</strong>이 완료되었습니다.</h2>
			<p>
				로그인 후 신선운세의 다양한 컨텐츠를 만나보세요.
			</p>
			<?php
			}
			?>

			<?php if (is_use_email_certify()) {  ?>
			<p>
				회원 가입 시 입력하신 이메일 주소로 인증메일이 발송되었습니다.<br>
				발송된 인증메일을 확인하신 후 인증처리를 하시면 사이트를 원활하게 이용하실 수 있습니다.
			</p>
			<div id="result_email">
				<span>아이디</span>
				<strong><?php echo $mb['mb_id'] ?></strong><br>
				<span>이메일 주소</span>
				<strong><?php echo $mb['mb_email'] ?></strong>
			</div>
			<p>
				이메일 주소를 잘못 입력하셨다면, 사이트 관리자에게 문의해주시기 바랍니다.
			</p>
			<?php }  ?>

			<?php
			if ( !$mb['mb_id'] ) {
			?>
			<!-- 상담사 회원일 때 -->
			<a href="<?php echo G5_URL ?>/" class="car_btn">홈으로 이동하기</a>
			<?php
			}
			else {
			?>
			<!-- 일반 회원일 때 -->
			<!-- <a href="/bbs/login.php" class="btn_submit">로그인</a> -->
			<a href="<?php echo G5_URL ?>/" class="car_btn">홈으로 이동하기</a>
			<?php
			}
			?>
		</div>
	</div>
</div>
<!-- } 회원가입결과 끝 -->
<!-- NAVER SCRIPT -->
<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
<script type="text/javascript">
var _nasa={};
_nasa["cnv"] = wcs.cnv("2","1");
</script>
<!-- NAVER SCRIPT END -->