<?php
include_once('./_common.php');

$od_pwd = get_encrypt_string($od_pwd);

if ($member['mb_level'] == 3) {
    header('Location: ./shop/orderinquiry2.php');
}

// 회원인 경우
if ($is_member)
{
    $sql_common = " from {$g5['g5_shop_order_table']} where mb_id = '{$member['mb_id']}' AND od_status='입금' ";
}
else if ($od_id && $od_pwd) // 비회원인 경우 주문서번호와 비밀번호가 넘어왔다면
{
    $sql_common = " from {$g5['g5_shop_order_table']} where od_id = '$od_id' and od_pwd = '$od_pwd' ";
}
else // 그렇지 않다면 로그인으로 가기
{
    goto_url(G5_BBS_URL.'/login.php?url='.urlencode(G5_URL.'/mypage_payment_list.php'));
}

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt, SUM(od_cart_price) as tot_money, SUM(od_pay_time) as tot_time " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];
$tot_money = $row['tot_money'];
$tot_time = $row['tot_time'];
$tot_hours = floor($tot_time / 3600);
$tot_minutes = floor(($tot_time / 60) % 60);
$tot_seconds = $tot_time % 60;

// 비회원 주문확인시 비회원의 모든 주문이 다 출력되는 오류 수정
// 조건에 맞는 주문서가 없다면
if ($total_count == 0)
{
    /*if ($is_member) // 회원일 경우는 메인으로 이동
        alert('주문이 존재하지 않습니다.', G5_SHOP_URL);
    else // 비회원일 경우는 이전 페이지로 이동
        alert('주문이 존재하지 않습니다.');*/
}

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함


// 비회원 주문확인의 경우 바로 주문서 상세조회로 이동
if (!$is_member)
{
    $sql = " select od_id, od_time, od_ip from {$g5['g5_shop_order_table']} where od_id = '$od_id' and od_pwd = '$od_pwd' ";
    $row = sql_fetch($sql);
    if ($row['od_id']) {
        $uid = md5($row['od_id'].$row['od_time'].$row['od_ip']);
        set_session('ss_orderview_uid', $uid);
        goto_url(G5_SHOP_URL.'/orderinquiryview.php?od_id='.$row['od_id'].'&amp;uid='.$uid);
    }
}
$g5['title'] =  '결제내역';

include_once(G5_PATH.'/head.php');
?>

<div class="c_hero">
	<strong>신선운세 <mark>결제내역</mark></strong>
</div>
<div class="c_list">
	<div class="cl_menu t1">
		<span>마이페이지</span>
		<span><mark>결제내역</mark></span>
	</div>
	<button type="button" class="cl_btn"><span class="blind"></span></button>
</div>
<ul id="mypage-tab">
	<?php
	include_once(G5_SHOP_PATH.'/mymenu.php');
	?>
</ul>
<div class="c_area mypage">
	<div class="wrap">
		<ul class="ca_function">
			<li><span><?php echo $member['mb_name']; ?>님</span></li>
				<?php
			switch($member['mb_grade']) {
				case "1" :
					echo '<li><span><div class="caf_rank"><img src="/images/common/icon_rank01.svg"></div><b>나그네회원</b></span></li>';
					break;
				case "2" :
					echo '<li><span><div class="caf_rank"><img src="/images/common/icon_rank02.svg"></div><b>열심회원</b></span></li>';
					break;
				case "3" :
					echo '<li><span><div class="caf_rank"><img src="/images/common/icon_rank03.svg"></div><b>성실회원</b></span></li>';
					break;
				case "4" :
					echo '<li><span><div class="caf_rank"><img src="/images/common/icon_rank04.svg"></div><b>충성회원</b></span></li>';
					break;
				case "5" :
				case "6" :
					echo '<li><span><div class="caf_rank"><img src="/images/common/icon_rank05.svg"></div><b>신선회원</b></span></li>';
					break;
				default :
					echo '<li><span><div class="caf_rank"><img src="/images/common/icon_rank01.svg"></div><b>나그네회원</b></span></li>';
					break;
			}
			//보유 포인트 확인
			$sql = "select * from {$g5['point_table']} where mb_id = '{$member['mb_id']}' order by po_id DESC";
			$row = sql_fetch($sql);
			?>
			<li><span><i class="icon money"></i>보유 <mark class="cs"><?=number_format($row['po_mb_point'])?></mark> coin</span></li>
		</ul>
  <!-- 주문 내역 시작 { -->
		<div id="mypage-content" class="payment">
			 <p>결제내역</p>
			<div class="ca_charge">
				<p class="cah_info price"> 총 금액 : <span><?php echo number_format($tot_money); ?>원</span></p>
				<p class="cah_info time">총 충전시간 : <span><?php echo $tot_hours; ?>시간 <?php echo $tot_minutes; ?>분 <?php echo $tot_seconds; ?>초</span> </p>
			</div>
				<div class="ca_board">
				  <table class="cab_table">
					<thead>
					  <tr>
						<th scope="col">결제일시</th>
						<th scope="col">결제번호</th>
						<th class="w45">결제방법</th>
						<th class="w45">결제금액</th>
						<th class="w35">상태</th>
						<th scope="col">충전시간</th>
					  </tr>
					</thead>
					<tbody>
					  <?php
					  $sql = " select *
								 from {$g5['g5_shop_order_table']}
								where mb_id = '{$member['mb_id']}' AND od_status IN ('입금','취소')
								order by od_id desc
								$limit ";
					  //echo $sql;
					  $result = sql_query($sql);
					  for ($i=0; $row=sql_fetch_array($result); $i++)
					  {
						  $uid = md5($row['od_id'].$row['od_time'].$row['od_ip']);

						  switch($row['od_status']) {
							  case '주문':
								  $od_status = '<span class="status_01">입금확인중</span>';
								  break;
							  case '입금':
								  $od_status = '<span class="status_02">입금완료</span>';
								  break;
							  case '준비':
								  $od_status = '<span class="status_03">상품준비중</span>';
								  break;
							  case '배송':
								  $od_status = '<span class="status_04">상품배송</span>';
								  break;
							  case '완료':
								  $od_status = '<span class="status_05">배송완료</span>';
								  break;
							  default:
								  $od_status = '<span class="status_06">주문취소</span>';
								  break;
						  }

						  switch($row['od_settle_case']) {
							  case 'CARD':
								  $od_settle_case = '카드결제';
								  break;
							  case 'VBANK':
								  $od_settle_case = '가상계좌';
								  break;
							  case '5분무료':
								  $od_settle_case = '5분무료';
								  break;
							  case '10분무료':
								  $od_settle_case = '10분무료';
								  break;
							  case '무통장':
								  $od_settle_case = '무통장';
								  break;
							  default:
								  $od_settle_case = '카드결제';
								  break;
						  }

						  $hours = floor($row['od_pay_time'] / 3600);
						  $minutes = floor(($row['od_pay_time'] / 60) % 60);
						  $seconds = $row['od_pay_time'] % 60;
					  ?>

					  <tr>
						<td><strong>결제일시</strong><?php echo substr($row['od_time'],2,14); ?> (<?php echo get_yoil($row['od_time']); ?>)</td>
						<td class="breakall">
							<strong>결제번호</strong>
							<input type="hidden" name="ct_id[<?php echo $i; ?>]" value="<?php echo $row['ct_id']; ?>">
							<?php echo $row['od_id']; ?>
						</td>
						<td><strong>결제방법</strong><?php echo $od_settle_case; ?></td><!--무통장입금/카드결제-->
						<td><strong>결제금액</strong><?php echo display_price($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']); ?></td>
						<td><strong>상태</strong><?php echo $row['od_status']; ?></td>
						<td><strong>충전시간</strong><span><?php echo $hours; ?>시간</span> <span><?php echo $minutes; ?>분</span> <span><?php echo $seconds; ?>초</span></td>
					  </tr>
					  <?php
					  }

					  if ($i == 0)
						  echo '<tr><td colspan="7" class="empty_table"코인충전 내역이 없습니다.</td></tr>';
					  ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- } 주문 내역 끝 -->

<?php
include_once(G5_PATH.'/tail.php');
?>
