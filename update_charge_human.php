<?php 
include_once('./_common.php');

$period = intval ( ( strtotime(date("Y-m-d H:i:s")) - strtotime($member['mb_datetime']) ) / 31536000 );
//echo $period . " ". date("Y-m-d", strtotime("+".$period." years", strtotime($member['mb_datetime']))) . " " .date("Y-m-d", strtotime("+".($period+1)." years", strtotime($member['mb_datetime'])));
//$cp = "287";			// config.php 파일에 정의함
//$svc = "0234331166";
//$svc = "0234331177";	// config.php 파일에 정의함

$sql="select * from g5_shop_order where od_id='".$ORDER_ID."'";
$re = sql_fetch($sql);
$tel = trim($re['od_hp']);
$pwd = substr($tel,-4);
$amt = trim($AUTH_AMOUNT);
$sec = trim($re['od_pay_time']);

if ( $re['dc_status'] != "승인완료" && $re['dc_status'] != "신규승인") {

	//$chk_telnum_addr = "http://060300.co.kr/dc-comm/chk_telnum.php";		// config.php 파일에 정의함
	//$new_user_addr = "http://060300.co.kr/dc-comm/new_user.php";			// config.php 파일에 정의함
	//$user_prepay_addr = "http://060300.co.kr/dc-comm/user_prepay.php";	// config.php 파일에 정의함

	$params = "cp=$cp&svc=$svc&tel=$tel";
	//$params = "cp=$cp&svc=$svc&tel=01055919609";
	$url = $chk_telnum_addr."?".$params;

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$ret = curl_exec($ch);
	curl_close($ch);
	//echo $ret;exit;
	$return = array();

	// 이미등록되어있는 전화번호기 때문에 바로 충전
	//echo "ret:".$ret."<br>";exit;
	if($ret == "dup"){

		$params = "cp=$cp&svc=$svc&tel=$tel&pwd=$pwd&amt=$amt&sec=$sec";
		$url2 = $user_prepay_addr."?".$params;

		$ch2 = curl_init($url2);
		curl_setopt($ch2, CURLOPT_HEADER, false);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
		$ret2 = curl_exec($ch2);
		curl_close($ch2);

		$return['code']	= $ret2;

		//echo "url:".$url."<br>";
		//echo "ret2:".$ret2."<br>";
		if($ret2=="ok"){		
			$sql_use_list = "update g5_shop_order set dc_status='승인완료', test='{$url2}' where od_id='{$ORDER_ID}'";
			sql_query($sql_use_list);
			$sql_use_list = "select ifnull(sum(od_cart_price), 0) as od_cart_price from g5_shop_order where od_hp ='".$tel."' and dc_status='승인완료' AND od_status='입금' AND od_time BETWEEN '".date("Y-m-d", strtotime("+".$period." years", strtotime($member['mb_datetime'])))."' AND '".date("Y-m-d", strtotime("+".($period+1)." years", strtotime($member['mb_datetime'])))."'";
			//echo "sql_use_list:".$sql_use_list."<br>";
			$re = sql_fetch($sql_use_list);
			if ($re["od_cart_price"] < 500000) {
				$mb_grade = "1";
				$add_sec = 0;
				$add_pa_point = 0;
                                
			} else if ($re["od_cart_price"] >= 500000 && $re["od_cart_price"] < 1000000) {
				$mb_grade = "2";
				$add_sec = 0;//15 * 60;
				$add_pa_point = 0;//900;
                                $grade_point = 10000;
                                $grade = "나그네회원";                                
			} else if ($re["od_cart_price"] >= 1000000 && $re["od_cart_price"] < 4000000) {
				$mb_grade = "3";
				$add_sec = 0;//30 * 60;
				$add_pa_point = 0;//1800;
                                $grade_point = 30000;
                                $grade = "열심회원";
			} else if ($re["od_cart_price"] >= 4000000 && $re["od_cart_price"] < 5000000) {
				$mb_grade = "4";
				$add_sec = 0;//40 * 60;
				$add_pa_point = 0;//2400;
                                $grade_point = 50000;
                                $grade = "성실회원";
			} else if ($re["od_cart_price"] >= 5000000 && $re["od_cart_price"] < 10000000) {
				$mb_grade = "5";
				$add_sec = 0;//60 * 60;
				$add_pa_point = 0;//3600;
                                $grade_point = 70000;
                                $grade = "충성회원";
			} else {
				$mb_grade = "6";
				$add_sec = 0;//120 * 60;
				$add_pa_point = 0;//7200;
                                $grade_point = 100000;
                                $grade = "신선회원";
			}
			$sql_use_list = "update g5_member set mb_grade='{$mb_grade}' where mb_id='".$member['mb_id']."'";
			sql_query($sql_use_list);
			//echo "sql_use_list:".$sql_use_list."<br>";
			$sql_chk = "SELECT COUNT(*) cnt FROM g5_shop_order WHERE od_hp ='".$tel."' AND od_settle_case='".$add_sec." 추가충전' AND od_time BETWEEN '".date("Y-m-d", strtotime("+".$period." years", strtotime($member['mb_datetime'])))."' AND '".date("Y-m-d", strtotime("+".($period+1)." years", strtotime($member['mb_datetime'])))."'";
			$isEx = sql_fetch($sql_chk);
			if ($add_sec > 0 && $isEx['cnt'] <= 0) {
                                
                            
				$params = "cp=$cp&svc=$svc&tel=$tel&pwd=$pwd&amt=0&sec=$add_sec";
				$url3 = $user_prepay_addr."?".$params;

				$ch3 = curl_init($url3);
				curl_setopt($ch3, CURLOPT_HEADER, false);
				curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
//				$ret3 = curl_exec($ch3);
				curl_close($ch3);

				/* 추가 금액 충전시  */
				$od_id = date("YmdHis")."S".str_replace("-","",$tel);
				$sql = "insert into g5_shop_order set
						od_id='{$od_id}',
						mb_id='{$member['mb_id']}',
						od_name='{$member['mb_name']}',
						od_deposit_name='{$member['mb_name']}',
						od_b_name='{$member['mb_name']}',
						od_email='{$member['mb_email']}',
						od_hp='{$tel}',
						od_b_hp='{$tel}',
						od_pay_time='{$add_sec}',
						od_pwd='{$member['mb_password']}',
						od_ip='".$_SERVER['REMOTE_ADDR']."',
						od_time=now(),
						od_misu='0',
						od_status='입금',
						od_settle_case='".$add_sec." 추가충전',
						is_free='1'
				";

//				$re = sql_query($sql);
                                insert_point($member['mb_id'], $grade_point , $grade.'승급으로 포인트부여',"@grade",$member['mb_id'], $grade.'승급으로 포인트부여');
//				insert_point($member['mb_id'], $add_pa_point, $od_id.', 추가, '.$add_sec.' 초 충전', '@charge', $member['mb_id'], $od_id.', 추가, '.$add_sec.' 초 충전');
				/* 추가 금액 충전시  */

			}
			//echo "ret3:".$ret3."<br>";
		} else if($ret2=="dif"){
			$sql_use_list = "update g5_shop_order set dc_status='실패1', test='{$url2}' where od_id='{$ORDER_ID}'";
			sql_query($sql_use_list);
		}else{
			$sql_use_list = "update g5_shop_order set dc_status='실패1-1', test='{$url2}' where od_id='{$ORDER_ID}'";
			sql_query($sql_use_list);
		}


	// 신규등록후 충전
	}else{

		$params = "cp=$cp&svc=$svc&tel=$tel&pwd=$pwd&amt=$amt&sec=$sec";
		$url2 = $new_user_addr."?".$params;

		$ch2 = curl_init($url2);
		curl_setopt($ch2, CURLOPT_HEADER, false);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
		$ret2 = curl_exec($ch2);
		curl_close($ch2);

		$return['code']	= $ret2;
		//echo "url:".$url."<br>";
		//echo "ret2:".$ret2."<br>";
		if($ret2=="ok"){
			$return['msg'] =  "신규등록과 충전을 성공 하였습니다.";
			
			$sql_use_list = "update g5_shop_order set dc_status='신규승인', test='{$url2}' where od_id='{$ORDER_ID}'";
			sql_query($sql_use_list);
			$sql_use_list = "select ifnull(sum(od_cart_price), 0) as od_cart_price from g5_shop_order where od_hp ='".$tel."' and dc_status='승인완료' AND od_status='입금' AND od_time BETWEEN '".date("Y-m-d", strtotime("+".$period." years", strtotime($member['mb_datetime'])))."' AND '".date("Y-m-d", strtotime("+".($period+1)." years", strtotime($member['mb_datetime'])))."'";
			$re = sql_fetch($sql_use_list);
			if ($re["od_cart_price"] < 500000) {
				$mb_grade = "1";
				$add_sec = 0;
				$add_pa_point = 0;
			} else if ($re["od_cart_price"] >= 500000 && $re["od_cart_price"] < 1000000) {
				$mb_grade = "2";
				$add_sec = 0;//15 * 60;
				$add_pa_point = 0;//900;
                                $grade_point = 10000;
                                $grade = "나그네회원";
			} else if ($re["od_cart_price"] >= 1000000 && $re["od_cart_price"] < 4000000) {
				$mb_grade = "3";
				$add_sec = 0;//30 * 60;
				$add_pa_point = 0;//1800;
                                $grade_point = 30000;
                                $grade = "열심회원";
			} else if ($re["od_cart_price"] >= 4000000 && $re["od_cart_price"] < 5000000) {
				$mb_grade = "4";
				$add_sec = 0;//40 * 60;
				$add_pa_point = 0;//2400;
                                $grade_point = 50000;
                                $grade = "성실회원";
			} else if ($re["od_cart_price"] >= 5000000 && $re["od_cart_price"] < 10000000) {
				$mb_grade = "5";
				$add_sec = 0;//60 * 60;
				$add_pa_point = 0;//3600;
                                $grade_point = 70000;
                                $grade = "충성회원";
			} else {
				$mb_grade = "6";
				$add_sec = 0;//120 * 60;
				$add_pa_point = 0;//7200;
                                $grade_point = 100000;
                                $grade = "신선회원";
			}
			$sql_use_list = "update g5_member set mb_grade='{$mb_grade}' where mb_id='".$member['mb_id']."'";
			sql_query($sql_use_list);
			$sql_chk = "SELECT COUNT(*) cnt FROM g5_shop_order WHERE od_hp ='".$tel."' AND od_settle_case='".$add_sec." 추가충전' AND od_time BETWEEN '".date("Y-m-d", strtotime("+".$period." years", strtotime($member['mb_datetime'])))."' AND '".date("Y-m-d", strtotime("+".($period+1)." years", strtotime($member['mb_datetime'])))."'";
			$isEx = sql_fetch($sql_chk);
			if ($add_sec > 0 && $isEx['cnt'] <= 0) {
                                
				$params = "cp=$cp&svc=$svc&tel=$tel&pwd=$pwd&amt=0&sec=$add_sec";
				$url3 = $user_prepay_addr."?".$params;

				$ch3 = curl_init($url3);
				curl_setopt($ch3, CURLOPT_HEADER, false);
				curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
//				$ret3 = curl_exec($ch3); //승급시 휴먼포인트가 아닌 포인트를 제공하기로 했으므로 주석처리
				curl_close($ch3);

				/* 추가 금액 충전시  */
				$od_id = date("YmdHis")."S".str_replace("-","",$tel);
				$sql = "insert into g5_shop_order set
						od_id='{$od_id}',
						mb_id='{$member['mb_id']}',
						od_name='{$member['mb_name']}',
						od_deposit_name='{$member['mb_name']}',
						od_b_name='{$member['mb_name']}',
						od_email='{$member['mb_email']}',
						od_hp='{$tel}',
						od_b_hp='{$tel}',
						od_pay_time='{$add_sec}',
						od_pwd='{$member['mb_password']}',
						od_ip='".$_SERVER['REMOTE_ADDR']."',
						od_time=now(),
						od_misu='0',
						od_status='입금',
						od_settle_case='".$add_sec." 추가충전',
						is_free='1'
				";

//				$re = sql_query($sql);
                                insert_point($member['mb_id'], $grade_point , $grade.'승급으로 포인트부여',"@grade",$member['mb_id'], $grade.'승급으로 포인트부여');
//				insert_point($member['mb_id'], $add_pa_point, $od_id.', 추가, '.$add_sec.' 초 충전', '@charge', $member['mb_id'], $od_id.', 추가, '.$add_sec.' 초 충전');
				/* 추가 금액 충전시  */

			}
		}else if($ret2=="dup"){
			$sql_use_list = "update g5_shop_order set dc_status='실패2', test='{$url2}' where od_id='{$ORDER_ID}'";
			sql_query($sql_use_list);
		}else{
			$sql_use_list = "update g5_shop_order set dc_status='실패2-1', test='{$url2}' where od_id='{$ORDER_ID}'";
			sql_query($sql_use_list);
		}
	}

}
//echo json_encode($return);
if ($PAY_PROCESS != "N") {
?>
<script>
	alert("충전이 완료되었습니다.");
	<?php if(is_mobile()){?>
	location.href="/";
	<?php }else{?>
	window.close();
	<?php }?>
</script>	
<?php }?>
