<?php
include_once('./_common.php');
$cp = "287";
$svc = "0234331177";

?>
<?php
//남은시간 확인하기

$ch = curl_init($user_remaining_secs_addr."?cp=".$cp."&svc=".$svc."&tel=01054676757&pwd=6757");
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 1);
$ret = curl_exec($ch);
curl_close($ch);
echo "사용자: $ch <br>";
echo "남은시간(초): $ret <br><br>";

?>

<?php
//등록된 사용자인지 확인하기      
$ch1 = curl_init($chk_telnum_addr."?cp=".$cp."&svc=".$svc."&tel=01054676757&pwd=6757");
curl_setopt($ch1, CURLOPT_HEADER, false);
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
$ret1 = curl_exec($ch1);
curl_close($ch1);
echo "사용자: $ch1<br>";
echo "사용자임:dup, 사용자아님:ok  ->  $ret1 <br><Br>";
?>

<?php
//충전하기
$tel='01054676757';
$pwd='6757';
$amt=100;
$sec=30;
		$params = "cp=$cp&svc=$svc&tel=$tel&pwd=$pwd&amt=$amt&sec=$sec";
		$url2 = $user_prepay_addr."?".$params;

		$ch2 = curl_init($url2);
		curl_setopt($ch2, CURLOPT_HEADER, false);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
//		$ret2 = curl_exec($ch2);
		curl_close($ch2);
    
    echo "사용자: $ch2<br>";
    echo "충전결과:  $ret2 <br>";
?>

<?php
//상담사 상태값
	$url = $counsel_stat_chk."?cp_code=".$cp;

	$ch3 = curl_init($url);
	curl_setopt($ch3, CURLOPT_HEADER, false);
	curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
	$ret3 = curl_exec($ch3);
	curl_close($ch3);
        
            
    echo "사용자: $ch3<br>";
    echo "결과값:  $ret3 <br>";// String 형태값
    echo "변수타입: ". gettype($ret3)."<br>";// 
/*
[상태값]

- 000: 상담불가(0) 상태이고, 상담중이 아니고(0), 현재 상담시간이 아님(0)
- 001: 상담불가(0) 상태이고, 상담중이 아니고(0), 현재 상담시간임(1)
- 010: 상담불가(0) 상태이고, 상담중이고(1), 현재 상담시간이 아님(0)
- 011: 상담불가(0) 상태이고, 상담중이고(1), 현재 상담시간임(1)
- 100: 상담가능(1) 상태이고, 상담중이 아니고(0), 현재 상담시간이 아님(0)
- 101: 상담가능(1) 상태이고, 상담중이 아니고(0), 현재 상담시간임(1)
- 110: 상담가능(1) 상태이고, 상담중이고(1), 현재 상담시간이 아님(0)
- 111: 상담가능(1) 상태이고, 상담중이고(1), 현재 상담시간임(1)

[상태값 해석]

- 상담중(통화중): 010, 011, 110, 111
- 상담불가(부재중): 000, 001
- 상담시간 아님: 100
- 상담가능(대기중): 101
*/
?>

<?php
//string json으로 파싱
include_once(G5_LIB_PATH.'/json.lib.php');
$ret4 = json_decode($ret3, true);
echo "변수타입: ". gettype($ret4)."<br>";// 
echo "json값: ". $ret4['001']."<br>";// 

	$data = array();
	$arr = json_decode($ret3, true);
	foreach ($arr as $key => $val) {
		if ( $val == '010' || $val == '011' || $val == '110' || $val == '111' ) {
			$data[$key] = '1';     //상담중(통화중)
		} else if ( $val == '000' || $val == '001' ) {
			$data[$key] = '3';   //상담불가(부재중)
		} else if ( $val == '100' || $val == '101' ) {
			$data[$key] = '2'; //상담시간 아님
		} else {
			$data[$key] = '2';    //상담가능(대기중)
		}
        }
        echo "". $data['001']."<br>";// 
?>