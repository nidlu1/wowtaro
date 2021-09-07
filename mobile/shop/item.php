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

// 상품문의의 개수를 얻음
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
<?php
  switch ($ca_id) {
    case '10' :
      $sub_img_str = "sub_taro";
      break;
    case '20' :
      $sub_img_str = "sub_sin";
      break;
    case '30' :
      $sub_img_str = "sub_saju";
      break;
    case '40' :
      $sub_img_str = "sub_pet";
      break;
    case '50' :
      $sub_img_str = "sub_dream";
      break;
    default :
      $sub_img_str = "sub_taro";
      break;
  }
?>
<div class="c_hero" id="<?php echo $sub_img_str; ?>">
	 <!--서브 카테고리에 따라 id달림 :
	  타로 일때 : sub_taro (현재 예시로 설정해 놓음)
	  펫타로 일때 : sub_pet
	  꿈해몽 일떄 : sub_dream
	  사주 일떄 : sub_saju
	  신점 일때 : sub_sin
	-->
	<strong>신선운세 <mark><?php echo $ca['ca_name'] ?></mark></strong>
	<!--div class="tag_list">
		<button type="button" class="tag_button <?php echo ( $_REQUEST['ht_no'] == "" ) ? "active" : ""; ?>" id="ht_0" name="ht_no" data-no="">전체</button>
		<?php
		$qdt2 = get_hash_list();	// 세부분야내역 가져오기
		for ($ii = 0; $ii < count($qdt2); $ii++) {
		?>
		<button type="button" class="tag_button <?php echo ( $_REQUEST['ht_no'] == $qdt2[$ii]['ht_no'] ) ? "active" : ""; ?>" id="ht_<?php echo $qdt2[$ii]['ht_no']; ?>" name="ht_no" data-no="<?php echo $qdt2[$ii]['ht_no']; ?>"><?php echo $qdt2[$ii]['ht_name']; ?></button>
		<?php
		}
		?>
  </div-->
</div>
<div class="c_list">
	<div class="cl_menu">
		<a href='<?php echo G5_URL; ?>/'><i></i><span class="blind">HOME</span></a>
		<span>신선운세</span>
		<span><mark><a href="/shop/list.php?ca_id=<?php echo $ca['ca_id'] ?>"><?php echo $ca['ca_name'] ?></a></mark></span>
	</div>
</div>
<div class="c_area view">
	<div class="wrap">
		<ul class="ca_function t1">
			<li class="caf_item favorite"><a href="javascript:item_wish(document.fitem, '<?php echo $it['mb_no']; ?>');" class="cafi_btn"><span>단골등록</span></a></li>
			<li class="caf_item share"><button type="button" class="cafi_btn" id="ViewLink"><span>공유하기</span></button></li>
		</ul>
		<div class="ca_member">
			<form name="fitem" method="post" action="./cartupdate.php" onsubmit="return fitem_submit(this);">
			<input type="hidden" name="it_id[]" value="<?php echo $it['mb_no']; ?>">
			<input type="hidden" name="sw_direct">
			<input type="hidden" name="url">
			<input id="clip_target" type="text" value="" style="position:absolute;top:-9999em;"/>
				<div class="cam_area">
					<div class="cam_wrap">
						<div class="cam_pic">
							<div>
								<img src="<?php echo G5_DATA_URL; ?>/temp/<?php echo $it['mb_no']; ?>/<?php echo $it['mb_8']; ?>" alt="<?php echo $it['mb_nick']; ?> <?php echo $it['mb_id']; ?>번">
							
								<?php
									if ( $mb_st ) $it['mb_status'] = $mb_st;

									if ( $it['mb_status'] == 2 ) {
										$mb_status = "상담가능";
										$mb_status_css = "tel-avail";
										$mb_status_img = "1";
									}
									else if ( $it['mb_status'] == 1 ) {
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
								<div class="camp_status <?php echo $mb_status_css ?>">
									<span><?php echo $mb_status ?></span>
								</div>
							</div>
						</div>
						<div class="cam_info">
							<div class="cami_title">
								<span><?php echo $it['mb_nick']; ?> <mark><?php echo $it['mb_id']; ?>번</mark></span>
							</div>
							<div class="cami_txt">
								<span><?php echo $it['mb_9']; ?></span>
							</div>
						</div>
						<!--분류 추가-->
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
								$profile_arr = explode("\n", $it['mb_profile']);
								//print_r($profile_arr);
								for ($i = 0; $i < count($profile_arr); $i++) {
								?>
								<li><span><?php echo $profile_arr[$i]; ?></span></li>
								<?php
								}
								?>
							</ul>
						</div>
						<div class="cam_score">
							<?php
							$sql = "SELECT AVG(is_score) is_score, COUNT(is_id) cnt, IFNULL(SUM( IF( is_reply_name<>'',1,0 ) ),0) re_cnt FROM ".$g5['g5_shop_item_use_table']." WHERE it_id='".$it['mb_no']."' AND is_cat2='".$bcat_arr[$l]['ca_name']."'";
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
								<span><span>상담후기</span><mark><?php echo $use_dt['cnt']; ?></mark></span>
							</span>
						</div>
					</div>
				</div>
				<ul class="cam_buttons">
					<li><a href="#counsel_detail" class="tel">바로상담</a></li>
					<li><a href="#counsel_detail" class="tel">할인상담</a></li>
				</ul>
			</form>
		</div>
		<div class="ca_board">
			<!-- 상담사 정보 시작 { -->
			<div class="cab_wrap" id="cab_info">
				<ul>
					<li class="on"><a href="#cab_info">인사말</a></li>
					<li><a href="#cab_review">상담후기</a></li>
					<li><a href="#cab_qa">상담문의</a></li>
				</ul>
				<section class="cab_content">
					<h2 class="blind">상담사 정보</h2>
					<h3 class="blind">상담사 상세설명</h3>
					<div class="cabc_txt">
						<p><?php echo $it['mb_memo']; ?></p>
					</div>
				</section>
			</div>
			<!-- } 상담사 정보 끝 -->

			<!-- 사용후기 시작 { -->
			<div class="cab_wrap" id="cab_review">
				<ul>
					<li><a href="#cab_info">인사말</a></li>
					<li class="on"><a href="#cab_review">상담후기</a></li>
					<li><a href="#cab_qa">상담문의</a></li>
				</ul>
				<section class="cab_content">
					<!-- <h2>사용후기</h2> -->
					<div id="itemuse">
						<?php
						include "itemuse.php";
						?>
					</div>
				</section>
			</div>
			<!-- 상담사문의 시작 { -->
			<div class="cab_wrap" id="cab_qa">
				<ul>
					<li><a href="#cab_info">인사말</a></li>
					<li><a href="#cab_review">상담후기</a></li>
					<li class="on"><a href="#cab_qa">상담문의</a></li>
				</ul>
				<section class="cab_content">
					<h2 class="blind">상담문의</h2>
					<div class="cabc_qa">
						<?php
						include "itemqa.php";
						?>
					</div>
				</section>
			</div>
			<!-- } 상담문의 끝 -->
		</div>
	</div>
</div>

	

<!-- 팝업, 신선운세 상담 S -->
<div class="popup t2 counsel_detail">
	<div class="p_box">
		<a href="#!" class="p_close"><span class="blind">닫기</span></a>
		<div class="p_wrap">
			<div class="p_head t1">
				<h3>바로상담</h3>
				<p>
					<span><a href="tel:0603006700"><i></i>060-300-6700</a> + 전화연결 후 + <?php echo $it['mb_id']; ?></span>
				</p>
			</div>
			<div class="p_body">
				<p>
					<span><mark>30초당 1300원이 부과</mark>됩니다.</span>
					<span>보다 부담없는 요금으로 신선운세를 이용하시려면, <strong>할인상담</strong>을 권해드립니다.</span>
					<span><strong>할인상담 시 30~50%의 요금이 할인</strong>됩니다.</span>
				</p>
			</div>
			<div class="p_head t2">
				<h3>할인상담</h3>
				<p>
					<span><a href="tel:16613439"><i class="t1"></i>1661-3439</a> + 전화연결 후 + <?php echo $it['mb_id']; ?></span>
					<span><a href="tel:0234331177"><i class="t2"></i>02-3433-1177</a> + 전화연결 후 + <?php echo $it['mb_id']; ?></span>
				</p>
			</div>
			<div class="p_body">
				<p>
					<span>할인상담 시 <strong><a href="tel:0234331177">02-3433-1177</a> 이용하시면 발신요금을 절약</strong>하실 수 있습니다.</span>
					<span>요금제나 통신사에 따라 무료 발신요금이 다를 수 있으며, 자세한 내용은</span>
					<span>해당 통신사 홈페이지를 참고하세요.</span>
				</p>
			</div>
		</div>
	</div>
</div>
<!-- 팝업, 신선운세 상담 E -->

<script>
$(function (){
    $(".tab_con>li").hide();
	<?php
	if ( $anchor ) {
	?>
    $("#<?php echo $anchor; ?>").show();
	//var offset = $("#sit_tab").offset();
	//$('html, body').animate({scrollTop : offset.top}, 400);
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
