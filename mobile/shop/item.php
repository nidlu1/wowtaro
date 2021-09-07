<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/iteminfo.lib.php');

$it_id = get_search_string(trim($_GET['it_id']));

// 분류사용, 상품사용하는 상품의 정보를 얻음
$sql = " select * from {$g5['member_table']} where mb_no = '$it_id' AND mb_hide='0' ";
$it = sql_fetch($sql);
if (!$it['mb_no'])
    alert('상담사회원이 없습니다.');

$bcat_arr = b_cat_func($it['mb_1']);
$l = mt_rand( 0, (count($bcat_arr) - 1) );
$_REQUEST['ca_id'] = ( !$_REQUEST['ca_id'] ) ? $bcat_arr[$l]['ca_id'] : $_REQUEST['ca_id'];

// 분류 테이블에서 분류 상단, 하단 코드를 얻음
$sql = " select ca_id, ca_name, ca_mobile_skin_dir, ca_include_head, ca_include_tail, ca_cert_use, ca_adult_use
           from {$g5['g5_shop_category_table']}
          where ca_id = '{$_REQUEST['ca_id']}' ";
$ca = sql_fetch($sql);

// 본인인증, 성인인증체크
if(!$is_admin) {
    $msg = shop_member_cert_check($it_id, 'item');
    if($msg)
        alert($msg, G5_SHOP_URL);
}

// 오늘 본 상품 저장 시작
// tv 는 today view 약자
$saved = false;
$tv_idx = (int)get_session("ss_tv_idx");
if ($tv_idx > 0) {
    for ($i=1; $i<=$tv_idx; $i++) {
        if (get_session("ss_tv[$i]") == $it_id) {
            $saved = true;
            break;
        }
    }
}

if (!$saved) {
    $tv_idx++;
    set_session("ss_tv_idx", $tv_idx);
    set_session("ss_tv[$tv_idx]", $it_id);
}
// 오늘 본 상품 저장 끝

// 조회수 증가
if (get_cookie('ck_it_id') != $it_id) {
    //sql_query(" update {$g5['g5_shop_item_table']} set it_hit = it_hit + 1 where it_id = '$it_id' "); // 1증가
    set_cookie("ck_it_id", $it_id, 3600); // 1시간동안 저장
}
/*
// 이전 상품보기
$sql = " select it_id, it_name from {$g5['g5_shop_item_table']}
          where it_id > '$it_id'
            and SUBSTRING(ca_id,1,4) = '".substr($it['ca_id'],0,4)."'
            and it_use = '1'
          order by it_id asc
          limit 1 ";
$row = sql_fetch($sql);
if ($row['it_id']) {
    $prev_title = '이전상품 <span>'.$row['it_name'].'</span>';
    $prev_href = '<a href="'.G5_SHOP_URL.'/item.php?it_id='.$row['it_id'].'" id="siblings_prev">';
    $prev_href2 = '</a>';
} else {
    $prev_title = '';
    $prev_href = '';
    $prev_href2 = '';
}

// 다음 상품보기
$sql = " select it_id, it_name from {$g5['g5_shop_item_table']}
          where it_id < '$it_id'
            and SUBSTRING(ca_id,1,4) = '".substr($it['ca_id'],0,4)."'
            and it_use = '1'
          order by it_id desc
          limit 1 ";
$row = sql_fetch($sql);
if ($row['it_id']) {
    $next_title = '다음 상품 <span>'.$row['it_name'].'</span>';
    $next_href = '<a href="'.G5_SHOP_URL.'/item.php?it_id='.$row['it_id'].'" id="siblings_next">';
    $next_href2 = '</a>';
} else {
    $next_title = '';
    $next_href = '';
    $next_href2 = '';
}
*/
// 관리자가 확인한 사용후기의 개수를 얻음
$sql = " select count(*) as cnt from `{$g5['g5_shop_item_use_table']}` where it_id = '{$it_id}' and is_confirm = '1' ";
$row = sql_fetch($sql);
$item_use_count = $row['cnt'];

// 상담문의의 개수를 얻음
$sql = " select count(*) as cnt from `{$g5['g5_shop_item_qa_table']}` where it_id = '{$it_id}' ";
$row = sql_fetch($sql);
$item_qa_count = $row['cnt'];
/*
if ($default['de_mobile_rel_list_use']) {
    // 관련상품의 개수를 얻음
    $sql = " select count(*) as cnt
               from {$g5['g5_shop_item_relation_table']} a
               left join {$g5['g5_shop_item_table']} b on (a.it_id2=b.it_id)
              where a.it_id = '{$it['it_id']}' and b.it_use='1' ";
    $row = sql_fetch($sql);
    $item_relation_count = $row['cnt'];
}
*/
// 상품품절체크
//if(G5_SOLDOUT_CHECK)
    //$is_soldout = is_soldout($it['it_id']);

// 주문가능체크
$is_orderable = true;
//if(!$it['it_use'] || $it['it_tel_inq'] || $is_soldout)
    //$is_orderable = false;
/*
if($is_orderable) {
    if(defined('G5_THEME_USE_OPTIONS_TRTD') && G5_THEME_USE_OPTIONS_TRTD){
        $option_item = get_item_options($it['it_id'], $it['it_option_subject'], '');
        $supply_item = get_item_supply($it['it_id'], $it['it_supply_subject'], '');
    } else {
        // 선택 옵션 ( 기존의 tr td 태그로 가져오려면 'div' 를 '' 로 바꾸거나 또는 지워주세요 )
        $option_item = get_item_options($it['it_id'], $it['it_option_subject'], 'div');

        // 추가 옵션 ( 기존의 tr td 태그로 가져오려면 'div' 를 '' 로 바꾸거나 또는 지워주세요 )
        $supply_item = get_item_supply($it['it_id'], $it['it_supply_subject'], 'div');
    }

    // 상품 선택옵션 수
    $option_count = 0;
    if($it['it_option_subject']) {
        $temp = explode(',', $it['it_option_subject']);
        $option_count = count($temp);
    }

    // 상품 추가옵션 수
    $supply_count = 0;
    if($it['it_supply_subject']) {
        $temp = explode(',', $it['it_supply_subject']);
        $supply_count = count($temp);
    }
}
*/
// 스킨경로
$skin_dir = G5_MSHOP_SKIN_PATH;
$ca_dir_check = true;

if($it['it_mobile_skin']) {
    if(preg_match('#^theme/(.+)$#', $it['it_mobile_skin'], $match))
        $skin_dir = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/shop/'.$match[1];
    else
        $skin_dir = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/shop/'.$it['it_mobile_skin'];

    if(is_dir($skin_dir)) {
        $form_skin_file = $skin_dir.'/item.form.skin.php';

        if(is_file($form_skin_file))
            $ca_dir_check = false;
    }
}

if($ca_dir_check) {
    if($ca['ca_mobile_skin_dir']) {
        if(preg_match('#^theme/(.+)$#', $ca['ca_mobile_skin_dir'], $match))
            $skin_dir = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/shop/'.$match[1];
        else
            $skin_dir = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/shop/'.$ca['ca_mobile_skin_dir'];

        if(is_dir($skin_dir)) {
            $form_skin_file = $skin_dir.'/item.form.skin.php';

            if(!is_file($form_skin_file))
                $skin_dir = G5_MSHOP_SKIN_PATH;
        } else {
            $skin_dir = G5_MSHOP_SKIN_PATH;
        }
    }
}

define('G5_SHOP_CSS_URL', str_replace(G5_PATH, G5_URL, $skin_dir));

$g5['title'] = $it['it_name'].' &gt; '.$it['ca_name'];

include_once(G5_MSHOP_PATH.'/_head.php');
include_once(G5_SHOP_PATH.'/settle_naverpay.inc.php');

// 상단 HTML
echo '<div id="sit_hhtml">'.conv_content($it['it_mobile_head_html'], 1).'</div>';

$sql = "SELECT AVG(is_score) is_score, COUNT(is_id) cnt, IFNULL(SUM( IF( is_reply_name<>'',1,0 ) ),0) re_cnt FROM ".$g5['g5_shop_item_use_table']." WHERE it_id='".$it['mb_no']."' AND is_cat2='".$ca['ca_name']."'";
$use_dt = sql_fetch($sql);
$star_str = "";
for ($jj = 1; $jj <= 5; $jj++) {
	if ($jj <= intval($use_dt['is_score'])) $star_str .= "<i class='xi-star'></i>";
	else $star_str .= "<i class='xi-star-o'></i>";
}

$bcat_arr = b_cat_func($it['mb_1']);
$scat_arr = s_cat_func($it['mb_2']);

$l = searchForId("ca_id", $ca_id, $bcat_arr);
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
?>

<?php if($is_orderable) { ?>
<script src="<?php echo G5_JS_URL; ?>/shop.js"></script>
<?php } ?>

<?php
if (G5_HTTPS_DOMAIN)
    $action_url = G5_HTTPS_DOMAIN.'/'.G5_SHOP_DIR.'/cartupdate.php';
else
    $action_url = G5_SHOP_URL.'/cartupdate.php';

add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);

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
        <a href="<?php echo $call_ret > 0 ? "tel:1661-3439" : G5_URL."/payment.php"; ?>" class="tel-box">
          <img src="/m-fortune-img/call_icon.png" alt="전화번호">
          <span>1661-3439</span>
        </a>
		<!-- tel:02-3433-1177 -->
        <span class="relative">
          <a href="<?php echo $call_ret > 0 ? "tel:02-3433-1177" : G5_URL."/payment.php"; ?>" class="tel-box">
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

<div class="pop-bg2 tip_pop">
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
<script>
  $(function(){
	<?php
	//if ($is_member) {
	?>
    $(".status_possible").on("click",function(){
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

    $(".help_btn").on("click",function(){
      $(".pop-bg2").show();
    });
    $(".pop-close").on("click",function(){
      $(".pop-bg2").hide();
    });

	$("#ViewLink").click(function() {
		var text = "<?php echo G5_SHOP_URL; ?>/item.php?ca_id=<?php echo $ca_id; ?>&it_id=<?php echo $it['mb_no']; ?>"; //$("#site_url2").text();

		//숨겨진 input박스 value값으로 text 변수 넣어줌.
		$('#clip_target').val(text);
		//input박스 value를 선택
		$('#clip_target').select();
		// Use try & catch for unsupported browser
		try {
			// The important part (copy selected text)
			var successful = document.execCommand('copy');
			alert ('주소가 복사되었습니다.');
		}
		catch (err) {
			alert('이 브라우저는 지원하지 않습니다.')
		}
	});
  });
</script>
<div id="sit">

    <?php
    // 상품 구입폼
    //include_once($skin_dir.'/item.form.skin.php');
    ?>

<?php if($config['cf_kakao_js_apikey']) { ?>
<script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>
<script src="<?php echo G5_JS_URL; ?>/kakaolink.js"></script>
<script>
    // 사용할 앱의 Javascript 키를 설정해 주세요.
    Kakao.init("<?php echo $config['cf_kakao_js_apikey']; ?>");
</script>
<?php } ?>

<form name="fitem" action="<?php echo $action_url; ?>" method="post" onsubmit="return fitem_submit(this);">
<input type="hidden" name="it_id[]" value="<?php echo $it['mb_no']; ?>">
<input type="hidden" name="sw_direct">
<input type="hidden" name="url">
<input id="clip_target" type="text" value="" style="position:absolute;top:-9999em;"/>
<script>

  function goBack(){
    window.history.back();
  }
</script>

<div class="navi clearfix">
  <div class="left" onclick="goBack();">
    <a href="javascript:void(0)" onclick="javascript:history.back();">
      <i class="xi-angle-left"></i><span>목록으로</span>
    </a>
  </div>

  <div class="right">
    <a href="/index.php" class="home"><i class="xi-home"></i></a>
    <i class="xi-angle-right-min"></i>
    <a href="/shop/list.php?ca_id=<?php echo $ca['ca_id'] ?>" class="txt"><?php echo $ca['ca_name'] ?></a>
  </div>
</div><!--navi-->

<div class="inner">
  <div id="sit_ov_wrap">
  <div class="sit-buttons clearfix">
    <div class="counsel">
	<?php
	$mb_st = counsel_stat($it['mb_id']);
	//var_dump($mb_st);
	if ( $mb_st ) $it['mb_status'] = $mb_st;

	if ( $it['mb_status'] == 2 ) {
		$mb_status = "상담가능";
		$mb_status_css = "status_possible";
	}
	else if ( $it['mb_status'] == 1 ) {
		$mb_status = "상담중";
		$mb_status_css = "status_ing";
	}
	else {
		$mb_status = "예약대기";
		$mb_status_css = "status_impossible";
	}
	?>

  <!--상담가능 : status_possible, 예약대기 :status_impossible, 상담중 : status_ing
  class달라짐-->
      <div class="<?php echo $mb_status_css; ?>" data-img="<?php echo G5_DATA_URL.'/temp/'.$it['mb_no'].'/'.$it['mb_8']; ?>" data-cate="<?php echo $bcat_arr[$l]['ca_name']; ?>" data-nick="<?php echo $it['mb_nick']." ".$it['mb_id']; ?>" data-css="<?php echo $bcat_bg; ?>">
        <p><?php echo $mb_status; ?></p>
      </div>

    </div>
    <div class="regular-cus">
        <a href="javascript:item_wish(document.fitem, '<?php echo $it['mb_no']; ?>');"><i class="xi-home-o"></i><spsan>단골등록</spsan></a>
    </div>
  </div>

  <!--상품 이미지 시작-->
  <div class="sit_img teacher_back_common <?php echo $bcat_bg; ?>">
    <!-- 선생님 배경이미지 : 클래스, 배경이미지 바뀜(sct_img 뒤에 클래스 추가)
    타로 일때 : back_taro (현재 예시로 설정해 놓음)
    꿈해몽 일떄 : back_dream
    펫타로 일때 : back_pettaro
    사주 일떄 : back_saju
    신점 일때 : back_shinjeom -->

    <!--카테고리 추가-->
    <div class="teacher_cate">
		<!--타로일때, 클래스와 배경 바뀜-->
      <p class="cate-<?php echo $bcat_str; ?>"><?php echo $bcat_arr[$l]['ca_name']; ?></p>
      <!--사주일때, 클래스와 배경 바뀜
       <p class="cate-saju">사주</p> -->
      <!-- 신점일때, 클래스와 배경 바뀜
      <p class="cate-sin">신점</p> -->
      <!--꿈해몽일때, 클래스와 배경 바뀜
      <p class="cate-dream">꿈해몽</p> -->
      <!-- 펫타로일때, 클래스와 배경 바뀜
      <p class="cate-pet">펫타로</p> -->
    </div>
    <!--//카테고리 추가-->

    <?php
    // 이미지(중) 썸네일
    $thumb_img = '';
    /*$thumb_img_w = 450; // 넓이
    $thumb_img_h = 248; // 높이
    for ($i=1; $i<=10; $i++)
    {
        if(!$it['it_img'.$i])
            continue;

        $thumb = get_it_thumbnail($it['it_img'.$i], $thumb_img_w, $thumb_img_h);

        if(!$thumb)
            continue;

        $thumb_img .= '<li>';
        $thumb_img .= '<a href="'.G5_SHOP_URL.'/largeimage.php?it_id='.$it['it_id'].'&amp;no='.$i.'" class="popup_item_image slide_img" target="_blank">'.$thumb.'</a>';
        $thumb_img .= '</li>'.PHP_EOL;
    }*/
    //if ($thumb_img)
    //{
		$thumb_img .= '<li>';
        $thumb_img .= '<img src="'.G5_DATA_URL.'/temp/'.$it['mb_no'].'/'.$it['mb_8'].'" width="450" alt="">';
        $thumb_img .= '</li>'.PHP_EOL;
        echo '<div id="sit_pvi">'.PHP_EOL;
        // echo '<button type="button" id="sit_pvi_prev" class="sit_pvi_btn" >이전</button>'.PHP_EOL;
        // echo '<button type="button" id="sit_pvi_next" class="sit_pvi_btn">다음</button>'.PHP_EOL;
        echo '<ul id="sit_pvi_slide">'.PHP_EOL;
        echo $thumb_img;
        echo '</ul>'.PHP_EOL;
        echo '</div>';
    //}
    ?>
  </div><!--sit-img-->

  <div class="sit_ov_top">
    <h2 id="sit_title"><?php echo stripslashes($it['mb_nick']); ?> <span class="teacher_number"><?php echo stripslashes($it['mb_id']); ?>번</span>
		<!--span class="sct_icon"-->
		<?php
		if ( $it['mb_type1'] == "1" ) {
			$icon = "shop_icon_1";
			$icon_str = "성실";
			echo "<span class=\"sct_icon\"><span class=\"shop_icon ".$icon."\">".$icon_str."</span></span>\n";
		}
		else if ( $it['mb_type2'] == "1" ) {
			$icon = "shop_icon_2";
			$icon_str = "추천";
			echo "<span class=\"sct_icon\"><span class=\"shop_icon ".$icon."\">".$icon_str."</span></span>\n";
		}
		else if ( $it['mb_type3'] == "1" ) {
			$icon = "shop_icon_3";
			$icon_str = "NEW";
			echo "<span class=\"sct_icon\"><span class=\"shop_icon ".$icon."\">".$icon_str."</span></span>\n";
		}
		else {
			$icon = "";
			$icon_str = "";
			echo "";
		}
		?>
		<!--/span-->
	</h2>
    <p id="sit_desc"><?php echo $it['mb_9']; ?></p>
    <!-- <p id="sit_url">https://www.sinsun.com/profile/홍길동 <button type="button" class="url_copy">URL복사</button></p> -->

    <!--공유하기 버튼 추가-->
    <button type="button" class="share" id="ViewLink"> <i class="xi-share-alt-o"></i></button>
    <!--//공유하기 버튼 추가-->

  </div>

  <div class="sit_ov_middle">
    <ul>
		<?php
		$profile_arr = explode("\n", $it['mb_profile']);
		//print_r($profile_arr);
		for ($i = 0; $i < count($profile_arr); $i++) {
		?>
		<li><?php echo $profile_arr[$i]; ?></li>
		<?php
		}
		?>
    </ul>
  </div>

  <!--분류 추가-->
  <div class="sorting">
	<?php
	$scat_arr = s_cat_func($it['mb_2']);
	for ($j = 0; $j < 3; $j++) {
	?>
	<span><?php echo $scat_arr[$j]['ht_name']; ?></span>
	<?php
	}
	?>
  </div>

<!--전화연결 시작
  <div class="call-wr">
    <div class="btn-wr clearfix">
      <a class="" href="tel:060-300-6700">
        일반전화상담
      </a>
      <a class="discount" href="tel:1661-3439">
        할인전화상담
      </a>
    </div>
전화연결 끝-->

  <div class="clearfix">
    <span class="txt">전화연결 후 + 고유번호 <?php echo $it['mb_id']; ?>번을 눌러주세요.</span>
    <span class="tip_button help_btn">TIP</span>
  </div>

  </div>

  <div class="num-wr">
    <span class="txt_wr">
      <?php echo $star_str; ?> 평점 <b><?php echo number_format($use_dt['is_score'],1); ?></b>
    </span>
    <span class="txt_wr">
      상담후기 <b><?php echo $use_dt['cnt']; ?></b>
    </span>

    <span class="txt_wr">
      상담사 댓글 <b><?php echo $use_dt['re_cnt']; ?></b>
    </span>
</div><!--num-wr-->
</div>



    <!-- 다른 상품 보기 시작 { -->
    <!-- <div id="sit_siblings"> -->
        <!-- <?php
        if ($prev_href || $next_href) {
            $prev_title = '<i class="fa fa-caret-left" aria-hidden="true"></i> '.$prev_title;
            $next_title = $next_title.' <i class="fa fa-caret-right" aria-hidden="true"></i>';

            echo $prev_href.$prev_title.$prev_href2;
            echo $next_href.$next_title.$next_href2;
        } else {
            echo '<span class="sound_only">이 분류에 등록된 다른 상품이 없습니다.</span>';
        }
        ?> -->
        <!-- <a href="<?php echo G5_SHOP_URL; ?>/largeimage.php?it_id=<?php echo $it['it_id']; ?>&amp;no=1" target="_blank" class="popup_item_image "><i class="fa fa-search-plus" aria-hidden="true"></i><span class="sound_only">확대보기</span></a>
    </div> -->
    <!-- } 다른 상품 보기 끝 -->

    <!-- <div id="sit_star_sns">
        <?php
        $sns_title = get_text($it['it_name']).' | '.get_text($config['cf_title']);
        $sns_url  = G5_SHOP_URL.'/item.php?it_id='.$it['it_id'];

        if ($score = get_star_image($it['it_id'])) { ?>
        <span class="sound_only">고객평점 <?php echo $score?>개</span>
        <img src="<?php echo G5_SHOP_URL; ?>/img/s_star<?php echo $score?>.png" alt="" class="sit_star" width="100"> <span class="st_bg"></span>
        <?php } ?>


         <i class="fa fa-commenting-o" aria-hidden="true"></i><span class="sound_only">리뷰</span> <?php echo $it['it_use_cnt']; ?>


        <span class="st_bg"></span> <i class="fa fa-heart-o" aria-hidden="true"></i><span class="sound_only">위시</span> <?php echo get_wishlist_count_by_item($it['it_id']); ?>
        <button type="button" class="btn_sns_share"><i class="fa fa-share-alt" aria-hidden="true"></i><span class="sound_only">sns 공유</span></button>
        <div class="sns_area">-->
            <!-- <?php echo get_sns_share_link('facebook', $sns_url, $sns_title, G5_MSHOP_SKIN_URL.'/img/facebook.png'); ?>
            <?php echo get_sns_share_link('twitter', $sns_url, $sns_title, G5_MSHOP_SKIN_URL.'/img/twitter.png'); ?>
            <?php echo get_sns_share_link('googleplus', $sns_url, $sns_title, G5_MSHOP_SKIN_URL.'/img/gplus.png'); ?>
            <?php echo get_sns_share_link('kakaotalk', $sns_url, $sns_title, G5_MSHOP_SKIN_URL.'/img/sns_kakao.png'); ?>
            <?php
            $href = G5_SHOP_URL.'/iteminfo.php?it_id='.$it_id;
            ?> -->
            <!-- <a href="javascript:popup_item_recommend('<?php echo $it['it_id']; ?>');" id="sit_btn_rec"><i class="fa fa-envelope-o" aria-hidden="true"></i><span class="sound_only">추천하기</span></a></div>
        </div>
    <script>
    $(".btn_sns_share").click(function(){
        $(".sns_area").show();
    });
    $(document).mouseup(function (e){
        var container = $(".sns_area");
        if( container.has(e.target).length === 0)
        container.hide();
    });


  </script>-->
</div><!--inner-->

<div id="sit_tt"></div>

<div id="sit_tab">
    <ul class="tab_tit">
        <li><button type="button" rel="#sit_inf" <?php echo $anchor == "sit_inf" || $anchor == "" ? 'class="selected"' : ''; ?>>인사말</button></li>
        <li><button type="button" rel="#sit_use" <?php echo $anchor == "sit_use" ? 'class="selected"' : ''; ?>>상담후기</button></li>
        <li><button type="button" rel="#sit_qa" <?php echo $anchor == "sit_qa" ? 'class="selected"' : ''; ?>>상담문의</button></li>
    </ul>
    <ul class="tab_con">

        <!-- 인사말 시작 { -->
        <li id="sit_inf">
            <h2 class="contents_tit"><span>인사말</span></h2>

            <h3>상품 상세설명</h3>
            <div id="sit_inf_explan">
                <?php echo $it['mb_memo']; ?>

                <!--솔팅추가-->
                <div class="sorting">
                <?php
                $scat_arr = s_cat_func($it['mb_2']);
                for ($j = 3; $j < count($scat_arr); $j++) {
                ?>
                <span><?php echo $scat_arr[$j]['ht_name']; ?></span>
                <?php
                }
                ?>
                <!--//솔팅추가-->
                </div>
            </div>


        </li>
        <!-- 상담후기 시작 { -->
        <li id="sit_use">
            <h2>상담후기</h2>
            <div id="itemuse"><?php include_once(G5_SHOP_PATH.'/itemuse.php'); ?></div>
        </li>
        <!-- } 사용후기 끝 -->

        <!-- 상담문의 시작 { -->
        <li id="sit_qa">
            <h2>상담문의</h2>

            <div id="itemqa"><?php include_once(G5_SHOP_PATH.'/itemqa.php'); ?></div>
        </li>
        <!-- } 상담문의 끝 -->


    </ul>
</div>
<script>
$(function (){
    $(".tab_con>li").hide();
	<?php
	if ( $anchor ) {
	?>
    $("#<?php echo $anchor; ?>").show();
	var offset = $("#sit_tab").offset();
	$('html, body').animate({scrollTop : offset.top}, 400);
	<?php
	}
	else {
	?>
	$(".tab_con>li:first").show();
	<?php
	}
	?>
    $(".tab_tit li button").click(function(){
        $(".tab_tit li button").removeClass("selected");
        $(this).addClass("selected");
        $(".tab_con>li").hide();
        $($(this).attr("rel")).show();
    });
});
</script>
</form>




<script>
$(window).bind("pageshow", function(event) {
    if (event.originalEvent.persisted) {
        document.location.reload();
    }
});

$(function(){
    // 상품이미지 슬라이드
    var time = 500;
    var idx = idx2 = 0;
    var slide_width = $("#sit_pvi_slide").width();
    var slide_count = $("#sit_pvi_slide li").size();
    $("#sit_pvi_slide li:first").css("display", "block");
    if(slide_count > 1)
        $(".sit_pvi_btn").css("display", "inline");

    $("#sit_pvi_prev").click(function() {
        if(slide_count > 1) {
            idx2 = (idx - 1) % slide_count;
            if(idx2 < 0)
                idx2 = slide_count - 1;
            $("#sit_pvi_slide li:hidden").css("left", "-"+slide_width+"px");
            $("#sit_pvi_slide li:eq("+idx+")").filter(":not(:animated)").animate({ left: "+="+slide_width+"px" }, time, function() {
                $(this).css("display", "none").css("left", "-"+slide_width+"px");
            });
            $("#sit_pvi_slide li:eq("+idx2+")").css("display", "block").filter(":not(:animated)").animate({ left: "+="+slide_width+"px" }, time,
                function() {
                    idx = idx2;
                }
            );
        }
    });

    $("#sit_pvi_next").click(function() {
        if(slide_count > 1) {
            idx2 = (idx + 1) % slide_count;
            $("#sit_pvi_slide li:hidden").css("left", slide_width+"px");
            $("#sit_pvi_slide li:eq("+idx+")").filter(":not(:animated)").animate({ left: "-="+slide_width+"px" }, time, function() {
                $(this).css("display", "none").css("left", slide_width+"px");
            });
            $("#sit_pvi_slide li:eq("+idx2+")").css("display", "block").filter(":not(:animated)").animate({ left: "-="+slide_width+"px" }, time,
                function() {
                    idx = idx2;
                }
            );
        }
    });

    // 상품이미지 크게보기
    $(".popup_item_image").click(function() {
        var url = $(this).attr("href");
        var top = 10;
        var left = 10;
        var opt = 'scrollbars=yes,top='+top+',left='+left;
        popup_window(url, "largeimage", opt);

        return false;
    });
});

// 상품보관
function item_wish(f, it_id)
{
    f.url.value = "<?php echo G5_SHOP_URL; ?>/wishupdate.php?it_id="+it_id;
    f.action = "<?php echo G5_SHOP_URL; ?>/wishupdate.php";
    f.submit();
}

// 추천메일
function popup_item_recommend(it_id)
{
    if (!g5_is_member)
    {
        if (confirm("회원만 추천하실 수 있습니다."))
            document.location.href = "<?php echo G5_BBS_URL; ?>/login.php?url=<?php echo urlencode(G5_SHOP_URL."/item.php?it_id=$it_id"); ?>";
    }
    else
    {
        url = "<?php echo G5_SHOP_URL; ?>/itemrecommend.php?it_id=" + it_id;
        opt = "scrollbars=yes,width=616,height=420,top=10,left=10";
        popup_window(url, "itemrecommend", opt);
    }
}

// 재입고SMS 알림
function popup_stocksms(it_id)
{
    url = "<?php echo G5_SHOP_URL; ?>/itemstocksms.php?it_id=" + it_id;
    opt = "scrollbars=yes,width=616,height=420,top=10,left=10";
    popup_window(url, "itemstocksms", opt);
}

function fsubmit_check(f)
{
    // 판매가격이 0 보다 작다면
    if (document.getElementById("it_price").value < 0) {
        alert("전화로 문의해 주시면 감사하겠습니다.");
        return false;
    }

    if($(".sit_opt_list").size() < 1) {
        alert("상품의 선택옵션을 선택해 주십시오.");
        return false;
    }

    var val, io_type, result = true;
    var sum_qty = 0;
    var min_qty = parseInt(<?php echo $it['it_buy_min_qty']; ?>);
    var max_qty = parseInt(<?php echo $it['it_buy_max_qty']; ?>);
    var $el_type = $("input[name^=io_type]");

    $("input[name^=ct_qty]").each(function(index) {
        val = $(this).val();

        if(val.length < 1) {
            alert("수량을 입력해 주십시오.");
            result = false;
            return false;
        }

        if(val.replace(/[0-9]/g, "").length > 0) {
            alert("수량은 숫자로 입력해 주십시오.");
            result = false;
            return false;
        }

        if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
            alert("수량은 1이상 입력해 주십시오.");
            result = false;
            return false;
        }

        io_type = $el_type.eq(index).val();
        if(io_type == "0")
            sum_qty += parseInt(val);
    });

    if(!result) {
        return false;
    }

    if(min_qty > 0 && sum_qty < min_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(min_qty))+"개 이상 주문해 주십시오.");
        return false;
    }

    if(max_qty > 0 && sum_qty > max_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(max_qty))+"개 이하로 주문해 주십시오.");
        return false;
    }

    return true;
}

// 바로구매, 장바구니 폼 전송
function fitem_submit(f)
{
    f.action = "<?php echo $action_url; ?>";
    f.target = "";

    if (document.pressed == "장바구니") {
        f.sw_direct.value = 0;
    } else { // 바로구매
        f.sw_direct.value = 1;
    }

    // 판매가격이 0 보다 작다면
    if (document.getElementById("it_price").value < 0) {
        alert("전화로 문의해 주시면 감사하겠습니다.");
        return false;
    }

    if($(".sit_opt_list").size() < 1) {
        alert("상품의 선택옵션을 선택해 주십시오.");
        return false;
    }

    var val, io_type, result = true;
    var sum_qty = 0;
    var min_qty = parseInt(<?php echo $it['it_buy_min_qty']; ?>);
    var max_qty = parseInt(<?php echo $it['it_buy_max_qty']; ?>);
    var $el_type = $("input[name^=io_type]");

    $("input[name^=ct_qty]").each(function(index) {
        val = $(this).val();

        if(val.length < 1) {
            alert("수량을 입력해 주십시오.");
            result = false;
            return false;
        }

        if(val.replace(/[0-9]/g, "").length > 0) {
            alert("수량은 숫자로 입력해 주십시오.");
            result = false;
            return false;
        }

        if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
            alert("수량은 1이상 입력해 주십시오.");
            result = false;
            return false;
        }

        io_type = $el_type.eq(index).val();
        if(io_type == "0")
            sum_qty += parseInt(val);
    });

    if(!result) {
        return false;
    }

    if(min_qty > 0 && sum_qty < min_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(min_qty))+"개 이상 주문해 주십시오.");
        return false;
    }

    if(max_qty > 0 && sum_qty > max_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(max_qty))+"개 이하로 주문해 주십시오.");
        return false;
    }

    return true;
}
</script>
<?php /* 2017 리뉴얼한 테마 적용 스크립트입니다. 기존 스크립트를 오버라이드 합니다. */ ?>
<script src="<?php echo G5_JS_URL; ?>/shop.override.js"></script>

</div>


<?php
// 하단 HTML
echo conv_content($it['it_mobile_tail_html'], 1);
include_once(G5_MSHOP_PATH.'/_tail.php');
?>
