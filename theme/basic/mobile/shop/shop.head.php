<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
?>
<?php
if ( $member['mb_level'] == "3" && $member['mb_cert'] == "0000-00-00 00:00:00" ) {
?>
<!-- 상담사 회원 최초 로그인 시 -->
<div class="layer_pop" id="layer_contract" style="display:none;">
  <div class="layer_pop_container">
    <div class="pop_header">
      <h3>계약내용 확인</h3>
    </div>
    <div class="pop_body">
      <div class="pop_content">
        <div class="counseler_pop_content">
          <div class="head_title">
            본계약은 인천 부평구 동수로120번길43 205동 101호에 거주하는
            (이하 ‘을’ 이라한다) 와 인천 본사를 두고 있는-와우엔터테인먼트-
            (이하 ‘갑’ 이라한다.)간에 년 월 일에 계약 체결되었다.
            또는 (홈페이지에 등록할 때 기준으로함)
          </div>
          <h4 class="text-center">서 문</h4>
          <p>
            갑은 현재 부가통신사업법 및 동법 시행령에 의하여, 운세 관련 실시간 타로, 역학, 무속,꿈 해몽 기타 전문상담 선생님 전문가와 1:1 전화상담 사업을 유료로 제공하는 통신 서비스를 진행하고 있다.
          </p>
          <p>
            갑은 본건의 운세상담 전문가 1:1 전화상담 서비스 관련하여 갑의 고객에게 전화상담을 제공하기로 하고, 갑은 을에게 발생하는 정보이용료의 일정부분을 보수로 지급하기로 한다.
          </p>
          <p>
            이에 갑과 을은 다음과 같이 합의한다.
          </p>

          <h4 class="text-center">다  음</h4>
          <h5>제1조 계약의 목적</h5>
          <p>을은 갑이 와우엔터테인먼트 에 관련한 상담서비스를 진행함에 있어 갑의 서비스와 경쟁하는 다른 서비스 업체의 사업에 갑의 동의 없이 참여는 가능하나 와우엔터테인먼트 에 관련된 초상권 및 이미지등록 을 할 수 없다.</p>


          <h5>제2조 을의 의무</h5>
          <p>(1) 을은 갑이 와우엔터테인먼트 에 관련한 상담서비스를 진행함에 있어 갑의 서비스와 경쟁하는 다른 서비스 업체의 사업에 갑의 동의 없이 참여는 가능하나
          와우엔터테인먼트 에 관련된 초상권 및 이미지등록을 할 수 없다.</p>

          <P>(2) 을은 갑이 진행하는 와우엔터테인먼트 전화상담 서비스의 안정적 운영을 위해 자체적으로 전화 상담을 할 수 있는 공간을 확보하여야 하며, 서비스시간은 별첨에 준한다.</p>

          <P>(3) 을의 상담은 전화로만 끝내야 하며 비록 고객이 원한다 할 지라도 절대 개인 연락처를 고객에게 알려 주어서는 아니 되며 개인적의 용도로 이용해서도 아니된다.</p>

          <P>(4) 을은 어떠한 이유로든 상담요금 이외의 금액을 고객에게 요구할 수 없다.</p>

          <h5>제3조 갑의 의무</h5>
          <p>(1) 갑은 을에게 와우엔터테인먼트 회선을 통하여 상담한 통화에 회수비율 기준 분당 416.6원을 지급하여야 한다. (상담료 별첨 첨부) </p>
          <p>(2) 정산은 갑의 매출 발생월 익월 초 매달 5일에 이루어지는 것으로 한다.(정산일에 국가가 정한 휴일이 있을시 3일 뒤에 지급하는 것으로 한다.) <p>

          <h5>제4조 계약기간</h5>
          본 계약의 기간은 체결일로부터 1년간으로 하되 상호 협의 하에 기간을 연장하거나 파기 할 수 있다. 계약 종료 1개월 전에 상호간 다른 언급이 없는 한, 1년 단위로 연장되는 걸로 명시 한다.<br>
          다만 본 계약 기간 중 발생한 채권, 채무관계에 대하여는 본 계약기간이 적용되지 않는다.


          <h5>제5조 와우엔터테인먼트 상담 서비스 운영 및 내용</h5>
          <p>(1) 갑은 상담내용을 제공하는 타로상담 선생님 , 역학 등 상담 선생님등이 운세 및 타로상담 외에 불건전한 정보 음란성 내용을 제공하지 않도록 관리하여야 하며, 이용자의 항의로 인한 모든 피해는 ‘을’이 책임지도록 한다.</p>
          <p>(2) 2조2항에서의 합의한 시간준수가 이루어지지 않아 발생하는 매출 손실의 경우 본 계약을 해제할 수 있다.하루 평균(10회 이하) 한달기준(40회 미만)</p>

          <p>(3) 2조4항에서 명시된 내용을 위반하였을 시에는 고객의 환불요구 여부와 상관없이 고객이 을에게 지불한 금액을 을에게 지급될 상담료에서 제하여 고객에게 환불하는 것으로 한다. 또한 환불금액이 지급 될 상담료보다 초과 시 환불료에 대한 초과금액은 을에게 청구한다.</p>

          <p>(4)을은 갑이 제공하는 운세 상담서비스를 진행함에 있어서 욕설을 포함한 상스러운 언행 및 상담자에게 정신적인 충격을 줄 수 있는 내용(죽음)을 언급하여 상담자가 갑에게 신고하는 경우 갑은 을의 동의 없이 즉각적으로 회선을 중단하고 서비스 개선을 요구할 수 있다.<br>
          또한 그 행위가 와우엔터테인먼트 에 큰 이미지손상을 줬다고 판단될 경우 갑(와우엔터테인먼트)은 을(상담사)에게 손해배상을 청구할 수 있다.</p>

          <p>(5) 을이 상담하는 도중 을의 전화번호를 상담자에게 언급하여 와우엔터테인먼트 대표번호를 통하지 않고 상담하는 경우 , 갑은 을에게 상담료를 지불하지 않으 므로 상담시 또한 전화번호를 노출하지 말아야 한다. 본 계약을 해제할 수 있다.</p>

          <h5>제6조 계약의 해제. 해지</h5>
          <p>(1) 갑과 을의 합의에 의하여 본 계약을 해지할 수있다.</p>

          <p>(2) 갑과 을은 일방 당사자가 본 계약상의 의무사항을 위반하거나 불성실하게 수행하는 것으로 판단되는 경우, 일방 당사자에게 기간을 정하여 위반사항을 원상회복 하거나 성실히 이행할 것을 최고하며, 그럼에도 불구하고 원상회복이나 성실한 이행이 이루어지지 않았다고 판단될 경우 본 계약을 해제할 수 있다.</p>

          <p>(3) 갑과 을  입장에서 상담사가 상담하는것에 대한 문제가 있다고 추측, 갑 에 피해를 주고 있다고 판단 될시 상담료를 100%로 반환 하여야한다 단 갑은 그에 대한 근거  를 을 에게 알릴 의무가 있다</p>

          <p>(4) 갑이 다음 각 호에 해당하는 경우 갑은 별도의 최고 없이 본 계약을 즉시 해지할 수 있다.<br>
          * 금융기관으로부터 거래정지처분을 받은 경우<br>
          * 감독관청으로부터 영업취소, 정지 등의 처분을 받은 경우<br>
          * 제3자로부터 가압류, 가처분, 강제집행을 받아 계약 이행이 곤란하다고 판단하는 경우<br>
          * 파산 또는 회사 정리절차가 신청되거나 법원이동 절차를 개시 결정한 경우와 회사가 인수되는 경우<br>
          * 기타 현저한 사정에 의하여 본 계약상의 의무를 이행하기 어렵다고 판단되는 경우<br>
          </p>

          <h5>제7조 계약 위반에 대한 책임</h5>
          <p>일방이 본 계약상의 의무를 위반하는 경우, 제6조에 의한 계약의 해제 및 해지와 별도로 , 상대방에 대하여 그로 인하여 상대방이 입은 손해를 배상하여야 하며, 손해 배상은 계약 위반 전월 갑 매출의 200%을 배상하는 걸로 한다.</p>

          <h5>제8조 준거법 및 관할</h5>

          <p>본 계약은 대한민국의 법률과 상관행에 의하여 해석되고 규율 되며, 본 계약과관련한 양 당사자사이의 분쟁은 인천지방법원의 관할로 한다.<br>
          증명하기 위하여 원본계약서를 2통 작성하고, 갑과 을이 각 1통씩 보관하기로 한다.<br>
          계약서 내용이 갑 운영상 다소 내용이 변경될수 있음을 알려드립니다 단 변경된 내용은 을 에게 상담사에게 미리 공지해야 할 의무가 있다.</p>

          <p>* 온라인 동의관련은 계약서에 준하여 주민번호등록사진 주소등 홈페이지에 선생님 신청및 등록할시 서면계약하고  동일하게 계약 성립으로 본다</p>


          <p>
            (갑)<br>
            와우엔터테인먼트(WOW EMTERTAINMENT) <br>
            대표: 김 두 혁<br>
            사업자등록번호:673-10-00525  <br>
            주소:인천 부평구 동수로120번길43  <br>
            205동 101호
          </p>

          <p>
            (을)<br>
            이름 : <br>
            주민번호 : <br>
            주소 : <br>
            (파트너) (일반)
          </p>
        </div>
      </div>
      <div class="frm_input">
        <label class="frm_agree"><input type="checkbox" id="chkAgree" name="thisAgree"> 위의 계약내용을 확인하였고 계약내용 사항에 동의합니다.</label>
      </div>
      <div class="btn_area">
        <input type="button" value="동의" id="fregister_submit" class="btn_submit wp50_btn">
        <button type="button" class="btn_b01 wp50_btn" name="button" id="fregister_cancel">취소</button>
      </div>
    </div>
  </div>
  <div class="dim_bg"></div>
</div>
<!-- //상담사 회원 최초 로그인 시 -->
<script type="text/javascript">
$(document).ready(function() {
	$("#layer_contract").show();

	$("#fregister_cancel").click(function() {
		if ( confirm( "계약내용에 동의해주지 않으시면 상담사 활동이 불가합니다.\n취소하시겠습니까?" ) ) {
			location.href = "<?php echo G5_BBS_URL; ?>/logout.php?url=shop";
		}
	});

	$("#fregister_submit").click(function() {
		if ( $("#chkAgree").is(":checked") == false ) {
			alert("계약내용에 동의해 주셔야 상담사 활동이 가능합니다.");
			$("#chkAgree").focus();
			return;
		}

		$.ajax({
			url: "<?php echo G5_BBS_URL; ?>/ajax.mb_cert.php",
			type: "POST",
			async: false,
			cache: false,
			success: function(data) {
				$("#layer_contract").hide();
			}
		});
	});
});
</script>
<?php
}
?>
<div id="wrap" class="<?php if(!defined('_INDEX_')){ ?>sub<?php } ?>">

<!-- 상단 시작 { -->
    <h1 id="hd_h1" class="blind"><?php echo $g5['title'] ?></h1>

    <div id="skip_to_container"><a href="#container">본문 바로가기</a></div>

	<?php
	// if (defined('_INDEX_')) { // index에서만 실행
		include G5_MOBILE_PATH.'/newwin.inc.php'; // 팝업레이어
	// }
	?>
	<hr>
	<header id="header">
		<div class="h_wrap">
			<div class="h_logo">
				<a href="<?php echo G5_URL; ?>" title="신선운세"><h1 class="blind">신선운세</h1></a>
			</div>
			<nav class="h_menu">
				<h2 class="blind">MENU</h2>
				<div class="hm_all">
					<button type="button" class="hma_btn"><i></i><span class="blind">전체메뉴</span></button>
					<div class="hma_wrap <?php if ($_COOKIE["topbanner"]){ ?>onbanner<?php } ?>">
						<div class="hma_title">
							<img src="/images/m/ratio_9x1.png"/>
							<button type="button" class="hma_btn"><i></i><span class="blind">메뉴 닫기</span></button>
							<?php if(!$is_member){?>
							<a href="/bbs/login.php" class="t1">로그인</a>
							<a href="/bbs/register.php" class="t2">회원 가입</a>
							<?php } else {	?>
							<a href="<?php echo G5_BBS_URL; ?>/logout.php?" class="t1">로그아웃</a>
							<?php if ($member['mb_level'] == 3) { ?>
							<a href="<?php echo G5_SHOP_URL; ?>/orderinquiry2.php" class="t2"><span>마이페이지</span></a>
							<?php } else { ?>
							<a href="<?php echo G5_URL; ?>/mypage_payment_list.php" class="t2"><span>마이페이지</span></a>
							<?php } ?>
							<?php } ?>
							
							<h3 class="title t1 font cb">신선운세 <strong class="bold cb">전체메뉴</strong></h3>
						</div>
						<div class="hma_list main">
							<ul>
								<li><a href="<?php echo G5_URL; ?>/shop/list.php?ca_id=20">신점</a></li>
								<li><a href="<?php echo G5_URL; ?>/shop/list.php?ca_id=10">타로</a></li>
								<li><a href="<?php echo G5_URL; ?>/shop/list.php?ca_id=30">사주</a></li>
								<li><a href="<?php echo G5_URL; ?>/shop/list.php?ca_id=40">펫타로</a></li>
								<li><a href="<?php echo G5_URL; ?>/shop/list.php?ca_id=50">꿈해몽</a></li>
							</ul>
						</div>
						<div class="hma_list sub">
							<ul>
								<li><a href="<?php echo G5_SHOP_URL; ?>/itemuselist.php">상담후기</a></li>
								<li><a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=best">상담사례</a></li>
								<li><a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=event">이벤트/혜택</a></li>
								<li><a href="<?php echo G5_URL; ?>/shop/itemuselist.php?gubun=best">베스트후기</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="hm_search">
					<h2 class="blind">SEARCH</h2>
					<a href="#search" class="hms_btn"><i></i><span class="blind">검색열기</span></a>
				</div>
			</nav>
		</div>
	</header>
	<hr>
	<nav id="nav">
		<ul>
			<li><a href="#help" class="n_btn n_menu"><span>도우미</span></a></li>
			<?php if ($member['mb_level'] == 3) { ?>
			<li><a href="<?php echo G5_SHOP_URL; ?>/orderinquiry2.php" class="n_btn n_mypage"><span>마이페이지</span></a></li>
			<?php } else { ?>
			<li><a href="<?php echo G5_URL; ?>/mypage_payment_list.php" class="n_btn n_mypage"><span>마이페이지</span></a></li>
			<?php } ?>
			<li><a href="<?php echo G5_URL; ?>/payment.php" class="n_btn n_coin"><span>코인충전</span></a></li>
			<li><a href="<?php echo G5_BBS_URL; ?>/faq2.php?fm_id=3" class="n_btn n_customer"><span>고객센터</span></a></li>
		</ul>
	</nav>
    <script>
   /* $( document ).ready( function() {
        var jbOffset = $( '#hd_wr' ).offset();
        $( window ).scroll( function() {
            if ( $( document ).scrollTop() > jbOffset.top ) {
                $( '#hd_wr' ).addClass( 'fixed' );
            }
            else {
                $( '#hd_wr' ).removeClass( 'fixed' );
            }
        });
    });

    $(function() {
      $('#check_pop').click(function(){
        $('#layer').show();
      });

      $('#fregister_submit').click(function(){
        $('#layer').hide();
      });
    });



    $(".menu_close").on("click", function() {
        $(".menu").hide();
    });
     $(".cate_bg").on("click", function() {
        $(".menu").hide();
    });

//    $("#mainSch").on("click", function(){
//      $("#hd_sch").show();
//      $("#mainSchClose").show();
//    });
    $("#mainSchClose").on("click", function(){
      $("#hd_sch").hide();
      $("#mainSchClose").hide();
    });
*/
   </script>
</header>

<div id="contents" <?php if(defined('_INDEX_')){ ?>class="c_main"<?php } ?>>
    <?php if ((!$bo_table || $w == 's' ) && !defined('_INDEX_')) { ?><h1 id="container_title"><?php echo $g5['title'] ?></h1><?php } ?>
