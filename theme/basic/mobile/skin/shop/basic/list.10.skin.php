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

    if ($i == 0) {
        if ($this_css) {
            echo "<ul id=\"sct_wrap\" class=\"{$this->css}\">\n";
        } else {
            echo "<ul id=\"sct_wrap\" class=\"sct ".$ul_sct_class."\">\n";
        }
    }

    echo "<li class=\"sct_li {$li_clear}\"$li_width_style><div class=\"li_wr is_view_type_list\">\n";

    ?>
    <div class="inner">
      <div class="clearfix top-wr">

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
<div class="top_txt">
  <div class="top_txt_tit clearfix">
<?php


    if ($row['mb_no']) {
        //echo "<div class=\"sct_id\">&lt;".stripslashes($row['it_id'])."&gt;</div>\n";
    }

    if ($this_href) {
        echo "<div class=\"sct_txt\"><a href=\"{$this_href}{$row['mb_no']}\" class=\"sct_a\">\n";
    }

    if ($row['mb_nick']) {
        echo stripslashes($row['mb_nick'])."\n";
    }
    ?>
    <!--번호 추가-->
    <span class="teacher_number"><?php echo $row['mb_id']; ?>번</span>
    <!--//번호 추가-->
    <?php
    if ($this_href) {
        echo "</a></div>\n";
    }
/*이름영역 끝*/
    // if ($this->view_it_price) {
    //     echo "<div class=\"sct_cost\">\n";
    //     echo display_price(get_price($row), $row['it_tel_inq'])."\n";
    //     echo "</div>\n";
    // }
    //
    // if ($this->view_sns) {
    //     $sns_top = $this->img_height + 10;
    //     $sns_url  = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
    //     $sns_title = get_text($row['it_name']).' | '.get_text($config['cf_title']);
    //     echo "<div class=\"sct_sns\" style=\"top:{$sns_top}px\">";
    //     echo get_sns_share_link('facebook', $sns_url, $sns_title, G5_MSHOP_SKIN_URL.'/img/facebook.png');
    //     echo get_sns_share_link('twitter', $sns_url, $sns_title, G5_MSHOP_SKIN_URL.'/img/twitter.png');
    //     echo get_sns_share_link('googleplus', $sns_url, $sns_title, G5_MSHOP_SKIN_URL.'/img/gplus.png');
    //     echo get_sns_share_link('kakaotalk', $sns_url, $sns_title, G5_MSHOP_SKIN_URL.'/img/sns_kakao.png');
    //     echo "</div>\n";
    // }


	if ( $row['mb_type1'] == "1" ) {
		$icon = "shop_icon_1";
		$icon_str = "성실";
		echo "<div class=\"sct_icon\"><span class=\"shop_icon ".$icon."\">".$icon_str."</span></div>\n";
	}
	else if ( $row['mb_type2'] == "1" ) {
		$icon = "shop_icon_2";
		$icon_str = "추천";
		echo "<div class=\"sct_icon\"><span class=\"shop_icon ".$icon."\">".$icon_str."</span></div>\n";
	}
	else if ( $row['mb_type3'] == "1" ) {
		$icon = "shop_icon_3";
		$icon_str = "NEW";
		echo "<div class=\"sct_icon\"><span class=\"shop_icon ".$icon."\">".$icon_str."</span></div>\n";
	}
	else {
		$icon = "";
		$icon_str = "";
		echo "";
	}
    /*아이콘 영역*/
    ?>
      </div><!--top_txt_tit-->


        <div class="top_txt_txt">
          <p><?php echo $row['mb_9']; ?></p>
        </div>

        <div class="tel-wr">
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
		  <div class="tel <?php echo $mb_status_css; ?>" data-img="<?php echo G5_DATA_URL.'/temp/'.$row['mb_no'].'/'.$row['mb_8']; ?>" data-cate="<?php echo $bcat_arr[$l]['ca_name']; ?>" data-nick="<?php echo $row['mb_nick']." ".$row['mb_id']; ?>" data-css="<?php echo $bcat_bg; ?>">
			<img src="/m-fortune-img/call_icon.png">
			<span><?php echo $mb_status; ?></span>
		  </div>
          <!--div class="tel tel-avail">
            <img src="/m-fortune-img/call_icon.png">
            <span>상담가능</span>
          </div>

          <!-- 상담중일 시 클래스명과 배경색, 텍스트 바뀜
          <div class="tel tel-ing">
            <img src="/m-fortune-img/call_icon.png">
            <span>상담중</span>
          </div> -->

          <!-- 예약대기일 시 클래스명과 배경색, 텍스트 바뀜
          <div class="tel tel-disabled">
            <img src="/m-fortune-img/call_icon.png">
            <span>예약대기</span> -->
          </div>

        </div><!--top_txt-->
      </div><!--top-wr-->

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
    </div><!--inner-->

	<?php
	$sql = "SELECT AVG(is_score) is_score, COUNT(is_id) cnt, IFNULL(SUM( IF( is_reply_name<>'',1,0 ) ),0) re_cnt FROM ".$g5['g5_shop_item_use_table']." WHERE it_id='".$row['mb_no']."' AND is_cat2='".$bcat_arr[$l]['ca_name']."'";
	$use_dt = sql_fetch($sql);
	$star_str = "";
	for ($jj = 1; $jj <= 5; $jj++) {
		if ($jj <= intval($use_dt['is_score'])) $star_str .= "<i class='xi-star'></i>";
		else $star_str .= "<i class='xi-star-o'></i>";
	}
	?>
      <!--게시판 연결-->
        <div class="num-wr">
          <span class="star"><?php echo $star_str; ?>
            평점 <?php echo number_format($use_dt['is_score'],1); ?>
          </span>
          <span class="rev-num"><a href="<?php echo G5_SHOP_URL; ?>/item.php?ca_id=<?php echo $bcat_arr[$l]['ca_id']; ?>&it_id=<?php echo $row['mb_no']; ?>&anchor=sit_use">상담후기<b><?php echo $use_dt['cnt']; ?></b></a></span>
          <span class="comment-num"><a href="<?php echo G5_SHOP_URL; ?>/item.php?ca_id=<?php echo $bcat_arr[$l]['ca_id']; ?>&it_id=<?php echo $row['mb_no']; ?>&anchor=sit_use">상담사댓글<b><?php echo $use_dt['re_cnt']; ?></b></a></span>
        </div>


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
<!--pop-->
<div class="pop-bg1">
  <div class="pop1">
    <div class="tit_wr">
      <span id="pop-css" class="pop_img teacher_back_small">
        <!--
        선생님 배경이미지 : 클래스, 배경이미지 바뀜(teacher_back_small 뒤에 클래스 추가)
        타로 일때 : back_taro (현재 예시로 설정해 놓음)
        꿈해몽 일떄 : back_dream
        펫타로 일때 : back_taro
        사주 일떄 : back_saju
        신점 일때 : back_shinjeom -->
        <img id="pop-img" src="" alt="당담자 사진">
      </span>

      <span class="tit">
        [<span id="pop-cate"></span>]
        <span id="pop-nick"></span>
      </span>

      <span class="pop-close">
        <i class="xi-close"></i>
      </span>
    </div>
    <div class="pop_con_wr">
      <div class="discount">
        <h3>할인상담<span>(코인충전)</span></h3>
        <!--로그인 상태에서 안보이게-->
        <p>
          코인충전후 전화연결시 상담사 바로 연결됩니다.<br>
          코인상담은 <a href="/bbs/login.php" class="login">로그인</a> 후 이용 가능합니다.
        </p>
        <!--//로그인 상태에서 안보이게 tel:1661-3439 -->
        <a href="<?php echo $call_ret > 0 ? "tel:1661-3439" : G5_URL."/payment.php"; ?>"" class="tel-box">
          <img src="/m-fortune-img/call_icon.png" alt="전화번호">
          <span>1661-3439</span>
        </a>
		<!-- tel:02-3433-1177 -->
        <span class="relative">
          <a href="<?php echo $call_ret > 0 ? "tel:02-3433-1177" : G5_URL."/payment.php"; ?>"" class="tel-box">
            <img src="/m-fortune-img/call_icon.png" alt="전화번호">
            <span>02-3433-1177</span>
          </a>
          <i class="xi-help help-btn"></i>
        </span>

      </div>
      <div class="baro">
        <h3>060 바로상담<span>(후불)</span></h3>
        <p>
          전화연결시 고유번호 입력후 상담사와 바로연결됩니다.
        </p>
        <a href="tel:060-300-6700" class="tel-box red">
          <img src="/m-fortune-img/call_icon.png" alt="전화번호">
          <span>060-300-6700</span>
        </a>
      </div>
    </div><!--pop_con_wr-->
  </div>
</div>

<!--pop-->

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

<?php if( !defined('G5_IS_SHOP_AJAX_LIST') ) { ?>
<script>
$(function(){
	<?php
	//if ($is_member) {
	?>
    $(".tel-avail").on("click",function(){
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
    });

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
