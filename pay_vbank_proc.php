<?php
include_once('./_common.php');

/*******************************************************************************
 * 변수명           한글명
 *--------------------------------------------------------------------------------
 ********************************************************************************
 * 공통
 ********************************************************************************
 * transSeq			거래번호
 * userId			사용자아이디
 * userName			사용자이름
 * userPhoneNo		사용자휴대폰번호
 * moid				주문번호
 * goodsName		상품명
 * goodsAmt			상품금액
 * buyerName		구매자명
 * buyerPhoneNo		구매자휴대폰번호
 * pgCode			PG코드 ( 01:NICE / 02:KICC / 03:INFINISOFT / 04:KSNET / 05:KCP / 06:SMATRO )
 * pgName			PG명
 * payMethod		결제수단( 01:현금결제 / 02:신용카드 / 03:신용카드ARS )
 * payMethodName	결제수단명
 * pgMid			PG아이디
 * pgSid			PG서비스아이디
 * status			거래상태 ( 25:결제완료 / 85:결제취소 )
 * statusName		거래상태명
 * pgResultCode		PG결과코드
 * pgResultMsg		PG결과메세지
 * pgAppDate		PG승인일자
 * pgAppTime		PG승인시간
 * pgTid			PG거래번호
 * approvalAmt		승인금액
 * approvalNo		승인번호
 ********************************************************************************
 * 현글결제(현금영수증)
 ********************************************************************************
 * cashReceiptType			증빙구분 ( 1:소득공제 / 2:지출증빙 )
 * cashReceiptTypeName		증빙구분명
 * cashReceiptSupplyAmt		공급가
 * cashReceiptVat			부가세
 ********************************************************************************
 * 신용카드결제
 ********************************************************************************
 * cardNo					카드번호
 * cardQuota				할부개월
 * cardIssueCode			발급사코드 ( 메뉴얼참조 )
 * cardIssueName			발급사명
 * cardAcquireCode			매입사코드 ( 메뉴얼참조 )
 * cardAcquireName			매입사명
 ********************************************************************************
 * 가상계좌결제
 ********************************************************************************
 * vacctNo					가상계좌번호
 * vbankBankCd				가상계좌은행코드
 * vbankAcctNm				송금자명
 * vbankRefundAcctNo		환불계좌번호
 * vbankRefundBankCd		수취인연락처
 * vbankRefundAcctNm		환불계좌주명
 ********************************************************************************
 * 결제취소
 ********************************************************************************
 * cancelAmt				취소요청금액
 * cancelMsg				취소요청메세지
 * cancelResultCode			취소결과코드
 * cancelResultMsg			취소결과메세지
 * cancelAppDate			취소승인일자
 * cancelAppTime			취소승인시간
 * cancelPgTid				PG거래번호
 * cancelApprovalAmt		승인금액
 * cancelApprovalNo			승인번호
*******************************************************************************/

if($status == "25"){			// 결제완료

	$sql = "SELECT * FROM ".$g5['g5_shop_order_table']." WHERE od_id='".$_POST["moid"]."'";
	$row = sql_fetch($sql);
	if ( $row['od_id'] ) {
		$member = get_member($row['mb_id']);
		$ORDER_ID = $_POST["moid"];
		$sql = "update ".$g5['g5_shop_order_table']." set od_misu = '0', od_cart_price='".$_POST["goodsAmt"]."', od_status='입금', od_receipt_price='".$_POST["goodsAmt"]."', od_receipt_time=now(), dc_status='arsok'  where od_id='".$_POST["moid"]."'";
		$re = sql_query($sql);

		include_once G5_PATH."/update_charge_human.php";
		insert_point($row['mb_id'], ($PAY_TYPE * 10), "od_id".$_POST["moid"].', '.$row['od_settle_case'].', '.$_POST["goodsAmt"].' 충전', '@charge', $row['mb_id'], $_POST["moid"].', '.$row['od_settle_case'].', '.$_POST["goodsAmt"].' 충전');
	}
}
else if($status == "85"){		// 결제취소

}
else{
	return;
}
echo "0000";
?>