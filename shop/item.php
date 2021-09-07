<?php
include_once('./_common.php');

// 조회수 증가
//if (get_cookie('ck_view_ip') != $_SERVER['REMOTE_ADDR']."_".$it_id) {
    //set_cookie('ck_view_ip', $_SERVER['REMOTE_ADDR']."_".$it_id, 86400); // 하루동안 저장

    sql_query("UPDATE ".$g5['member_table']." SET mb_view=mb_view+1 WHERE mb_no='".$it_id."'");
//}
/* 회원이 접속하면 상담사의 상태값이 상담중, 예약대기 인 경우 휴먼정보의 상태값으로 변경 */
counsel_stat_update();
/* 회원이 접속하면 상담사의 상태값이 상담중, 예약대기 인 경우 휴먼정보의 상태값으로 변경 */
if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/item.php');
    return;
}

$it_id = get_search_string(trim($_GET['it_id']));

include_once(G5_LIB_PATH.'/iteminfo.lib.php');

// 분류사용, 상담사 사용하는 상담사의 정보를 얻음
$sql = " select * from {$g5['member_table']} where mb_no = '$it_id' AND mb_hide='0' ";
$it = sql_fetch($sql);
if (!$it['mb_no'])
    alert('상담사회원이 없습니다.');

$bcat_arr = b_cat_func($it['mb_1']);
$l = mt_rand( 0, (count($bcat_arr) - 1) );
$_REQUEST['ca_id'] = ( !$_REQUEST['ca_id'] ) ? $bcat_arr[$l]['ca_id'] : $_REQUEST['ca_id'];

// 분류 테이블에서 분류 상단, 하단 코드를 얻음
$sql = " select ca_id, ca_name, ca_skin_dir, ca_include_head, ca_include_tail, ca_cert_use, ca_adult_use from {$g5['g5_shop_category_table']} where ca_id = '{$_REQUEST['ca_id']}' ";
$ca = sql_fetch($sql);

// 본인인증, 성인인증체크
if(!$is_admin) {
    $msg = shop_member_cert_check($it_id, 'item');
    if($msg)
        alert($msg, G5_SHOP_URL);
}

// 오늘 본 상담사 저장 시작
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
// 오늘 본 상담사 저장 끝

// 조회수 증가
if (get_cookie('ck_it_id') != $it_id) {
    //sql_query(" update {$g5['g5_shop_item_table']} set it_hit = it_hit + 1 where it_id = '$it_id' "); // 1증가
    set_cookie("ck_it_id", $it_id, 3600); // 1시간동안 저장
}


// 스킨경로
$skin_dir = G5_SHOP_SKIN_PATH;
$ca_dir_check = true;

if($it['it_skin']) {
    if(preg_match('#^theme/(.+)$#', $it['it_skin'], $match))
        $skin_dir = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/shop/'.$match[1];
    else
        $skin_dir = G5_PATH.'/'.G5_SKIN_DIR.'/shop/'.$it['it_skin'];

    if(is_dir($skin_dir)) {
        $form_skin_file = $skin_dir.'/item.form.skin.php';

        if(is_file($form_skin_file))
            $ca_dir_check = false;
    }
}

if($ca_dir_check) {
    if($ca['ca_skin_dir']) {
        if(preg_match('#^theme/(.+)$#', $ca['ca_skin_dir'], $match))
            $skin_dir = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/shop/'.$match[1];
        else
            $skin_dir = G5_PATH.'/'.G5_SKIN_DIR.'/shop/'.$ca['ca_skin_dir'];

        if(is_dir($skin_dir)) {
            $form_skin_file = $skin_dir.'/item.form.skin.php';

            if(!is_file($form_skin_file))
                $skin_dir = G5_SHOP_SKIN_PATH;
        } else {
            $skin_dir = G5_SHOP_SKIN_PATH;
        }
    }
}

define('G5_SHOP_CSS_URL', str_replace(G5_PATH, G5_URL, $skin_dir));

$g5['title'] = $it['mb_nick'].' &gt; '.$ca['ca_name'];

// 분류 상단 코드가 있으면 출력하고 없으면 기본 상단 코드 출력
if ($ca['ca_include_head'] && is_include_path_check($ca['ca_include_head']))
    @include_once($ca['ca_include_head']);
else
    include_once(G5_SHOP_PATH.'/_head.php');

?>
<?php
  switch ($ca['ca_id']) {
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
<div class="c_hero" id="<?php echo $sub_img_str;?>">
	<!--서브 카테고리에 따라 id달림 :
	  타로 일때 : sub_taro (현재 예시로 설정해 놓음)
	  펫타로 일때 : sub_pet
	  꿈해몽 일떄 : sub_dream
	  사주 일떄 : sub_saju
	  신점 일때 : sub_sin
	-->
	<strong>신선운세 <mark><?php echo $ca['ca_name'] ?></mark></strong>
	<!--div class="tag_list">
	<button type="button" class="tag_button active" id="ht_0" name="ht_no" data-no="">전체</button>
			<button type="button" class="tag_button " id="ht_1" name="ht_no" data-no="1">연애/속마음</button>
			<button type="button" class="tag_button " id="ht_2" name="ht_no" data-no="2">재회/이별</button>
			<button type="button" class="tag_button " id="ht_3" name="ht_no" data-no="3">커플/궁합</button>
			<button type="button" class="tag_button " id="ht_4" name="ht_no" data-no="4">심리/성향</button>
			<button type="button" class="tag_button " id="ht_5" name="ht_no" data-no="5">취업/진로</button>
			<button type="button" class="tag_button " id="ht_8" name="ht_no" data-no="8">사업/금전</button>
			<button type="button" class="tag_button " id="ht_9" name="ht_no" data-no="9">직업/이직</button>
			<button type="button" class="tag_button " id="ht_12" name="ht_no" data-no="12">연애/코치</button>
			<button type="button" class="tag_button " id="ht_21" name="ht_no" data-no="21">펫성향/심리</button>
			<button type="button" class="tag_button " id="ht_22" name="ht_no" data-no="22">펫궁합</button>
			<button type="button" class="tag_button " id="ht_24" name="ht_no" data-no="24">펫건강</button>
			<button type="button" class="tag_button " id="ht_28" name="ht_no" data-no="28">예지몽/흉몽</button>
			<button type="button" class="tag_button " id="ht_29" name="ht_no" data-no="29">태몽/길몽</button>
			<button type="button" class="tag_button " id="ht_30" name="ht_no" data-no="30">사주/운세</button>
			<button type="button" class="tag_button " id="ht_31" name="ht_no" data-no="31">타로전문가</button>
			<button type="button" class="tag_button " id="ht_32" name="ht_no" data-no="32">요점정리</button>
	  </div-->
</div>


<?php

// 분류 위치
// HOME > 1단계 > 2단계 ... > 6단계 분류
$ca_id = $ca['ca_id'];
$nav_skin = $skin_dir.'/navigation.skin.php';
if(!is_file($nav_skin))
    $nav_skin = G5_SHOP_SKIN_PATH.'/navigation.skin.php';
include $nav_skin;

if(defined('G5_THEME_USE_ITEM_CATEGORY') && G5_THEME_USE_ITEM_CATEGORY){
    // 이 분류에 속한 하위분류 출력
    $cate_skin = $skin_dir.'/listcategory.skin.php';
    if(!is_file($cate_skin))
        $cate_skin = G5_SHOP_SKIN_PATH.'/listcategory.skin.php';
    include $cate_skin;
}

if ($is_admin) {
    //echo '<div class="sit_admin"><a href="'.G5_ADMIN_URL.'/shop_admin/itemform.php?w=u&amp;it_id='.$it_id.'" class="btn_admin">상담사 관리</a></div>';
}
?>

	<div class="cl_function">
		<div class="clf_item favorite">
			<a href="javascript:item_wish(document.fitem, '<?php echo $it['mb_no']; ?>');" class="clfi_btn"><span>단골등록</span></a>
		</div>
		<div class="clf_item share">
			<button type="button" class="clfi_btn" id="ViewLink"> 공유하기</button>
		</div>
	</div>
</div>

<script type="text/javascript">

$(document).ready(function() {
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

function item_wish(f, it_id)
{
	f.url.value = "<?php echo G5_SHOP_URL; ?>/wishupdate.php?it_id="+it_id;
	f.action = "<?php echo G5_SHOP_URL; ?>/wishupdate.php";
	f.submit();
}

</script>
<!-- 상담사 상세보기 시작 { -->
<?php
// 상단 HTML
echo '<div id="sit_hhtml">'.conv_content($it['it_head_html'], 1).'</div>';

?>
<?php
$sql = "SELECT AVG(is_score) is_score, COUNT(is_id) cnt, IFNULL(SUM( IF( is_reply_name<>'',1,0 ) ),0) re_cnt FROM ".$g5['g5_shop_item_use_table']." WHERE it_id='".$it['mb_no']."' AND is_cat2='".$ca['ca_name']."'";
$use_dt = sql_fetch($sql);
//ptr2($sql);
$star_str = "";
//for ($jj = 1; $jj <= 5; $jj++) {
	//if ($jj <= intval($use_dt['is_score'])) $star_str .= "<i class='xi-star'></i>";
	//else $star_str .= "<i class='xi-star-o'></i>";
//}

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
<div class="c_area view">
	<div class="wrap">
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

<!-- 팝업, 신선운세 상담 S -->
<div class="popup t2 counsel_detail">
	<div class="p_box">
		<a href="#!" class="p_close"><span class="blind">닫기</span></a>
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
<!-- 팝업, 신선운세 상담 E -->
<?php
// 하단 HTML
echo conv_content($it['it_tail_html'], 1);
echo '</div>';
?>

</div>
<?php
if ($ca['ca_include_tail'] && is_include_path_check($ca['ca_include_tail'])){
    @include_once($ca['ca_include_tail']);
}
else {
    include_once(G5_SHOP_PATH.'/_tail.php');
    
}
?>
