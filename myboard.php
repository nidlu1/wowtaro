<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/myboard.php');
    return;
}

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
$current_isboard = true;
include_once('./_head.php');
?>
<!--타이틀영역-->
<div class="c_hero">
	<strong>신선운세 <mark>공지사항</mark></strong>
</div>
<div class="c_list">
	<div class="cl_menu">
		<a href="<?php echo G5_URL; ?>"><i></i><span class="blind">HOME</span></a>
		<span>신선운세</span>
		<span>마이페이지</span>
		<span><mark><a href="/myboard.php?bo_table=notice2" class="sct_here">공지사항</a></mark></span>
	</div>
	<div class="cl_function mypage">
		<li>
			<span><?php echo $member['mb_name']; ?>님</span>
			<span><?php echo $member['mb_nick']; ?>님</span>
		</li>
	</div>
</div>
<div class="c_area">
  <div class="wrap">
	<ul id="mypage-tab">
	<?php
	include_once(G5_SHOP_PATH.'/mymenu.php');
	?>
    </ul>
  <!-- 주문 내역 시작 { -->
    <div id="mypage-content">
        <p>공지사항</p>

        <?php
		$_REQUEST['bo_table'] = "notice2";
        include G5_BBS_PATH."/board.php";
        ?>

		</div>
	</div>
</div>
<!-- } 주문 내역 끝 -->

<?php
include_once('./_tail.php');
?>