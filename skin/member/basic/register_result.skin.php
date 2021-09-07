<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 상담사 회원일 때 -->
<!-- <div class="sub_banner">
  <h2>상담사회원 가입</h2>
</div> -->
<!-- 일반 회원일 때 -->
<div class="sub_banner" id="sub_join">
  <h2>일반회원 가입</h2>
</div>

<!-- 회원가입결과 시작 { -->
<div class="inner">
<div id="reg_result">
	<?php
	if ( !$mb['mb_id'] ) {
	?>
    <!-- 상담사 회원일 때 -->
    <h2><strong>상담사 신청</strong>이 완료되었습니다.</h2>
    <p class="reg_result_p">
      관리자가 승인 후 이용이 가능합니다.
    </p>
	<?php
	}
	else {
	?>
    <!-- 일반 회원일 때 -->
    <h2><strong>회원가입</strong>이 완료되었습니다.</h2>
    <p class="reg_result_p">
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
	<a href="<?php echo G5_URL ?>/" class="btn_submit">홈으로 이동하기</a>
	<?php
	}
	else {
	?>
	<!-- 일반 회원일 때 -->
	<!-- <a href="/bbs/login.php" class="btn_submit">로그인</a> -->
  <a href="<?php echo G5_URL ?>/" class="btn_submit">홈으로 이동하기</a>
	<?php
	}
	?>
</div>
</div>
<!-- } 회원가입결과 끝 -->

<!-- Tracking Script Start 2.0 -->
<script type="text/javascript" async="true">
var dspu = "LI9c2luc2VvbnVuc2U";      // === (필수)광고주key (변경하지마세요) ===

var dspt = "2";         // === (필수)전환구분( 2:기타구분 ) (변경하지마세요)  === 
var dspo = "<?php echo $mb['mb_id'] ?>";          // === (선택)구문번호( 미입력시 - 중복체크 안함. ) ===

var dspu,dspt,dspo,dspom; 
function loadanalJS_dsp(b,c){var d=document.getElementsByTagName("head")[0],a=document.createElement("sc"+"ript");a.type="text/javasc"+"ript";null!=c&&(a.charset="UTF-8");
a.src=b;a.async="true";d.appendChild(a)}function loadanal_dsp(b){loadanalJS_dsp(("https:"==document.location.protocol?"https://":"http://")+b,"UTF-8");document.write("<span id=dsp_spn style=display:none;></span>");}
loadanal_dsp("tk.realclick.co.kr/tk_comm.js?dspu="+dspu+"&dspt="+dspt+"&dspo="+dspo+"&dspom="+dspom);
</script>
<!-- Tracking Script End 2.0 -->

<!-- NAVER SCRIPT -->
<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
<script type="text/javascript">
var _nasa={};
_nasa["cnv"] = wcs.cnv("2","1");
</script>
<!-- NAVER SCRIPT END -->