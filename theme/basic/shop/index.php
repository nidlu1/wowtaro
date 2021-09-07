<?php
include_once('./_common.php');
/* 회원이 접속하면 상담사의 상태값이 상담중, 예약대기 인 경우 휴먼정보의 상태값으로 변경 */
counsel_stat_update();
/* 회원이 접속하면 상담사의 상태값이 상담중, 예약대기 인 경우 휴먼정보의 상태값으로 변경 */
if (G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/index.php');
    return;
}

define("_INDEX_", TRUE);
//echo G5_THEME_SHOP_PATH;
include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
?>


<!-- 메인이미지 시작 (이미지 등록은 admin > /쇼핑몰현황/기타 > 배너관리에서 추가하여 사용하시죵~) { -->
<?php echo display_banner('메인', 'mainbanner.10.skin.php'); ?>
<!-- } 메인이미지 끝 -->

<div class="index-inner">
  <div class="brown-sec clearfix">
    <h2 class="guide">
      <a href="/bbs/faq2.php?fm_id=3">이용안내<i class="xi-angle-right-min"></i></a>
      <!-- <h3>일반상담 : 060-300-6700 + 고유번호3자리 + #버튼</h3>
      <h3>할인상담 : 1661-3439 + 고유번호3자리 + #버튼</h3>
      <p>전화 연결 후 원하는 선생님의 고유번호 입력 후 #버튼을 눌러주세요.</p> -->
    </h2>
    <h2 class="question">
      <a href="/bbs/faq.php?fm_id=4">자주묻는 질문<i class="xi-angle-right-min"></a></i>
      <!-- <h3>고객님들이 자주 찾는 질문</h3>
      <p>신선운세를 이용하시면서 고객님들이 자주 찾는 질문만 모았습니다. </p> -->
    </h2>
  </div>

<?php if($default['de_type2_list_use']) { ?>
<!-- 추천상품 시작 { -->
<section class="sct_wrap">
  <!-- 메인 상품 진열은 이걸로 진행할게요. 어떤 스킨 사용하는지 확인하시려면 admin > 쇼핑몰관리 > 쇼핑몰설정 > 쇼핑몰 초기화면 에서 체크해주세요~ -->
    <?php
    //---------------- 여기부터
    $skin_file = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/shop/basic/main.10.skin.php'; //스킨명(기존 것을 사용하거나 새로이 만들거나)

    $item_mod = 3; //한줄당 갯수
    /*$item_rows = 3; //줄 수
    $item_width= 378; //이미지 가로
    $item_height = 238; //이미지 세로
    $order_by = "it_update_time desc"; // 최신등록순
    $list = new item_list($skin_file, $item_mod , $item_rows, $item_width, $item_height);
    $list->set_order_by($order_by);
    //---------- 여기까지

    // $list = new item_list();
    $list->set_view('it_img', true);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_cust_price', false);
    $list->set_view('it_price', false);
    $list->set_view('it_icon', true);
    echo $list->run();
	*/
	$sql = "SELECT * FROM ".$g5['member_table']." WHERE mb_level='3' AND mb_hide='0' AND mb_type4='1' ORDER BY mb_status ASC, rand() LIMIT 12";
	//echo $sql;
	$result = sql_query($sql);

	// where 된 전체 상품수
	$total_count = sql_num_rows($result);
	// 전체 페이지 계산
	$total_page  = ceil($total_count / $items);
//echo $skin_file;
	include $skin_file;
    ?>
</section>
<!-- } 추천상품 끝 -->
<?php } ?>

<div class="event">
  <a href="/bbs/write.php?bo_table=event_form">
  <h2>이벤트 안내</h2>
  <p class="mar">타로 캐리커처 함께 할 수 있는 다양한 이벤트 행사</p>
  <p class="link">보러가기 <i class="xi-angle-right-min"></i></p>
  </a>
</div>

</div>



<?php
include_once(G5_THEME_SHOP_PATH.'/main.shop.tail.php');
?>
