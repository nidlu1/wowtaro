<?php
include_once('./_common.php');

//$qry = "SELECT * FROM ".$g5['member_table']
//        ." WHERE mb_level='3' AND mb_free5='1' ORDER BY mb_nick ASC"; 
//$qres = sql_query($qry);
//echo 'member_table<br>';
//while ( $qrow = mysqli_fetch_array($qres) ) {
//    echo $qrow[0]." | ".$qrow[1]." | ".$qrow[2]." | ".$qrow[3]." | ".$qrow[4]." | ".$qrow[5]." | ".$qrow[6]." | ".$qrow[7]." | ".$qrow[8]." | ".$qrow[9]." | ".$qrow[10]." | ".$qrow[11]." | ".$qrow[12]." | ".$qrow[13]." | ".$qrow[14]." | ".$qrow[15]." | ".$qrow[16]." | ".$qrow[17]." | ".$qrow[18]." | ".$qrow[19]." | ".$qrow[20]."<br><br>";
//    echo $qrow['mb_id']." | ".$qrow['mb_name']." | ".$qrow['mb_hp']." | ".$qrow['mb_email']." | ".$qrow['mb_mailling']." | ".$qrow['mb_sms']." | ".$qrow['mb_level']." | ".$qrow['mb_nick']." | ".$qrow['mb_free5']." | ".$qrow['mb_use']."<br><br><hr>";
//}
//echo '-----------------------------------------------------------------<br>';


//$qry = "SELECT * FROM ".$g5['g5_shop_order_table']."";
//$qres = sql_query($qry);
//echo 'g5_shop_order_table<br>';
//while ( $qrow = mysqli_fetch_array($qres) ) {
//    echo $qrow[0]." | ".$qrow[1]." | ".$qrow[2]." | ".$qrow[3]." | ".$qrow[4]." | ".$qrow[5]." | ".$qrow[6]." | ".$qrow[7]." | ".$qrow[8]."<br><br>";
//    echo $qrow['od_id']." | ".$qrow['mb_id']." | ".$qrow['od_name']." | ".$qrow['od_tel']." | ".$qrow['od_hp']." | ".$qrow['od_b_name']." | ".$qrow['od_b_tel']." | ".$qrow['od_b_hp']." | ".$qrow['od_deposit_name']."<br><br><hr>";
//}
//echo '-----------------------------------------------------------------<br>';





$qry = "SELECT * FROM ".$g5['g5_shop_item_use_table']."";
$qres = sql_query($qry);
echo 'g5_shop_item_use_table<br>';
while ( $qrow = mysqli_fetch_array($qres) ) {
//    echo $qrow[0]." | ".$qrow[1]." | ".$qrow[2]." | ".$qrow[3]." | ".$qrow[4]." | ".$qrow[5]." | ".$qrow[6]." | ".$qrow[7]." | ".$qrow[8]." | ".$qrow[9]." | ".$qrow[10]." | ".$qrow[11]." | ".$qrow[12]." | ".$qrow[13]." | ".$qrow[14]." | ".$qrow[15]." | ".$qrow[16]."<br><br>";
    echo $qrow['it_id']." | ".$qrow['mb_id']." | ".$qrow['is_score']." | ".$qrow['is_name']." | ".$qrow['is_password']." | ".$qrow['is_subject']." | ".$qrow['is_content']." | ".$qrow['is_time']." | ".$qrow['is_cat']." | ".$qrow['is_cat2']." | ".$qrow['is_ip']." | ".$qrow['de_item_use_use']." | ".$qrow['is_confirm']."<br><br><hr>";
}
echo '-----------------------------------------------------------------<br>';

//$qry = "SELECT * FROM ".$g5['g5_shop_category_table']."";
//$qres = sql_query($qry);
//echo 'g5_shop_category_table<br>';
//while ( $qrow = mysqli_fetch_array($qres) ) {
//    echo $qrow[0]." | ".$qrow[1]." | ".$qrow[2]." | ".$qrow[3]." | ".$qrow[4]." | ".$qrow[5]." | ".$qrow[6]." | ".$qrow[7]." | ".$qrow[8]." | ".$qrow[9]." | ".$qrow[10]." | ".$qrow[11]." | ".$qrow[12]." | ".$qrow[13]." | ".$qrow[14]." | ".$qrow[15]." | ".$qrow[16]."<br><br>";
////    echo $qrow['ca_id']." | ".$qrow['ca_name']." | ".$qrow['ca_order']." | ".$qrow['is_name']." | ".$qrow['is_password']." | ".$qrow['is_subject']." | ".$qrow['is_content']." | ".$qrow['is_time']." | ".$qrow['is_cat']." | ".$qrow['is_cat2']." | ".$qrow['is_ip']." | ".$qrow['de_item_use_use']." | ".$qrow['is_confirm']."<br><br><hr>";
//}
//echo '-----------------------------------------------------------------<br>';
//

//$qry = "SELECT * FROM ".$g5['member_table']." WHERE mb_id = '613 ' ";
//$qres = sql_query($qry);
//echo 'g5_shop_category_table<br>';
//while ( $qrow = mysqli_fetch_array($qres) ) {
//    echo $qrow['mb_use']." | ".$qrow[1]." | ".$qrow[2]." | ".$qrow[3]." | ".$qrow[4]." | ".$qrow[5]." | ".$qrow[6]." | ".$qrow[7]." | ".$qrow[8]." | ".$qrow[9]." | ".$qrow[10]." | ".$qrow[11]." | ".$qrow[12]." | ".$qrow[13]." | ".$qrow[14]." | ".$qrow[15]." | ".$qrow[16]."<br><br>";
//}
//echo '-----------------------------------------------------------------<br>';




?>

