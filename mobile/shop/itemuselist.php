<?php
include_once('./_common.php');

//$sfl = trim($_REQUEST['sfl']);
//$stx = trim($_REQUEST['stx']);

$g5['title'] = 'REVIEW';
include_once(G5_MSHOP_PATH.'/_head.php');

$sql_common = " from `{$g5['g5_shop_item_use_table']}` a join `{$g5['member_table']}` b on (a.it_id=b.mb_no AND b.mb_level='3' AND b.mb_hide='0') ";
$sql_search = " where a.is_confirm = '1' ";

if ( $_REQUEST['gubun'] == "best" ) $sql_search .= " AND is_best='1'";
else if ( $_REQUEST['gubun'] == "할인상담" ) $sql_search .= " AND is_cat='할인상담'";
else if ( $_REQUEST['gubun'] == "일반상담" ) $sql_search .= " AND is_cat='일반상담'";
$qstr .= "&gubun=".$_REQUEST['gubun'];

if(!$sfl)
    $sfl = 'b.it_name';

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "a.it_id" :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
        case "a.is_name" :
        case "a.mb_id" :
            $sql_search .= " ($sfl = '$stx') ";
            break;
        default :
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "a.is_id";
    $sod = "desc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt
         $sql_common
         $sql_search
         $sql_order ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
          $sql_common
          $sql_search
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);

$itemuselist_skin = G5_MSHOP_SKIN_PATH.'/itemuselist.skin.php';

if(!file_exists($itemuselist_skin)) {
    echo str_replace(G5_PATH.'/', '', $itemuselist_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($itemuselist_skin);
}

include_once(G5_MSHOP_PATH.'/_tail.php');
?>
