<?php
include_once('./_common.php');

if ( $member['mb_level'] == 3 ) {
?>
	<li>
		<strong>나의상담</strong>
		<ul>
			<li><a <?php echo preg_match("/orderinquiry2/", $_SERVER['PHP_SELF']) ? "class='on'" : ""; ?> href="/shop/orderinquiry2.php">상담내역</a></li>
			<li><a <?php echo preg_match("/mypage_myreview2/", $_SERVER['PHP_SELF']) ? "class='on'" : ""; ?> href="/mypage_myreview2.php">나의 상담후기</a></li>
			<li><a <?php echo preg_match("/mypage_mycounsel2/", $_SERVER['PHP_SELF']) ? "class='on'" : ""; ?> href="/mypage_mycounsel2.php">나의 상담문의</a></li>
		</ul>
	</li>
	<li>
		<strong>상담관리</strong>
		<ul>
			<li class="mt-admin" ><a href="https://060300.co.kr/mgr2/site/login" target="_blank">일반상담 관리자</a></li>
			<li class="mt-admin" ><a href="https://060300.co.kr/dc/site/login" target="_blank">할인상담 관리자</a></li>
		</ul>
	</li>
	<li>
		<strong>상담사 정보</strong>
		<ul>
			<li><a <?php echo preg_match("/register_form2/", $_SERVER['PHP_SELF']) ? "class='on'" : ""; ?> href="/bbs/member_confirm.php?url=register_form2.php">상담사 정보수정</a></li>
			<li><a <?php echo preg_match("/myboard/", $_SERVER['PHP_SELF']) ? "class='on'" : ""; ?> href="/myboard.php?bo_table=notice2">공지사항</a></li>
			
		</ul>
	</li>
<?php
}
else {
?>
		<!--li><a <?php echo preg_match("/orderinquiry/", $_SERVER['PHP_SELF']) ? "class='on'" : ""; ?> href="/shop/orderinquiry.php">상담내역</a></li-->
		<!-- <li class="my_meber_rank">
		<?php
		switch($member['mb_grade']) {
			case "1" :
				echo '<span><img src="/add_img/rank/rank_icon_01.png"><b>나그네회원</b></span>';
				break;
			case "2" :
				echo '<span><img src="/add_img/rank/rank_icon_02.png"><b>열심회원</b></span>';
				break;
			case "3" :
				echo '<span><img src="/add_img/rank/rank_icon_03.png"><b>성실회원</b></span>';
				break;
			case "4" :
				echo '<span><img src="/add_img/rank/rank_icon_04.png"><b>충성회원</b></span>';
				break;
			case "5" :
			case "6" :
				echo '<span><img src="/add_img/rank/rank_icon_05.png"><b>신선회원</b></span>';
				break;
			default :
				echo '<span><img src="/add_img/rank/rank_icon_01.png"><b>나그네회원</b></span>';
				break;
		}
		//보유 포인트 확인
		$sql = "select * from {$g5['point_table']} where mb_id = '{$member['mb_id']}' order by po_id DESC";
		$row = sql_fetch($sql);
		?>
		</li>
		<li><a><?php echo $member['mb_nick']; ?>님</a></li>
		<li><a>보유 포인트: <?=$row['po_mb_point']?> </a></li> -->
		
		<li>
			<strong>결제정보</strong>
			<ul>
				<li><a <?php echo preg_match("/mypage_payment_list/", $_SERVER['PHP_SELF']) ? "class='on'" : ""; ?> href="/mypage_payment_list.php">결제내역</a></li>
				<li><a href="/payment.php">코인충전</a></li>
				<li><a <?php echo preg_match("/mypage_point_list/", $_SERVER['PHP_SELF']) ? "class='on'" : ""; ?> href="/mypage_point_list.php">코인내역</a></li>
			</ul>
		</li>
		<li>
			<strong>나의상담</strong>
			<ul>
				<li><a <?php echo preg_match("/mypage_myreview/", $_SERVER['PHP_SELF']) ? "class='on'" : ""; ?> href="/mypage_myreview.php">나의 상담후기</a></li>
				<li><a <?php echo preg_match("/mypage_mycounsel/", $_SERVER['PHP_SELF']) ? "class='on'" : ""; ?> href="/mypage_mycounsel.php">나의 상담문의</a></li>
				<li><a <?php echo preg_match("/wishlist/", $_SERVER['PHP_SELF']) ? "class='on'" : ""; ?> href="/shop/wishlist.php">단골 상담사</a></li>
				<li><a href="#review">상담후기 운영 정책</a></li>
			</ul>
		</li>
		<li>
			<strong>회원정보</strong>
			<ul>
				<li><a <?php echo preg_match("/register_form/", $_SERVER['PHP_SELF']) ? "class='on'" : ""; ?> href="/bbs/member_confirm.php?url=register_form.php">회원 정보 수정</a></li>
				<li><a href="/bbs/member_confirm.php?url=member_leave.php">회원탈퇴</a></li>
			</ul>
		</li>
<?php
}
include_once G5_PATH.'/mypage_myreview_popup.php';
?>
