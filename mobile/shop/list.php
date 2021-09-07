<?php
include_once('./_common.php');

// 상담사 리스트에서 다른 필드로 정렬을 하려면 아래의 배열 코드에서 해당 필드를 추가하세요.
if( isset($sort) && ! in_array($sort, array('it_sum_qty', 'it_price', 'it_use_avg', 'it_use_cnt', 'it_update_time')) ){
    $sort='';
}

$sql = " select *
           from {$g5['g5_shop_category_table']}
          where ca_id = '$ca_id'
            and ca_use = '1'  ";
$ca = sql_fetch($sql);
if (!$ca['ca_id'])
    alert('등록된 분류가 없습니다.', G5_SHOP_URL);

// 테마미리보기 스킨 등의 변수 재설정
if(defined('_THEME_PREVIEW_') && _THEME_PREVIEW_ === true) {
    $ca['ca_mobile_skin']       = (isset($tconfig['ca_mobile_skin']) && $tconfig['ca_mobile_skin']) ? $tconfig['ca_mobile_skin'] : $ca['ca_mobile_skin'];
    $ca['ca_mobile_img_width']  = (isset($tconfig['ca_mobile_img_width']) && $tconfig['ca_mobile_img_width']) ? $tconfig['ca_mobile_img_width'] : $ca['ca_mobile_img_width'];
    $ca['ca_mobile_img_height'] = (isset($tconfig['ca_mobile_img_height']) && $tconfig['ca_mobile_img_height']) ? $tconfig['ca_mobile_img_height'] : $ca['ca_mobile_img_height'];
    $ca['ca_mobile_list_mod']   = (isset($tconfig['ca_mobile_list_mod']) && $tconfig['ca_mobile_list_mod']) ? $tconfig['ca_mobile_list_mod'] : $ca['ca_mobile_list_mod'];
    $ca['ca_mobile_list_row']   = (isset($tconfig['ca_mobile_list_row']) && $tconfig['ca_mobile_list_row']) ? $tconfig['ca_mobile_list_row'] : $ca['ca_mobile_list_row'];
}

// 본인인증, 성인인증체크
if(!$is_admin) {
    $msg = shop_member_cert_check($ca_id, 'list');
    if($msg)
        alert($msg, G5_SHOP_URL);
}

$g5['title'] = $ca['ca_name'];

include_once(G5_MSHOP_PATH.'/_head.php');

// 스킨경로
$skin_dir = G5_MSHOP_SKIN_PATH;

if($ca['ca_mobile_skin_dir']) {
    if(preg_match('#^theme/(.+)$#', $ca['ca_mobile_skin_dir'], $match))
        $skin_dir = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/shop/'.$match[1];
    else
        $skin_dir = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/shop/'.$ca['ca_mobile_skin_dir'];

    if(is_dir($skin_dir)) {
        $skin_file = $skin_dir.'/'.$ca['ca_mobile_skin'];

        if(!is_file($skin_file))
            $skin_dir = G5_MSHOP_SKIN_PATH;
    } else {
        $skin_dir = G5_MSHOP_SKIN_PATH;
    }
}

define('G5_SHOP_CSS_URL', str_replace(G5_PATH, G5_URL, $skin_dir));
?>

<script>
var g5_shop_url = "<?php echo G5_SHOP_URL; ?>";
</script>
<script src="<?php echo G5_JS_URL; ?>/shop.mobile.list.js"></script>


<div id="sct">
  <div class="navi clearfix">
    <div class="left">
      <a href="#">
      </a>
    </div>

    <div class="right">
      <a href="/index.php" class="home"><i class="xi-home"></i></a>
      <i class="xi-angle-right-min"></i>
      <a href="#" class="txt"><?php echo get_text($g5['title']); ?></a>
    </div>
  </div>

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
  <div class="sub_banner" id="<?php echo $sub_img_str; ?>">
    <!--서브 카테고리에 따라 id달림 :
    타로 일때 : sub_taro (현재 예시로 설정해 놓음)
    펫타로 일때 : sub_pet
    꿈해몽 일떄 : sub_dream
    사주 일떄 : sub_saju
    신점 일때 : sub_sin
  -->
    <h2><?php echo $ca['ca_name'] ?></h2>

    <!--모바일에서는 세부분야 사용 안한다고 해서 주석처리해두었습니다~-->
    <!-- <div class="tag_list">
      <button type="button" class="tag_button <?php echo ( $_REQUEST['ht_no'] == "" ) ? "active" : ""; ?>" id="ht_0" name="ht_no" data-no="">전체</button>
	  <?php
	  $qdt2 = get_hash_list();	// 세부분야내역 가져오기
	  for ($ii = 0; $ii < count($qdt2); $ii++) {
	  ?>
	  <button type="button" class="tag_button <?php echo ( $_REQUEST['ht_no'] == $qdt2[$ii]['ht_no'] ) ? "active" : ""; ?>" id="ht_<?php echo $qdt2[$ii]['ht_no']; ?>" name="ht_no" data-no="<?php echo $qdt2[$ii]['ht_no']; ?>"><?php echo $qdt2[$ii]['ht_name']; ?></button>
	  <?php
	  }
	  ?>
    </div> -->
  </div>
<?php
$sct_sort_href = $_SERVER['SCRIPT_NAME'].'?';
if($ca_id)
    $sct_sort_href .= 'ca_id='.$ca_id;
else if($ev_id)
    $sct_sort_href .= 'ev_id='.$ev_id;
if($skin)
    $sct_sort_href .= '&amp;skin='.$skin;
$sct_sort_href .= '&amp;sort=';
?>
  <!--솔팅 추가-->
  <ul id="ssch_sort" class="clearfix">
    <li><a href="<?php echo $sct_sort_href; ?>it_sum_qty&amp;sortodr=desc">조회순</a></li>
    <li><a href="<?php echo $sct_sort_href; ?>it_use_cnt&amp;sortodr=desc">후기많은순</a></li>
    <li><a href="<?php echo $sct_sort_href; ?>it_use_avg&amp;sortodr=desc">별점높은순</a></li>
  </ul>
  <!--솔팅 추가-->


  <!-- <div class="main-tab">
    <ul>
      <li class="reco">
        추천
      </li>
      <li class="new">
        NEW
      </li>
      <li class="avail">
        상담가능
      </li>
    </ul>
  </div> -->

<div class="inner">


    <?php
    // 상단 HTML
    echo '<div id="sct_hhtml">'.conv_content($ca['ca_mobile_head_html'], 1).'</div>';

    $cate_skin = $skin_dir.'/listcategory.skin.php';
    if(!is_file($cate_skin))
        $cate_skin = G5_MSHOP_SKIN_PATH.'/listcategory.skin.php';
    include $cate_skin;

    // // 테마미리보기 베스트상담사 재설정
    // if(defined('_THEME_PREVIEW_') && _THEME_PREVIEW_ === true) {
    //     if(isset($theme_config['ca_mobile_list_best_mod']))
    //         $theme_config['ca_mobile_list_best_mod'] = (isset($tconfig['ca_mobile_list_best_mod']) && $tconfig['ca_mobile_list_best_mod']) ? $tconfig['ca_mobile_list_best_mod'] : 0;
    //     if(isset($theme_config['ca_mobile_list_best_row']))
    //         $theme_config['ca_mobile_list_best_row'] = (isset($tconfig['ca_mobile_list_best_row']) && $tconfig['ca_mobile_list_best_row']) ? $tconfig['ca_mobile_list_best_row'] : 0;
    // }
    //
    // // 분류 Best Item
    // $list_mod = (isset($theme_config['ca_mobile_list_best_mod']) && $theme_config['ca_mobile_list_best_mod']) ? (int)$theme_config['ca_mobile_list_best_mod'] : $ca['ca_mobile_list_mod'];
    // $list_row = (isset($theme_config['ca_mobile_list_best_row']) && $theme_config['ca_mobile_list_best_row']) ? (int)$theme_config['ca_mobile_list_best_row'] : $ca['ca_mobile_list_row'];
    // $limit = $list_mod * $list_row;
    // $best_skin = G5_MSHOP_SKIN_PATH.'/list.best.10.skin.php';
    //
    // $sql = " select *
    //             from {$g5['g5_shop_item_table']}
    //             where ( ca_id like '$ca_id%' or ca_id2 like '$ca_id%' or ca_id3 like '$ca_id%' )
    //               and it_use = '1'
    //               and it_type4 = '1'
    //             order by it_order, it_id desc
    //             limit 0, $limit ";
    //
    // $list = new item_list($best_skin, $list_mod, $list_row, $ca['ca_mobile_img_width'], $ca['ca_mobile_img_height']);
    // $list->set_query($sql);
    // $list->set_mobile(true);
    // $list->set_view('it_img', true);
    // $list->set_view('it_id', false);
    // $list->set_view('it_name', true);
    // $list->set_view('it_price', true);
    // echo $list->run();

    // 상담사 출력순서가 있다면
    if ($sort != "")
        $order_by = $sort.' '.$sortodr.' , it_order, it_id desc';
    else
        $order_by = 'it_order, it_id desc';

    $error = '<p class="sct_noitem">등록된 선생님이 없습니다.</p>';

    // 리스트 스킨
    $skin_file = is_include_path_check($skin_dir.'/'.$ca['ca_mobile_skin']) ? $skin_dir.'/'.$ca['ca_mobile_skin'] : $skin_dir.'/list.10.skin.php';

    if (file_exists($skin_file)) {

        // echo '<div id="sct_sortlst">';
        //
        // $sort_skin = $skin_dir.'/list.sort.skin.php';
        // if(!is_file($sort_skin))
        //     $sort_skin = G5_MSHOP_SKIN_PATH.'/list.sort.skin.php';
        // include $sort_skin;
        //
        //     // 상담사 보기 타입 변경 버튼
        // $sub_skin = $skin_dir.'/list.sub.skin.php';
        // if(!is_file($sub_skin))
        //     $sub_skin = G5_MSHOP_SKIN_PATH.'/list.sub.skin.php';
        //
        // if(is_file($sub_skin)){
        //     include $sub_skin;
        // }
        //
        // echo '</div>';

        // 총몇개
        $items = $ca['ca_mobile_list_mod'] * $ca['ca_mobile_list_row'];
        // 페이지가 없으면 첫 페이지 (1 페이지)
        if ($page < 1) $page = 1;
        // 시작 레코드 구함
        $from_record = ($page - 1) * $items;
		/*
        $list = new item_list($skin_file, $ca['ca_mobile_list_mod'], $ca['ca_mobile_list_row'], $ca['ca_mobile_img_width'], $ca['ca_mobile_img_height']);
        $list->set_category($ca['ca_id'], 1);
        $list->set_category($ca['ca_id'], 2);
        $list->set_category($ca['ca_id'], 3);
        $list->set_is_page(true);
        $list->set_mobile(true);
        $list->set_order_by($order_by);
        $list->set_from_record($from_record);
        $list->set_view('it_img', true);
        $list->set_view('it_id', false);
        $list->set_view('it_name', true);
        $list->set_view('it_price', true);
        $list->set_view('sns', true);
        echo $list->run();

        // where 된 전체 상담사수
        $total_count = $list->total_count;
		*/
		$ca['ca_list_mod'] = 1;

		if ( $sort == "it_sum_qty" ) {
			$orderby = " mb_view DESC";
		}
		else if ( $sort == "it_use_avg" ) {
			$orderby = " mb_star DESC";
		}
		else if ( $sort == "it_use_cnt" ) {
			$orderby = " mb_review DESC";
		}
		else {
			$orderby = " mb_status ASC, rand()";
		}
		$sub_where = "";
		if ( $_REQUEST['ca_id'] ) {
			//$sub_where .= " AND INSTR(mb_1,'".$_REQUEST['ca_id']."') > 0 AND mb_use='".$_REQUEST['ca_id']."' ";
			$sub_where .= " AND INSTR(mb_1,'".$_REQUEST['ca_id']."') > 0 ";
		}
		if ( $_REQUEST['ht_no'] ) {
			$sub_where .= " AND INSTR(mb_2,'".$_REQUEST['ht_no']."') > 0 ";
		}
		/*$sql = "SELECT COUNT(*) AS cnt FROM ".$g5['member_table']." WHERE mb_level='3' ".$sub_where." ORDER BY ".$orderby;
		//echo $sql;
		$tot_arr = sql_fetch($sql);
		$total_count = $tot_arr['cnt'];*/

		$sql = "SELECT * FROM ".$g5['member_table']." WHERE mb_level='3' AND mb_hide='0' ".$sub_where." ORDER BY ".$orderby; //." LIMIT ".$from_record.", ".$items;
		//echo $sql;
		$result = sql_query($sql);

        // where 된 전체 상담사수
        $total_count = sql_num_rows($result);
        // 전체 페이지 계산
        $total_page  = ceil($total_count / $items);
//echo $skin_file;
		include $skin_file;
    }
    else
    {
        echo '<div class="sct_nofile">'.str_replace(G5_PATH.'/', '', $skin_file).' 파일을 찾을 수 없습니다.<br>관리자에게 알려주시면 감사하겠습니다.</div>';
    }
    ?>

    <?php
    if($i > 0 && $total_count > $items) {
        $qstr1 .= 'ca_id='.$ca_id;
        $qstr1 .='&sort='.$sort.'&sortodr='.$sortodr;
        $ajax_url = G5_SHOP_URL.'/ajax.list.php?'.$qstr1.'&use_sns=1';
    ?>

    <!--div class="li_more">
        <p id="item_load_msg"><img src="<?php echo G5_SHOP_CSS_URL; ?>/img/loading.gif" alt="로딩이미지" ><br>잠시만 기다려주세요.</p>
        <div class="li_more_btn">
            <button type="button" id="btn_more_item" class="main-more" data-url="<?php echo $ajax_url; ?>" data-page="<?php echo $page; ?>">상담사 더보기<i class="xi-angle-down-min"></i></button>
        </div>
    </div-->
    <?php } ?>

    <?php
    // 하단 HTML
    echo '<div id="sct_thtml">'.conv_content($ca['ca_mobile_tail_html'], 1).'</div>';
    ?>
</div>
</div>


<script>
/*mobile tab*/
$(function() {
			$('.main-tab li').click(function() {
        var idx = $(this).index();

        $(".sct_wrap").hide()
        $(".sct_wrap").eq(idx).show()

        // $(".tab_btn").removeClass("on")
        // $(".tab_btn").eq(idx).addClass("on")
			});
		});

$(document).ready(function() {
	$("button[name=ht_no]").click(function() {
		location.href = "<?php echo G5_SHOP_URL; ?>/list.php?ca_id=<?php echo $ca_id; ?>&ht_no="+$(this).data('no');
	});
});
</script>
<?php
include_once(G5_MSHOP_PATH.'/_tail.php');

echo "\n<!-- {$ca['ca_mobile_skin']} -->\n";
?>
