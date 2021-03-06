<style>
    .search-page-form{
        text-align: center;
    }
    .search-page-form .subject {
        display: inline-block;
        width: 600px;
        text-align: left;
    }
    .subject, .search-tag_area .subject{
        font-size: 18px;
        color: #222;
        font-weight: 600;
        margin-bottom: 10px;        
    }
    .search-page-form .defalut-view {
    display: inline-block;
    width: 600px;
    text-align: left;
}
.search-page-form .sub-title {
    font-size: 24px;
    color: #555;
    letter-spacing: -1px;
}
.m60t {
    margin-top: 60px;
}
.search-page-form .sub-title span {
    color: #222;
}
.no-result-desc {
    position: relative;
    width: 580px;
    margin-left: auto;
    margin-right: auto;
    text-align: left;
    font-size: 16px;
    letter-spacing: -1px;
    color: #555;
    line-height: 24px;
}
.no-result-desc li {
    position: relative;
    padding-left: 10px;
}
.search-tag_area {
    margin-top: 30px;
    margin: 40px auto 20px auto;
}
.search-page-form .subject {
    display: inline-block;
    width: 600px;
    text-align: left;
}
.subject, .search-tag_area .subject {
    font-size: 18px;
    color: #222;
    font-weight: 600;
    margin-bottom: 10px;
}
.search-tag_area .subject .title-line {
    display: block;
    height: 17px;
    margin-top: 10px;
    font-weight: normal;
    font-size: 16px;
    color: #555;
}
.search-tag_area .tag_list {
    margin: 15px auto 0 auto;
    width: 610px;
}
.search-tag_area .tag_list li {
    width: 23.6%;
    margin-right: 1.5%;
    font-size: 12px;
    list-style: none;
    float: left;
    text-align: center;
    border: 1px solid #222;
    margin-bottom: 1.5%;
    background: #fff;
    border-radius: 20px;
}
.search-tag_area .tag_list li a {
    display: block;
    width: 100%;
    color: #222;
    font-size: 16px;
    padding: 10px 0;
}
.search-tag_area .tag_list::after {
    display: block;
    content: "";
    clear: both;
}
.search-page-form input {
    vertical-align: top;
    padding-left: 7px;
    width: 550px;
    height: 50px;
    border: 2px solid #222;
}
.search-page-form #sch_submit {
    border: 0;
    border: 1px solid #f0f0f0;
    border-left: 0;
    width: 50px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 14px;
    height: 50px;
    color: #555;
    background: #ddd;
}
</style>
<div class="c_hero">
	<strong>???????????? <mark>??????</mark></strong>
</div>
<div class="c_list">
	<div class="cl_menu">
		<a href="<?php echo G5_URL; ?>"><i></i><span class="blind">HOME</span></a>
		<span>????????????</span>
		<span><mark><a href="/shop/search.php" class="sct_here">??????</a></mark></span>
	</div>
</div>
<div class="c_area">
	<div class="wrap">
		<div class="ca_find">
			<div class="caf_title">
				<strong>???????????? ?????? ?????????????</strong>
			</div>
			<div class="caf_search">
				<form action="./search.php" method="get" id="searchKeywordForm">
					<label for="sch_str" class="sound_only">?????????<strong class="sound_only"> ??????</strong></label>
					<select name="seach_category" id="sch_str">
						<option value="level3">?????????</option>
					</select>
					<label for="keyword" class="sound_only">?????????<strong class="sound_only"> ??????</strong></label>
					<input type="text" name="q" id="keyword"  placeholder="????????? ?????????(??????)?????? ???????????? ???????????? ???????????????. " value="<?php echo stripslashes(get_text(get_search_string($q))); ?>">
					<button type="submit" id="sch_submit"><span>??????</span></button>
				</form>
			</div>
			<p class="caf_txt"><mark>?????? ??????</mark><span>????????? ???????????? ????????? ???????????? ????????? ????????? ???????????? ???????????????.</span></p>
            <!-- 210809 ???????????? ?????? -->
            <div>
                <?php
                // ????????? ???????????? ??????
                $list_file = G5_SHOP_SKIN_PATH.'/'.$default['de_search_list_skin'];
                // echo $list_file;
                if (file_exists($list_file)) {
                    define('G5_SHOP_CSS_URL', G5_SHOP_SKIN_URL);
                    $sub_where = "";
                    if ( $_REQUEST['q'] ) {
                        $concat = array();
                        $concat[] = "mb_nick";
                        $concat[] = "mb_id";

                        $concat_fields = "concat(".implode(",' ',",$concat).")";

                        $sub_where = " AND ".$concat_fields." like '%".$_REQUEST['q']."%' ";
                    }

                    $sql = "SELECT * FROM ".$g5['member_table']." WHERE mb_level='3' ".$sub_where." ORDER BY mb_status ASC, rand()";
                    $result = sql_query($sql);
                    $total_count = sql_num_rows($result);
                    $total_page  = ceil($total_count / $items);
                    echo $skin_file;
                    include $list_file;
                }
                else
                {
                    $i = 0;
                    $error = '<p class="sct_nofile">'.$list_file.' ????????? ?????? ??? ????????????.<br>??????????????? ??????????????? ?????????????????????.</p>';
                }

                if ($i==0)
                {
                    echo '<div>'.$error.'</div>';
                }

                $query_string = 'qname='.$qname.'&amp;qexplan='.$qexplan.'&amp;qid='.$qid;
                if($qfrom && $qto) $query_string .= '&amp;qfrom='.$qfrom.'&amp;qto='.$qto;
                $query_string .= '&amp;qcaid='.$qcaid.'&amp;q='.urlencode($q);
                $query_string .='&amp;qsort='.$qsort.'&amp;qorder='.$qorder;
                echo get_paging($config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$query_string.'&amp;page=');
                ?>
            </div>
            <!-- 210809 ???????????? ??? -->
		</div>
		<ul class="ca_member">
			<?php
            echo $result;
			for ($i = 1; $row = sql_fetch_array($result); $i++) {
				if ($item_mod >= 2) { // 1??? ????????? : 2??? ??????
					if ($i % $item_mod == 0)
						$sct_last = 'sct_last'; // ??? ?????????
					else if ($i % $item_mod == 1)
						$sct_last = 'sct_clear'; // ??? ?????????
					else
						$sct_last = '';
				} else { // 1??? ????????? : 1???
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
					<div class="cam_wrap">
						<div class="cam_pic">
							<a href="<?php echo G5_SHOP_URL; ?>/item.php?ca_id=<?php echo $bcat_arr[$l]['ca_id']; ?>&it_id=<?php echo $row['mb_no']; ?>">
								<img src="<?php echo G5_DATA_URL; ?>/temp/<?php echo $row['mb_no']; ?>/<?php echo $row['mb_8']; ?>" alt="<?php echo $row['mb_nick']; ?> <?php echo $row['mb_id']; ?>???">
							
								<?php
									if ( $mb_st ) $row['mb_status'] = $mb_st;

									if ( $row['mb_status'] == 2 ) {
										$mb_status = "????????????";
										$mb_status_css = "tel-avail";
										$mb_status_img = "1";
									}
									else if ( $row['mb_status'] == 1 ) {
										$mb_status = "?????????";
										$mb_status_css = "tel-ing";
										$mb_status_img = "2";
									}
									else {
										$mb_status = "????????????";
										$mb_status_css = "tel-disabled";
										$mb_status_img = "3";
									}
								?>
								<div class="camp_status <?php echo $mb_status_css ?>">
									<span><?php echo $mb_status ?></span>
								</div>
							</a>
						</div>
						<div class="cam_info">
							<div class="cami_title">
								<span><?php echo $row['mb_nick']; ?> <mark><?php echo $row['mb_id']; ?>???</mark></span>
							</div>
							<div class="cami_txt">
								<span><?php echo $row['mb_9']; ?></span>
							</div>
						</div>
						<!--?????? ??????-->
						<div class="cam_sort">
							<?php
							for ($j = 0; $j < 3; $j++) {
							?>
							<span><?php echo $scat_arr[$j]['ht_name']; ?></span>
							<?php
							}
							?>
						</div>
						<div class="cam_review">
							<ul>
								<?php
								$query = "SELECT a.*,b.mb_nick FROM ".$g5['g5_shop_item_use_table']." a JOIN ".$g5['member_table']." b ON a.mb_id=b.mb_id WHERE a.it_id='".$row['mb_no']."' AND a.is_cat2='".$bcat_arr[$l]['ca_name']."' ORDER BY a.is_id DESC LIMIT 3";
								$use_res = sql_query($query);
                                echo $query;
								while ( $use_row = sql_fetch_array($use_res) ) {
								?>
								<li>
									<a href="<?php echo G5_SHOP_URL; ?>/item.php?ca_id=<?php echo $bcat_arr[$l]['ca_id']; ?>&it_id=<?php echo $row['mb_no']; ?>#cab_review"><?php echo $use_row['is_best'] == 1 ? "[Best]" : ""; ?><?php echo $use_row['is_subject']; ?></a>
									<span class="user_name"><?php echo $use_row['is_name']; ?></span>
								</li>
								<?php
								}
								?>
							</ul>
						</div>
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
								<a href="<?php echo G5_SHOP_URL; ?>/item.php?ca_id=<?php echo $bcat_arr[$l]['ca_id']; ?>&it_id=<?php echo $row['mb_no']; ?>#sit_use"><span>????????????</span><mark><?php echo $use_dt['cnt']; ?></mark></a>
							</span>
						</div>
					</div>
				</li>
				<?php
			}
			if ($i == 1)
				echo "<p class=\"sct_noitem title cg bold\">????????? ???????????? ????????????.</p>\n";
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
