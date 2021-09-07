<?php
include_once('./_common.php');

if (!$is_member) {
    alert_close("사용후기는 회원만 작성이 가능합니다.");
}

$it_id       = trim($_REQUEST['it_id']);
$is_reply_subject  = trim($_POST['is_reply_subject']);
$is_reply_content  = trim($_POST['is_reply_content']);
$is_reply_content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $is_reply_content);
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

    if (!$is_reply_subject) alert("제목을 입력하여 주십시오.");
    if (!$is_reply_content) alert("내용을 입력하여 주십시오.");
}

if($is_mobile_shop)
    $url = './item.php?it_id='.$it_id.'&ca_id='.$rowss['ca_id'].'&info=use';
else
    $url = "./item.php?it_id=".$it_id."&ca_id=".$rowss['ca_id']."&_=".get_token()."#sit_use";

if ($w == "")
{

}
else if ($w == "u")
{
    $sql = " select it_id from {$g5['g5_shop_item_use_table']} where is_id = '$is_id' ";
    $row = sql_fetch($sql);
//echo $row['it_id']." != ".$member['mb_no'];exit;
    if ($row['it_id'] != $member['mb_no'])
        alert("본인의 상담후기가 아니므로 수정하실 수 없습니다.");

    $sql = " update {$g5['g5_shop_item_use_table']}
                set is_reply_subject = '$is_reply_subject',
                    is_reply_content = '$is_reply_content',
					is_reply_name = '".$member['mb_nick']."'
              where is_id = '$is_id' ";
    sql_query($sql);

    $alert_msg = "사용후기의 답변이 등록되었습니다.";
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

    $alert_msg = "사용후기를 삭제 하였습니다.";
}

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