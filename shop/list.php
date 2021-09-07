<?php
include_once('./_common.php');
// 상담사 리스트에서 다른 필드로 정렬을 하려면 아래의 배열 코드에서 해당 필드를 추가하세요.
if( isset($sort) && ! in_array($sort, array('it_sum_qty', 'it_price', 'it_use_avg', 'it_use_cnt', 'it_update_time')) ){
    $sort='';
}
/* 회원이 접속하면 상담사의 상태값이 상담중, 예약대기 인 경우 휴먼정보의 상태값으로 변경 */
counsel_stat_update();
/* 회원이 접속하면 상담사의 상태값이 상담중, 예약대기 인 경우 휴먼정보의 상태값으로 변경 */
if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/list.php');
    return;
}

$sql = " select * from {$g5['g5_shop_category_table']} where ca_id = '$ca_id' and ca_use = '1' ";
$ca = sql_fetch($sql);
if (!$ca['ca_id'])
    alert('등록된 분류가 없습니다.');

// 테마미리보기 스킨 등의 변수 재설정
if(defined('_THEME_PREVIEW_') && _THEME_PREVIEW_ === true) {
    $ca['ca_skin']       = (isset($tconfig['ca_skin']) && $tconfig['ca_skin']) ? $tconfig['ca_skin'] : $ca['ca_skin'];
    $ca['ca_img_width']  = (isset($tconfig['ca_img_width']) && $tconfig['ca_img_width']) ? $tconfig['ca_img_width'] : $ca['ca_img_width'];
    $ca['ca_img_height'] = (isset($tconfig['ca_img_height']) && $tconfig['ca_img_height']) ? $tconfig['ca_img_height'] : $ca['ca_img_height'];
    $ca['ca_list_mod']   = (isset($tconfig['ca_list_mod']) && $tconfig['ca_list_mod']) ? $tconfig['ca_list_mod'] : $ca['ca_list_mod'];
    $ca['ca_list_row']   = (isset($tconfig['ca_list_row']) && $tconfig['ca_list_row']) ? $tconfig['ca_list_row'] : $ca['ca_list_row'];
}

// 본인인증, 성인인증체크
if(!$is_admin) {
    $msg = shop_member_cert_check($ca_id, 'list');
    if($msg)
        alert($msg, G5_SHOP_URL);
}

$g5['title'] = $ca['ca_name'].' 상담사리스트';

if ($ca['ca_include_head'] && is_include_path_check($ca['ca_include_head']))
    @include_once($ca['ca_include_head']);
else
    include_once(G5_SHOP_PATH.'/_head.php');
//print_r($_REQUEST);
?>


<?php
//$bcat_arr = b_cat_func($row['mb_1']);
//$scat_arr = s_cat_func($row['mb_2']);

//for ($j = 0; $j < count($bcat_arr); $j++) {
//  switch ($bcat_arr[$j]['ca_id']) {
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
//}
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

<?php
// 스킨경로
$skin_dir = G5_SHOP_SKIN_PATH;

if($ca['ca_skin_dir']) {
    if(preg_match('#^theme/(.+)$#', $ca['ca_skin_dir'], $match))
        $skin_dir = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/shop/'.$match[1];
    else
        $skin_dir = G5_PATH.'/'.G5_SKIN_DIR.'/shop/'.$ca['ca_skin_dir'];

    if(is_dir($skin_dir)) {
        $skin_file = $skin_dir.'/'.$ca['ca_skin'];

        if(!is_file($skin_file))
            $skin_dir = G5_SHOP_SKIN_PATH;
    } else {
        $skin_dir = G5_SHOP_SKIN_PATH;
    }
}

define('G5_SHOP_CSS_URL', str_replace(G5_PATH, G5_URL, $skin_dir));

// if ($is_admin)
//     echo '<div class="sct_admin"><a href="'.G5_ADMIN_URL.'/shop_admin/categoryform.php?w=u&amp;ca_id='.$ca_id.'" class="btn_admin">분류 관리</a></div>';
// ?>

<script>
var itemlist_ca_id = "<?php echo $ca_id; ?>";

$(document).ready(function() {
	$("button[name=ht_no]").click(function() {
		location.href = "<?php echo G5_SHOP_URL; ?>/list.php?ca_id=<?php echo $ca_id; ?>&ht_no="+$(this).data('no');
	});
});
</script>
<script src="<?php echo G5_JS_URL; ?>/shop.list.js"></script>

<!-- 상담사 목록 시작 { -->
<div id="sct">

    <?php
    $nav_skin = $skin_dir.'/navigation.skin.php';
    if(!is_file($nav_skin))
        $nav_skin = G5_SHOP_SKIN_PATH.'/navigation.skin.php';
    include $nav_skin;

    // 상단 HTML
   // echo '<div id="sct_hhtml">'.conv_content($ca['ca_head_html'], 1).'</div>';
    ?>
<?php
    $cate_skin = $skin_dir.'/listcategory.skin.php';
    if(!is_file($cate_skin))
        $cate_skin = G5_SHOP_SKIN_PATH.'/listcategory.skin.php';
    include $cate_skin;

    // 상담사 출력순서가 있다면
    if ($sort != "")
        $order_by = $sort.' '.$sortodr.' , it_order, it_id desc';
    else
        $order_by = 'it_order, it_id desc';

    $error = '<p class="sct_noitem title t1 cg">등록된 선생님이 없습니다.</p>';

    // 리스트 스킨
    $skin_file = is_include_path_check($skin_dir.'/'.$ca['ca_skin']) ? $skin_dir.'/'.$ca['ca_skin'] : $skin_dir.'/list.10.skin.php';

    if (file_exists($skin_file)) {

		//echo '<div id="sct_sortlst">';
        $sort_skin = $skin_dir.'/list.sort.skin.php';
        if(!is_file($sort_skin))
            $sort_skin = G5_SHOP_SKIN_PATH.'/list.sort.skin.php';
        include $sort_skin;

        // 상담사 보기 타입 변경 버튼
        $sub_skin = $skin_dir.'/list.sub.skin.php';
        if(!is_file($sub_skin))
            $sub_skin = G5_SHOP_SKIN_PATH.'/list.sub.skin.php';
        include $sub_skin;
        //echo '</div>';

        // 총몇개 = 한줄에 몇개 * 몇줄
        $items = $ca['ca_list_mod'] * $ca['ca_list_row'];
        // 페이지가 없으면 첫 페이지 (1 페이지)
        if ($page < 1) $page = 1;
        // 시작 레코드 구함
        $from_record = ($page - 1) * $items;
/*
        $list = new item_list($skin_file, $ca['ca_list_mod'], $ca['ca_list_row'], $ca['ca_img_width'], $ca['ca_img_height']);
        $list->set_category($ca['ca_id'], 1);
        $list->set_category($ca['ca_id'], 2);
        $list->set_category($ca['ca_id'], 3);
        $list->set_is_page(true);
        $list->set_order_by($order_by);
        $list->set_from_record($from_record);
        $list->set_view('it_img', true);
        $list->set_view('it_id', false);
        $list->set_view('it_name', true);
        $list->set_view('it_basic', true);
        $list->set_view('it_cust_price', false);
        $list->set_view('it_price',false);
        $list->set_view('it_icon', true);
        $list->set_view('sns', false);
        echo $list->run();
*/
		//'it_sum_qty', 'it_use_avg', 'it_use_cnt'
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


        $sql_paging = "SELECT * FROM ".$g5['member_table']." WHERE mb_level='3' AND mb_hide='0' ".$sub_where." ORDER BY ".$orderby;
        // echo $sql_paging;
        $result_paging = sql_query($sql_paging);
        $totalRecord = sql_num_rows($result_paging);
        $curPage = empty( $_GET["curPage"])? 1 : $_GET["curPage"] ;
        $listPage = 18;
        $blockCnt = 5;
        $blockNum = ceil($curPage/$blockCnt);
        $blockStart = (($blockNum-1)*$blockCnt)+1;
        $blockEnd = $blockStart + $blockCnt -1;

        $pageStart = ($curPage-1)*$listPage;
        $totalPage = ceil($totalRecord / $listPage);
        if($blockEnd>$totalPage){
            $blockEnd=$totalPage;
        }
        $totalBlock = ceil($totalPage/$blockCnt);        





		$sql = "SELECT * FROM ".$g5['member_table']." WHERE mb_level='3' AND mb_hide='0' ".$sub_where." ORDER BY ".$orderby." limit $pageStart, $listPage";
		// echo "\n".$sql;
		$result = sql_query($sql);
        




        
        $totalRecord = sql_num_rows($result);
        // where 된 전체 상담사수

        $total_count = sql_num_rows($result);
        // 전체 페이지 계산
        $total_page  = ceil($total_count / $items);
// echo $skin_file;echo "<br>test<br>";
		include $skin_file;

    }
    else
    {
        echo '<div class="sct_nofile">'.str_replace(G5_PATH.'/', '', $skin_file).' 파일을 찾을 수 없습니다.<br>관리자에게 알려주시면 감사하겠습니다.</div>';
    }
    ?>
    <nav class="pg_wrap shop">
        <?php
            if($curPage>1){
                echo "<a href='/shop/list.php?ca_id=$ca_id&curPage=1' class='pg_start'></a>";
            }
            if($curPage>1){
                $pre = $curPage -1;
                echo "<a href='/shop/list.php?ca_id=$ca_id&curPage=$pre' class='pg_prev'></a>";
            }
            for($i = $blockStart; $i <= $blockEnd; $i++){
                if($curPage == $i){
                    echo "<strong class='pg_current'>$i</strong>";
                }else {
                    echo "<a href='/shop/list.php?ca_id=$ca_id&curPage=$i'>$i</a>";
                }

            }
            if($curPage<$totalPage){
                $next = $curPage + 1;
                echo "<a href='/shop/list.php?ca_id=$ca_id&curPage=$next' class='pg_next'></a>";
            }
            if($curPage<$totalPage){
                echo "<a href='/shop/list.php?ca_id=$ca_id&curPage=$totalPage' class='pg_end'></a>";
            }
        ?>
    </nav>
    <?php
    $qstr1 .= 'ca_id='.$ca_id;
    $qstr1 .='&amp;sort='.$sort.'&amp;sortodr='.$sortodr;
    //echo get_paging($config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr1.'&amp;page=');
    ?>

    <?php
    // 하단 HTML
    echo '<div id="sct_thtml">'.conv_content($ca['ca_tail_html'], 1).'</div>';

?>
</div>
<!-- } 상담사 목록 끝 -->

<?php
if ($ca['ca_include_tail'] && is_include_path_check($ca['ca_include_tail']))
    @include_once($ca['ca_include_tail']);
else
    include_once(G5_SHOP_PATH.'/_tail.php');

echo "\n<!-- {$ca['ca_skin']} -->\n";
?>
