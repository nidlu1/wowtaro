<?php
include_once('./_common.php');

if (!$is_member)
    goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_SHOP_URL.'/wishlist.php'));

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/wishlist.php');
    return;
}

// 테마에 wishlist.php 있으면 include
if(defined('G5_THEME_SHOP_PATH')) {
    $theme_wishlist_file = G5_THEME_SHOP_PATH.'/wishlist.php';
    if(is_file($theme_wishlist_file)) {
        include_once($theme_wishlist_file);
        return;
        unset($theme_wishlist_file);
    }
}

$g5['title'] = "단골 상담사";
include_once('./_head.php');
?>

<!-- 위시리스트 시작 { -->


<div class="sub_banner" id="sub_mypage">
  <h2>단골상담사</h2>
  <h3 style="color: white "><?=$member['mb_name']?> / <?=$member['mb_nick']?></h3>
</div>

<div class="inner">
  <div class="order-wr clearfix">
    <ul class="mypage-tab">
	<?php
	include_once(G5_SHOP_PATH.'/mymenu.php');
	?>
    </ul>



<div id="sod_ws">

  <p id="sod_v_tit">나의 상담문의</p>
  <div class="tbl_head03 tbl_wrap">
    <table>
      <thead>
        <tr>
          <th scope="col">상담사</th>
          <th scope="col">상담상태</th>
          <th scope="col">등록일시</th>
          <th scope="col"></th>
        </tr>
      </thead>
    <form name="fwishlist" method="post" action="./cartupdate.php">
    <input type="hidden" name="act"       value="multi">
    <input type="hidden" name="sw_direct" value="">
    <input type="hidden" name="prog"      value="wish">


      <tbody>
	<?php
    $sql  = " select a.wi_id, a.wi_time, b.* from {$g5['g5_shop_wish_table']} a left join {$g5['member_table']} b on ( a.it_id = b.mb_no ) ";
    $sql .= " where a.mb_id = '{$member['mb_id']}' order by a.wi_id desc ";
    $result = sql_query($sql);
    for ($i=0; $row = sql_fetch_array($result); $i++) {

        //$out_cd = '';
        //$sql = " select count(*) as cnt from {$g5['g5_shop_item_option_table']} where it_id = '{$row['it_id']}' and io_type = '0' ";
        //$tmp = sql_fetch($sql);
        //if($tmp['cnt'])
            //$out_cd = 'no';

        //$it_price = get_price($row);

        if ($row['it_tel_inq']) $out_cd = 'tel_inq';

        //$image = get_it_image($row['it_id'],230, 230);
    ?>

        <tr>

          <td><a href="./item.php?it_id=<?php echo $row['mb_no']; ?>" class="info_link"><?php echo stripslashes($row['mb_nick']); ?></a></td>
          <td>상담중</td><!--상담중/상담대기-->
          <td><div class="info_date"><?php echo $row['wi_time']; ?></div></td>
          <td><a href="./wishupdate.php?w=d&amp;wi_id=<?php echo $row['wi_id']; ?>" class="wish_del"><i class="fa fa-trash" aria-hidden="true"></i><span class="sound_only">삭제</span></a></td>
        </tr>

              <?php
              }

              if ($i == 0)
                  echo '<tr><td colspan=4><li class="empty_table">보관함이 비었습니다.</li></td></tr>';
              ?>
      </tbody>
	</table>
  </div>


</div>
</div><!--order-wr-->
</div> <!--inner-->
<script>
<!--
    function out_cd_check(fld, out_cd)
    {
        if (out_cd == 'no'){
            alert("옵션이 있는 상품입니다.\n\n상품을 클릭하여 상품페이지에서 옵션을 선택한 후 주문하십시오.");
            fld.checked = false;
            return;
        }

        if (out_cd == 'tel_inq'){
            alert("이 상품은 전화로 문의해 주십시오.\n\n장바구니에 담아 구입하실 수 없습니다.");
            fld.checked = false;
            return;
        }
    }

    function fwishlist_check(f, act)
    {
        var k = 0;
        var length = f.elements.length;

        for(i=0; i<length; i++) {
            if (f.elements[i].checked) {
                k++;
            }
        }

        if(k == 0)
        {
            alert("상품을 하나 이상 체크 하십시오");
            return false;
        }

        if (act == "direct_buy")
        {
            f.sw_direct.value = 1;
        }
        else
        {
            f.sw_direct.value = 0;
        }

        return true;
    }
//-->
</script>
<!-- } 위시리스트 끝 -->

<?php
include_once('./_tail.php');
?>
