<?php
include_once('./_common.php');
include_once(G5_PATH.'/sms_send_register.php');


$od_id = date("YmdHis")."S".str_replace("-","",$member['mb_hp']);
$today=mktime(); 
$today_time = date('YmdHis', $today);

//parameter
$serviceId = "M1714254" ;   //테스트서버 : glx_api
$orderDate = $today_time ; //(YYYYMMDDHHMMSS)
$orderId = $od_id ;  
$userId = $member['mb_id'] ; 
$itemCode = $config['cf_1']."분무료";
$amount = 0;
$sec = $config['cf_1']*60;
$od_dc_pwd = substr($member['mb_hp'],-4) ;
$aa = str_replace("-","",$member['mb_hp']);
$mb_ip = $member['mb_ip'] ;


if(strpos($hp,"-")!==false){
$hp = str_replace("-","",$member['mb_hp']);
}





 
$sql = "select count(*) as cnt from ".$g5['g5_shop_order_table']." where is_free=1 and od_hp = '{$hp}";
$re = sql_fetch($sql);
if($re['cnt']>0){
	alert("이벤트는 한번만 참여가 가능합니다.", G5_URL."/free_counsel.php");
	exit;
}
//$sql = "select count(*)as cnt from ".$g5['g5_shop_order_table']." where is_free=1 and od_ip ='{$mb_ip}'";
//$re = sql_fetch($sql);
//if($re['cnt']>0){
//	alert("이벤트는 한번만 참여가 가능합니다.", G5_URL."/free_counsel.php");
//	exit;
//}

$sql = "select count(*)as cnt from ".$g5['g5_shop_order_table']." where is_free=1 and od_time BETWEEN '".date("Y-m-d")." 00:00:00' AND '".date("Y-m-d")." 23:59:59' ";
$re = sql_fetch($sql);
if($re['cnt']>30){
	alert("오늘의 이벤트 신청이 모두 마감되었습니다\n내일 다시 신청해주세요\n감사합니다.", G5_URL."/free_counsel.php");
	exit;
}

/* 한승희
 * 2020-11-10 기능추가: 5분 무료 상담시, 해당 선생님의 상담후기에 '이벤트상담' 카테고리로 응원메세지를 등록하는 기능.
 */
    $smb_id = explode("/", trim($_REQUEST['smb_id']));
    $it_id = $smb_id[0];
    $mb_id = trim($_REQUEST['mb_id']);
    $is_score = '5';
    $is_name = trim($_REQUEST['mb_name']);
    $is_password = "1";
    $is_subject = trim($_REQUEST['smb_mungu']);
    $is_content = $_REQUEST['smb_mungu'];
    $is_cat = "이벤트상담";
    
    switch ($smb_id[1]){
        case 10:
            $is_cat2 = "타로";
            break;
        case 20:
            $is_cat2 = "신점";
            break;
        case 30:
            $is_cat2 = "사주";
            break;
        case 40:
            $is_cat2 = "펫타로";
            break;
        case 50:
            $is_cat2 = "꿈해몽";
            break;
    }
    $sql = "insert {$g5['g5_shop_item_use_table']}
               set it_id = '$it_id',
                   mb_id = '$mb_id',
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
//2020-11-10 기능추가: 5분 무료 상담시, 해당 선생님의 상담후기에 '이벤트상담' 카테고리로 응원메세지를 등록하는 기능 끝

    
    

$sql = "insert into g5_shop_order set
		od_id='{$od_id}',
		mb_id='{$member['mb_id']}',
		od_name='{$member['mb_name']}',
		od_deposit_name='{$member['mb_name']}',
		od_b_name='{$member['mb_name']}',
		od_email='{$member['mb_email']}',
		od_hp='{$hp}',
		od_b_hp='{$hp}',
		od_pay_time='{$sec}',
		od_pwd='{$member['mb_password']}',
		od_ip='".$_SERVER['REMOTE_ADDR']."',
		od_time=now(),
		od_misu='{$amount}',
		od_status='입금',
		od_settle_case='{$itemCode}',
		is_free='1'
";

$re = sql_query($sql);
$ORDER_ID = $od_id;
if($re<=0){
?>
<script>
	alert("주문번호 중복입니다. 처음부터 결제해 주세요");
	opener.location.reload();
</script>
<?php
}

$time = time();
//include_once $_SERVER['DOCUMENT_ROOT']."/pay/update_free_charge_human.php";

$tel = trim(str_replace("-","",$member['mb_hp']));
$pwd = $od_dc_pwd;
$amt = trim($amount);


$params = "cp=$cp&svc=$svc&tel=$tel";
//$params = "cp=$cp&svc=$svc&tel=01055919609";
$url = $chk_telnum_addr."?".$params;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//$ret = curl_exec($ch);
curl_close($ch);

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
	} else if($ret2=="dif"){
		$sql_use_list = "update g5_shop_order set dc_status='실패1', test='{$url2}' where od_id='{$ORDER_ID}'";
		sql_query($sql_use_list);
	}else{
		$sql_use_list = "update g5_shop_order set dc_status='실패1-1', test='{$url2}' where od_id='{$ORDER_ID}'";
		sql_query($sql_use_list);
	}
        
    //관리자에게 안내문자 발송
//    sms_send_register("", $member['mb_name']."님께서".$config['cf_1']."분 무료 신청을 했습니다.");

// 신규등록후 충전
}else{

	$params = "cp=$cp&svc=$svc&tel=$tel&pwd=$pwd&amt=$amt&sec=$sec";
	$url2 = $new_user_addr."?".$params;

	$ch2 = curl_init($url2);
	curl_setopt($ch2, CURLOPT_HEADER, false);
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
//	$ret2 = curl_exec($ch2);
	curl_close($ch2);

	$return['code']	= $ret2;
	//echo "url:".$url."<br>";
	//echo "ret2:".$ret2."<br>";
	if($ret2=="ok"){
		$return['msg'] =  "신규등록과 충전을 성공 하였습니다.";
		
		$sql_use_list = "update g5_shop_order set dc_status='신규승인', test='{$url2}' where od_id='{$ORDER_ID}'";
		sql_query($sql_use_list);
	}else if($ret2=="dup"){
		$sql_use_list = "update g5_shop_order set dc_status='실패2', test='{$url2}' where od_id='{$ORDER_ID}'";
		sql_query($sql_use_list);
	}else{
		$sql_use_list = "update g5_shop_order set dc_status='실패2-1', test='{$url2}' where od_id='{$ORDER_ID}'";
		sql_query($sql_use_list);
	}
}

//신청시 IP가 기록되어있다면 관리자에게 알려줌
$remote_ip = $_SERVER["REMOTE_ADDR"];
$sql_ip = "select count(*) as cnt from g5_member where mb_ip = '$remote_ip'";
$re_ip = sql_fetch($sql_ip);
if($re_ip['cnt']>0){
//    sms_send_register($hp, "$userId 님께서 중복된 아이피로 5분 무료를 신청했습니다.\nIP주소: $remote_ip");
}

alert("신청되었습니다.", "./free_counsel.php");
exit;
?>