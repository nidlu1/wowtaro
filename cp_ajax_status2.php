<?php

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
- 상담불가(예약대기): 000, 001
- 상담시간 아님: 100
- 상담가능(대기중): 101

*/
//print_r($_GET);exit;

if (!isset($_GET['cp_code'])) die();

$cp_code = $_GET['cp_code'];
$ch = curl_init("http://060300.co.kr/dc-stat/cp_stat2.php?cp_code=$cp_code");
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$ret = curl_exec($ch);
curl_close($ch);
echo "ret = ".$ret;
if (!$ret or ($ret == 'none') or ($ret == 'error')) die();

$data = array();
$arr = json_decode($ret, true);
foreach ($arr as $key => $val) {
    if (substr($val, 1, 1) == '1') {
        $data[$key] = 'busy';     //상담중(통화중)
    } elseif (substr($val, 0, 1) == '0') {
        $data[$key] = 'absent';   //상담불가(예약대기)
    } elseif (substr($val, 2, 1) == '0') {
        $data[$key] = 'off_hour'; //상담시간 아님
    } else {
        $data[$key] = 'ready';    //상담가능(대기중)
    }
}

echo "data = ".json_encode($data);

/*

위에서 각 데이터 값은 다음과 같이 변환됩니다.

1) $ret --> {"001":"101","002":"100"}
2) $arr --> ["001"=>"101","002"=>"100"]
3) $data --> ["001"=>"ready","002"=>"off_hour"]
4) json_encode($data) --> {"001":"ready","002":"off_hour"}

*/
?>