<?php
$sub_menu = '100400';
include_once('./_common.php');

if ($w == "u" || $w == "d")
    check_demo();

if ($w == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");

check_admin_token();

if ($w == "" || $w == "u")
{
    if(preg_match("/[^a-z0-9_]/i", $ht_no)) alert("ID 는 영문자, 숫자, _ 만 가능합니다.");

    $sql = " select * from {$g5['hashtag_table']} where ht_no = '$ht_no' ";
    $co_row = sql_fetch($sql);
}

//$ht_no = preg_replace('/[^a-z0-9_]/i', '', $ht_no);
$ht_name = strip_tags($ht_name);

$error_msg = '';

$sql_common = " ht_name          = '$ht_name' ";

if ($w == "")
{

    $sql = " insert {$g5['hashtag_table']}
                set ht_date = now() ,
                    $sql_common ";
    sql_query($sql);
	$ht_no = sql_insert_id();
}
else if ($w == "u")
{
    $sql = " update {$g5['hashtag_table']}
                set $sql_common
              where ht_no = '$ht_no' ";
    sql_query($sql);
}
else if ($w == "d")
{

    $sql = " delete from {$g5['hashtag_table']} where ht_no = '$ht_no' ";
    sql_query($sql);
}

if ($w == "" || $w == "u")
{
    if( $error_msg ){
        alert($error_msg, "./hashtagform.php?w=u&amp;ht_no=$ht_no");
    } else {
        goto_url("./hashtagform.php?w=u&amp;ht_no=$ht_no");
    }
}
else
{
    goto_url("./hashtaglist.php");
}
?>
