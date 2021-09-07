<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>



<!-- 전체 상품 사용후기 목록 시작 { -->
<!-- <form method="get" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
<div id="sps_sch">
    <div class="sch_wr">
        <label for="sfl" class="sound_only">검색항목</label>
        <select name="sfl" id="sfl" required>
            <option value="">선택</option>
            <option value="b.it_name"   <?php echo get_selected($sfl, "b.it_name"); ?>>상품명</option>
            <option value="a.it_id"     <?php echo get_selected($sfl, "a.it_id"); ?>>상품코드</option>
            <option value="a.is_subject"<?php echo get_selected($sfl, "a.is_subject"); ?>>후기제목</option>
            <option value="a.is_content"<?php echo get_selected($sfl, "a.is_content"); ?>>후기내용</option>
            <option value="a.is_name"   <?php echo get_selected($sfl, "a.is_name"); ?>>작성자명</option>
            <option value="a.mb_id"     <?php echo get_selected($sfl, "a.mb_id"); ?>>작성자아이디</option>
        </select>
        <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" required class="sch_input" size="10">
        <button type="submit" value="검색" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
    </div>
    <a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">전체보기</a>

</div>
</form> -->
<div class="c_hero" id="c_review">
	<strong>신선운세 <mark>상담후기</mark></strong>
</div>
<div class="c_list">
	<div class="cl_menu">
		<a href='<?php echo G5_URL; ?>/'><i></i><span class="blind">HOME</span></a>
		<span>신선운세</span>
		<span><mark><a href="/shop/itemuselist.php">상담후기</a></mark></span>
	</div>
</div>
<div class="wrap">
    <!-- <p><?php echo $config['cf_title']; ?> 전체 사용후기 목록입니다.</p> -->
	<div class="c_area review">
		<div class="ca_tabs" id="ca_tab">
			<ul>
				<li<?php echo $_REQUEST['gubun']=="" ? " class='on'" : ""; ?>><a href="<?php echo G5_SHOP_URL; ?>/itemuselist.php#ca_tab"><span>전체상담후기</span></a></li>
				<li<?php echo $_REQUEST['gubun']=="best" ? " class='on'" : ""; ?>><a href="<?php echo G5_SHOP_URL; ?>/itemuselist.php?gubun=best#ca_tab"><span>베스트후기</span></a></li>
				<li<?php echo $_REQUEST['gubun']=="할인상담" ? " class='on'" : ""; ?>><a href="<?php echo G5_SHOP_URL; ?>/itemuselist.php?gubun=할인상담#ca_tab"><span>할인상담후기</span></a></li>
				<li<?php echo $_REQUEST['gubun']=="일반상담" ? " class='on'" : ""; ?>><a href="<?php echo G5_SHOP_URL; ?>/itemuselist.php?gubun=일반상담#ca_tab"><span>일반상담후기</span></a></li>
			</ul>
		</div>
		<div class="ca_policy">
			<a href="#review">상담후기 운영 정책</a>
		</div>

		<?php
		$thumbnail_width = 500;

		for ($i=0; $row=sql_fetch_array($result); $i++)
		{
			$num = $total_count - ($page - 1) * $rows - $i;
			$star = get_star($row['is_score']);

			$is_content = get_view_thumbnail(conv_content($row['is_content'], 1), $thumbnail_width);

			$row2 = sql_fetch(" select it_name from {$g5['g5_shop_item_table']} where it_id = '{$row['it_id']}' ");
			$it_href = G5_SHOP_URL."/item.php?it_id={$row['it_id']}";

			if ($i == 0) echo '<ol class="ca_member">';
		?>
		<li>
		 <!--  <div class="sps_img">
		  			  <a href="<?php echo $it_href; ?>">
		  				  <?php echo get_itemuselist_thumbnail($row['it_id'], $row['is_content'], 100, 100); ?>
		  				  <span><?php echo $row2['it_name']; ?></span>
		  			  </a>
		  </div> -->
			<?php
			$bcat_arr = b_cat_func($row['mb_1']);
			$scat_arr = s_cat_func($row['mb_2']);

			$l = searchForId("ca_name", $row['is_cat2'], $bcat_arr);

			//switch ($bcat_arr[$j]['ca_name']) {
			switch ($row['is_cat2']) {
				case '타로' :
					$bcat_str = "taro";
					$bcat_bg = "back_taro";
					break;
				case '신점' :
					$bcat_str = "sin";
					$bcat_bg = "back_shinjeom";
					break;
				case '사주' :
					$bcat_str = "saju";
					$bcat_bg = "back_saju";
					break;
				case '펫타로' :
					$bcat_str = "pet";
					$bcat_bg = "back_pettaro";
					break;
				case '꿈해몽' :
					$bcat_str = "dream";
					$bcat_bg = "back_dream";
					break;
				default :
					$bcat_str = "taro";
					$bcat_bg = "back_taro";
					break;
			}
			?>
			<div class="cam_wrap">
				<a href="#review_<?php echo $i ?>">
					<div class="cam_pic">
						<div class="camp_wrap">
							<img src="<?php echo G5_DATA_URL; ?>/temp/<?php echo $row['mb_no']; ?>/<?php echo $row['mb_8']; ?>"alt="<?php echo $row['mb_nick']; ?> <?php echo $row['mb_id']; ?>번">
						</div>
						<div class="camp_content">
							<div class="campc_status">
								<span><?php echo $row['is_cat2'];?></span>
							</div>
							<span><?php echo $row['mb_nick']; ?> <mark><?php echo $row['mb_id']; ?>번</mark></span>
						</div>
					</div>
					<div class="cam_info">
						<div class="cami_content">
							<span class="calic_category"><?php echo $row['is_best'] == 1 ? "BEST" : ""; ?><?php echo $row['is_cat']; ?></span>
							<h2><?php echo $row['is_name']; ?></h2>
						</div>
						<div class="cami_txt">
							<span class="cami_hover">
								<?php echo $is_content; // 사용후기 내용 ?>
							</span>
						</div>
					</div>
					<div class="cam_bottom">
						<div class="fl">
							<div class="camb_item">
								<?php
								$star_str = "";
								for ($jj = 1; $jj <= 5; $jj++) {
									if ($jj <=  $star) $star_str .= "<i class='camei_icon on'></i>";
									else $star_str .= "<i class='camei_icon off'></i>";
								}
								?>
								<span class="camei_star"><?php echo $star_str; ?>
									<mark><?php echo number_format($star,1); ?></mark>
								</span>
							</div>
						</div>
						<div class="fr">
							<div class="camb_item">
								<?php
								if( !empty($row['is_reply_subject']) ){
								  echo "<mark>1개의 댓글이 있습니다.</mark>";
								} ?>
							</div>
						</div>
					</div>
						</a>
					<div class="popup t6 review_<?php echo $i; ?>">
						<div class="p_box">
							<a href="#!" class="p_close"><span class="blind">닫기</span></a>
							<div class="pb_state">
								<div class="pbs_data">
									<span class="pbsd_category"><?php echo $row['is_best'] == 1 ? "BEST" : ""; ?><?php echo $row['is_cat']; ?></span>
									<h2><?php echo $row['is_name']; ?></h2>

									<?php
									$star_str = "";
									for ($jj = 1; $jj <= 5; $jj++) {
										if ($jj <=  $star) $star_str .= "<i class='pbsd_icon on'></i>";
										else $star_str .= "<i class='pbsd_icon off'></i>";
									}
									?>
									<span class="pbsd_star"><?php echo $star_str; ?>
										<mark><?php echo number_format($star,1); ?></mark>
									</span>
								</div>
								<div id="sps_con_<?php echo $i; ?>" class="pbs_txt">
									<?php echo $is_content; // 사용후기 내용 ?>

									<?php
									if( !empty($row['is_reply_subject']) ){
									  echo "<mark class=\"pbst_toggle\">1개의 댓글이 있습니다.</mark>";
									} ?>

									<?php
									if( !empty($row['is_reply_subject']) ){     //사용후기 답변이 있다면
										$is_reply_content = get_view_thumbnail(conv_content($row['is_reply_content'], 1), $thumbnail_width);
									?>
									<div class="pbst_reply" style="display: none;">
										<strong><?php echo $row['is_reply_name']; ?></strong>
										<span id="sps_con_<?php echo $i; ?>_reply">
											<?php echo $is_reply_content; // 사용후기 답변 내용 ?>
										</span>
									</div>
									<?php }     //end if ?>
								</div>
							</div>
						</div>
					<a href="#!" class="p_out"><span class="blind">닫기</span></a>
				</div>
			</div>
		</li>
		<?php }
		if ($i > 0) echo '</ol>';
		if ($i == 0) echo '<p class="title cg">자료가 없습니다.</p>';
		?>

		<!--button type="button" class="more_btn" name="button">후기 더보기 <i class="xi-angle-down-min"></i></button-->
		<?php echo get_paging_moblie($config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>
	</div>
</div>


<script>
$(function(){
    // 사용후기 더보기
     $(".pbst_toggle").click(function(){
        var $con = $(this).next('.pbst_reply');
        if($con.is(":visible")) {
            $con.hide();
            $(this).html("1개의 댓글이 있습니다.");
        } else {
          $con.show();
          $(this).html("댓글접기");
        }
    });

    $(".sps_con_btn button").click(function(){
        var $con = $(this).parent().prev();
        if($con.is(":visible")) {
            $con.slideUp();
            $(this).html("내용보기 <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i>");
        } else {
            $(".sps_con_btn button").html("내용보기 <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i>");
            $("div[id^=sps_con]:visible").hide();
            $con.slideDown(
                function() {
                    // 이미지 리사이즈
                    $con.viewimageresize2();
                }
            );
            $(this).html("내용닫기 <i class=\"fa fa-caret-up\" aria-hidden=\"true\"></i>");
        }
    });

  //상담후기 운영정책 팝업
  $('.review_pop_open').click(function(){
    $('.review_pop').show();
  });
  $('.review_pop_close').click(function(){
    $('.review_pop').hide();
  });
});
</script>
<!-- } 전체 상품 사용후기 목록 끝 -->
