<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//echo G5_MSHOP_SKIN_URL;
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>

<?php if(!defined('G5_IS_SHOP_AJAX_LIST') && $config['cf_kakao_js_apikey']) { ?>
<script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>
<script src="<?php echo G5_JS_URL; ?>/kakaolink.js"></script>
<script>
    // 사용할 앱의 Javascript 키를 설정해 주세요.
    Kakao.init("<?php echo $config['cf_kakao_js_apikey']; ?>");
</script>
<?php } ?>

<!-- 메인상담사진열 10 시작 { -->
<div class="c_area">
	<div class="wrap">
		<div class="ca_tabs" id="ca_tab">
			<ul>
				<li><a href="/shop/list.php?ca_id=<?php echo $ca['ca_id']; ?>&amp;sort=it_sum_qty&amp;sortodr=desc#ca_tab"><i></i><span>조회높은순</span></a></li>
				<li><a href="/shop/list.php?ca_id=<?php echo $ca['ca_id']; ?>&amp;sort=it_use_cnt&amp;sortodr=desc#ca_tab"><i></i><span>후기많은순</span></a></li>
				<li><a href="/shop/list.php?ca_id=<?php echo $ca['ca_id']; ?>&amp;sort=it_use_avg&amp;sortodr=desc#ca_tab"><i></i><span>별점높은순</span></a></li>
				<li><a href="./list.php?ca_id=<?php echo $ca['ca_id']; ?>#ca_tab"><i></i><span>필터 초기화</span></a></li>
			</ul>
		</div>
<!-- 상품진열 10 시작 { -->
	<?php if ($i > 0) {?>
		<ul class="ca_member">
	<?php }?>
<?php
$is_gallery_list = ($ca['ca_id'] && isset($_COOKIE['ck_itemlist'.$ca['ca_id'].'_type'])) ? $_COOKIE['ck_itemlist'.$ca['ca_id'].'_type'] : '';
if(!$is_gallery_list){
    $is_gallery_list = 'gallery';
}

$li_width = ($is_gallery_list === 'gallery') ? intval(100 / $ca['ca_list_mod']) : 100;
$li_width_style = ' style="width:'.$li_width.'%;"';
$ul_sct_class = ($is_gallery_list === 'gallery') ? 'sct_10' : 'sct_20';

for ($i=0; $row=sql_fetch_array($result); $i++) {
    if ($ca['ca_list_mod'] >= 2) { // 1줄 이미지 : 2개 이상
        if ($i%$ca['ca_list_mod'] == 0) $li_clear = 'sct_last'; // 줄 마지막
        else if ($i%$ca['ca_list_mod'] == 1) $li_clear = 'sct_clear'; // 줄 첫번째
        else $li_clear = '';
    } else { // 1줄 이미지 : 1개
        $li_clear = 'sct_clear';
    }

	$bcat_arr = b_cat_func($row['mb_1']);
	$scat_arr = s_cat_func($row['mb_2']);

	$l = searchForId("ca_id", $ca_id, $bcat_arr);
	if ( $l == "" ) $l = 0;
//echo "key = ".$l."<br>";
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


    echo "<li class=\"sct_li {$li_clear}\"$li_width_style><div class=\"li_wr is_view_type_list\">\n";

    ?>
    <?php
	$this_href = G5_SHOP_URL."/item.php?ca_id=".$bcat_arr[$l]['ca_id']."&it_id=";
    if ($this_href) {
        echo "<div class=\"sct_img teacher_back_common ".$bcat_bg."\"><a href=\"{$this_href}{$row['mb_no']}\">\n";
        // 선생님 배경이미지 : 클래스, 배경이미지 바뀜
        // (teacher_back_common 뒤에 클래스 추가)
        // 타로 일때 : back_taro (현재 예시로 설정해 놓음)
        // 꿈해몽 일떄 : back_dream
        // 펫타로 일때 : back_pettaro
        // 사주 일떄 : back_saju
        // 신점 일때 : back_shinjeom
    }

    if ($row['mb_8']) {
        //echo get_it_image($row['it_id'], $this->img_width, $this->img_height, '', '', stripslashes($row['it_name']))."\n";
		echo '<img src="'.G5_DATA_URL.'/temp/'.$row['mb_no'].'/'.$row['mb_8'].'" width="185" height="117" alt="'.$row['mb_nick'].' '.$row['mb_id'].'번" title="">';
    }

    ?>

    <div class="cate">
		<p class="cate-<?php echo $bcat_str; ?>"><?php echo $bcat_arr[$l]['ca_name']; ?></p>
      <!--p class="cate-taro">타로</p>
      < 사주일때, 클래스와 배경 바뀜
       <p class="cate-saju">사주</p> -->
      <!-- 신점일때, 클래스와 배경 바뀜
      <p class="cate-sin">신점</p> -->
      <!--꿈해몽일때, 클래스와 배경 바뀜
      <p class="cate-dream">꿈해몽</p> -->
      <!-- 펫타로일때, 클래스와 배경 바뀜
      <p class="cate-pet">펫타로</p> -->
    </div>

    <?php


    if ($this_href) {
        echo "</a></div>\n";
    }
/*이미지영역 끝*/
?>

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
   
    <?php

    echo "</div></li>\n";
}

if ($i > 0) echo "</ul>\n";

if($i == 0) echo "<p class=\"sct_noitem\">등록된 선생님이 없습니다.</p>\n";
?>
<!-- } 상담사진열 10 끝 -->

<?php
if ( $member['mb_level'] == 2 ) {
	$ch = curl_init($user_remaining_secs_addr."?cp=".$cp."&svc=".$svc."&tel=".str_replace("-","",$member['mb_hp'])."&pwd=".substr($member['mb_hp'],-4)."");
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 1);
	$call_ret = curl_exec($ch);
	curl_close($ch);
}
?>

<?php if( !defined('G5_IS_SHOP_AJAX_LIST') ) { ?>
<script>
$(function(){
	<?php
	//if ($is_member) {
	?>
    /*$(".tel-avail").on("click",function(){
	  $("#pop-img").attr("src", $(this).data("img"));
	  $("#pop-cate").html($(this).data("cate"));
	  $("#pop-nick").html($(this).data("nick"));
	  $("#pop-css").removeClass("back_taro");
	  $("#pop-css").removeClass("back_shinjeom");
	  $("#pop-css").removeClass("back_saju");
	  $("#pop-css").removeClass("back_pettaro");
	  $("#pop-css").removeClass("back_dream");
	  $("#pop-css").addClass($(this).data("css"));
	  console.log($(this).data("img") + " , " + $(this).data("cate") + " , " + $(this).data("nick") + " , " + $(this).data("css") + " ==> " + $("#pop-img").attr("src"));
      $(".pop-bg1").show();
    });*/

    $(".pop1 .pop-close").on("click",function(){
      $(".pop-bg1").hide();
    });
	<?php
	//}
	?>
  $(".help-btn").on("click",function(){
    $(".pop-bg2").show();
  });

  $(".pop2 .pop-close").on("click",function(){
    $(".pop-bg2").hide();
  });
});


jQuery(function($){
    var li_width = "100",
        img_width = "185",
        img_height = "0",
        list_ca_id = "<?php echo $ca['ca_id']; ?>";

    function shop_list_type_fn(type){
        var $ul_sct = $("ul.sct");

        if(type == "gallery") {
            $ul_sct.removeClass("sct_20").addClass("sct_10")
            .find(".sct_li").attr({"style":"width:"+li_width+"%"});
        } else {
            $ul_sct.removeClass("sct_10").addClass("sct_20")
            .find(".sct_li").removeAttr("style");
        }

        if (typeof g5_cookie_domain != 'undefined') {
            set_cookie("ck_itemlist"+list_ca_id+"_type", type, 1, g5_cookie_domain);
        }
    }

    $("button.sct_lst_view").on("click", function() {
        var $ul_sct = $("ul.sct");

        if($(this).hasClass("sct_lst_gallery")) {
            shop_list_type_fn("gallery");
        } else {
            shop_list_type_fn("list");
        }
    });
});
</script>
<?php } ?>
