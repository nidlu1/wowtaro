<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<!-- 상품진열 10 시작 { -->


  <!--pop2-->
  <div class="pop-bg2">
  <div class="pop2">

    <div class="tit_wr">
      <i class="xi-help"></i>
      <span class="tit">
        발신요금절약 TIP
      </span>
      <span class="pop-close">
        <i class="xi-close"></i>
      </span>
    </div>

    <div class="pop_con_wr">
        <p>
          할인상담시 <span>02-3433-1177</span> 이용하시면 발신요금을 절약하실 수 있습니다.<br>
          휴대폰 음성 무제한 요금제 사용 고객은 발신 요금이 무료이며 요금제에 따라
          발신료 무료 시간이 다르므로 발신요금의 대한자세한 내용은 가입하신
          통신사 홈페이지를 참조하세요.
        </p>
    </div><!--pop_con_wr-->
  </div>
  </div>

  <!--//팝업끝-->

<ul class="sct sct_10">
<?php
for ($i=1; $row=sql_fetch_array($result); $i++) {
    if ($item_mod >= 2) { // 1줄 이미지 : 2개 이상
        if ($i%$item_mod == 0) $sct_last = 'sct_last'; // 줄 마지막
        else if ($i%$item_mod == 1) $sct_last = 'sct_clear'; // 줄 첫번째
        else $sct_last = '';
    } else { // 1줄 이미지 : 1개
        $sct_last = 'sct_clear';
    }

	$bcat_arr = b_cat_func($row['mb_1']);
	$scat_arr = s_cat_func($row['mb_2']);

	//$l = mt_rand( 0, (count($bcat_arr) - 1) );
	$l = searchForId3($row['mb_use'],$bcat_arr);
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
	<li class="sct_li <?php echo $sct_last; ?>" >
		<div class="sct_img teacher_back_common <?php echo $bcat_bg; ?>">
      <!--선생님 배경이미지 : 클래스, 배경이미지 바뀜
      타로 일때 : back_taro (현재 예시로 설정해 놓음)
      꿈해몽 일떄 : back_dream
      펫타로 일때 : back_pettaro
      사주 일떄 : back_saju
      신점 일때 : back_shinjeom
    -->
			<a href="<?php echo G5_SHOP_URL; ?>/item.php?ca_id=<?php echo $bcat_arr[$l]['ca_id']; ?>&it_id=<?php echo $row['mb_no']; ?>">
				<img src="<?php echo G5_DATA_URL; ?>/temp/<?php echo $row['mb_no']; ?>/<?php echo $row['mb_8']; ?>" width="378" height="238" alt="<?php echo $row['mb_nick']; ?> <?php echo $row['mb_id']; ?>번">
			</a>

			<div class="cate">
				<p class="cate-<?php echo $bcat_str; ?>"><?php echo $bcat_arr[$l]['ca_name']; ?></p>
			</div>

		</div>
		<!--분류 추가-->
		<div class="sorting">
			<?php
			for ($j = 0; $j < 3; $j++) {
			?>
			<span><?php echo $scat_arr[$j]['ht_name']; ?></span>
			<?php
			}
			?>
		</div>

		<div class = "clearfix sct-tit">
			<a href="<?php echo G5_SHOP_URL; ?>/item.php?ca_id=<?php echo $bcat_arr[$l]['ca_id']; ?>&it_id=<?php echo $row['mb_no']; ?>">
				<div class="tel">
					<?php
					//$mb_st = counsel_stat($row['mb_id']);
					//var_dump($mb_st);
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
					<span class="<?php echo $mb_status_css; ?>"><?php echo $mb_status; ?></span>
					<img src="/fortune-img/box-ico<?php echo $mb_status_img; ?>.png">
					<!-- 상담중일 시 클래스명과 이미지, 텍스트 바뀜
					<span class ="tel-ing">상담중</span>
					<img src="/fortune-img/box-ico2.png"> -->
					<!-- 예약대기일 시 클래스명과 이미지, 텍스트 바뀜
					<span class ="tel-disabled">예약대기</span>
					<img src="/fortune-img/box-ico3.png"> -->
				</div>


				<div class="right">
					<div class="right-top clearfix">
						<div class="sct_txt">
							<?php echo $row['mb_nick']; ?> <span class="teacher_number"><?php echo $row['mb_id']; ?>번</span>
						</div>
						<div class="sct_icon">
							<span class="sit_icon">
							<?php
							if ( $row['mb_type1'] == "1" ) {
								$icon = "shop_icon_1";
								$icon_str = "성실";
							}
							else if ( $row['mb_type2'] == "1" ) {
								$icon = "shop_icon_2";
								$icon_str = "추천";
							}
							else if ( $row['mb_type3'] == "1" ) {
								$icon = "shop_icon_3";
								$icon_str = "NEW";
							}
							else {
								$icon = "";
								$icon_str = "";
							}
							?>
								<span class="shop_icon <?php echo $icon; ?>"><?php echo $icon_str; ?></span>
							</span>
						</div>
					</div>
					<div class="sct_basic"><?php echo $row['mb_9']; ?></div>
				</div>
			</a>
		</div>
		<!--하드코딩영역-->
		<div class="tel-num">
			<ul>
				<li>
					<span class="tel_tit">일반전화상담</span>
					<b>060-300-6700 + <span class="teacher_number"><?php echo $row['mb_id']; ?></span></b>
				</li>
				<li class="color">
					<span class="tel_tit">할인전화상담</span>
					<b>1661-3439 + <span class="teacher_number"><?php echo $row['mb_id']; ?></span></b>
          <span class="tip_button">TIP</span>
				</li>
			</ul>
		</div>

		<div class="review">
			<ul>
	<?php
	$query = "SELECT a.*,b.mb_nick FROM ".$g5['g5_shop_item_use_table']." a JOIN ".$g5['member_table']." b ON a.mb_id=b.mb_id WHERE a.it_id='".$row['mb_no']."' AND a.is_cat2='".$bcat_arr[$l]['ca_name']."' ORDER BY a.is_id DESC LIMIT 3";
	$use_res = sql_query($query);
	while ( $use_row = sql_fetch_array($use_res) ) {
	?>
				<li class="clearfix">
					<a href="<?php echo G5_SHOP_URL; ?>/item.php?ca_id=<?php echo $bcat_arr[$l]['ca_id']; ?>&it_id=<?php echo $row['mb_no']; ?>#sit_use"><?php echo $use_row['is_best'] == 1 ? "[Best]" : ""; ?><?php echo $use_row['is_subject']; ?></a>
					<span class="user_name"><?php echo $use_row['is_name']; ?></span>
				</li>
	<?php
	}
	?>
			</ul>
		</div>

		<div class="num-wr">
	<?php
	$sql = "SELECT AVG(is_score) is_score, COUNT(is_id) cnt, IFNULL(SUM( IF( is_reply_name<>'',1,0 ) ),0) re_cnt FROM ".$g5['g5_shop_item_use_table']." WHERE it_id='".$row['mb_no']."' AND is_cat2='".$bcat_arr[$l]['ca_name']."'";
	//ptr2($sql);
	$use_dt = sql_fetch($sql);
	$star_str = "";
	for ($jj = 1; $jj <= 5; $jj++) {
		if ($jj <= intval($use_dt['is_score'])) $star_str .= "<i class='xi-star'></i>";
		else $star_str .= "<i class='xi-star-o'></i>";
	}
	?>
			<span class="star"><?php echo $star_str; ?>
			<?php echo number_format($use_dt['is_score'],1); ?>
			</span>
			<span class="rev-num"><a href="<?php echo G5_SHOP_URL; ?>/item.php?ca_id=<?php echo $bcat_arr[$l]['ca_id']; ?>&it_id=<?php echo $row['mb_no']; ?>#sit_use">상담후기<b><?php echo $use_dt['cnt']; ?></b></a></span>
			<span class="comment-num"><a href="<?php echo G5_SHOP_URL; ?>/item.php?ca_id=<?php echo $bcat_arr[$l]['ca_id']; ?>&it_id=<?php echo $row['mb_no']; ?>#sit_use">상담사댓글<b><?php echo $use_dt['re_cnt']; ?></b></a></span>
		</div>
	</li>
<?php
}

if($i == 1) echo "<p class=\"sct_noitem\">등록된 선생님이 없습니다.</p>\n";
?>
</ul>

<!--button type="button" name="button" class="more_btn">
  상담사 더 보기<i class="xi-angle-down-min"></i>
</button-->
<!-- } 상품진열 10 끝 -->

<script type="text/javascript">
  $(function(){

    $(".tip_button").on("click",function(){
      $(".pop-bg2").show();
    });

    $(".pop2 .pop-close").on("click",function(){
      $(".pop-bg2").hide();
    });
  });
</script>
