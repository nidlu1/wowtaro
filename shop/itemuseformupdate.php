<?php
include_once('./_common.php');

if (!$is_member) {
    alert_close("사용후기는 회원만 작성이 가능합니다.");
}

$it_id       = trim($_REQUEST['it_id']);
$is_subject  = trim($_POST['is_subject']);
$is_content  = trim($_POST['is_content']);
$is_content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $is_content);
$is_name     = trim($_POST['is_name']);
$is_password = trim($_POST['is_password']);
$is_score    = (int)$_POST['is_score'] > 5 ? 0 : (int)$_POST['is_score'];
$get_editor_img_mode = $config['cf_editor'] ? false : true;
$is_id       = (int) trim($_REQUEST['is_id']);
$is_cat = trim($_POST['is_cat']);
$is_cat2 = trim($_POST['is_cat2']);

// 사용후기 작성 설정에 따른 체크
check_itemuse_write($it_id, $member['mb_id']);

$sqlss = "SELECT * FROM ".$g5['g5_shop_category_table']." WHERE ca_use='1' AND ca_name LIKE '".$is_cat2."'";
$resss = sql_query($sqlss);
$rowss = sql_fetch_array($resss);
//echo $sqlss;print_r($rowss);exit;
if ($w == "" || $w == "u") {
    $is_name     = addslashes(strip_tags($member['mb_nick']));
    $is_password = $member['mb_password'];

    if (!$is_subject) alert("제목을 입력하여 주십시오.");
    if (!$is_content) alert("내용을 입력하여 주십시오.");
}

if($is_mobile_shop)
    $url = './item.php?it_id='.$it_id.'&ca_id='.$rowss['ca_id'].'&info=use';
else
    $url = "./item.php?it_id=".$it_id."&ca_id=".$rowss['ca_id']."&_=".get_token()."#sit_use";

if ($w == "")
{
    /*
    $sql = " select max(is_id) as max_is_id from {$g5['g5_shop_item_use_table']} ";
    $row = sql_fetch($sql);
    $max_is_id = $row['max_is_id'];

    $sql = " select max(is_id) as max_is_id from {$g5['g5_shop_item_use_table']} where it_id = '$it_id' and mb_id = '{$member['mb_id']}' ";
    $row = sql_fetch($sql);
    if ($row['max_is_id'] && $row['max_is_id'] == $max_is_id)
        alert("같은 상품에 대하여 계속해서 평가하실 수 없습니다.");
    */

    /* 포인트지급 로직 시작
     * 
     */
    $sql_common = " from g5_pointuse ";
    $point_sql = " select * $sql_common ";
    $result = sql_fetch($point_sql);
    $html_content = htmlspecialchars($is_content);
    $html_content_len = mb_strlen($html_content,'utf-8');
    $searchName = "img src=";
    
//    echo $html_content.":내용<br>";
//    echo $html_content_len.":길이<br>";
    
    switch ($html_content_len<300){
        case true:
//            echo $result['p02'].":포인트<br>";
            insert_point($member['mb_id'], $result['p02'], "상담후기 작성으로 코인 지급","","","상담후기 작성으로 코인 지급");
            break;
        case false:
//        echo $result['p03'].":포인트<br>";
            insert_point($member['mb_id'], $result['p03'], "상담후기(300자 이상) 작성으로 포인트 지급","","","상담후기(300자 이상) 작성으로 포인트 지급");
            break;
    }
    if(strpos($html_content, $searchName) == true) {
//        echo $result['p04'].":포인트1<br>";
        insert_point($member['mb_id'], $result['p04'], "상담후기(이미지 첨부) 작성으로 포인트 지급","","","상담후기(이미지 첨부) 작성으로 포인트 지급");
    }
//    포인트 지급 로직 끝
    
    $sql = "insert {$g5['g5_shop_item_use_table']}
               set it_id = '$it_id',
                   mb_id = '{$member['mb_id']}',
                   is_score = '$is_score',
                   is_name = '$is_name',
                   is_password = '$is_password',
                   is_subject = '$is_subject',
                   is_content = '$is_content',
                   is_time = '".G5_TIME_YMDHIS."',
				   is_cat = '$is_cat',
				   is_cat2 = '$is_cat2',
                   is_ip = '{$_SERVER['REMOTE_ADDR']}' ";
    if (!$default['de_item_use_use'])
        $sql .= ", is_confirm = '1' ";
    sql_query($sql);

    if ($default['de_item_use_use']) {
        $alert_msg = "평가하신 글은 관리자가 확인한 후에 출력됩니다.";
    }  else {
        $alert_msg = "사용후기가 등록 되었습니다.";
    }
}
else if ($w == "u")
{
    $sql = " select is_password from {$g5['g5_shop_item_use_table']} where is_id = '$is_id' ";

    $row = sql_fetch($sql);
    if ($row['is_password'] != $is_password)
        alert("비밀번호가 틀리므로 수정하실 수 없습니다.");

    $sql = " update {$g5['g5_shop_item_use_table']}
                set is_subject = '$is_subject',
                    is_content = '$is_content',
					is_cat = '$is_cat',
					is_cat2 = '$is_cat2',
                    is_score = '$is_score'
              where is_id = '$is_id' ";
    sql_query($sql);

    $alert_msg = "사용후기가 수정 되었습니다.";
}
else if ($w == "d")
{
    if (!$is_admin)
    {
        $sql = " select count(*) as cnt from {$g5['g5_shop_item_use_table']} where mb_id = '{$member['mb_id']}' and is_id = '$is_id' ";
        $row = sql_fetch($sql);
        if (!$row['cnt'])
            alert("자신의 사용후기만 삭제하실 수 있습니다.");
    }

    // 에디터로 첨부된 이미지 삭제
    $sql = " select is_content from {$g5['g5_shop_item_use_table']} where is_id = '$is_id' and md5(concat(is_id,is_time,is_ip)) = '{$hash}' ";
    $row = sql_fetch($sql);

    $imgs = get_editor_image($row['is_content'], $get_editor_img_mode);

    for($i=0;$i<count($imgs[1]);$i++) {
        $p = parse_url($imgs[1][$i]);
        if(strpos($p['path'], "/data/") != 0)
            $data_path = preg_replace("/^\/.*\/data/", "/data", $p['path']);
        else
            $data_path = $p['path'];


        if( preg_match('/(gif|jpe?g|bmp|png)$/i', strtolower(end(explode('.', $data_path))) ) ){

            $destfile = ( ! preg_match('/\w+\/\.\.\//', $data_path) ) ? G5_PATH.$data_path : '';

            if($destfile && preg_match('/\/data\/editor\/[A-Za-z0-9_]{1,20}\//', $destfile) && is_file($destfile))
                @unlink($destfile);
        }
    }

    $sql = " delete from {$g5['g5_shop_item_use_table']} where is_id = '$is_id' and md5(concat(is_id,is_time,is_ip)) = '{$hash}' ";
    sql_query($sql);

    
    /* 포인트삭제 로직 시작
     * 
     */
    $sql_common = " from g5_pointuse ";
    $point_sql = " select * $sql_common ";
    $result = sql_fetch($point_sql);
    $html_content = htmlspecialchars($row['is_content']);
    $html_content_len = mb_strlen($html_content,'utf-8');
    $searchName = "img src=";
    
//    echo $html_content.":내용<br>";
//    echo $html_content_len.":길이<br>";
    
    switch ($html_content_len<300){
        case true:
//            echo $result['p02'].":포인트<br>";
            insert_point($member['mb_id'], $result['p02']*(-1), "상담후기 삭제로 코인 반환");
            break;
        case false:
//        echo $result['p03'].":포인트<br>";
            insert_point($member['mb_id'], $result['p03']*(-1), "상담후기(300자 이상) 삭제로 코인 반환");
            break;
    }
    if(strpos($html_content, $searchName) == true) {
//        echo $result['p04'].":포인트<br>";
        insert_point($member['mb_id'], $result['p04']*(-1), "상담후기(이미지 첨부) 삭제로 코인 반환");
    }
//    포인트 지급 로직 끝
    
    $alert_msg = "사용후기를 삭제 하였습니다.";
}

$cnt_arr = sql_fetch("select count(*) as cnt, AVG(is_score) AS score from {$g5['g5_shop_item_use_table']} where it_id = '$it_id'");
sql_query("UPDATE ".$g5['member_table']." SET mb_review='".$cnt_arr['cnt']."',mb_star='".$cnt_arr['score']."' WHERE mb_no='".$it_id."'");

//쇼핑몰 설정에서 사용후기가 즉시 출력일 경우
if( ! $default['de_item_use_use'] ){
    update_use_cnt($it_id);
    update_use_avg($it_id);
}

if($w == 'd')
    alert($alert_msg, $url);
else
    alert_opener($alert_msg, $url);
?>