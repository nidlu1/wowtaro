<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/etc.lib.php');
include_once(G5_LIB_PATH.'/mailer.lib.php');

/*------------------------------------------------------------------------------
    ※ KCP 에서 가맹점의 결과처리 페이지로 데이터를 전송할 때에, 아래와 같은
       IP 에서 전송을 합니다. 따라서 가맹점측께서 전송받는 데이터에 대해 KCP
       에서 전송된 건이 맞는지 체크하는 부분을 구현할 때에, 아래의 IP 에 대해
       REMOTE ADDRESS 체크를 하여, 아래의 IP 이외의 다른 경로를 통해서 전송된
       데이터에 대해서는 결과처리를 하지 마시기 바랍니다.
------------------------------------------------------------------------------*/
if(!$default['de_card_test']) {
    switch ($_SERVER['REMOTE_ADDR']) {
        case '203.238.36.58' :
        case '203.238.36.160' :
        case '203.238.36.161' :
        case '203.238.36.173' :
        case '203.238.36.178' :
            break;
        default :
            $super_admin = get_admin('super');
            $egpcs_str = "ENV[" . serialize($_ENV) . "] "
                       . "GET[" . serialize($_GET) . "]"
                       . "POST[" . serialize($_POST) . "]"
                       . "COOKIE[" . serialize($_COOKIE) . "]"
                       . "SESSION[" . serialize($_SESSION) . "]";
            mailer('경고', 'waring', $super_admin['mb_email'], '올바르지 않은 접속 보고', "{$_SERVER['SCRIPT_NAME']} 에 {$_SERVER['REMOTE_ADDR']} 이 ".G5_TIME_YMDHIS." 에 접속을 시도하였습니다.\n\n" . $egpcs_str, 2);
            exit;
    }
}

    /* ============================================================================== */
    /* =   PAGE : 공통 통보 PAGE                                                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2006   KCP Inc.   All Rights Reserverd.                   = */
    /* ============================================================================== */
?>
<?php
    /* ============================================================================== */
    /* =   01. 공통 통보 페이지 설명(필독!!)                                        = */
    /* = -------------------------------------------------------------------------- = */
    /* =   에스크로 서비스의 경우, 가상계좌 입금 통보 데이터와 가상계좌 환불        = */
    /* =   통보 데이터, 구매확인/구매취소 통보 데이터, 배송시작 통보 데이터 등을    = */
    /* =   KCP 를 통해 별도로 통보 받을 수 있습니다. 이러한 통보 데이터를 받기      = */
    /* =   위해 가맹점측은 결과를 전송받는 페이지를 마련해 놓아야 합니다.           = */
    /* =   현재의 페이지를 업체에 맞게 수정하신 후, KCP 관리자 페이지에 등록해      = */
    /* =   주시기 바랍니다. 등록 방법은 연동 매뉴얼을 참고하시기 바랍니다.          = */
    /* ============================================================================== */

    //write_log("$g5[path]/data/log/kcp_common.log", print_r($_POST));

    /* ============================================================================== */
    /* =   02. 공통 통보 데이터 받기                                                = */
    /* = -------------------------------------------------------------------------- = */
    $site_cd      = $_POST [ "site_cd"  ];                 // 사이트 코드
    $tno          = $_POST [ "tno"      ];                 // KCP 거래번호
    $order_no     = $_POST [ "order_no" ];                 // 주문번호
    $tx_cd        = $_POST [ "tx_cd"    ];                 // 업무처리 구분 코드
    $tx_tm        = $_POST [ "tx_tm"    ];                 // 업무처리 완료 시간
    /* = -------------------------------------------------------------------------- = */
    $ipgm_name    = "";                                    // 주문자명
    $remitter     = "";                                    // 입금자명
    $ipgm_mnyx    = "";                                    // 입금 금액
    $bank_code    = "";                                    // 은행코드
    $account      = "";                                    // 가상계좌 입금계좌번호
    $op_cd        = "";                                    // 처리구분 코드
    $noti_id      = "";                                    // 통보 아이디
    /* = -------------------------------------------------------------------------- = */
    $refund_nm    = "";                                    // 환불계좌주명
    $refund_mny   = "";                                    // 환불금액
    $bank_code    = "";                                    // 은행코드
    /* = -------------------------------------------------------------------------- = */
    $st_cd        = "";                                    // 구매확인 코드
    $can_msg      = "";                                    // 구매취소 사유
    /* = -------------------------------------------------------------------------- = */
    $waybill_no   = "";                                    // 운송장 번호
    $waybill_corp = "";                                    // 택배 업체명

    /* = -------------------------------------------------------------------------- = */
    /* =   02-1. 가상계좌 입금 통보 데이터 받기                                     = */
    /* = -------------------------------------------------------------------------- = */
    if ( $tx_cd == "TX00" )
    {
        $ipgm_name = $_POST[ "ipgm_name" ];                // 주문자명
        $remitter  = $_POST[ "remitter"  ];                // 입금자명
        $ipgm_mnyx = $_POST[ "ipgm_mnyx" ];                // 입금 금액
        $bank_code = $_POST[ "bank_code" ];                // 은행코드
        $account   = $_POST[ "account"   ];                // 가상계좌 입금계좌번호
        $op_cd     = $_POST[ "op_cd"     ];                // 처리구분 코드
        $noti_id   = $_POST[ "noti_id"   ];                // 통보 아이디
    }

    /* = -------------------------------------------------------------------------- = */
    /* =   02-2. 가상계좌 환불 통보 데이터 받기                                     = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $tx_cd == "TX01" )
    {
        $refund_nm  = $_POST[ "refund_nm"  ];              // 환불계좌주명
        $refund_mny = $_POST[ "refund_mny" ];              // 환불금액
        $bank_code  = $_POST[ "bank_code"  ];              // 은행코드
    }

    /* = -------------------------------------------------------------------------- = */
    /* =   02-3. 구매확인/구매취소 통보 데이터 받기                                 = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $tx_cd == "TX02" )
    {
        $st_cd = $_POST[ "st_cd" ];                        // 구매확인 코드

        if ( $st_cd == "N" )                               // 구매확인 상태가 구매취소인 경우
        {
            $can_msg = $_POST[ "can_msg" ];                // 구매취소 사유
        }
    }

    /* = -------------------------------------------------------------------------- = */
    /* =   02-4. 배송시작 통보 데이터 받기                                          = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $tx_cd == "TX03" )
    {
        $waybill_no   = $_POST[ "waybill_no"   ];          // 운송장 번호
        $waybill_corp = $_POST[ "waybill_corp" ];          // 택배 업체명
    }
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   03. 공통 통보 결과를 업체 자체적으로 DB 처리 작업하시는 부분입니다.      = */
    /* = -------------------------------------------------------------------------- = */
    /* =   통보 결과를 DB 작업 하는 과정에서 정상적으로 통보된 건에 대해 DB 작업을  = */
    /* =   실패하여 DB update 가 완료되지 않은 경우, 결과를 재통보 받을 수 있는     = */
    /* =   프로세스가 구성되어 있습니다. 소스에서 result 라는 Form 값을 생성 하신   = */
    /* =   후, DB 작업이 성공 한 경우, result 의 값을 "0000" 로 세팅해 주시고,      = */
    /* =   DB 작업이 실패 한 경우, result 의 값을 "0000" 이외의 값으로 세팅해 주시  = */
    /* =   기 바랍니다. result 값이 "0000" 이 아닌 경우에는 재통보를 받게 됩니다.   = */
    /* = -------------------------------------------------------------------------- = */

    /* = -------------------------------------------------------------------------- = */
    /* =   03-1. 가상계좌 입금 통보 데이터 DB 처리 작업 부분                        = */
    /* = -------------------------------------------------------------------------- = */
    if ( $tx_cd == "TX00" )
    {
        $sql = " select pp_id, od_id from {$g5['g5_shop_personalpay_table']} where pp_id = '$order_no' and pp_tno = '$tno' ";
        $row = sql_fetch($sql);

        $result = false;

        if($row['pp_id']) {
            // 개인결제 UPDATE
            $sql = " update {$g5['g5_shop_personalpay_table']}
                        set pp_receipt_price    = '$ipgm_mnyx',
                            pp_receipt_time     = '$tx_tm'
                        where pp_id = '$order_no'
                          and pp_tno = '$tno' ";
            sql_query($sql, false);

            if($row['od_id']) {
                // 주문서 UPDATE
                $receipt_time    = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3 \\4:\\5:\\6", $tx_tm);
                $sql = " update {$g5['g5_shop_order_table']}
                            set od_receipt_price = od_receipt_price + '$ipgm_mnyx',
                                od_receipt_time = '$tx_tm',
                                od_shop_memo = concat(od_shop_memo, \"\\n개인결제 ".$row['pp_id']." 로 결제완료 - ".$receipt_time."\")
                          where od_id = '{$row['od_id']}' ";
                $result = sql_query($sql, FALSE);
            }
        } else {
            // 주문서 UPDATE
            $sql = " update {$g5['g5_shop_order_table']}
                        set od_receipt_price = '$ipgm_mnyx',
                            od_receipt_time = '$tx_tm'
                      where od_id = '$order_no'
                        and od_tno = '$tno' ";
            $result = sql_query($sql, FALSE);
        }
    }

    if($result) {
        if($row['od_id'])
            $od_id = $row['od_id'];
        else
            $od_id = $order_no;

        // 주문정보 체크
        $sql = " select count(od_id) as cnt
                    from {$g5['g5_shop_order_table']}
                    where od_id = '$od_id'
                      and od_status = '주문' ";
        $row = sql_fetch($sql);

        if($row['cnt'] == 1) {
            // 미수금 정보 업데이트
            $info = get_order_info($od_id);

            $sql = " update {$g5['g5_shop_order_table']}
                        set od_misu = '{$info['od_misu']}' ";
            if($info['od_misu'] == 0)
                $sql .= " , od_status = '입금' ";
            $sql .= " where od_id = '$od_id' ";
            sql_query($sql, FALSE);

            // 장바구니 상태변경
            if($info['od_misu'] == 0) {
                $sql = " update {$g5['g5_shop_cart_table']}
                            set ct_status = '입금'
                            where od_id = '$od_id' ";
                sql_query($sql, FALSE);
            }
        }
    }

    /* = -------------------------------------------------------------------------- = */
    /* =   03-2. 가상계좌 환불 통보 데이터 DB 처리 작업 부분                        = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $tx_cd == "TX01" )
    {
    }

    /* = -------------------------------------------------------------------------- = */
    /* =   03-3. 구매확인/구매취소 통보 데이터 DB 처리 작업 부분                    = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $tx_cd == "TX02" )
    {
    }

    /* = -------------------------------------------------------------------------- = */
    /* =   03-4. 배송시작 통보 데이터 DB 처리 작업 부분                             = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $tx_cd == "TX03" )
    {
    }

    /* = -------------------------------------------------------------------------- = */
    /* =   03-5. 정산보류 통보 데이터 DB 처리 작업 부분                             = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $tx_cd == "TX04" )
    {
    }

    /* = -------------------------------------------------------------------------- = */
    /* =   03-6. 즉시취소 통보 데이터 DB 처리 작업 부분                             = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $tx_cd == "TX05" )
    {
    }

    /* = -------------------------------------------------------------------------- = */
    /* =   03-7. 취소 통보 데이터 DB 처리 작업 부분                                 = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $tx_cd == "TX06" )
    {
    }

    /* = -------------------------------------------------------------------------- = */
    /* =   03-7. 발급계좌해지 통보 데이터 DB 처리 작업 부분                         = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $tx_cd == "TX07" )
    {
    }
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   04. result 값 세팅 하기                                                  = */
    /* ============================================================================== */
?>
<html><body><form><input type="hidden" name="result" value="0000"></form></body></html>