<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$admin = get_admin("super");

// 사용자 화면 우측과 하단을 담당하는 페이지입니다.
// 우측, 하단 화면을 꾸미려면 이 파일을 수정합니다.
?>
</div><!-- container End -->
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

<div class="tailbox-wr">
  <div class="inner">
    <ul>
<?php
if ($is_guest) {
?>
      <li class="boxes box1">
        <h2 class="tit">베스트 상담사 신청</h2>
        <p class="txt">
          실력과 긍정 마인드를 겸비한<br>
          신선운세의 베스트 상담사를 모십니다.
        </p>
        <a href="<?php echo G5_BBS_URL; ?>/register2.php" class="coun_btn">베스트 상담사 신청하기</a>
      </li>
<?
}
?>
      <li class="boxes box2">
        <h2 class="tit">고객센터</h2>
        <b class="num">1522-9284</b>
        <div class="txt-wr">
          <p class="txt">
            업무시간 AM 10:00 ~ PM 17:00
          </p>
          <p class="txt red">
            점심시간 PM 13:00 ~ PM 14:00
          </p>
        </div>

        <ul class="btn_box">
          <li class="btn_box1">
            <a href="<?php echo G5_BBS_URL; ?>/qalist.php">
              <img src="/m-fortune-img/cus_icon1.png" alt="1:1고객문의">
            </a>
            <p>1:1고객문의</p>
          </li>
          <li class="btn_box2">
            <a href="<?php echo G5_BBS_URL; ?>/faq2.php?fm_id=3">
              <img src="/m-fortune-img/cus_icon2.png" alt="이용안내">
            </a>
            <p>이용안내</p>
          </li>
          <li class="btn_box3">
            <a href="<?php echo G5_BBS_URL; ?>/faq.php?fm_id=4">
              <img src="/m-fortune-img/cus_icon3.png" alt="FAQ">
            </a>
            <p>FAQ</p>
          </li>
        </ul><!--btn_box-->
      </li>

      <li class="boxes box3">
        <!-- 커뮤니티 최신글 시작 { -->
          <?php //echo latest('theme/shop_basic', 'notice', 4, 30); ?>
<style>
/* 최근게시물 스킨 (latest) */
.lt h2 a{
  margin: 17px 0 6px;
  display: block;
  font-size: 16px;
}
.lt h3{
  margin-bottom: 9px;
  font-size: 13px;
  color: #585858;
  font-weight: normal;
}
.lt ul {
  padding:0 20px;
}
.lt li{
  text-align:left;
  background:#fff;
  padding:5px 0;
  border-bottom: 1px solid #f8f8f8;
}
.lt .noti-tit, .lt li .deco {
  float: left;
}
.lt li .time {
  float: right;
  color: #585858;
  font-size: 12px;
}
.lt .noti-tit {
  display:inline-block;
  color:#585858;
  text-decoration:none;
  padding-left: 5px;
  width: 70%;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
.lt li .deco {
  font-size: 15px;
  color: #585858;
  padding-right: 3px;
  margin-top: 2px;
}

.lt li i{
  color:#9da4bc;
}
.lt li .fa-heart{
  color:#ff0000;
}
.lt li .new_icon{display:inline-block;padding: 0 3px;line-height:15px ;font-size:0.92em;color:#fff;background:#c56bed}
.lt li .cnt_cmt{color:#48a3d5}
</style>
<div class="lt">
    <h2><a>신청내역</a></h2>
    <h3>&nbsp;</h3>
    <ul>
<?php
$sql = "SELECT * FROM {$g5['member_table']} WHERE mb_level IN ('1','3') AND mb_leave_date='' ORDER BY mb_datetime DESC LIMIT 4";
$result = sql_query($sql);
$list = NULL;
while ($row = sql_fetch_array($result)) {
	$list[] = $row;
}
?>

    <?php for ($i=0; $i<count($list); $i++) {  ?>
        <li class="clearfix">
            <i class="xi-bookmark-o deco"></i><a class="noti-tit"><strong><?php echo $list[$i]['mb_nick']."님 선생님 신청"; ?></strong></a>
        </li>
	<?php }  ?>
    <?php if (count($list) == 0) { //게시물이 없을 때  ?>
    <li class="empty_li">게시물이 없습니다.</li>
    <?php }  ?>
            </ul>
</div>
      </li>
    </ul>
  </div><!--inner-->
</div><!--tailbox-wr-->
<a href="https://open.kakao.com/o/sddbIq0c" id="kakaotalk" target="_blank"><i></i><span>카카오톡 문의하기</span></a>
<div id="ft">
    <h2><?php echo $config['cf_title']; ?> 정보</h2>
    <div class="sns">
      <ul class="clearfix">
        <li class="insta">
          <a href="https://www.instagram.com/sinseonunse" target="_blank">
            <img src="/m-fortune-img/sns_icon1.png" alt="">
            <p>인스타그램</p>
          </a>
        </li>
        <li class="blog">
          <a href="https://blog.naver.com/sinseonunse" target="_blank">
            <img src="/m-fortune-img/sns_icon2.png" alt="">
            <p>블로그</p>
          </a>
        </li>
        <li class="post">
          <a href="https://m.post.naver.com/sinseonunse?isHome=1" target="_blank">
            <img src="/m-fortune-img/sns_icon3.png" alt="">
            <p>네이버포스트</p>
          </a>
        </li>
				<li class="kakao_inquire">
          <a href="https://open.kakao.com/o/sSPKf93b" target="_blank">
            <img src="/add_img/sns_kakao.png" alt="">
            <p>카카오톡 문의</p>
          </a>
        </li>
      </ul>
    </div>

    <div id="ft_company">
      <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision">이용약관</a>
      <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy"><b>개인정보처리방침</b></a>
      <a href="<?php echo G5_URL; ?>/payment.php">코인충전</a>
      <a href="<?php echo G5_BBS_URL; ?>/register2.php"><strong style="font-size: 14px">베스트상담사신청</strong></a>
        <!-- <?php
        if(G5_DEVICE_BUTTON_DISPLAY && G5_IS_MOBILE) { ?>
        <a href="<?php echo get_device_change_url(); ?>" id="device_change">PC 버전</a>
        <?php } ?> -->
    </div>
    <div class="ft_bottom">
        <span class="bar"><?php echo $default['de_admin_company_name']; ?></span>
        <span class="bar">주소 : <?php echo $default['de_admin_company_addr']; ?></span>
		<span>대표 : <?php echo $default['de_admin_company_owner']; ?></span><br>
        <span>사업자 등록번호 : <?php echo $default['de_admin_company_saupja_no']; ?></span><br>
        <span>통신판매업신고 : <?php echo $default['de_admin_tongsin_no']; ?></span><br>
				<span>특허출원번호 : 제 40-1423559 호, 제 40-2018-0018894호</span><br>
        <span class="bar">전화 : <?php echo $default['de_admin_company_tel']; ?></span>
        <span>이메일 : <?php echo $default['de_admin_info_email']; ?></span><br>
        <p class="copy">Copyright 2018 Sinseonunse. All rights reserved.</p>
				<a href="<?php echo get_device_change_url(); ?>" class="change_pc">PC버전으로 보기</a>

      </div>
</div>

<div class="quick">
  <ul class="clearfix">
    <li class="quick01">
	<?php if ($member['mb_level'] == 3) {  ?>
	  <a href="<?php echo G5_SHOP_URL; ?>/orderinquiry2.php">
	<?php } else { ?>
	  <a href="<?php echo G5_URL; ?>/mypage_payment_list.php">
	<?php } ?>
        <img src="/m-fortune-img/quick_icon1.png" alt="">
        <p>마이페이지</p>
      </a>
    </li>
    <li class="quick02">
      <a href="<?php echo G5_URL; ?>/payment.php">
        <img src="/m-fortune-img/quick_icon2.png" alt="">
        <p>코인충전</p>
      </a>
    </li>
    <li class="quick03">
      <a href="<?php echo $event_href; ?>">
        <div class="ten_img"><?php echo $config['cf_1']; ?></div>
        <p><?php echo $config['cf_1']; ?>분무료</p>
      </a>
    </li>

	<!-- 10분무료-->
	<!--<li class="quick03">
      <a href="<?php echo $event_href; ?>">
        <div class="ten_img">10</div>
        <p><?php echo $config['cf_1']; ?>분무료</p>
      </a>
    </li>-->
	<!-- //10분무료-->

    <li class="quick04">
      <a href="tel:060-300-6700">
        <img src="/m-fortune-img/quick_icon_tel.png" alt="">
        <p>바로상담</p>
      </a>
    </li>
    <li class="quick05"  id="ft_to_top">
      <a href="#">
        <img src="/m-fortune-img/quick_icon5.png" alt="">
        <p>TOP</p>

      </a>
    </li>
  </ul>
</div>

<?php
$sec = get_microtime() - $begin_time;
$file = $_SERVER['SCRIPT_NAME'];

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<script src="<?php echo G5_JS_URL; ?>/sns.js"></script>

<!-- ADN 크로징 설치  start -->
<script type="text/javascript">
var adn_panel_param = adn_panel_param || [];
adn_panel_param.push([{
 ui:'101897',	
 ci:'1018970002',
 gi:'21797'
}]);
</script>
<script type="text/javascript" async src="//fin.rainbownine.net/js/adn_mobile_closingad_1.1.1.js"></script>
<!-- ADN 크로징 설치 end -->

<?php
include_once(G5_THEME_PATH.'/tail.sub.php');
?>
