<?php
include_once('./_common.php');

// 테마에 wishlist.php 있으면 include
if(defined('G5_THEME_SHOP_PATH')) {
    $theme_wishlist_file = G5_THEME_MSHOP_PATH.'/wishlist.php';
    if(is_file($theme_wishlist_file)) {
        include_once($theme_wishlist_file);
        return;
        unset($theme_wishlist_file);
    }
}

$g5['title'] = "단골 상담사";
include_once(G5_MSHOP_PATH.'/_head.php');
?>
<div class="sub_banner" id="sub_mypage">
  <h2>단골 상담사</h2>
</div>

    <ul class="mypage-tab">
	<?php
	include_once(G5_SHOP_PATH.'/mymenu.php');
	?>
      <li><a>&nbsp;</a></li>
    </ul>
<div id="sod_ws">

    <form name="fwishlist" method="post" action="./cartupdate.php">
    <input type="hidden" name="act"       value="multi">
    <input type="hidden" name="sw_direct" value="">
    <input type="hidden" name="prog"      value="wish">
    <ul id="wish_li">
    <?php
        $sql  = " select a.wi_id, a.wi_time, b.* from {$g5['g5_shop_wish_table']} a left join {$g5['member_table']} b on ( a.it_id = b.mb_no ) ";
		$sql .= " where a.mb_id = '{$member['mb_id']}' order by a.wi_id desc ";
		$result = sql_query($sql);
        for ($i=0; $row = sql_fetch_array($result); $i++) {
//print_r($row);
            //$out_cd = '';
            //$sql = " select count(*) as cnt from {$g5['g5_shop_item_option_table']} where it_id = '{$row['it_id']}' and io_type = '0' ";
            //$tmp = sql_fetch($sql);
            //if($tmp['cnt'])
            //    $out_cd = 'no';

            //$it_price = get_price($row);

            //if ($row['it_tel_inq']) $out_cd = 'tel_inq';

            //$image = get_it_image($row['it_id'], 70, 70);
			$image = '<img src="'.G5_DATA_URL.'/temp/'.$row['mb_no'].'/'.$row['mb_8'].'" width="70" alt="">';
    ?>

        <li>
            <div class="wish_img teacher_back_common back_taro">
              <!-- 선생님 배경이미지 : 클래스, 배경이미지 바뀜(sct_img 뒤에 클래스 추가)
              타로 일때 : back_taro (현재 예시로 설정해 놓음)
              꿈해몽 일떄 : back_dream
              펫타로 일때 : back_taro
              사주 일떄 : back_saju
              신점 일때 : back_shinjeom -->
              <a href="<?php echo G5_SHOP_URL; ?>/item.php?it_id=<?php echo $row['mb_no']; ?>"><?php echo $image; ?></a>
            </div>
            <div class="wish_info">
                <a href="<?php echo G5_SHOP_URL; ?>/item.php?it_id=<?php echo $row['mb_no']; ?>" class="wish_prd"><?php echo stripslashes($row['mb_nick']); ?></a>
                <span class="info_date"> <?php echo substr($row['wi_time'], 2, 17); ?></span>

                <div class="wish_chk">
                    <input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $row['mb_no']; ?>">
                    <input type="hidden" name="io_type[<?php echo $row['mb_no']; ?>][0]" value="0">
                    <input type="hidden" name="io_id[<?php echo $row['mb_no']; ?>][0]" value="">
                    <input type="hidden" name="io_value[<?php echo $row['mb_no']; ?>][0]" value="<?php echo $row['mb_nick']; ?>">
                    <input type="hidden"   name="ct_qty[<?php echo $row['mb_no']; ?>][0]" value="1">
                </div>
                <span class="wish_del"><a href="<?php echo G5_SHOP_URL; ?>/wishupdate.php?w=d&amp;wi_id=<?php echo $row['wi_id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i><span class="sound_only">삭제</span></a></span>
            </div>

        </li>
        <?php
        }
        if ($i == 0)
            echo '<li class="empty_table">보관함이 비었습니다.</li>';
        ?>
    </ul>

    </form>
</div>

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

<?php
include_once(G5_MSHOP_PATH.'/_tail.php');
?>
