<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/mypage_point_list.php');
    return;
}

$od_pwd = get_encrypt_string($od_pwd);

// 회원인 경우
if ($is_member)
{
    $sql_common = " from {$g5['point_table']} where mb_id = '{$member['mb_id']}' ";
}
else // 그렇지 않다면 로그인으로 가기
{
    goto_url(G5_BBS_URL.'/login.php?url='.urlencode(G5_URL.'/mypage_point_list.php'));
}

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

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

$g5['title'] =  '코인내역';

include_once(G5_PATH.'/head.php');
?>

<div class="sub_banner" id="sub_mypage">
  <h2>코인내역</h2>
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
      <p id="sod_v_tit">코인내역</p>
        <div class="tbl_head03 tbl_wrap">
          <table>
            <thead>
              <tr>
                <th scope="col">일시</th>
                <th scope="col">코인내역</th>
                <th scope="col">코인</th>
                <th scope="col">코인합</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = " select *
                         from {$g5['point_table']}
                        where mb_id = '{$member['mb_id']}'
                        order by po_id desc
                        $limit ";
			  //echo $sql;
              $result = sql_query($sql);
              for ($i=0; $row=sql_fetch_array($result); $i++)
              {

				  switch($row['od_settle_case']) {
                      case 'CARD':
                          $od_settle_case = '카드결제';
                          break;
                      case 'VBANK':
                          $od_settle_case = '가상계좌';
                          break;
                      default:
                          $od_settle_case = '카드결제';
                          break;
                  }


              ?>

              <tr>
                <td><?php echo $row['po_datetime']; ?></td>
                <td>
                  <?php echo $row['po_rel_action']; ?>
                </td>
                <td><?php echo number_format($row['po_point']) ?></td><!--무통장입금/카드결제-->
                <td><?php echo number_format($row['po_mb_point']); ?></td>
              </tr>
              <?php
              }

              if ($i == 0)
                  echo '<tr><td colspan="4" class="empty_table"코인충전 내역이 없습니다.</td></tr>';
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
