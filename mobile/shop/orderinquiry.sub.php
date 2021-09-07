<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (!defined("_ORDERINQUIRY_")) exit; // 개별 페이지 접근 불가

// 테마에 orderinquiry.sub.php 있으면 include
if(defined('G5_THEME_SHOP_PATH')) {
    $theme_inquiry_file = G5_THEME_MSHOP_PATH.'/orderinquiry.sub.php';
    if(is_file($theme_inquiry_file)) {
        include_once($theme_inquiry_file);
        return;
        unset($theme_inquiry_file);
    }
}
?>

<?php if (!$limit) { ?>총 <?php echo $cnt; ?> 건<?php } ?>


<div id="sod_inquiry">
    <ul>
        <?php
        $sql = " select *,
                    (od_cart_coupon + od_coupon + od_send_coupon) as couponprice
                   from {$g5['g5_shop_order_table']}
                  where mb_id = '{$member['mb_id']}'
                  order by od_id desc
                  $limit ";
        $result = sql_query($sql);
        for ($i=0; $row=sql_fetch_array($result); $i++)
        {
            // 주문상품
            $sql = " select it_name, ct_option
                        from {$g5['g5_shop_cart_table']}
                        where od_id = '{$row['od_id']}'
                        order by io_type, ct_id
                        limit 1 ";
            $ct = sql_fetch($sql);
            $ct_name = get_text($ct['it_name']).' '.get_text($ct['ct_option']);

            $sql = " select count(*) as cnt
                        from {$g5['g5_shop_cart_table']}
                        where od_id = '{$row['od_id']}' ";
            $ct2 = sql_fetch($sql);
            if($ct2['cnt'] > 1)
                $ct_name .= ' 외 '.($ct2['cnt'] - 1).'건';

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

            $od_invoice = '';
            if($row['od_delivery_company'] && $row['od_invoice'])
                $od_invoice = '<span class="inv_inv"><i class="fa fa-truck" aria-hidden="true"></i> <strong>'.get_text($row['od_delivery_company']).'</strong> '.get_text($row['od_invoice']).'</span>';

            $uid = md5($row['od_id'].$row['od_time'].$row['od_ip']);
        ?>

        <li>
            <div class="inquiry_idtime">
                <!-- <a href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>" class="idtime_link"><?php echo $row['od_id']; ?></a> -->
                <a class="idtime_link"><?php echo $row['od_id']; ?></a>
                <span class="idtime_time"><?php echo substr($row['od_time'],2,14); ?> (<?php echo get_yoil($row['od_time']); ?>)</span>
            </div>
            <div class="inquiry_name">
                이순신 008번 / 할인상담 / 상담시간: 00:05:30
            </div>
            <div class="inquiry_price">
              <?php echo display_price($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']); ?>
            </div>
            <!-- <div class="inquiry_inv">
                <?php echo $od_invoice; ?>
                <span class="inv_status"><?php echo $od_status; ?></span>
            </div> -->
        </li>

        <?php
        }

        if ($i == 0)
            echo '<li class="empty_list">주문 내역이 없습니다.</li>';
        ?>
    </ul>

    <!--상담사 회원일때-->
    <!-- <div class="tbl_head03 tbl_wrap">
      <table>
        <thead>
          <tr>
            <th>상담종류</th>
            <th>건수</th>
            <th>총 시간</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>일반상담</td>
              <?php
              $mb_con_arr = explode(":",$member['mb_con_time']);
              $mb_con2_arr = explode(":",$member['mb_con_time2']);

              echo "<td> 총 ".$member['mb_con_time_cnt']."건 </td>

              <td>총 ".$mb_con_arr[0]."시간 ".$mb_con_arr[1]."분 ".$mb_con_arr[2]."초</td>";
              ?>
          </tr>

          <tr>
            <td>할인상담</td>
              <?php
              $mb_con_arr = explode(":",$member['mb_con_time']);
              $mb_con2_arr = explode(":",$member['mb_con_time2']);
              echo "<td> 총 ".$member['mb_con_time2_cnt']."건</td>
               <td>총 ".$mb_con2_arr[0]."시간 ".$mb_con2_arr[1]."분 ".$mb_con2_arr[2]."초</td>";
              ?>
          </tr>
        </tbody>

      </table>
    </div> -->

    <!--//상담사 회원일때-->
</div>
