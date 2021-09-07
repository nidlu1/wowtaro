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
    if(preg_match("/[^a-z0-9_]/i", $pa_no)) alert("ID 는 영문자, 숫자, _ 만 가능합니다.");

    $sql = " select * from {$g5['pay_table']} where pa_no = '$pa_no' ";
    $co_row = sql_fetch($sql);
}

//$pa_no = preg_replace('/[^a-z0-9_]/i', '', $pa_no);
$pa_amt = str_replace(",","",trim($pa_amt));
$pa_time = str_replace(",","",trim($pa_time)) * 60;
$pa_point = str_replace(",","",trim($pa_point));

$error_msg = '';

//20210129 결제상품 문구
$pa_mungu = $_REQUEST['pa_mungu'];

$sql_common = " pa_amt          = '$pa_amt' 
                ,pa_time        = '$pa_time'
                ,pa_point       = '$pa_point'
                ,pa_use         = '$pa_use'
                ,pa_mungu       = '$pa_mungu'
                                    
			";

if ($w == "")
{

    $sql = " insert {$g5['pay_table']}
                set pa_date = now() ,
                    $sql_common ";
    sql_query($sql);
	$pa_no = sql_insert_id();
}
else if ($w == "u")
{
    $sql = " update {$g5['pay_table']}
                set $sql_common
              where pa_no = '$pa_no' ";
    sql_query($sql);
}
else if ($w == "d")
{

    $sql = " delete from {$g5['pay_table']} where pa_no = '$pa_no' ";
    sql_query($sql);
}

if ($w == "" || $w == "u")
{
    if( $error_msg ){
        alert($error_msg, "./payform.php?w=u&amp;pa_no=$pa_no");
    } else {
        goto_url("./payform.php?w=u&amp;pa_no=$pa_no");
    }
}
else
{
    goto_url("./paylist.php");
}
?>
