<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (!defined("_ORDERINQUIRY_")) exit; // 개별 페이지 접근 불가

// 테마에 orderinquiry.sub.php 있으면 include
if(defined('G5_THEME_SHOP_PATH')) {
    $theme_inquiry_file = G5_THEME_SHOP_PATH.'/orderinquiry.sub.php';
    if(is_file($theme_inquiry_file)) {
        include_once($theme_inquiry_file);
        return;
        unset($theme_inquiry_file);
    }
}
?>

<!-- 주문 내역 목록 시작 { -->
<?php if (!$limit) { ?>총 <?php echo $cnt; ?> 건<?php } ?>

<div class="tbl_head03 tbl_wrap">
    <table>
    <thead>
    <tr>
      <th scope="col" class="counsel-datetime">상담일시</th>
      <th scope="col" class="cate">구분</th>
      <!--th scope="col" class="counselor">상담사</th-->
      <th scope="col" class="counsel-time">상담시간</th>
      <th scope="col" class="used-coin">사용코인</th>
        <th scope="col">주문서번호</th>

        <!-- <th scope="col">상품수</th> -->

        <!-- <th scope="col">입금액</th>
        <th scope="col">미입금액</th> -->
        <!-- <th scope="col">상태</th> -->
    </tr>
    </thead>
    <tbody>
    <?php
    $sql = " select *
               from {$g5['g5_shop_order_table']}
              where mb_id = '{$member['mb_id']}'
              order by od_id desc
              $limit ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
		$pwd_value = substr($row['od_hp'],-4);
		$ch = curl_init("http://060300.co.kr/dc-info/user_remaining_secs.php?cp=$cp&svc=$svc&tel=".$row['od_hp']."&pwd=".$pwd_value."");
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 1);
		$ret = curl_exec($ch);
		curl_close($ch);
		$hours = floor($ret / 3600);
		$minutes = floor(($ret / 60) % 60);
		$seconds = $ret % 60;
		//echo $hours."시간 ".$minutes."분 ".$seconds."초";
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
    ?>

    <tr>
      <td><?php echo substr($row['od_time'],2,14); ?> (<?php echo get_yoil($row['od_time']); ?>)</td>
      <td><?=$row["od_settle_case"]?></td><!--할인상담/일반상담-->
      <!--td>이순신</td-->
      <td><?php echo $hours; ?>:<?php echo $minutes; ?>:<?php echo $seconds; ?></td>
      <td><?php echo ($ret * 10); ?></td>
        <td>
            <input type="hidden" name="ct_id[<?php echo $i; ?>]" value="<?php echo $row['ct_id']; ?>">
            <!-- <a href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>"><?php echo $row['od_id']; ?></a> -->
            <a><?php echo $row['od_id']; ?></a>
        </td>

        <!-- <td class="td_numbig"><?php echo $row['od_cart_count']; ?></td> 상품수-->

        <!-- <td class="td_numbig text_right"><?php echo display_price($row['od_receipt_price']); ?>압금액</td>
        <td class="td_numbig text_right"><?php echo display_price($row['od_misu']); ?></td> 미입금액-->
        <!-- <td><?php echo $od_status; ?></td> 상태-->
    </tr>

    <?php
    }

    if ($i == 0)
        echo '<tr><td colspan="5" class="empty_table"상담 내역이 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>
<!-- } 주문 내역 목록 끝 -->
