<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$sct_sort_href = $_SERVER['SCRIPT_NAME'].'?';
if($ca_id)
    $sct_sort_href .= 'ca_id='.$ca_id;
else if($ev_id)
    $sct_sort_href .= 'ev_id='.$ev_id;
if($skin)
    $sct_sort_href .= '&amp;skin='.$skin;
$sct_sort_href .= '&amp;sort=';

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
?>

<!-- 상품 정렬 선택 시작 { -->
	<div class="cl_function">
		<ul>
			<li <?php if($sort == "it_sum_qty") {?> class="on" <?php }?>><a href="<?php echo $sct_sort_href; ?>it_sum_qty&amp;sortodr=desc"><i></i><span>조회높은순</span></a></li>
			<li <?php if($sort == "it_use_cnt") {?> class="on" <?php }?>><a href="<?php echo $sct_sort_href; ?>it_use_cnt&amp;sortodr=desc"><i></i><span>후기많은순</span></a></li>
			<li <?php if($sort == "it_use_avg") {?> class="on" <?php }?>><a href="<?php echo $sct_sort_href; ?>it_use_avg&amp;sortodr=desc"><i></i><span>별점높은순</span></a></li>
		</ul>
		<?php echo $sort_reset; ?>
	</div>
</div>

<!-- } 상품 정렬 선택 끝 -->