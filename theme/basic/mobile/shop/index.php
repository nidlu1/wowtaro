<?php
include_once('./_common.php');
/* 회원이 접속하면 상담사의 상태값이 상담중, 예약대기 인 경우 휴먼정보의 상태값으로 변경 */
counsel_stat_update();
/* 회원이 접속하면 상담사의 상태값이 상담중, 예약대기 인 경우 휴먼정보의 상태값으로 변경 */
define("_INDEX_", TRUE);

include_once(G5_THEME_MSHOP_PATH.'/shop.head.php');
?>


<script src="<?php echo G5_JS_URL; ?>/swipe.js"></script>
<script src="<?php echo G5_JS_URL; ?>/shop.mobile.main.js"></script>

<?php echo display_banner('메인', 'mainbanner.10.skin.php'); ?>
<?php echo display_banner('왼쪽', 'boxbanner.skin.php'); ?>


<!--메인 아래 -->


<div class="inner">
  <div class="brown-box clearfix">
      <a href="/payment.php" class="coin">
        <h3>코인상담</h3>
        <p>최대 <span>50%</span> 할인</p>
        <span class="arr">
          <i class="xi-angle-right-min"></i>
        </span>
      </a>

      <a href="tel:060-300-6700" class="postpay">
        <h3>060상담</h3>
        <p><span>후불제</span>로 바로 이용</p>
        <span class="arr">
          <i class="xi-angle-right-min"></i>
        </span>
      </a>
  </div>
</div><!--inner-->

  <ul class="menu-list clearfix">
    <li>
      <a href="/shop/list.php?ca_id=10">
        <img src="/m-fortune-img/cate_icon1.png" alt="">
        <p>타로</p>
      </a>
    </li>
    <li>
      <a href="/shop/list.php?ca_id=20">
        <img src="/m-fortune-img/cate_icon2.png" alt="">
        <p>신점</p>
      </a>
    </li>
    <li>
      <a href="/shop/list.php?ca_id=30">
        <img src="/m-fortune-img/cate_icon3.png" alt="">
        <p>사주</p>
      </a>
    </li>
    <li>
      <a href="/shop/list.php?ca_id=40">
        <img src="/m-fortune-img/cate_icon4.png" alt="">
        <p>펫타로</p>
      </a>
    </li>
    <li>
      <a href="/shop/list.php?ca_id=50">
        <img src="/m-fortune-img/cate_icon5.png" alt="">
        <p>꿈해몽</p>
      </a>
    </li>
    <li>
      <a href="/shop/itemuselist.php">
        <img src="/m-fortune-img/cate_icon6.png" alt="">
        <p>상담후기</p>
      </a>
    </li>

  </ul>


<!--div class="main-tab">
  <ul>
    <li class="reco">
      추천
    </li>
    <li class="new">
      NEW
    </li>
    <li class="avail">
      상담가능
    </li>
  </ul>
</div-->

<div class="list-wr reco-wr">
<?php
$sct_sort_href = $_SERVER['SCRIPT_NAME'].'?';
if($ca_id)
    $sct_sort_href .= 'ca_id='.$ca_id;
else if($ev_id)
    $sct_sort_href .= 'ev_id='.$ev_id;
if($skin)
    $sct_sort_href .= '&amp;skin='.$skin;
$sct_sort_href .= '&amp;type=';
?>
  <!--솔팅 추가-->
  <ul id="ssch_sort" class="clearfix">
    <li><a href="<?php echo $sct_sort_href; ?>mb_type1">성실상담사</a></li>
    <li><a href="<?php echo $sct_sort_href; ?>mb_type2">추천상담사</a></li>
    <li><a href="<?php echo $sct_sort_href; ?>mb_type3">NEW상담사</a></li>
  </ul>
  <!--솔팅 추가-->
  <?php if($default['de_mobile_type2_list_use']) { ?>
  <div class="sct_wrap">
      <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=2">추천상품</a></h2>
      <?php
	  $skin_file = G5_THEME_PATH.'/mobile/skin/shop/basic/main.10.skin.php'; //스킨명(기존 것을 사용하거나 새로이 만들거나)

      $item_mod = 1; //한줄당 갯수
	  /*
      $list = new item_list();
      $list->set_mobile(true);
      $list->set_type(2);
      $list->set_view('it_id', false);
      $list->set_view('it_name', true);
      $list->set_view('it_cust_price', true);
      $list->set_view('it_price', true);
      $list->set_view('it_icon', true);
      $list->set_view('sns', false);
      echo $list->run();
	  */
	  $sub_where = "";
	  if ( $type ) {
		  $sub_where = " AND ".$type."='1' ";
	  }
	  $sql = "SELECT * FROM ".$g5['member_table']." WHERE mb_level='3' AND mb_hide='0' AND mb_type4='1' ".$sub_where." ORDER BY mb_status ASC, rand() limit 12";
	  //echo $sql;
	  $result = sql_query($sql);

	  // where 된 전체 상품수
	  $total_count = sql_num_rows($result);
	  // 전체 페이지 계산
	  $total_page  = ceil($total_count / $items);
//echo $skin_file." , ".$total_count;exit;
	  include $skin_file;
      ?>
  </div>
  <?php } ?>


    <?php /*if($default['de_mobile_type3_list_use']) { ?>
    <div class="sct_wrap new-wr">
        <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=3">최신상품</a></h2>
        <?php
        $list = new item_list();
        $list->set_mobile(true);
        $list->set_type(3);
        $list->set_view('it_id', false);
        $list->set_view('it_name', true);
        $list->set_view('it_cust_price', true);
        $list->set_view('it_price', true);
        $list->set_view('it_icon', true);
        $list->set_view('sns', true);
        echo $list->run();
        ?>
    </div>
    <?php } ?>

    <!-- 아래 히트상품 상담가능으로 변경해야함 -->
    <?php if($default['de_mobile_type1_list_use']) { ?>
    <div class="sct_wrap avail-wr">
            <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=1">히트상품</a></h2>
        <?php
        $list = new item_list();
        $list->set_mobile(true);
        $list->set_type(1);
        $list->set_view('it_id', false);
        $list->set_view('it_name', true);
        $list->set_view('it_cust_price', true);
        $list->set_view('it_price', true);
        $list->set_view('it_icon', true);
        $list->set_view('sns', true);
        echo $list->run();
        ?>
    </div>
    <?php }*/ ?>

</div><!--list-wr-->



<div class="event">
  <a href="/bbs/write.php?bo_table=event_form">
    <h2>이벤트 안내</h2>
    <p class="txt">타로와 캐리커처 함께 할 수 있는 다양한 이벤트 행사</p>
    <p class="go">보러가기<span class="arr"><i class="xi-angle-right-min"></i></span></p>
  </a>
</div>

    <!-- <?php include_once(G5_MSHOP_SKIN_PATH.'/main.event.skin.php'); // 이벤트 ?> -->
<script>
$(function() {
			$('.tab_txt_list li').click(function() {
        var idx = $(this).index();

        $(".s03_con").hide()
        $(".s03_con").eq(idx).show()

        $(".tab_b").removeClass("on")
        $(".tab_b").eq(idx).addClass("on")
			})
		});

/*mobile tab*/
$(function() {
			$('.main-tab li').click(function() {
        var idx = $(this).index();

        $(".sct_wrap").hide()
        $(".sct_wrap").eq(idx).show()

        // $(".tab_btn").removeClass("on")
        // $(".tab_btn").eq(idx).addClass("on")
			});
		});


</script>


<?php
include_once(G5_THEME_MSHOP_PATH.'/shop.tail.php');
?>
