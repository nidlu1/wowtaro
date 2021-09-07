<?php

include_once('./_common.php');
/* 회원이 접속하면 상담사의 상태값이 상담중, 예약대기 인 경우 휴먼정보의 상태값으로 변경 */
counsel_stat_update();

if (G5_IS_MOBILE) {
//    echo G5_MSHOP_PATH . '/search.php';
    include_once(G5_MSHOP_PATH . '/search.php');
    return;
}

$g5['title'] = "상담사 검색 결과";
include_once('./_head.php');
?>
<?php

$mb_hashtag = SQLFiltering( str_replace("#", "", filter_input(INPUT_GET, "mb_hashtag")) );

$sql = " SELECT *
        FROM g5_member gm 
        WHERE mb_level='3' AND mb_hide='0' AND mb_type4='1' AND ( mb_status='1' OR mb_status='2' OR mb_status='3' ) AND ( mb_hashtag LIKE '%$mb_hashtag%' OR mb_nick LIKE '%$mb_hashtag%' ) ORDER BY mb_status ASC, rand();
 ";
$result = sql_query($sql);

$sql_hashtag = "SELECT * FROM g5_hashtag_v1 WHERE mg_YN = 'Y' ";
$result_hashtag = sql_query($sql_hashtag);

$search_skin = G5_SHOP_SKIN_PATH . '/search.skin.php';
if (!file_exists($search_skin)) {
    echo str_replace(G5_PATH . '/', '', $search_skin) . ' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($search_skin);
}
?>
<?php

//echo $sql."<br>";
//echo $search_skin;
include_once('./_tail.php');
?>
