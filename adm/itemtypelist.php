<?php
$sub_menu = '200120';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$doc = strip_tags($doc);

$g5['title'] = '상담사유형관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

/*
$sql_search = " where 1 ";
if ($search != "") {
	if ($sel_field != "") {
    	$sql_search .= " and $sel_field like '%$search%' ";
    }
}

if ($sel_ca_id != "") {
    $sql_search .= " and (ca_id like '$sel_ca_id%' or ca_id2 like '$sel_ca_id%' or ca_id3 like '$sel_ca_id%') ";
}

if ($sel_field == "")  $sel_field = "it_name";
*/

$where = " WHERE mb_level='3' ";
$sql_search = $where."";
if ($stx != "") {
    if ($sfl != "") {
        $sql_search .= " AND $sfl like '%$stx%' ";
    }
    if ($save_stx != $stx)
        $page = 1;
}

if ($sca != "") {
    $sql_search .= " AND (ca_id like '$sca%' or ca_id2 like '$sca%' or ca_id3 like '$sca%') ";
}

if ($sfl == "")  $sfl = "mb_nick";

if (!$sst)  {
    $sst  = "mb_no";
    $sod = "desc";
}
$sql_order = "order by $sst $sod";

$sql_common = "  FROM {$g5['member_table']} ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql  = " select mb_no, mb_id, mb_8, mb_use, mb_1, mb_hide,
                 mb_nick,
                 mb_type1,
                 mb_type2,
                 mb_type3,
                 mb_type4,
                 mb_type5,
				 mb_free5,
				 mb_free10
          $sql_common
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);

$qstr  = $qstr.'&amp;sca='.$sca.'&amp;page='.$page.'&amp;save_stx='.$stx;

function searchForId2($id, $array) {
   foreach ($array as $key => $val) {
       if ($val['ca_id'] === $id) {
           return $val['ca_name'];
       }
   }
   return null;
}
$qdt = get_cate_list();

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';
?>

<div class="local_ov01 local_ov">
    <?php echo $listall; ?>
        <span class="btn_ov01"><span class="ov_txt">전체 상담사</span><span class="ov_num">  <?php echo $total_count; ?>명</span></span>
</div>

<form name="flist" class="local_sch01 local_sch">
<input type="hidden" name="doc" value="<?php echo $doc; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<label for="sca" class="sound_only">분류선택</label>
<select name="sca" id="sca">
    <option value="">전체분류</option>
    <?php
    $sql1 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} order by ca_order, ca_id ";
    $result1 = sql_query($sql1);
    for ($i=0; $row1=sql_fetch_array($result1); $i++) {
        $len = strlen($row1['ca_id']) / 2 - 1;
        $nbsp = "";
        for ($i=0; $i<$len; $i++) $nbsp .= "&nbsp;&nbsp;&nbsp;";
        echo '<option value="'.$row1['ca_id'].'" '.get_selected($sca, $row1['ca_id']).'>'.$nbsp.$row1['ca_name'].PHP_EOL;
    }
    ?>
</select>

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="mb_nick" <?php echo get_selected($sfl, 'mb_nick'); ?>>상담사명</option>
	<option value="mb_id" <?php echo get_selected($sfl, 'mb_id'); ?>>상담사코드</option>
</select>

<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" required class="frm_input required">
<input type="submit" value="검색" class="btn_submit">

</form>

<form name="fitemtypelist" method="post" action="./itemtypelistupdate.php">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr id="menu_top">
        <th scope="col" style="width:5%;"><?php echo subject_sort_link("mb_id", $qstr, 1); ?>상담사코드</a></th>
        <th scope="col" style="width:40%;"><?php echo subject_sort_link("mb_nick"); ?>상담사명</a></th>
		<th scope="col" style="width:10%;"><?php echo subject_sort_link("mb_use", $qstr, 1); ?>상담사<br>노출</a></th>
		<th scope="col" style="width:5%;"><?php echo subject_sort_link("mb_hide", $qstr, 1); ?>상담사<br>숨김</a></th>
        <th scope="col" style="width:5%;"><?php echo subject_sort_link("mb_type1", $qstr, 1); ?>성실<br>상담사</a></th>
        <th scope="col" style="width:5%;"><?php echo subject_sort_link("mb_type2", $qstr, 1); ?>추천<br>상담사</a></th>
        <th scope="col" style="width:5%;"><?php echo subject_sort_link("mb_type3", $qstr, 1); ?>신규<br>상담사</a></th>
        <th scope="col" style="width:5%;"><?php echo subject_sort_link("mb_type4", $qstr, 1); ?>메인화면<br>배치</a></th>
        <th scope="col" style="width:5%;"><?php echo subject_sort_link("mb_type5", $qstr, 1); ?>이달의<br>상담사</a></th>
		<th scope="col" style="width:5%;"><?php echo subject_sort_link("mb_free5", $qstr, 1); ?>5분무료</a></th>
        <th scope="col" style="width:5%;"><?php echo subject_sort_link("mb_free10", $qstr, 1); ?>10분무료</a></th>
        <th scope="col" style="width:5%;">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php for ($i=0; $row=sql_fetch_array($result); $i++) {
        $href = G5_SHOP_URL.'/item.php?it_id='.$row['mb_no'];

		$img_src = ($row['mb_8']) ? "<img src='".G5_DATA_URL."/temp/".$row['mb_no']."/".$row['mb_8']."' width='50'>" : "";

        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_code" style="width:5%;">
            <input type="hidden" name="mb_no[<?php echo $i; ?>]" value="<?php echo $row['mb_no']; ?>">
            <?php echo $row['mb_id']; ?>
        </td>
        <td class="td_left" style="width:40%;"><a href="<?php echo $href; ?>"><?php echo $img_src; ?><?php echo cut_str(stripslashes($row['mb_nick']), 60, "&#133"); ?></a></td>
		<td class="td_chk2" style="width:10%;">
            <label for="type1_<?php echo $i; ?>" class="sound_only">상담사노출</label>
            <!--input type="checkbox" name="mb_use[<?php echo $i; ?>]" value="1" id="use_<?php echo $i; ?>" <?php echo ($row['mb_use'] ? 'checked' : ''); ?>-->
			<select id="use_<?php echo $i; ?>" name="mb_use[<?php echo $i; ?>]">
			<?php
			$arr_mb_1 = explode(",",$row['mb_1']);
			for ( $kkk = 0; $kkk < count($arr_mb_1); $kkk++) {
				$mb_1_str = searchForId2 ($arr_mb_1[$kkk], $qdt);
			?>
				<option value="<?php echo $arr_mb_1[$kkk]; ?>" <?php echo ($row['mb_use'] == $arr_mb_1[$kkk] ? 'selected' : ''); ?>><?php echo $mb_1_str; ?></option>
			<?php
			}
			?>
			</select>
        </td>
		<td class="td_chk2" style="width:5%;">
            <label for="hide_<?php echo $i; ?>" class="sound_only">상담사숨김</label>
            <input type="checkbox" name="mb_hide[<?php echo $i; ?>]" value="1" id="hide_<?php echo $i; ?>" <?php echo ($row['mb_hide'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_chk2" style="width:5%;">
            <label for="type1_<?php echo $i; ?>" class="sound_only">성실상담사</label>
            <input type="checkbox" name="mb_type1[<?php echo $i; ?>]" value="1" id="type1_<?php echo $i; ?>" <?php echo ($row['mb_type1'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_chk2" style="width:5%;">
            <label for="type2_<?php echo $i; ?>" class="sound_only">추천상담사</label>
            <input type="checkbox" name="mb_type2[<?php echo $i; ?>]" value="1" id="type2_<?php echo $i; ?>" <?php echo ($row['mb_type2'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_chk2" style="width:5%;">
            <label for="type3_<?php echo $i; ?>" class="sound_only">신규상담사</label>
            <input type="checkbox" name="mb_type3[<?php echo $i; ?>]" value="1" id="type3_<?php echo $i; ?>" <?php echo ($row['mb_type3'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_chk2" style="width:5%;">
            <label for="type4_<?php echo $i; ?>" class="sound_only">메인화면배치</label>
            <input type="checkbox" name="mb_type4[<?php echo $i; ?>]" value="1" id="type4_<?php echo $i; ?>" <?php echo ($row['mb_type4'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_chk2" style="width:5%;">
            <label for="type5_<?php echo $i; ?>" class="sound_only">이달의상담사</label>
            <input type="checkbox" name="mb_type5[<?php echo $i; ?>]" value="1" id="type5_<?php echo $i; ?>" <?php echo ($row['mb_type5'] ? 'checked' : ''); ?>>
        </td>
		<td class="td_chk2" style="width:5%;">
            <label for="type6_<?php echo $i; ?>" class="sound_only">5분무료</label>
            <input type="checkbox" name="mb_free5[<?php echo $i; ?>]" value="1" id="type6_<?php echo $i; ?>" <?php echo ($row['mb_free5'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_chk2" style="width:5%;">
            <label for="type7_<?php echo $i; ?>" class="sound_only">10분무료</label>
            <input type="checkbox" name="mb_free10[<?php echo $i; ?>]" value="1" id="type7_<?php echo $i; ?>" <?php echo ($row['mb_free10'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_mng td_mng_s" style="width:5%;">
            <a href="./member_form.php?w=u&amp;mb_id=<?php echo $row['mb_id']; ?>&amp;ca_id=<?php echo $row['ca_id']; ?>&amp;<?php echo $qstr; ?>" class="btn btn_03"><span class="sound_only"><?php echo cut_str(stripslashes($row['mb_nick']), 60, "&#133"); ?> </span>수정</a>
         </td>
    </tr>
    <?php
    }

    if (!$i)
        echo '<tr><td colspan="8" class="empty_table"><span>자료가 없습니다.</span></td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_confirm03 btn_confirm">
    <input type="submit" value="일괄수정" class="btn_submit">
</div>
</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script type="text/javascript">
var jbOffset = $( '#menu_top' ).offset();
var top_width = $(".tbl_head01 > table").width();
//console.log(top_width);
$(window).scroll(function(event){ 
	var sheight = eval($(document).scrollTop() + " + 100");
	if ( sheight > jbOffset.top ) {
		$( '#menu_top' ).css({"display" : "flex", "position" : "fixed", "z-index" : "9999", "top" : "100px", "width" : top_width+"px"});
		//$( '#menu_top > th' ).css({"display" : "block"});
	}
	else {
		$( '#menu_top' ).removeAttr("style"); 
		//$( '#menu_top > th' ).css({"display" : "table-cell"});
		//$( '#menu_top' ).css({"position" : "relative"});
	}

});
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
