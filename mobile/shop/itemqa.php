<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$itemqa_list = "./itemqalist.php";
$itemqa_form = "./itemqaform.php?it_id=".$it_id."&is_cat2=".$ca['ca_name'];
$itemqa_formupdate = "./itemqaformupdate.php?it_id=".$it_id."&is_cat2=".$ca['ca_name'];
$itemqa_form2 = "./itemqaform2.php?it_id=".$it_id."&is_cat2=".$ca['ca_name'];
$itemqa_form2update = "./itemqaform2update.php?it_id=".$it_id."&is_cat2=".$ca['ca_name'];

$sql_common = " from `{$g5['g5_shop_item_qa_table']}` a join `{$g5['member_table']}` b on (a.it_id=b.mb_no) where a.it_id = '{$it_id}' AND is_cat2='".$ca['ca_name']."' ";

// 테이블의 전체 레코드수만 얻음
$sql = " select COUNT(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 5;
$total_page  = ceil($total_count / $rows); // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 레코드 구함

$sql = "select *, a.mb_id iq_mb_id $sql_common order by a.iq_id desc limit $from_record, $rows ";
$result = sql_query($sql);

$itemqa_skin = G5_MSHOP_SKIN_PATH.'/itemqa.skin.php';

if(!file_exists($itemqa_skin)) {
    echo str_replace(G5_PATH.'/', '', $itemqa_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($itemqa_skin);
}
?>