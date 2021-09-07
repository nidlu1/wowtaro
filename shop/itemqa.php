<?php
include_once('./_common.php');

if( !isset($it) && !get_session("ss_tv_idx") ){
    if( !headers_sent() ){  //헤더를 보내기 전이면 검색엔진에서 제외합니다.
        echo '<meta name="robots" content="noindex, nofollow">';
    }
    /*
    if( !G5_IS_MOBILE ){    //PC 에서는 검색엔진 화면에 노출하지 않도록 수정
        return;
    }
    */
}

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/itemqa.php');
    return;
}

include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// 현재페이지, 총페이지수, 한페이지에 보여줄 행, URL
function itemqa_page($write_pages, $cur_page, $total_page, $url, $add="")
{
    //$url = preg_replace('#&amp;page=[0-9]*(&amp;page=)$#', '$1', $url);
    $url = preg_replace('#&amp;page=[0-9]*#', '', $url) . '&amp;page=';

    $str = '';
    if ($cur_page > 1) {
        $str .= '<a href="'.$url.'1'.$add.'" class="pager_func first"><i class="xi-angle-left-min"></i><i class="xi-angle-left-min"></i></a>'.PHP_EOL;
    }

    $start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
    $end_page = $start_page + $write_pages - 1;

    if ($end_page >= $total_page) $end_page = $total_page;

    if ($start_page > 1) $str .= '<a href="'.$url.($start_page-1).$add.'" class="pager_func prev"><i class="xi-angle-left-min"></i></a>'.PHP_EOL;

    if ($total_page > 1) {
        for ($k=$start_page;$k<=$end_page;$k++) {
            if ($cur_page != $k)
                $str .= '<a href="'.$url.$k.$add.'">'.$k.'</a>'.PHP_EOL;
            else
                $str .= '<a href="'.$url.$k.$add.'" class="on">'.$k.'</a>'.PHP_EOL;
        }
    }

    if ($total_page > $end_page) $str .= '<a href="'.$url.($end_page+1).$add.'" class="pager_func next"><i class="xi-angle-right-min"></i></a>'.PHP_EOL;

    if ($cur_page < $total_page) {
        $str .= '<a href="'.$url.$total_page.$add.'" class="pager_func last"><i class="xi-angle-right-min"></i><i class="xi-angle-right-min"></i></a>'.PHP_EOL;
    }

    if ($str)
        return "<div class=\"pager\">{$str}</div>";
    else
        return "";
}

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

$itemqa_skin = G5_SHOP_SKIN_PATH.'/itemqa.skin.php';

if(!file_exists($itemqa_skin)) {
    echo str_replace(G5_PATH.'/', '', $itemqa_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($itemqa_skin);
}
?>