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
    <div class="sub_banner" id="<?php echo $sub_img_str; ?>">
      <!--서브 카테고리에 따라 id달림 :
      타로 일때 : sub_taro (현재 예시로 설정해 놓음)
      펫타로 일때 : sub_pet
      꿈해몽 일떄 : sub_dream
      사주 일떄 : sub_saju
      신점 일때 : sub_sin
    -->
      <h2><?php echo $ca['ca_name'] ?></h2>
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

    <div id="sit">
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

<div class="back_list">
  <a href="javascript:void(0)" onclick="javascript:history.back();"><i class="xi-calendar-list"></i>목록으로</a>
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
echo '<div class="inner">';
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
			<form name="fitem" method="post" action="./cartupdate.php" onsubmit="return fitem_submit(this);">
			<input type="hidden" name="it_id[]" value="<?php echo $it['mb_no']; ?>">
			<input type="hidden" name="sw_direct">
			<input type="hidden" name="url">
			<input id="clip_target" type="text" value="" style="position:absolute;top:-9999em;"/>

				<div id="sit_ov_wrap">
					<div class="product_ornarment"></div>
					<!-- 상담사이미지 미리보기 시작 { -->
          <div class="clearfix">
					<div id="sit_pvi">
						<div id="sit_pvi_big">
							<!--a href="http://fortune.newbird0412.gethompy.com/shop/largeimage.php?it_id=1556791470&amp;no=1" target="_blank" class="popup_item_image"-->

              <div class="teacher_img teacher_back_common <?php echo $bcat_bg; ?>">
                <!--선생님 배경 이미지 클래스 :
                타로 일때 : back_taro (현재 예시로 설정해 놓음)
                꿈해몽 일떄 : back_dream
                펫타로 일때 : back_pettaro
                사주 일떄 : back_saju
                신점 일때 : back_shinjeom
              -->
                <img src="<?php echo G5_DATA_URL; ?>/temp/<?php echo $it['mb_no']; ?>/<?php echo $it['mb_8']; ?>" width="486" height="307" alt=""><!--/a-->

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
              </div>

							<div id="sit_star_sns">
								<ul>
                  <!--별점 하드코당-->
                  <li>
                    <span class="sound_only">고객평점</span>
                    <img src="/shop/img/s_star<?php echo intval($use_dt['is_score'])?>.png" alt="" class="sit_star" width="100">
                    <span><?php echo number_format($use_dt['is_score'],1)?></span>
                  </li>

                  <!--별점 주석처리-->
                  <!-- <li><?php if ($star_score) { ?>
                  <span class="sound_only">고객평점</span>
                  <img src="<?php echo G5_SHOP_URL; ?>/img/s_star<?php echo $star_score?>.png" alt="" class="sit_star" width="100">
                  <span><?php echo $star_score?></span>
                  <?php } ?>
                  </li> -->
									<li>
										<span>상담후기</span>
										<strong><?php echo $use_dt['cnt']; ?></strong>
									</li>
									<li>
										<span>상담사 댓글</span>
										<strong><?php echo $use_dt['re_cnt']; ?></strong>
									</li>
								</ul>
							</div>
						</div>
					</div>
	    <!-- } 상담사이미지 미리보기 끝 -->

	    <!-- 상담사 요약정보 및 구매 시작 { -->
					<section id="sit_ov" class="2017_renewal_itemform">
						<div class="sit_buttons">
						<!-- 상태에 따른 클래스: 상담가능(status_possible)/상담중(status_img)/예약대기(status_impossible) -->
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

							<div class="<?php echo $mb_status_css; ?> tel"><?php echo $mb_status; ?></div>
							<a href="javascript:item_wish(document.fitem, '<?php echo $it['mb_no']; ?>');"><i class="xi-home-o"></i><span>단골등록</span></a>
						</div>
						<div class="sit_ov_top">
							<h2 id="sit_title"><?php echo $it['mb_nick']; ?> <?php echo $it['mb_id']; ?>번<span class="sct_icon"><span class="sit_icon"><span class="shop_icon shop_icon_2">추천</span></span></span></h2>
							<p id="sit_desc"><?php echo $it['mb_9']; ?></p>
							<!-- <p id="sit_url"><span id="site_url2"><?php echo G5_SHOP_URL; ?>/item.php?ca_id=<?php echo $ca_id; ?>&it_id=<?php echo $it['mb_no']; ?></span> <button type="button" id="ViewLink" class="url_copy">URL복사</button></p> -->
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
      <!--솔팅 및 공유하기 추가-->
            <div class="sorting_copy">
              <div class="sorting">
			<?php
			for ($j = 0; $j < 3; $j++) {
			?>
				<span><?php echo $scat_arr[$j]['ht_name']; ?></span>
			<?php
			}
			?>
                <button type="button" class="share" id="ViewLink"> <i class="xi-share-alt-o"></i> 공유하기</button>
              </div>
              <!-- <p id="sit_url"><span id="site_url2"><?php echo G5_SHOP_URL; ?>/item.php?ca_id=<?php echo $ca_id; ?>&it_id=<?php echo $it['mb_no']; ?></span> <button type="button" id="ViewLink" class="url_copy">URL복사</button></p> -->
            </div>
        <!--//솔팅 및 공유하기 추가-->


				<!-- 선택된 옵션 시작 { -->

			<!-- } 선택된 옵션 끝 -->

        </div>
					</section>

          <div class="sit_ov_bottom clearfix">
            <div class="counsel_wrap discount_coun">
              <label>일반전화상담</label>
              <strong>060-300-6700 + <b class="color_red"><?php echo $it['mb_id']; ?></b></strong>
              <span>전화연결 후 + 고유번호 <b class="color_red"><?php echo $it['mb_id']; ?></b>번을 눌러주세요.</span>
            </div>
            <div class="counsel_wrap default_coun">
              <label>할인전화상담</label>
              <strong>1661-3439 + <b class="color_red"><?php echo $it['mb_id']; ?></b></strong>
              <span>전화연결 후 + 고유번호 <b class="color_red"><?php echo $it['mb_id']; ?></b>번을 눌러주세요.</span>
            </div>
          </div>
	    <!-- } 상담사 요약정보 및 구매 끝 -->

				</div>
			</form>

  <!--pop 팝업 추가 시작-->
  <div class="pop-bg1">
  <div class="pop1">

    <div class="tit_wr">
      <span class="pop_img teacher_back_small back_taro">
        <!--선생님 배경 이미지 클래스 :
        타로 일때 : back_taro (현재 예시로 설정해 놓음)
        꿈해몽 일떄 : back_dream
        펫타로 일때 : back_pettaro
        사주 일떄 : back_saju
        신점 일때 : back_shinjeom
      -->
        <img src="<?php echo G5_DATA_URL; ?>/temp/<?php echo $it['mb_no']; ?>/<?php echo $it['mb_8']; ?>" alt="당담자 사진">
      </span>

      <span class="tit">
        <?php echo $it['mb_nick']; ?> <?php echo $it['mb_id']; ?>번
      </span>

      <span class="pop-close">
        <i class="xi-close"></i>
      </span>
    </div>
    <div class="pop_con_wr">
      <div class="discount">
        <h3>할인상담<span>(코인충전)</span></h3>
        <p>
          코인충전후 전화연결시 상담사 바로 연결됩니다.<br>
          코인상담은 <a href="#" class="login">로그인</a> 후 이용 가능합니다.
        </p>
        <div class="tel-box">
          <img src="/m-fortune-img/call_icon.png" alt="전화번호">
          <span>1661-3439</span>
        </div>
        <div class="tel-box mar">
          <img src="/m-fortune-img/call_icon.png" alt="전화번호">
          <span>02-3433-1177</span>
          <i class="xi-help help-btn"></i>
        </div>
      </div>
      <div class="baro">
        <h3>060 바로상담<span>(후불)</span></h3>
        <p>
          전화연결시 고유번호 입력후 상담사와 바로연결됩니다.
        </p>
        <div class="tel-box red">
          <img src="/m-fortune-img/call_icon.png" alt="전화번호">
          <span>060-300-6700</span>
        </div>
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
  <!--//팝업끝-->
  <script type="text/javascript">
    $(function(){
      $(".tel").on("click",function(){
        $(".pop-bg1").show();
      });

      $(".pop1 .pop-close").on("click",function(){
        $(".pop-bg1").hide();
      });
      $(".help-btn").on("click",function(){
        $(".pop-bg2").show();
      });

      $(".pop2 .pop-close").on("click",function(){
        $(".pop-bg2").hide();
      });
    });
  </script>


	<!-- 상담사 정보 시작 { -->
			<ul class="sanchor">
				<li><a href="#sit_inf" class="sanchor_on">인사말</a></li>
				<li><a href="#sit_use" >상담후기</a></li>
				<li><a href="#sit_qa" >상담문의</a></li>
			</ul>
			<section id="sit_inf">
				<h2>상담사 정보</h2>
				<h3>상담사 상세설명</h3>
				<div id="sit_inf_explan">
					<p><?php echo $it['mb_memo']; ?></p>

          <!--솔팅 추가-->
                <div class="sorting_copy">
                  <div class="sorting">
    			<?php
    			for ($j = 3; $j < count($scat_arr); $j++) {
    			?>
    				<span><?php echo $scat_arr[$j]['ht_name']; ?></span>
    			<?php
    			}
    			?>
          <!--//솔팅 추가-->
                  </div>
                  <!-- <p id="sit_url"><span id="site_url2"><?php echo G5_SHOP_URL; ?>/item.php?ca_id=<?php echo $ca_id; ?>&it_id=<?php echo $it['mb_no']; ?></span> <button type="button" id="ViewLink" class="url_copy">URL복사</button></p> -->
                </div>
            <!--//솔팅 및 공유하기 추가-->


				</div>
			</section>
	<!-- } 상담사 정보 끝 -->

	<!-- 사용후기 시작 { -->
			<section id="sit_use">
				<!-- <h2>사용후기</h2> -->
				<ul class="sanchor">
					<li><a href="#sit_inf" >인사말</a></li>
					<li><a href="#sit_use" class="sanchor_on">상담후기</a></li>
					<li><a href="#sit_qa" >상담문의</a></li>
				</ul>
				<div id="itemuse">
					<?php
					include "itemuse.php";
					?>
	<!-- 상담사 사용후기 시작 {
					<section id="sit_use_list">
						<h3>등록된 사용후기</h3>
						<div class="sit_use_top">
						</div>

						<p class="sit_empty">사용후기가 없습니다.</p>
						<div class="board_summary_bottom">
							<div class="pager">
								<a href="#" class="pager_func first"><i class="xi-angle-left-min"></i><i class="xi-angle-left-min"></i></a>
								<a href="#" class="pager_func prev"><i class="xi-angle-left-min"></i></a>
								<a href="#" class="on">1</a>
								<a href="#">2</a>
								<a href="#">3</a>
								<a href="#">4</a>
								<a href="#" class="pager_func next"><i class="xi-angle-right-min"></i></a>
								<a href="#" class="pager_func last"><i class="xi-angle-right-min"></i><i class="xi-angle-right-min"></i></a>
							</div>
							<a href="./itemuseform.php?it_id=1556791470" class="write_btn itemuse_form">후기등록<span class="sound_only"> 새 창</span></a>
						</div>
					</section>
				</div>
			</section>
	 } 사용후기 끝 -->

	<!-- 상담사문의 시작 { -->
			<section id="sit_qa">
				<h2>상담문의</h2>
				<ul class="sanchor">
					<li><a href="#sit_inf" >인사말</a></li>
					<li><a href="#sit_use" >상담후기</a></li>
					<li><a href="#sit_qa" class="sanchor_on">상담문의</a></li>
				</ul>
				<div id="itemqa">
					<?php
					include "itemqa.php";
					?>
	<!-- 상담사문의 목록 시작 {
					<section id="sit_qa_list">
						<h3>등록된 상담문의</h3>
						<p class="sit_empty">상담문의가 없습니다.</p>
						<div class="board_summary_bottom">
							<div class="pager">
								<a href="#" class="pager_func first"><i class="xi-angle-left-min"></i><i class="xi-angle-left-min"></i></a>
								<a href="#" class="pager_func prev"><i class="xi-angle-left-min"></i></a>
								<a href="#" class="on">1</a>
								<a href="#">2</a>
								<a href="#">3</a>
								<a href="#">4</a>
								<a href="#" class="pager_func next"><i class="xi-angle-right-min"></i></a>
								<a href="#" class="pager_func last"><i class="xi-angle-right-min"></i><i class="xi-angle-right-min"></i></a>
							</div>
							<a href="./itemqaform.php?it_id=1556791470" class="write_btn itemuse_form">문의하기<span class="sound_only"> 새 창</span></a>
						</div>
					</section>
 } 상담문의 목록 끝 -->
				</div>
            
			</section>
	<!-- } 상담문의 끝 -->
   


<?php
// 하단 HTML
echo conv_content($it['it_tail_html'], 1);
echo '</div>';
?>

<?php
if ($ca['ca_include_tail'] && is_include_path_check($ca['ca_include_tail']))
    @include_once($ca['ca_include_tail']);
else
    include_once(G5_SHOP_PATH.'/_tail.php');
?>
