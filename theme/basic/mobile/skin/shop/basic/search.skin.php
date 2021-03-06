<div class="c_hero">
	<strong>신선운세 <mark>검색</mark></strong>
</div>
<div class="c_list" id="search_top">
	<div class="cl_menu">
		<a href="<?php echo G5_URL; ?>"><i></i><span class="blind">HOME</span></a>
		<span>신선운세</span>
		<span><mark><a href="/shop/search.php" class="sct_here">검색</a></mark></span>
	</div>
</div>
<div class="c_area">
	<div class="wrap">
		<div class="ca_find">
			<div class="caf_title">
				<strong>선생님을 찾고 계신가요?</strong>
			</div>
			<div class="caf_search">
				<form action="./search.php" method="get" id="searchKeywordForm">
					<label for="sch_str" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
					<select name="seach_category" id="sch_str">
						<option value="level3">선생님</option>
					</select>
					<label for="keyword" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
					<input type="text" name="q" id="keyword"  placeholder="상담사 닉네임(예명)이나 원하시는 키워드로 검색하세요. " value="<?php echo stripslashes(get_text(get_search_string($q))); ?>">
					<button type="submit" id="sch_submit"><span>검색</span></button>
				</form>
			</div>
			<p class="caf_txt"><mark>태그 선택</mark><span>원하는 상담분야 태그를 선택하여 빠르고 편하게 선생님을 찾아보세요.</span></p>
			<ul class="caf_list">
				<?php
				while ($row_hashtag = sql_fetch_array($result_hashtag)){
				?>
				<li><a href="./search.php?mb_hashtag=<?=$row_hashtag['mg_hashtag']?>#search_top" class="tag">#<?=$row_hashtag['mg_hashtag']?></a></li>
				<?php } ?>
			</ul>
		</div>
		<ul class="ca_member">
			<?php
            $result = sql_query($sql);
            // echo $sql."<br>";
			for ($i = 1; $row = sql_fetch_array($result); $i++) {
				if ($item_mod >= 2) { // 1줄 이미지 : 2개 이상
					if ($i % $item_mod == 0)
						$sct_last = 'sct_last'; // 줄 마지막
					else if ($i % $item_mod == 1)
						$sct_last = 'sct_clear'; // 줄 첫번째
					else
						$sct_last = '';
				} else { // 1줄 이미지 : 1개
					$sct_last = 'sct_clear';
				}

				$bcat_arr = b_cat_func($row['mb_1']);
				$scat_arr = s_cat_func($row['mb_2']);

				//$l = mt_rand( 0, (count($bcat_arr) - 1) );
				$l = searchForId3($row['mb_use'], $bcat_arr);
				//echo "j==> ".$l;
				switch ($bcat_arr[$l]['ca_id']) {
					case '10' :
						$bcat_str = "taro";
						$bcat_bg = "back_taro";
						break;
					case '20' :
						$bcat_str = "sin";
						$bcat_bg = "back_shinjeom";
						break;
					case '30' :
						$bcat_str = "saju";
						$bcat_bg = "back_saju";
						break;
					case '40' :
						$bcat_str = "pet";
						$bcat_bg = "back_pettaro";
						break;
					case '50' :
						$bcat_str = "dream";
						$bcat_bg = "back_dream";
						break;
					default :
						$bcat_str = "taro";
						$bcat_bg = "back_taro";
						break;
				}
				?>
				<li>
					<a href="<?php echo G5_SHOP_URL; ?>/item.php?ca_id=<?php echo $bcat_arr[$l]['ca_id']; ?>&it_id=<?php echo $row['mb_no']; ?>" class="cam_wrap">
						<div class="cam_pic">
							<div>
								<img src="<?php echo G5_DATA_URL; ?>/temp/<?php echo $row['mb_no']; ?>/<?php echo $row['mb_8']; ?>" alt="<?php echo $row['mb_nick']; ?> <?php echo $row['mb_id']; ?>번">
								<?php
									if ( $mb_st ) $row['mb_status'] = $mb_st;

									if ( $row['mb_status'] == 2 ) {
										$mb_status = "상담가능";
										$mb_status_css = "tel-avail";
										$mb_status_img = "1";
									}
									else if ( $row['mb_status'] == 1 ) {
										$mb_status = "상담중";
										$mb_status_css = "tel-ing";
										$mb_status_img = "2";
									}
									else {
										$mb_status = "예약대기";
										$mb_status_css = "tel-disabled";
										$mb_status_img = "3";
									}
								?>
							</div>
						</div>
						<div class="cam_info">
							<div class="cami_title">
								<span><?php echo $row['mb_nick']; ?> <mark><?php echo $row['mb_id']; ?>번</mark></span>
							</div>
							<div class="cami_txt">
								<span><?php echo $row['mb_9']; ?></span>
							</div>
						</div>
						<div class="cam_middle">
							<div class="cam_score">
								<?php
								$sql = "SELECT AVG(is_score) is_score, COUNT(is_id) cnt, IFNULL(SUM( IF( is_reply_name<>'',1,0 ) ),0) re_cnt FROM ".$g5['g5_shop_item_use_table']." WHERE it_id='".$row['mb_no']."' AND is_cat2='".$bcat_arr[$l]['ca_name']."'";
								$use_dt = sql_fetch($sql);

								$star_str = "";
								for ($jj = 1; $jj <= 5; $jj++) {
									if ($jj <= intval($use_dt['is_score'])) $star_str .= "<i class='cam_icon on'></i>";
									else $star_str .= "<i class='cam_icon off'></i>";
								}
								?>
								<span class="cams_star"><?php echo $star_str; ?>
									<mark><?php echo number_format($use_dt['is_score'],1); ?></mark>
								</span>
								<span class="cams_total">
									<div><span>상담후기</span><mark><?php echo $use_dt['cnt']; ?></mark></div>
								</span>
							</div>
							<div class="cam_status <?php echo $mb_status_css ?>">
								<span><?php echo $mb_status ?></span>
							</div>
						</div>
						<!--분류 추가-->
						<div class="cam_sort">
							<?php
							for ($j = 0; $j < 3; $j++) {
							if($scat_arr[$j]['ht_name'] == ""){
								continue;
							}
							?>
							<span><?php echo $scat_arr[$j]['ht_name']; ?></span>
							<?php
							}
							?>
						</div>
					</a>
				</li>
				<?php
			}

			if ($i == 1)
				echo "<p class=\"sct_noitem title t1 cg bold\">등록된 선생님이 없습니다.</p>\n";
			?>
		</ul>
	</div>
</div>
<script type="text/javascript">
    $(function () {

        $(".tip_button").on("click", function () {
            $(".pop-bg2").show();
        });

        $(".pop2 .pop-close").on("click", function () {
            $(".pop-bg2").hide();
        });
    });
</script>
<div id="sct_thtml">
</div>