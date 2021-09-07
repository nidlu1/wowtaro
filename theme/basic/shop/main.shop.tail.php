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

</div>
    </div>
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

<!--퀵메뉴 시작-->
<div class="quick main_quick">
  <!--a class="quick-freecounsel quick-box">
    <img src="/fortune-img/quick-clock.png" alt="">
    <div class="quick_txt">
      회원가입시<br>
      <b><span>5분</span>무료상담</b>
    </div>
  </a-->

<!--추가 / 10분무료상담-->
  <a href="<?php echo $event_href; ?>" class="quick-freecounsel quick-box ten_min">
    <img src="/fortune-img/quick-clock.png" alt="">
    <div class="quick_txt">
      EVENT<br>
      <b><span><?php echo $config['cf_1']; ?>분</span>무료상담</b>
    </div>
  </a>

<!--추가 / 코인충전-->
  <a href="<?php echo G5_URL; ?>/payment.php" class="quick-freecounsel quick-box coin_add">
    <img src="/fortune-img/quick_coin.png" alt="">
    <div class="quick_txt">
      신선운세<br>
      <b>코인충전</b>
    </div>
  </a>

  <!--추가 / 카카오톡-->
    <a href="https://open.kakao.com/o/sddbIq0c" class="quick-box quick-kakao" target="_blank">
      <img src="/fortune-img/quick_kakao.png" alt="">
      <div class="quick_txt">
        <b>카카오톡</b><br>
        1:1 문의하기
      </div>
      <div class="quick_txt kakao_time">
        <b>응대시간</b><br>
        AM 10:00 ~ PM 22:00
      </div>
    </a>

  <div class="teacher quick-box">
    <p>이달의 선생님</p>
<?php
$t5sql = "SELECT * FROM ".$g5['member_table']." WHERE mb_level='3' AND mb_type5='1' ORDER BY rand() LIMIT 3";
$t5res = sql_query($t5sql);
while ( $t5row = sql_fetch_array($t5res) ) {
	$mb_1_arr = explode(",", $t5row['mb_1']);
	if ( in_array('10', $mb_1_arr) ) {
			$bcat_str = "taro";
			$bcat_str2 = "타로";
			$ca_id=10;
	}
	else if ( in_array('20', $mb_1_arr) ) {
			$bcat_str = "sin";
			$bcat_str2 = "신점";
			$ca_id=20;
	}
	else if ( in_array('30', $mb_1_arr) ) {
			$bcat_str = "saju";
			$bcat_str2 = "사주";
			$ca_id=30;
	}
	else if ( in_array('40', $mb_1_arr) ) {
			$bcat_str = "pet";
			$bcat_str2 = "펫타로";
			$ca_id=40;
	}
	else if ( in_array('50', $mb_1_arr) ) {
			$bcat_str = "dream";
			$bcat_str2 = "꿈해몽";
			$ca_id=50;
	}
	else {
			$bcat_str = "taro";
			$bcat_str2 = "타로";
			$ca_id=10;
	}
?>

    <a href="<?php echo G5_SHOP_URL; ?>/item.php?ca_id=<?php echo $ca_id; ?>&it_id=<?php echo $t5row['mb_no']; ?>" class="teacher-list">
      <div class="teacher_quick teacher_back_small back_taro">
        <!--선생님 배경 이미지 클래스 :
        타로 일때 : back_taro (현재 예시로 설정해 놓음)
        꿈해몽 일떄 : back_dream
        펫타로 일때 : back_pettaro
        사주 일떄 : back_saju
        신점 일때 : back_shinjeom
      -->
      <img src="<?php echo G5_DATA_URL; ?>/temp/<?php echo $t5row['mb_no']; ?>/<?php echo $t5row['mb_8']; ?>" alt="<?php echo $t5row['mb_nick']; ?>  이미지">
      </div>

      <div class="cate">
        <div class="cate-<?php echo $bcat_str; ?>"><?php echo $bcat_str2; ?></div>
      </div>
      <div class="teacher_name">
        <?php echo $t5row['mb_nick']; ?> <?php echo $t5row['mb_id']; ?>번
      </div>
    </a><!--teacher-list 끝-->
<?php
}
?>

  </div><!--teachers-->

  <a href="/bbs/faq2.php?fm_id=3" class="notice-tel quick-box">
    <img src="/fortune-img/quick-tel.png" alt="">
    <div class="quick_txt">
      선생님은<br>
      <span>전화번호</span>를<br>
      알려주지 않습니다.
    </div>
  </a>

  <div class="customer quick-box">
    <p>고객센터</p>
    <a href="/bbs/faq2.php?fm_id=3" class="cutomer_border_wr">
      <img src="/fortune-img/quick-center.png" alt="">
      <div class="quick_txt">
        빠르고 정확하게<br>
        궁금한 사항을<br>
        처리해드립니다.
        <span>
          1522 - 9284
        </span>
      </div>
    </a>
  </div>

</div>
<!--퀵메뉴 끝-->

<!-- 하단 시작 { -->
</div>

<div class="inner">
  <div class="tail-box clearfix">
    <div class="counselor boxes">
      <h2>베스트 상담사 신청</h2>
      <p>실력과 마인드를 겸비한<br>
        신선운세의 베스트 상담사를 모집합니다.</p>
      <a href="/bbs/register2.php">베스트 상담사 신청하기</a>
    </div>

    <div class="customer boxes">
      <h2>고객센터</h2>
      <h3>1522 - 9284</h3>
      <p>업무시간 AM 11:00 ~ PM 16:00</p>
      <p class="red">점심시간 PM 13:00 ~ PM 14:00</p>
      <ul class="icon-wr clearfix">
        <li>
          <a class="ico1" href="/bbs/qalist.php">
            <img src="/fortune-img/customer-ico1.png" alt="1:1고객문의">
          </a>
          <p>1:1고객문의</p>
        </li>
        <li>
          <a class="ico2" href="/bbs/faq2.php?fm_id=3">
            <img src="/fortune-img/customer-ico2.png" alt="이용안내">
          </a>
          <p>이용안내</p>
        </li>
        <li>
          <a class="ico3"  href="/bbs/faq.php?fm_id=4">
            <img src="/fortune-img/customer-ico3.png" alt="FAQ">
          </a>
          <p>FAQ</p>
        </li>
      </ul><!--ico-wr-->
    </div><!--cutomer-->

    <div class="latest_wr boxes">
    <!-- 공지사항 시작 { -->
        <div class="">

    <h2 class="lat_title"><a>신청내역</a></h2>
    <ul class="noti" style="max-height: 180px;">
<?php
$sql = "SELECT * FROM {$g5['member_table']} WHERE mb_level IN ('1','3') AND mb_leave_date='' ORDER BY mb_datetime DESC LIMIT 5";
$result = sql_query($sql);
$list = NULL;
while ($row = sql_fetch_array($result)) {
	$list[] = $row;
}
?>

    <?php for ($i=0; $i<count($list); $i++) {  ?>
        <li class="clearfix">
          <span class="blet"><i class="xi-bookmark-o"></i></span>
            <a> <strong><?php echo $list[$i]['mb_nick']."님 선생님 신청"; ?></strong></a>
        </li>
    <?php }  ?>
    <?php if (count($list) == 0) { //게시물이 없을 때  ?>
    <li class="empty_li">게시물이 없습니다.</li>
    <?php }  ?>
    </ul>

            <?php
            // 이 함수가 바로 공지사항을 추출하는 역할을 합니다.
            // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
            // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
            //echo latest('theme/basic', 'notice', 5, 23);
            ?>
        </div>
        <!-- } 공지사항 끝 -->
    </div>
  </div><!--tail-box-->

</div><!--inner-->
<a href="https://open.kakao.com/o/sddbIq0c" id="kakaotalk" target="_blank"><i></i><span>카카오톡 문의하기</span></a>
<div id="ft">

  <div class="ft_top clearfix">
    <div class="inner">
      <div id="top_btn">
        <i class="xi-angle-up"></i>
      </div>

      <ul class="ft_left clearfix">
        <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision">이용약관</a></li>
        <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy"><b>개인정보처리방침</b></a></li>
        <li><a href="/payment.php">코인충전</a></li>
        <li><a href="/bbs/register2.php">베스트상담사신청</a></li>
        <?
		if (is_mobile()){
		?>
		<li><a href="<?php echo get_device_change_url(); ?>">모바일버전</a></li>
		<?
		}
		?>
      </ul>
      <ul class="ft_right clearfix">
          <li>
            <a href="https://www.instagram.com/sinseonunse" target="_blank">
              <img src="/fortune-img/top-ico1.png" alt="인스타그램">
              인스타그램
            </a>
          </li>
          <li>
            <a href="https://blog.naver.com/sinseonunse" target="_blank">
              <img src="/fortune-img/top-ico2.png" alt="블로그">
              블로그
            </a>
          </li>
          <li>
            <a href="https://m.post.naver.com/sinseonunse?isHome=1" target="_blank">
              <img src="/fortune-img/top-ico3.png" alt="네이버 포스트">
              네이버포스트
            </a>
          </li>
      </ul>
    </div><!--inner-->
  </div><!---ft-top-->
  <div class="ft_bottom">
    <div class="inner clearfix">
      <div class="ft_add">
        <p>
          <span><?php echo $default['de_admin_company_name']; ?></span>
          <span class="ft_bar"></span>
          <span>주소 : <?php echo $default['de_admin_company_addr']; ?></span>
		  <span class="ft_bar"></span>
		  <span>대표 : <?php echo $default['de_admin_company_owner']; ?></span>
        </p>
        <p>
          <span>사업자등록번호 : <?php echo $default['de_admin_company_saupja_no']; ?></span>
          <span class="ft_bar"></span>
          <span>통신판매업신고 : <?php echo $default['de_admin_tongsin_no']; ?> </span>
        </p>
        <p>
          특허출원번호 : 제 40-1423559 호, 제 40-2018-0018894호
        </p>
        <p>
          <span>전화 : <?php echo $default['de_admin_company_tel']; ?></span>
          <span class="ft_bar"></span>
          <span>이메일 : <?php echo $default['de_admin_info_email']; ?></span>
        </p>
        <p class="ft_copy">Copyright &copy; 2018 Sinseonunse. All rights reserved.</p>
      </div>
      <div class="ft_logo">
        <img src="/fortune-img/logo-ft.png" alt="<?php echo G5_VERSION ?>">
      </div>

    </div>
  </div>

        <script>

        $(function() {
            $("#top_btn").on("click", function() {
                $("html, body").animate({scrollTop:0}, '500');
                return false;
            });
        });
        </script>
    </div>


</div>
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
