<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/mypage_payment_list.php');
    return;
}

$od_pwd = get_encrypt_string($od_pwd);

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

<div class="sub_banner" id="sub_mypage">
  <h2>결제내역</h2>
  <h3 style="color: white "><?=$member['mb_name']?> / <?=$member['mb_nick']?></h3>
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
      <div class="clearfix sod_v_tit_wrap">
        <p id="sod_v_tit">결제내역</p>
        <p class="mp_total_price"> 총 금액 : <span><?php echo number_format($tot_money); ?>원</span> /  총 충전시간 : <span><?php echo $tot_hours; ?>시간 <?php echo $tot_minutes; ?>분 <?php echo $tot_seconds; ?>초</span> </p>
      </div>

        <div class="tbl_head03 tbl_wrap">
          <table>
            <thead>
              <tr>
                <th scope="col">결제일시</th>
                <th scope="col">결제번호</th>
                <th scope="col">결제방법</th>
                <th scope="col">결제금액</th>
				<th scope="col">상태</th>
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
                <td><?php echo substr($row['od_time'],2,14); ?> (<?php echo get_yoil($row['od_time']); ?>)</td>
                <td>
                  <input type="hidden" name="ct_id[<?php echo $i; ?>]" value="<?php echo $row['ct_id']; ?>">
                  <?php echo $row['od_id']; ?>
                </td>
                <td><?php echo $od_settle_case; ?></td><!--무통장입금/카드결제-->
                <td><?php echo display_price($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']); ?></td>
				<td><?php echo $row['od_status']; ?></td>
				<td><?php echo $hours; ?>시간 <?php echo $minutes; ?>분 <?php echo $seconds; ?>초</td>
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
  </div><!--order-wr-->
</div> <!--inner-->
<!-- } 주문 내역 끝 -->

<?php
include_once(G5_PATH.'/tail.php');
?>
