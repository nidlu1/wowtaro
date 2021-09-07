<?php
    include_once('./_common.php');
    $mb_recommend='nidlu1@naver.com';

    //{member_table에 있는 추천인의 정보를 변수에 저장하는 코드}
    $recommend_info = sql_fetch(" select * from {$g5['member_table']} where mb_id = '$mb_recommend' ");
    $recommend_od_id = date("YmdHis");
    $recommend_mb_id = $recommend_info['mb_id'];
    $recommend_od_name = $recommend_info['mb_name'];
    $recommend_od_deposit_name = $recommend_info['mb_name'];
    $recommend_od_b_name = $recommend_info['mb_name'];
    $recommend_od_email = $recommend_info['mb_email'];
    $recommend_od_hp = str_replace("-","",$recommend_info['mb_hp']);
    $recommend_od_b_hp = str_replace("-","",$recommend_info['mb_hp']);
    $recommend_od_pay_time = 300;
    $recommend_od_pwd = $recommend_info['mb_password'];
    $recommend_od_ip = $_SERVER['REMOTE_ADDR'];
    $recommend_od_time = date("Y-m-d H:i:s");
    $recommend_od_misu = 0;
    $recommend_od_status = '테스트';
    $recommend_od_settle_case = '추천인5분';

echo '$recommend_info:'.$recommend_od_id.'<br>'.
        '$recommend_mb_id:'.$recommend_mb_id.'<br>'.
        '$recommend_od_id:'.$recommend_od_id.'<br>'.
        '$recommend_od_name:'.$recommend_od_name.'<br>'.
        '$recommend_od_deposit_name:'.$recommend_od_deposit_name.'<br>'.
        '$recommend_od_b_name:'.$recommend_od_b_name.'<br>'.
        '$recommend_od_email:'.$recommend_od_email.'<br>'.
        '$recommend_od_hp:'.$recommend_od_hp.'<br>'.
        '$recommend_od_b_hp:'.$recommend_od_b_hp.'<br>'.
        '$recommend_od_pay_time:'.$recommend_od_pay_time.'<br>'.
        '$recommend_od_pwd:'.$recommend_od_pwd.'<br>'.
        '$recommend_od_ip:'.$recommend_od_ip.'<br>'.
        '$recommend_od_time:'.$recommend_od_time.'<br>'.
        '$recommend_od_misu:'.$recommend_od_misu.'<br>';
        '$recommend_od_status:'.$recommend_od_status.'<br>';
        '$recommend_od_settle_case:'.$recommend_od_settle_case.'<br>';

//{member_table에 있는 추천인의 정보를 변수에 저장하는 코드} 
        $sql = "insert into g5_shop_order set
            od_id='{$recommend_od_id}',
            mb_id='{$recommend_mb_id}',
            od_name='{$recommend_od_name}',
            od_deposit_name='{$recommend_od_deposit_name}',
            od_b_name='{$recommend_od_b_name}',
            od_email='{$recommend_od_email}',
            od_hp='{$recommend_od_hp}',
            od_b_hp='{$recommend_od_b_hp}',
            od_pay_time='{$recommend_od_pay_time}',
            od_pwd='{$recommend_od_pwd}',
            od_ip='{$recommend_od_ip}',
            od_time='{$recommend_od_time}',
            od_misu='{$recommend_od_misu}',
            od_status='{$recommend_od_status}',
            od_settle_case='{$recommend_od_settle_case}',
            od_memo='',
            od_shop_memo='',
            od_mod_history='',
            od_cash=0,
            od_cash_no='',
            od_cash_info=''
            ";
        echo $sql.'<br>';
        sql_query($sql);
                    
//{060 실행하는데 필요한 데이터를 변수에 답는 코드.}                    
        $tel = $recommend_od_hp;
        $pwd = substr($tel,-4);
        $params = "cp=$cp&svc=$svc&tel=$tel";
        $sec = $recommend_od_pay_time;
        $url = $chk_telnum_addr."?".$params;
        echo $url.'<br>';
        
//{060에 입력하는 코드}        
        // 등록한 전화번호인지 체크
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $ret = curl_exec($ch);
        curl_close($ch);
        echo $ret;
        
        switch ($ret){
            case 'dup': //DB에 있는 경우.
                echo 'dupdup';
                $params = "cp=$cp&svc=$svc&tel=$tel&pwd=$pwd&amt=0&sec=$sec";
                $url2 = $user_prepay_addr."?".$params;
                $ch2 = curl_init($url2);
                curl_setopt($ch2, CURLOPT_HEADER, false);
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
//                $ret2 = curl_exec($ch2);
                curl_close($ch2);                
                $return['code']	= $ret2;   
                switch($ret2){
                    case 'ok':
                        $sql_use_list = "update g5_shop_order set dc_status='승인완료', test='{$url2}' where od_id='{$recommend_od_id}'";
                        sql_query($sql_use_list);
                        break;
                    case 'dif':
                        $sql_use_list = "update g5_shop_order set dc_status='실패1', test='{$url2}' where od_id='{$recommend_od_id}'";
                        sql_query($sql_use_list);
                        break;
                    default :
                        $sql_use_list = "update g5_shop_order set dc_status='실패1-1', test='{$url2}' where od_id='{$recommend_od_id}'";
                        sql_query($sql_use_list);
                        break;
                }
                break;
            case 'ok': //DB에 없는 경우.
                echo 'okok';
                $params = "cp=$cp&svc=$svc&tel=$tel&pwd=$pwd&amt=0&sec=$sec";
                $url2 = $new_user_addr."?".$params;
                $ch2 = curl_init($url2);
                curl_setopt($ch2, CURLOPT_HEADER, false);
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
//                $ret2 = curl_exec($ch2);
                curl_close($ch2);
                $return['code']	= $ret2;
                switch($ret2){
                    case 'ok':
                        $return['msg'] =  "신규등록과 충전을 성공 하였습니다.";
                        $sql_use_list = "update g5_shop_order set dc_status='신규승인', test='{$url2}' where od_id='{$recommend_od_id}'";
                        sql_query($sql_use_list);
                        break;
                    case 'dup':
                        $sql_use_list = "update g5_shop_order set dc_status='실패2', test='{$url2}' where od_id='{$recommend_od_id}'";
                        sql_query($sql_use_list);
                        break;
                    default :
                        $sql_use_list = "update g5_shop_order set dc_status='실패2-1', test='{$url2}' where od_id='{$recommend_od_id}'";
                        sql_query($sql_use_list);
                        break;
                }
                break;                
            default : //
                alert('잘못된 접근입니다', G5_URL);
                break;
        }
        
/*      추천인($mb_recommend)에게 5분 무료코인 부여 및 주문내역추가의 의사코드. */



?>