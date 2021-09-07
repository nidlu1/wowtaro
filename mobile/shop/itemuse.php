<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$itemuse_list = "./itemuselist.php";
$itemuse_form = "./itemuseform.php?it_id=".$it_id."&is_cat2=".$ca['ca_name'];
$itemuse_formupdate = "./itemuseformupdate.php?it_id=".$it_id."&is_cat2=".$ca['ca_name'];
$itemuse_form2 = "./itemuseform2.php?it_id=".$it_id."&is_cat2=".$ca['ca_name'];
$itemuse_form2update = "./itemuseform2update.php?it_id=".$it_id."&is_cat2=".$ca['ca_name'];

 $sql_common = " from `{$g5['g5_shop_item_use_table']}` where it_id = '{$it_id}' AND is_cat2='".$ca['ca_name']."' and is_confirm = '1' ";

// 테이블의 전체 레코드수만 얻음
$sql = " select COUNT(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 5;
$total_page  = ceil($total_count / $rows); // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$to_record = $page * $rows; // 시작 레코드 구함
$from_record = 0;

$sql = "select * $sql_common order by is_id desc limit $from_record, $to_record ";
$result = sql_query($sql);

$sql2 = "select * $sql_common AND is_cat='할인상담' order by is_id desc limit $from_record, $to_record ";
$result2 = sql_query($sql2);

$sql3 = "select * $sql_common AND is_cat='일반상담' order by is_id desc limit $from_record, $to_record ";
$result3 = sql_query($sql3);

$itemuse_skin = G5_MSHOP_SKIN_PATH.'/itemuse.skin.php';

if(!file_exists($itemuse_skin)) {
    echo str_replace(G5_PATH.'/', '', $itemuse_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($itemuse_skin);
}
?>