<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/shop.tail.php');
    return;
}

$admin = get_admin("super");

// 사용자 화면 우측과 하단을 담당하는 페이지입니다.
// 우측, 하단 화면을 꾸미려면 이 파일을 수정합니다.
?>



    <!-- } 콘텐츠 끝 -->
<?php
if ( $member['mb_level'] == 2 ) {
	$ch = curl_init($user_remaining_secs_addr."?cp=".$cp."&svc=".$svc."&tel=".str_replace("-","",$member['mb_hp'])."&pwd=".substr($member['mb_hp'],-4)."");
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 1);
	$ret = curl_exec($ch);
	curl_close($ch);
	$hours = floor($ret / 3600);
	$minutes = floor(($ret / 60) % 60);
	$seconds = $ret % 60;
?>
<!--잔여시간 안내 시작-->
<div class="my_time">
  <!-- <i class="xi-close-min close_mytime"></i> -->
  <p>
    회원님의 잔여시간 <span> <?php echo $hours; ?>시간 <?php echo $minutes; ?>분 <?php echo $seconds; ?>초 </span>
  </p>
</div>
<!--잔여시간 안내 끝-->
<script type="text/javascript">



var myTimer = setInterval(function() {
  // Timer codes
    $.ajax({
        type : "POST",
        url : "<?php echo G5_URL; ?>/ajax_time.php",
        data : "",
        contentType: "application/json; charset=utf-8",
        success : function(data){
            console.log(data);
            $('.my_time > p').html(data);
        },
        error : function(data){
        	console.log(data);
        	//alert("통신에러");
        }
    });
}, 10000);

//잔여시간 닫기
// $(function(){
//   $(".close_mytime").on("click",function(){
//     $(".my_time").hide();
//   });
// });
</script>
<?php
}
?>

	<footer id="footer">
		<h2 class="blind">FOOTER</h2>
		<div class="f_notice">
			<div class="wrap">
				<h3 class="fn_title">공지사항</h3>
				<?php if ($is_admin || $member['mb_level'] == 3)  { ?>
				<?php echo latest('notice_main','notice2',1, 100);?>
				<?php } else {?>
				<?php echo latest('notice_main','notice',1, 100);?>
				<?php }?>
				<?php if ($is_admin || $member['mb_level'] == 3)  { ?>
				<a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=notice2" class="fn_more">더보기</a>
				<?php } else {?>
				<a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=notice" class="fn_more">더보기</a>
				<?php }?>
			</div>
		</div>
		<div class="f_customer">
			<div class="wrap">
				<div class="fc_call">
					<h3>신선운세 고객센터</h3>
					<a href="tel:15229284">1522-9284</a>
					<p>업무시간 11:00 ~ 16:00 (점심 13:00 ~ 14:00)</p>
				</div>
				<div class="fc_contact">
					<ul>
						<li class="email">
							<h3>이메일 문의</h3>
							<a href="mailto:sinseonunse@naver.com">sinseonunse@naver.com</a>
						</li>
						<li class="kakao">
							<h3>카카오톡 1:1문의하기</h3>
							<a href="https://open.kakao.com/o/sddbIq0c" target="_blank">카톡문의</a>
							<p>응대시간 10:00 ~ 22:00</p>
						</li>
					</ul>
				</div>
				<div class="fc_quick">
					<ul>
						<li><a href="/bbs/qalist.php"><i class="fcq_icon inquiry"></i><span>1:1고객문의</span></a></li>
						<li><a href="/bbs/faq2.php?fm_id=3"><i class="fcq_icon guide"></i><span>이용안내</span></a></li>
						<li><a href="/bbs/faq.php?fm_id=4"><i class="fcq_icon faq"></i><span>FAQ</span></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="f_menu">
			<div class="wrap">
				<ul>
					<li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision">이용약관</a></li>
					<li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy">개인정보처리방침</a></li>
					<li><a href="/payment.php">코인충전</a></li>
					<?php if ( !$member['mb_id'] ) {?><li><a href="/bbs/content.php?co_id=recruit"><mark>베스트상담사신청</mark></a></li><?php } ?>
					<li><a href="/free_counsel.php">5분 무료이용</a></li>
					<?php if (is_mobile()) {?><li><a href="/index.php?device=mobile">모바일 화면 바로가기</a></li><?php } ?>
				</ul>
			</div>
		</div>
		<div class="f_info">
			<h3 class="blind">정보</h3>
			<div class="wrap">
				<ul>
					<li>
						<strong>업체명</strong>
						<span>와우엔터테인먼트</span>
					</li>
					<li>
						<strong>주소</strong>
						<span>인천광역시 부평구 동수로 120번길43</span>
					</li>
					<li>
						<strong>대표</strong>
						<span>김두혁</span>
					</li>
					<li>
						<strong>전화</strong>
						<span><a href="tel:15229284">1522-9284</a></span>
					</li>
					<li>
						<strong>이메일</strong>
						<span><a href="mailto:sinseonunse@naver.com">sinseonunse@naver.com</a></span>
					</li>
					<li>
						<strong>사업자등록번호</strong>
						<span>673-10-00525</span>
					</li>
					<li>
						<strong>통신판매업신고</strong>
						<span>제2017-인천부평-0338호</span>
					</li>
					<li>
						<strong>특허출원번호</strong>
						<span>제 40-2018-0018894호</span>
					</li>
				</ul>
				<p class="fi_copyright">Copyright © 2021 Sinseonunse. All rights reserved.</p>
				<p class="fi_notice">
					<span>사이트 관련 포토, 콘텐츠, 언론보도, 상업적인 목적으로 UI이나 재배포, 재전송, 스크래핑, 캡쳐 등 회사에 동의 없이 침해 하는 경우  저작권 침해 행위로 볼 수 있으며 발견 시 법적인 책임이 있을 수 있습니다.</span>
					<span>와우엔터테인먼트는 상담사와 고객간의 통신판매를 돕는 중간매개체로 상담사가 등록한 정보와 상담내용에 대한 문제 발생시 와우엔터테인먼트에서는 법적책임이 없음을 알려드립니다.</span>
				</p>
				<a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=policy" class="fi_btn">개인정보정책 안내</a>
			</div>
		</div>
	</footer>

</div>
<!-- 팝업, 신선운세 상담 S -->
<div class="popup t1 counsel">
	<div class="p_box">
		<a href="#!" class="p_close"><span class="blind">닫기</span></a>
		<div class="p_head t1">
			<h3>바로상담</h3>
			<p>
				<span><a href="tel:0603006700"><i></i>060-300-6700</a></span>
			</p>
		</div>
		<div class="p_body">
			<p>
				<span><mark>30초당 1300원이 부과</mark>됩니다.</span>
				<span>보다 부담없는 요금으로 신선운세를 이용하시려면, <strong>할인상담</strong>을 권해드립니다.</span>
				<span><strong>할인상담 시 30~50%의 요금이 할인</strong>됩니다.</span>
			</p>
		</div>
		<div class="p_head t2">
			<h3>할인상담</h3>
			<p>
				<span><a href="tel:16613439"><i class="t1"></i>1661-3439</a></span>
				<span><a href="tel:0234331177"><i class="t2"></i>02-3433-1177</a></span>
			</p>
		</div>
		<div class="p_body">
			<p>
				<span>할인상담 시 <strong><a href="tel:16613439">02-3433-1177</a> 이용하시면 발신요금을 절약</strong>하실 수 있습니다.</span>
				<span>요금제나 통신사에 따라 무료 발신요금이 다를 수 있으며, 자세한 내용은</span>
				<span>해당 통신사 홈페이지를 참고하세요.</span>
			</p>
		</div>
	</div>
</div>
<!-- 팝업, 신선운세 상담 E -->

<!-- 팝업, 신선운세 검색 S -->
<div class="popup t5 search">
	<div class="p_box">
		<a href="#!" class="p_close"><span class="blind">닫기</span></a>
		<div class="pb_title">
			<strong>선생님을 찾고 계신가요?</strong>
		</div>
		<div class="pb_search">
			<form name="frmsearch1" action="<?php echo G5_URL; ?>/shop/search.php" onsubmit="return search_submit(this);">
				<label for="sch_str" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
				<select name="seach_category" id="sch_str">
					<option value="level3">선생님</option>
				</select>
				<label for="sch_str" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
				<input type="text" name="mb_hashtag" value="" id="sch_str" placeholder="선생님 검색" required="" style="width: 60%">
				<button type="submit" id="sch_submit"><span>검색</span></button>
			</form>
			<script>
				function search_submit(f) {
				if (f.q.value.length < 2) {
				alert("검색어는 두글자 이상 입력하십시오.");
				f.q.select();
				f.q.focus();
				return false;
				}
				return true;
				}
			</script>
		</div>
	</div>
	<a href="#!" class="p_out"><span class="blind">닫기</span></a>
</div>
<!-- 팝업, 신선운세 검색 E -->

<!-- 팝업, 신선운세 도우미 S -->
<div class="popup t4 help">
	<div class="p_box">
		<a href="#!" class="p_close"><span class="blind">닫기</span></a>
		<div class="slide_type3 owl-carousel">
			<div class="item">
				<div class="pb_txt">
					<span class="pbt_number">01</span>
					<p class="pbt_title">
						<strong><mark>바로상담</mark>으로</strong>
						<span><mark>편하게 상담하세요!</mark>(후불제상담)</span>
					</p>
					<p class="pbt_content">
						<span>바로상담 대표번호 <mark><a href="tel:0603006700">060-300-6700</a>으로 전화 연결 후</mark></span>
						<span><mark>선생님 고유번호(ex.123) 3자리</mark>를 입력하여  선생님과 </span>
						<span>편하게 상담 을 시작해 보세요!</span>
					</p>
					<button type="button" class="pbt_btn"><mark>할인상담</mark> 알아보기</button>
				</div>
				<div class="pb_pic">
					<img src="/images/common/pic_help01.png" alt="바로상담 가이드 이미지"/>
				</div>
			</div>
			<div class="item">
				<div class="pb_txt">
					<span class="pbt_number">02</span>
					<p class="pbt_title">
						<strong><mark>할인상담</mark>으로</strong>
						<span><mark>부담은 덜고! 상담은 길게!</mark></span>
					</p>
					<p class="pbt_content">
						<span><mark>최대 60% 할인금액(바로상담대비)으로 코인을 충전</mark>하세요.</span>
						<span>비용에 대한 부담을 해소하실 수 있으며 고민에 대한 상담을</span>
						<span>더욱 길게 하실 수 있습니다!</span>
					</p>
					<button type="button" class="pbt_btn"><mark>추가혜택</mark> 더 알아보기</button>
				</div>
				<div class="pb_pic">
					<img src="/images/common/pic_help02.png" alt="코인충전시 최대 60프로 할인 이미지"/>
				</div>
			</div>
			<div class="item">
				<div class="pb_txt">
					<span class="pbt_number">03</span>
					<p class="pbt_title">
						<strong><mark>코인충전으로 추가혜택 받고</mark></strong>
						<span><mark>고민상담을 더 길게!</mark></span>
					</p>
					<p class="pbt_content">
						<span><mark>코인충전으로 할인과 추가 혜택으로 회원 등급별 코인도 받아</mark></span>
						<span>선생님과 함께 더욱 긴 시간 동안 고민을 해결해 보세요!</span>
					</p>
					<button type="button" class="pbt_btn"><mark>5분무료상담</mark> 알아보기</button>
				</div>
				<div class="pb_pic">
					<img src="/images/common/pic_help03.png" alt="코인충전으로 회원등급별 코인 받을 수 있는 이미지"/>
				</div>
			</div>
			<div class="item">
				<div class="pb_txt">
					<span class="pbt_number">04</span>
					<p class="pbt_title">
						<span><mark>고민이 있다면 주저말고 </mark></span>
						<strong><mark>신선운세와 함께 풀어가세요!</mark></strong>
					</p>
					<p class="pbt_content">
						<span>어떤 선생님이랑 상담을 해야할지 고민이시라구요?</span>
						<span><mark>회원가입을 하시면 5분무료상담코인을 드립니다.</mark></span>
						<span>5분무료코인으로 먼저 확인 해 보세요!</span>
					</p>
					<a href="#" class="pbt_btn t1"><mark>신선운세 상담 시작하기</mark></a>
				</div>
				<div class="pb_pic">
					<img src="/images/common/pic_help04.png" alt="5분 무료상담 이벤트 이미지"/>
				</div>
			</div>
			<!-- <div class="item">
				<div class="pb_txt t1">
					<span class="pbt_number">05</span>
					<p class="pbt_title">
					<span><mark>저희 신선운세는 규정상 상담사와 이용자간의</mark></span>
					<strong><mark>개인정보를 일체 알려드리지 않습니다.</mark></strong>
					</p>
					<p class="pbt_content">
						<span>1.상담사와 이용자간의 <mark>개인정보 유출로 인해 발생하는 모든 상담피해 문제에 대해서 저희 신선운세는 법적인 책임이 없습니다.</mark><br> 또한 상담사와 이용자간의 상담내용 피해발생시 상담사와 이용자를 <mark>연결해주는 중간 매개체인(운세 서비스 사업)신선운세는 법적인 책임이</mark> <mark>전혀 없음</mark>을 알려드립니다.</span>
						<span>2.상담사가 이용자에게 좀 더 저렴한 상담권유로 <mark>개인정보를 묻거나 타사이트로 유도 한다면 저희 홈 페이지 1:1문의 이메일이나 사이트로</mark> <mark>제보해 주세요 포인트 지급</mark>해 드립니다 절대 비밀보장고객센터 : <a href="tel:15229284">1522 - 9284</a></span>
						<span>3.이러한 조치는 신선운세의 <mark>상담사와 모든 이용고객님들의 피해를 막고 건전한 상담문화를 만들어 가는 밑거름</mark>이 되겠습니다.</span>
					</p>
				</div>
			</div> -->
		</div>
	</div>
	<a href="#!" class="p_out"><span class="blind">닫기</span></a>
</div>
<!-- 팝업, 신선운세 도우미 E -->
<!-- 팝업, 신선운세 리뷰 S -->
<div class="popup t3 review">
	<div class="p_box">
		<div class="pb_head pt10">
			<a href="#!" class="p_close"><span class="blind">닫기</span></a>
			<h2 class="title t3 bold cb s05">상담후기 코인 정책</h2>
		</div>
		<div class="pb_content">
			<div class="pbc_txt">
				<p class="mt20 mb15"><span>신선운세 상담후기는 회원가입 하고 상담한 회원만 후기를 쓸수가 있습니다.</span></p>
				<p class="pbct_sub mb30">
					<i class="txt_deco">1</i><span><b>상담댓글 쓰기</b></span>
					<span>상담후기는 로그인한 회원만 작성가능 하고 상담한 이력이 5분 이상인 분만 마이페이지에서 상담후기를 확인 하실수 있습니다. </span>
				</p>
				<p class="pbct_sub mb30">
					<i class="txt_deco">2</i><span><b>상담댓글 작성시 코인지급 기준</b></span>
					<span>일반후기 (30자 이상): 100코인</span>
					<span>손편지 후기 상담인증 (사진 첨부): 500코인</span>
					<span>베스트 후기 당첨시: 3000코인</span>
				</p>
				<div class="pbct_notice mb30">
					<h5><b>*상담후기 코인 지급 안내</b></h5>
					<ul>
						<li><span><mark>1.</mark> 일반후기는 30자 이상 후기를 작성 하면 자동으로 코인지급</span></li>
						<li><span><mark>2.</mark> 손편지후기(사진첨부)는 관리자 확인 후 지급, 개인적 연락처나 개인정보 노출시 개인정보 보호법에따라 삭제 될수 있습니다.</span></li>
						<li><span><mark>3.</mark> 베스트 댓글은 관리자가 매주 금요일날 지난 주 후기중 베스트 댓글 확인후 지급 합니다.</span></li>
						<li><span><mark>4.</mark> 마이페이지 에서 확인 가능.</span></li>
					</ul>
				</div>
				<div class="pbct_notice mb30">
					<h5><b>*손편지 꿀팁</b></h5>
					<p><span><mark>1.</mark> 정성가득 성의있는 손편지</span></p>
				</div>
				<div class="pbct_notice mb30">
					<h5><b>*베스트 상담후기 꿀팁</b></h5>
					<p><span><mark>1.</mark> 300자 이상 후기작성 후 손편지(사진첨부)시 베스트 댓글에 선정될 확률이 더 높아집니다.</span></p>
				</div>
				<h2 class="title t3 bold cb s05 mb25">상담사 댓글 관리규정</h2>
				<p class="pbct_sub">
					<i class="txt_deco">1</i><span><b>카카오톡, SNS, 이메일, 전화번호와 같은 개인정보는 쓰시면 안됩니다.</b></span>
				</p>
				<p class="pbct_sub">
					<i class="txt_deco">2</i><span><b>욕설과 비방, 명예훼손, 의미없는 글, 반복된 내용복사 등은 피해주세요.</b></span>
				</p>
				<p class="pbct_sub">
					<i class="txt_deco">3</i><span><b>저작권, 초상권에 문제가 있는 사진과 게시물은 올리지 마세요.</b></span>
				</p>
				<p class="pbct_sub mb30">
					<i class="txt_deco">4</i><span><b>작성된 후기글에 작성자와 상담사 외 다른 고객이 쓴 후기는 관리자가 임의 삭제할 수 있습니다.</b></span>
					<span class="pctc_hlep">(타인의 후기에 댓글을 달 때 발생할 수 있는 감정적인 문제를 예방하기 위함입니다.)</span>
				</p>
				<div class="pbct_notice mb30">
					<h5><b>* 후기 게시글 규정에 어긋나는 글에 대해서는 어떠한 알림없이 삭제될 수 있습니다.</b></h5>
					<h5><b>* 상담시 발생하는 고객들의 불만사항에 대해서는 삭제하지 않습니다. 더 질높은 상담을 유도하기 위함입니다 하지만 고의적인 의도가 있어보일시 어떠한 알림없이 삭제 될 수 있음을 알려드립니다.</b></h5>
				</div>
				<h2 class="title t3 bold cb s05  mb25">상담후기 작성시 유의사항</h2>
				<p class="pbct_notice">
					<span><mark>1.</mark> 3자 미만의 제목, 30자 이하의 성의 없는 후기</span>
					<span><mark>2.</mark> 상담과 무관한 내용의 후기</span>
					<span><mark>3.</mark> 다른 후기와 중복하여(카피 또는 도용) 작성한 경우</span>
					<span><mark>4.</mark> 한번의 상담으로 여러번의 반복적인 후기를 남긴 경우</span>
					<span><mark>5.</mark> 관리자 판단으로 코인지급이 불가능한 후기</span>
					<span><mark>6.</mark> 고의적인 후기작성이라 판단 되는 후기</span>
				</p>
				<p class="pbct_sub">
					<span>위의 조항들은 내담자님의 질높은 상담을 위한 유의 사항입니다.</span>
				</p>
			</div>
		</div>
	</div>
	<a href="#!" class="p_out"><span class="blind">닫기</span></a>
 </div>
<!-- 팝업, 신선운세 리뷰 E -->
<script type="text/javascript">
$(function(){
    var $win = $(window);
    var top = $(window).scrollTop(); // 현재 스크롤바의 위치값을 반환합니다.

    /*사용자 설정 값 시작*/
    var speed          = 1000;     // 따라다닐 속도 : "slow", "normal", or "fast" or numeric(단위:msec)
    var easing         = 'linear'; // 따라다니는 방법 기본 두가지 linear, swing
    var $layer         = $('.quick'); // 레이어 셀렉팅
    var layerTopOffset = 0;   // 레이어 높이 상한선, 단위:px
    $layer.css('position', 'absolute');
    /*사용자 설정 값 끝*/

    // 스크롤 바를 내린 상태에서 리프레시 했을 경우를 위해
    if (top > 0 )
        $win.scrollTop(layerTopOffset+top);
    else
        $win.scrollTop(0);

	yPosition = $win.scrollTop() - 0;
	//$layer.stop().animate({"top":yPosition }, {duration:speed, easing:easing, queue:true});

    //스크롤이벤트가 발생하면
    $(window).scroll(function(){
        yPosition = $win.scrollTop() - 0;
        if (yPosition < 0)
        {
            yPosition = 0;
        }
        //$layer.stop().animate({"top":yPosition }, {duration:speed, easing:easing, queue:true});
    });
});
</script>
<?php
$sec = get_microtime() - $begin_time;
$file = $_SERVER['SCRIPT_NAME'];

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<script src="<?php echo G5_JS_URL; ?>/sns.js"></script>
<!-- } 하단 끝 -->

<!-- ADN 크로징 설치  start -->
<script type="text/javascript">
var adn_panel_param = adn_panel_param || [];
adn_panel_param.push([{
 ui:'101897',	
 ci:'1018970001',
 gi:'21796'
}]);
</script>
<script type="text/javascript" async src="//fin.rainbownine.net/js/adn_closingad_1.1.1.js"></script>
<!-- ADN 크로징 설치 end -->

<?php
include_once(G5_THEME_PATH.'/tail.sub.php');
?>
