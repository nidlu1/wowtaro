<?php 
ini_set('display_errors', 1); // set to 0 for production version
error_reporting(E_ALL);

$wow_con = mysql_connect("127.0.0.1","fortune","fortune!@34");
mysql_select_db("wow_backup",$wow_con);
print_r($wow_con);

$sql = "SELECT * FROM g5_member WHERE mb_level='2' AND mb_id<>'' AND mb_no>=2290 ORDER BY mb_no";
$res = mysql_query($sql, $wow_con);
$data = NULL;
while ( $row = mysql_fetch_array($res) ) {
	$data[] = $row;
}
mysql_close($wow_con);

$con = mysql_connect("127.0.0.1","fortune","fortune!@34");
mysql_select_db("wow",$con);
print_r($con);

for ( $i = 0; $i < count($data); $i++ ) {
	$row = $data[$i];
	//echo $row['mb_id']."<br>";

	$qry = "INSERT INTO g5_member (
mb_id,
mb_password,
mb_name,
mb_nick,
mb_nick_date,
mb_email,
mb_homepage,
mb_level,
mb_grade,
mb_sex,
mb_birth,
mb_tel,
mb_hp,
mb_certify,
mb_adult,
mb_dupinfo,
mb_zip1,
mb_zip2,
mb_addr1,
mb_addr2,
mb_addr3,
mb_addr_jibeon,
mb_signature,
mb_recommend,
mb_point,
mb_today_login,
mb_login_ip,
mb_datetime,
mb_ip,
mb_leave_date,
mb_intercept_date,
mb_email_certify,
mb_email_certify2,
mb_memo,
mb_lost_certify,
mb_mailling,
mb_sms,
mb_open,
mb_open_date,
mb_profile,
mb_memo_call,
mb_1,
mb_2,
mb_3,
mb_4,
mb_5,
mb_6,
mb_7,
mb_8,
mb_9,
mb_10
	) VALUES (
'".$row['mb_id']."',
'".$row['mb_password']."',
'".$row['mb_name']."',
'".$row['mb_nick']."',
'".$row['mb_nick_date']."',
'".$row['mb_email']."',
'".$row['mb_homepage']."',
'".$row['mb_level']."',
'".$row['mb_grade']."',
'".$row['mb_sex']."',
'".$row['mb_birth']."',
'".$row['mb_tel']."',
'".$row['mb_hp']."',
'".$row['mb_certify']."',
'".$row['mb_adult']."',
'".$row['mb_dupinfo']."',
'".$row['mb_zip1']."',
'".$row['mb_zip2']."',
'".$row['mb_addr1']."',
'".$row['mb_addr2']."',
'".$row['mb_addr3']."',
'".$row['mb_addr_jibeon']."',
'".$row['mb_signature']."',
'".$row['mb_recommend']."',
'".$row['mb_point']."',
'".$row['mb_today_login']."',
'".$row['mb_login_ip']."',
'".$row['mb_datetime']."',
'".$row['mb_ip']."',
'".$row['mb_leave_date']."',
'".$row['mb_intercept_date']."',
'".$row['mb_email_certify']."',
'".$row['mb_email_certify2']."',
'".$row['mb_memo']."',
'".$row['mb_lost_certify']."',
'".$row['mb_mailling']."',
'".$row['mb_sms']."',
'".$row['mb_open']."',
'".$row['mb_open_date']."',
'".$row['mb_profile']."',
'".$row['mb_memo_call']."',
'".$row['mb_1']."',
'".$row['mb_2']."',
'".$row['mb_3']."',
'".$row['mb_4']."',
'".$row['mb_5']."',
'".$row['mb_6']."',
'".$row['mb_7']."',
'".$row['mb_8']."',
'".$row['mb_9']."',
'".$row['mb_10']."'
	)";

	mysql_query($qry,$con);
	//echo $qry; exit;
}
mysql_close($con);
?>