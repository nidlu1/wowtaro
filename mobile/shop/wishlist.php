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
<div class="c_hero">
	<strong>신선운세 <mark>단골 상담사</mark></strong>
</div>
<div class="c_list">
	<div class="cl_menu t1">
		<span>마이페이지</span>
		<span><mark>단골 상담사</mark></span>
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
			<div id="mypage-content">

				<p>나의 상담문의</p>
				<div class="ca_board">
					<table class="cab_table">
				<thead>
					<tr>
						<th scope="col">상담사</th>
						<th scope="col">상담상태</th>
						<th scope="col">등록일시</th>
						<th class="w40"></th>
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

					  <td><strong>상담사</strong><a href="./item.php?it_id=<?php echo $row['mb_no']; ?>" class="info_link"><?php echo stripslashes($row['mb_nick']); ?></a></td>
					  <td><strong>상담상태</strong>상담중</td><!--상담중/상담대기-->
					  <td><strong>등록일시</strong><div class="info_date"><?php echo $row['wi_time']; ?></div></td>
					  <td><strong>등록취소</strong><a href="./wishupdate.php?w=d&amp;wi_id=<?php echo $row['wi_id']; ?>" class="wish_del"><i class="cabt_trash" aria-hidden="true"></i><span class="sound_only">삭제</span></a></td>
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
