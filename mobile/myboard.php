<?php
include_once('./_common.php');

define("_ORDERINQUIRY_", true);

$od_pwd = get_encrypt_string($od_pwd);

// 회원인 경우
if ($is_member)
{
    //$sql_common = " from {$g5['g5_shop_order_table']} where mb_id = '{$member['mb_id']}' ";
}
else if ($od_id && $od_pwd) // 비회원인 경우 주문서번호와 비밀번호가 넘어왔다면
{
    //$sql_common = " from {$g5['g5_shop_order_table']} where od_id = '$od_id' and od_pwd = '$od_pwd' ";
}
else // 그렇지 않다면 로그인으로 가기
{
    goto_url(G5_BBS_URL.'/login.php?url='.urlencode(G5_SHOP_URL.'/orderinquiry2.php'));
}

$g5['title'] = '공지사항';
include_once('./_head.php');
?>
<!--타이틀영역-->
<div id="review">
  <div class="sub_banner" id="sub_mypage">
    <h2>공지사항</h2>
  </div>
</div>


<div class="inner">
  <div class="order-wr clearfix">
      <ul class="mypage-tab">
	<?php
	include_once(G5_SHOP_PATH.'/mymenu.php');
	?>
      </ul>
  <!-- 주문 내역 시작 { -->
    <div id="sod_v">
        <p id="sod_v_tit">공지사항</p>

        <?php
		$_REQUEST['bo_table'] = "notice2";
        include G5_BBS_PATH."/board.php";
        ?>

    </div>
  </div><!--order-wr-->
</div> <!--inner-->
<!-- } 주문 내역 끝 -->

<?php
include_once('./_tail.php');
?>