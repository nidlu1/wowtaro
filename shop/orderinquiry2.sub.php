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
<div class="ca_board">
	<table class="cab_table">
    <thead>
      <tr>
        <th>상담종류</th>
		<th>상담 월</th>
        <th>상담 건수</th>
        <th>예약대기 건수</th>
        <th>총 시간</th>
      </tr>
    </thead>

    <tbody>
      <tr>
        <td class="cg">일반상담</td>
		<td><?php echo $member['mb_con_mon'] ? $member['mb_con_mon']." 월" : "";?></td>
          <?php
          $mb_con_arr = explode(":",$member['mb_con_time']);
          $mb_con2_arr = explode(":",$member['mb_con_time2']);

          echo "<td> 총 ".$member['mb_con_time_cnt']."건 </td>
          <td> 총 ".$member['mb_miss']."건 </td>
          <td>총 ".$mb_con_arr[0]."시간 ".$mb_con_arr[1]."분 ".$mb_con_arr[2]."초</td>";
          ?>
      </tr>

      <tr>
        <td class="cg">할인상담</td>
		<td><?php echo $member['mb_con_mon'] ? $member['mb_con_mon']." 월" : "";?></td>
          <?php
          $mb_con_arr = explode(":",$member['mb_con_time']);
          $mb_con2_arr = explode(":",$member['mb_con_time2']);
          echo "<td> 총 ".$member['mb_con_time2_cnt']."건</td>
          <td> 총 ".$member['mb_miss2']."건 </td>
           <td>총 ".$mb_con2_arr[0]."시간 ".$mb_con2_arr[1]."분 ".$mb_con2_arr[2]."초</td>";
          ?>
      </tr>
    </tbody>

  </table>
</div>

<!-- <?php if (!$limit) { ?>총 <?php echo $cnt; ?> 건<?php } ?>
<div class="">
<?php
$mb_con_arr = explode(":",$member['mb_con_time']);
$mb_con2_arr = explode(":",$member['mb_con_time2']);
echo "일반상담 총 ".$member['mb_con_time_cnt']."건, 총 ".$mb_con_arr[0]."시간 ".$mb_con_arr[1]."분 ".$mb_con_arr[2]."초<br>";
echo "할인상담 총 ".$member['mb_con_time2_cnt']."건, 총 ".$mb_con2_arr[0]."시간 ".$mb_con2_arr[1]."분 ".$mb_con2_arr[2]."초";
?> -->

<!-- } 주문 내역 목록 끝 -->
