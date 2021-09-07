<?php
include_once('./_common.php');


//if (!$is_member)
	//alert('로그인 후 이용하여 주십시오.', G5_BBS_URL."/login.php?url=".G5_URL."/payment.php");

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/payment.php');
    return;
}

$g5['title'] =  '코인충전';

include_once(G5_PATH.'/head.php');
//print_r($member);

$moid = date("YmdHis")."S".str_replace("-","",$member['mb_hp']);

$sql = "SELECT * FROM ".$g5['pay_table']." WHERE pa_use='1' order by pa_no ";
$result = sql_query($sql);

?>
<script type="text/javascript" src="https://pg.innopay.co.kr/pay/js/Innopay.js"></script>
<form id="frm" name="frm" method="post" action="./payment_result.php">
	<div class="c_hero">
		<strong>신선운세 <mark>코인충전</mark></strong>
	</div>
	<div class="c_list">
		<div class="cl_menu">
			<a href="<?php echo G5_URL; ?>"><i></i><span class="blind">HOME</span></a>
			<span>신선운세</span>
			<span><mark><a href="/payment.php" class="sct_here">코인충전</a></mark></span>
		</div>
	</div>
	<div class="c_area">
		<div class="wrap">
			<?php
			if ( !$member['mb_id'] ) {
			?>
			<div class="ca_title title t2 cg mb50">
				<h3>현재고객님은 비회원이십니다 비회원으로 가입시 포인트 및 각종혜택을 이용하실 수 없습니다
 <!--<a href="/bbs/login.php">로그인하기</a>--></h3>
			</div>
			<?php
			}
			?>
			<div class="ca_kind">
				<h2 class="blind">결제금액 선택</h2>
				<ul>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						$origin_amt = 2600 * ($row['pa_time'] / 60);
						$per = ( $origin_amt - $row['pa_amt'] ) / $origin_amt * 100;
						$amt30 = ( $row['pa_amt'] / ($row['pa_time'] / 60) / 2 );
						//$add_amt = ( $row['pa_amt'] * 0.3 );
						$add_amt = $row['pa_amt'];
						$pluse_time = preg_replace("/[^0-9]*/s", "", $row['pa_mungu']);
						$base_time = ($row['pa_time'] / 60) -  $pluse_time;
						
					//			$add_amt2 = ( $row['pa_point'] - $add_amt == 0 ) ? "" : "<span class='bonus_coin'>(".number_format($add_amt)."코인<span class='blue_strong'>+보너스".number_format($row['pa_point'] - $add_amt)."코인</span>)</span>";
					//			$add_amt2 = "<span class='bonus_coin'>(".number_format($add_amt)."코인 <span class='blue_strong'> + 보너스".number_format( $row['pa_point']-$add_amt)."코인</span>)</span>";
						//if ( $row['pa_no'] == 7 && $_SERVER['REMOTE_ADDR'] != "175.114.22.192" ) continue;
					?>
					<li <?php echo $i == 1 ? "class='on'" : "";?>>
						<div class="cak_wrap">
							<div class="cak_radio">
								<input type="radio" id="pa_no_<?php echo $row['pa_no']; ?>" name="coin_count" value="<?php echo $row['pa_no']; ?>" data-amt="<?= $row['pa_amt']; ?>" data-point="<?php echo $row['pa_point']; ?>" data-time="<?php echo $row['pa_time']; ?>" <?php echo $i == 1 ? "checked" : "";?>>
								<i></i>
							</div>
							<div class="cak_time">
								<?php echo $base_time; ?>분
							</div>
							<div class="cak_pluse">
								 <?php echo $row['pa_mungu']; ?>
							</div>
							<div class="cak_content">
								<span>기본 상담시간 <?php echo $base_time; ?>분 <?php echo $pluse_time; ?>분추가,<mark>총 <?php echo ($row['pa_time'] / 60); ?>분</mark></span>
							</div>
							<div class="cak_rate">
								<span class="score_rate"><?php echo number_format($per,0); ?>% 할인</span>
							</div>
							<div class="cak_point">
								<span>적립코인 <?php echo number_format($row['pa_point']); ?> <i class="icon coin"></i></span>
							</div>
							<div class="fr">
								<div class="cak_price">
									<span><?php echo $row['pa_amt']/10000; ?>만원</span>
								</div>
							</div>
						</div>
					</li>
					<?php
					}
					?>
				</ul>
			</div>
			<ol class="ca_notice">
				<li><span>결제금액은 <mark>VAT별도 금액입니다.</span></li>
				<li><span>할인율은 <mark>바로상담 (<a href="tel:0603006700">060 - 300 - 6700</a>  /  30초당 1,300원) 대비 할인율</mark> 입니다.</span></li>
				<li><span>결제금액이 높을수록 더 많은 포인트가 지급됩니다.</span></li>
				<li><span><mark>1원당 1코인</mark> 입니다.</span></li>
				<li><span>이벤트 기간에는 적립금 코인이 지급되지 않습니다.</span></li>
			</ol>
			<!-- <div class="coin_content">
				<h2>결제금액에 따른 회원등급 부여</h2>
				<ol class="coin_notice">
				  <li><span>50만원</span><span>누적 시 나그네회원</span><span>무료 15분 코인충전</span></li>
				  <li><span>100만원</span><span>누적 시 열심회원</span><span>무료 30분 코인충전</span></li>
				  <li><span>400만원</span><span>누적 시 성실회원</span><span>무료 40분 코인충전</span></li>
				  <li><span>500만원</span><span>누적 시 충성회원</span><span>무료 60분 코인충전</span></li>
				  <li><span>1000만원</span><span>누적 시 신선회원</span><span>무료 120분 코인충전</span></li>
				</ol>
			  </div> -->

			<script>
			//콘텐츠배너 열고닫기
			  $(function(){
				$(".cai_title").on("click", function(){
				  $(this).siblings(".cai_content").toggle();
				  $(this).children("i").toggleClass("on");
				});
			  });
			</script>

			<!-- <div class="information_use payment_banner">
			 <h3 class="banner_title coin_banner_open">코인할인상담 최대 60%할인 이용방법안내
			  <i class="xi-angle-up-thin"></i>
			 </h3>
			 <div class="information_use_banner coin_banner_content">
			   <p>
				 <span class="num_style">1</span>
				 회원가입후 코인을 충전합니다.
			   </p>
			   <p>
				 <span class="num_style">2</span>
				 현재 선생님 상담상태인지 꼭 확인하고 상담
			   </p>
			   <p>
				 <span class="num_style">3</span>
				 코인할인상담 상담가능 선생님 코드번호를 확인하고 <span class="color_red">1661-3439</span>번으로 건 후<br>
				 선택한 000코드번호(#) 입력후 선생님과 상담 진행
			   </p>
			   <p>
				 <span class="num_style">4</span>
				  코인 사용기간은 사용자가 사용할때 차감되는 방식입니다.
			   </p>
			   <p>
				 <span class="num_style">5</span>
				 충전된 코인이 모두 사용되면 자동으로 통화가 종료됩니다.
			   </p>
			 </div>
		   </div> -->

			<div class="ca_info">
				<h3 class="cai_title">신선운세의 할인 혜택과 등급에 따라 추가 지급되는 적립 코인을 지금 확인하세요!! <i class="cai_arrow"></i></h3>
				<div class="cai_content">
					<img src="../images/payment/pic_event.jpg"/ alt="할인상담(코인충전 후 상담) 할인 혜택">
				</div>
			</div>

			<script>
			//계좌번호 나타나기
			  // $(function(){
			  //   $("#PayMethod1, #PayMethod2, #PayMethod3").on("click",function(){
			  //     $(".account_info").hide();
			  //     $(".coin_payment .fright").removeClass("on");
			  //   });
			  //   $("#PayMethod4").on("click",function(){
			  //     $(".account_info").show();
			  //     $(".coin_payment .fright").addClass("on");
			  //   });
			  // });
			</script>

			<div class="ca_paymethod">
				<h2 class="cap_title">결제 방법 선택</h2>
				<div class="cap_wrap">
					<div class="cap_select <?php if($member['mb_id']) { ?>on<?php }?>">
						<ul>
							<li><label><input type="radio" name="PayMethod" id="PayMethod1" class="radio" value="CARD" checked><i></i><span>신용카드</span></label></li>
							<li><label><input type="radio" name="PayMethod" id="PayMethod2" class="radio" value="CARS"><i></i><span>ARS결제</span></label></li>
							<li><label><input type="radio" name="PayMethod" id="PayMethod3" class="radio" value="VBANK"><i></i><span>가상계좌</span></label></li>
						</ul>
					<!-- <div class="account_info">
					  <p>입금계좌 : 100-033-433393 신한은행</p>
					  <p>예금주 : 김두혁(와우엔터테인먼트)</p>
					  <p>무통장입금 가능한 시간 : 09:00~24:00 가능 합니다</p>
					</div> -->
					</div>
					<div class="cap_money <?php if($member['mb_id']) { ?>on<?php }?>">
						<h4>결제금액</h4>
					</div>
					<div class="cap_info">
						<dl>
							<dt>결제금액<span id="time_str"></dt>
							<dd><span id="amt_str"></span>원</dd>
						</dl>
						
							<?php if ( $member['mb_id'] ) {?>
							<dl>
							<dt>
								<label for="BrowserType">보유코인: <span id="point_str"><?= $member['mb_point']?></span>코인</label>
								<input type="hidden" id="point_str2" value="<?= $member['mb_point']?>">
								<span id="time_str"></span>
							</dt>
							<dd><input type="text" class="payment-coin" id="pointpay_str" name="BrowserType"><button id="coin-apply" type="button" class="btn_submit">코인적용</button></dd>
						</dl>
						<?php } ?>
						<dl>
							<dt>실제 결제금액(VAT별도)</dt>
							<dd><span id="pay_str"></span>원</dd>
						</dl>

						<?php if($member['mb_id']) {?>
						<dl>
							<dt>결제자 휴대폰번호</dt>
							<dd><input type="tel" class="payment_hp" name="order_hp" value="<?=$member['mb_hp']?>" readOnly maxlength="12" placeholder="-없이 입력하세요"></dd>
						</dl>
						<dl>
						<?php }else{ ?>
						<dl>
							<dt>결제자 휴대폰번호</dt>
							<dd><input type="tel" class="payment_hp" name="order_hp" value="" maxlength="13" placeholder="010-1234-5678">
						<!--<button type="button" id="" class="btn_frmline">인증번호 요청</button></dd>-->
						</dl>
						<?php } ?>	
						<?php
							$sql_common = " from g5_pointuse ";
							$sql2 = " select * $sql_common ";
							$result2 = sql_fetch($sql2);
						?>
						<?php if ( $member['mb_id'] ) {?>
						<dl>
							<dt><mark class="cb"><?=number_format($result2['p01'])?></mark><i class="capi_coin"></i> 부터 사용이 가능합니다.</dt>
							<dd></dd>
						</dl>
						<?php } ?>
							
						
					</div>
				</div>
			</div>
			<input type="hidden" name="GoodsCnt" value="1" ><!-- 상품개수 -->
					<input type="hidden" name="GoodsName" value="<?php echo $member['mb_name']; ?> 코인구매" ><!-- 상품명 -->
					<input type="hidden" name="Amt" value="0" ><!-- 상품가격 -->
					<input type="hidden" name="Moid" value="<?php echo $moid; ?>"><!-- 가맹점주문번호 -->
					<input type="hidden" name="MID" value="<?php echo $MID; ?>"><!-- 상점 MID -->
					<input type="hidden" name="ReturnURL" value="<?php echo G5_URL; ?>/payment_result.php"> <!-- 결제결과전송 URL -->
					<input type="hidden" name="ResultYN" value="N" ><!-- 결제결과창 유무 -->
					<input type="hidden" name="RetryURL" value="https://pg.innopay.co.kr/pay/returnPay.jsp"><!-- 결제결과 RETRY URL -->
					<input type="hidden" name="mallUserID" value="<?=$member['mb_id']?>"><!--상점 결제 회원 ID-->
					<input type="hidden" name="BuyerName" value="<?=$member['mb_name']?>"><!-- 구매자명 -->
					<input type="hidden" name="BuyerTel" value="<?=str_replace("-","",$member['mb_hp'])?>"><!-- 구매자 연락처 -->
					<input type="hidden" name="BuyerEmail" value="<?=$member['mb_email']?>"><!-- 구매자 이메일 주소 -->
					<input type="hidden" name="OfferingPeriod" value="<?php echo date("Y.m.d"); ?> ~ <?php echo date("Y.m.d", strtotime("+1 Days",time())); ?>"><!-- 제공기간 ex) 2001.01.05 -->
					<input type="hidden" name="VbankExpDate" id="VbankExpDate" value=""><!-- 입금예정일(가상계좌) -->
					<input type="hidden" name="EncodingType" id="EncodingType" value="utf-8"><!-- 인코딩타입 -->
					<input type="hidden" name="FORWARD" id="FORWARD" value="Y"><!-- 결제창 팝업유무 -->
					<input type="hidden" name="ediDate" value=""><!-- 결제요청일시 제공된 js 내 setEdiDate 함수를 사용하거나 가맹점에서 설정 yyyyMMddHHmmss -->
					<input type="hidden" name="MerchantKey" value="<?php echo $MerchantKey; ?>"><!-- 발급된 가맹점키 -->
					<input type="hidden" name="EncryptData" value=""> <!-- 암호화데이터 -->
					<input type="hidden" name="MallIP" value="127.0.0.1"/> <!-- 가맹점서버 IP 가맹점에서 설정-->
					<input type="hidden" name="UserIP" value="127.0.0.1"> <!-- 구매자 IP 가맹점에서 설정-->
					<input type="hidden" name="MallResultFWD"   value="N"> <!-- Y 인 경우 PG결제결과창을 보이지 않음 -->
					<input type="hidden" name="device" value=""> <!-- 자동셋팅 -->
					<!--hidden 데이타 옵션-->
					<input type="hidden" name="BrowserType" value="">
						<input type="hidden" name="MallReserved" value="">
						<input type="hidden" name="BuyerAddr" value="">
					<!-- 현재는 사용안함 -->
					<input type="hidden" name="SUB_ID" value=""> <!-- 서브몰 ID -->
					<input type="hidden" name="BuyerPostNo" value="" > <!-- 배송지 우편번호 -->
					<input type="hidden" name="BuyerAuthNum">
					<input type="hidden" name="ParentEmail">
					<div class="conin_btn_wrap">
					<?php
					if ( $member['mb_id'] ) {
					?>
						<button type="button" name="submit_btn" id="submit_btn" class="btn t1 big">결제하기</button>
					<?php
					}
					else {
					?>
						<button type="button" id="non_submit_btn" class="btn t1 big" onClick="">비회원 결제하기</button>
						<button type="button" id="submit_btn" style="display: none">결제하기</button>
					<?php
					}
					?>
		</div>
	</div>
</form>
	</div>
<form id="arsfrm" name="arsfrm" action="<?php echo G5_URL; ?>/payment_ars_result.php">
<table id="payTable" style="display:none;">
<tr>
<td>
<input type="hidden" name="payMethod" value="CARS"> <!-- 필수: CARS 고정 -->
</td></tr><tr><td>
<input type="hidden" name="cardInterest" value=""> <!-- 선택: 무이자여부 (0: default, 1: 무이자) -->
</td></tr><tr><td>
<input type="hidden" name="currency" value=""> <!-- 선택: KRW : default, USD : 미화 -->
</td></tr><tr><td>
<input type="hidden" name="arsConnType" value="02"> <!-- 필수: ARS접속 방법 (특별 가맹점이 아닌 경우, “02”로 설정) “01” : 호전환ARS, “02” : 가상ARS번호, “03” : 대표ARS번호 -->
</td></tr><tr><td>
<input type="hidden" name="goodsName" value="<?php echo $member['mb_name']; ?> 신선운세 코인구매"> <!-- 필수: 상품명 (한글기준 20자 이하) -->
</td></tr><tr><td>
<input type="hidden" name="amt" value="0"> <!-- 필수: 결제요청금액 (숫자) -->
</td></tr><tr><td>
<input type="hidden" name="mid" value="<?php echo $MID; ?>"> <!-- 필수: 상점 아이디(인피니소프트 발급) -->
</td></tr><tr><td>
<input type="hidden" name="pgMID" value="<?php echo $pgMID; ?>"> <!-- 필수: PG사 MID(인피니소프트 발급) -->
</td></tr><tr><td>
<input type="text" name="moid" value="<?php echo $moid; ?>"> <!-- 필수: 가맹점 주문번호 -->
</td></tr><tr><td>
<input type="hidden" name="buyerName" value="<?=$member['mb_name']?>"> <!-- 필수: 결제자 이름 -->
</td></tr><tr><td>
<input type="hidden" name="buyerHp" value="<?=str_replace("-","",$member['mb_hp'])?>"> <!-- 필수: 결제자 휴대폰번호 (숫자) -->
</td></tr><tr><td>
<input type="hidden" name="buyerEmail" value="<?=$member['mb_email']?>"> <!-- 선택: 결제자 이메일 주소(결제 후 영수증 발송) -->
</td></tr><tr><td>
<input type="hidden" name="payExpDate" value=""> <!-- 선택: ARS결제마감기한 (미입력시 익일 23시59분59초) 예제 : (2017-11-21 23:59:59 or 20171121235959) -->
</td></tr><tr><td>
<input type="hidden" name="serviceMode" value="PY0"> <!-- 필수: PY0 고정 -->
</td></tr><tr><td>
<input type="hidden" name="licenseKey" value="<?php echo $MerchantKey; ?>"> <!-- 필수: 상점 라이센스키(인피니소프트 발급) -->
</td></tr><tr><td>
<input type="hidden" name="tid" id="tid" value=""><input type="hidden" name="od_pay_time" value=""> <!-- return -->
</td></tr>
</table>
</form>
<script type="text/javascript">
$(document).ready(function() {
	$("input[name=coin_count]").each(function (index, item) {
		if ( $(item).is(":checked") == true ) {
			var amt = eval( $(this).data("amt") + " + " + $(this).data("amt") + " / 10" );
			var time_str = eval($(this).data("time") + " / 60");
			$("input[name=Amt]").val( amt );
			document.arsfrm.amt.value = amt;
			$("#amt_str").html( number_format($(this).data("amt")) );
			$("#time_str").html( " ("+time_str+"분)" );
                        $("input[name=MallReserved]").val( $(this).data("point")+"/"+$(this).data("time")+"/" );
			$("input[name=od_pay_time]").val( $(this).data("time") );
                        $("#pay_str").html( number_format($(this).data("amt")) );
		}
	});


	$("input[name=coin_count]").click(function () {
		var amt = eval( $(this).data("amt") + " + " + $(this).data("amt") + " / 10" );
		var time_str = eval($(this).data("time") + " / 60");
		$("input[name=Amt]").val( amt );
		document.arsfrm.amt.value = amt;
		$("#amt_str").html( number_format($(this).data("amt")) );
		$("#time_str").html( " ("+time_str+"분)" );
		$("input[name=MallReserved]").val( $(this).data("point")+"/"+$(this).data("time")+"/" );
		$("input[name=od_pay_time]").val( $(this).data("time") );
                $("#pay_str").html( number_format($(this).data("amt")) );
		$(".ca_kind li").removeClass("on");
		$(this).closest("li").addClass("on");
	});

	$("#frm").find("input[name=PayMethod]").change(function(){
		if("VBANK"==$("#frm").find("input[name=PayMethod]").val()){
			$("#VbankExpDate").removeAttr("disabled");
			$("#VbankExpDate").val(ediDate.substring(0, 8));
		}else{
			$("#VbankExpDate").attr("disabled",true);
		}
	});

	$("#submit_btn").click(function () {
		//alert($("#frm").find("input[name=PayMethod]:checked").val());return;
		//alert($("input[name=coin_count]:checked").val());return;
		if ( $("#frm").find("input[name=PayMethod]:checked").val() != "CARD" && $("input[name=coin_count]:checked").val() == "7" ) {
			alert ("1,000원 결제는 신용카드만 가능합니다.");
			return;
		}
		var is_auth = "NO";
	    $.ajax({
			type : "POST",
			url : "<?php echo G5_URL; ?>/ajax_auth.php",
			data : "chk_val="+$("input[name=coin_count]:checked").val(),
			success : function(data){
				//console.log(data);
				is_auth = data;

				if (is_auth == "NO") {
					alert("로그인 세션이 끊겼습니다. 로그인 후 결제 부탁드립니다.");
					return;
				}
				if (is_auth == "NO2") {
					alert("해당 상품은 2번만 구매가 가능한 상품입니다.");
					return;
				}
				//alert(is_auth);return;
				if ( $("#frm").find("input[name=PayMethod]:checked").val() == "CARS" ) {
					send();
				}
				else if ( $("#frm").find("input[name=PayMethod]:checked").val() == "무통장" ) {
					$("#frm").attr("action","./payment_bank_result.php");
					$(this).hide();
					$("#frm").submit();
				}
				else {
					$("#frm").attr("action","./payment_result.php");
					$(this).hide();
					goPay(document.frm);
				}
			},
			error : function(data){
				console.log(data);
				//alert("통신에러");
			}
		});

	});
});

function tableToJSON(table) {
	var obj = new Object();
	var row, rows = table.rows;
	for (var i=0, iLen=rows.length; i<iLen; i++) {
	  row = rows[i];
	  console.log (document.arsfrm.getElementsByTagName("input")[i].getAttribute('name') + " , " + document.arsfrm.getElementsByTagName("input")[i].value);
	  obj[document.arsfrm.getElementsByTagName("input")[i].getAttribute('name')] = document.arsfrm.getElementsByTagName("input")[i].value;
	}
	console.log(obj);
	return JSON.stringify(obj);
}
/*
function tableToJSON(table) {
	var obj = new Array();
	var row;
	var str = "";
	//alert( table.find("input[name=amt]").val() ); return;
	table.find("input").each(function (index, item) {
		console.log(index + " , " + item.name + " , " + item.value);
		//obj[item.name] = item.value;
		if ( str == "" ) {
			str = "{"+item.name+":'"+item.value+"'}";
		}
		else {
			str += ",{"+item.name+":'"+item.value+"'}";
		}
	});
	obj = [str];
	var obj2 = JSON.stringify(obj);
	console.log("test => " + obj2);return;

	return obj2;
}
*/
function send(){
	$.support.cors = true;	//IE CROSSDOMAIN 관련 설정
    var resultcode = null;
//https://api.innopay.co.kr/api/registArsOrder
//https://api.innopay.co.kr/api/cardInterface
    $.ajax({
        type : "POST",
        url : "https://api.innopay.co.kr/api/registArsOrder",
        async : true,
        data : tableToJSON(document.getElementById('payTable')),
        contentType: "application/json; charset=utf-8",
        dataType : "json",
        cache : false,
        success : function(data){
			//$("#first").hide();
			//$("#second").show();

            console.log(data);
			$("#submit_btn").hide();
			alert ( data.resultMsg );
			$("#tid").val(data.arsTid);
			$("#arsfrm").submit();
            //goPay(document.frm);
        },
        error : function(data){
        	console.log(data);
        	alert("통신에러");
        }
    });
}
function back(){
	$("#first").show();
	$("#second").hide();
}
</script>

<script type="text/javascript">

// IE ERROR 관련 스크립트
//  json2.js
if (typeof JSON !== "object") {
    JSON = {};
}

(function () {
    "use strict";

    var rx_one = /^[\],:{}\s]*$/;
    var rx_two = /\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g;
    var rx_three = /"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g;
    var rx_four = /(?:^|:|,)(?:\s*\[)+/g;
    var rx_escapable = /[\\"\u0000-\u001f\u007f-\u009f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g;
    var rx_dangerous = /[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g;

    function f(n) {
        // Format integers to have at least two digits.
        return (n < 10)
            ? "0" + n
            : n;
    }

    function this_value() {
        return this.valueOf();
    }

    if (typeof Date.prototype.toJSON !== "function") {

        Date.prototype.toJSON = function () {

            return isFinite(this.valueOf())
                ? (
                    this.getUTCFullYear()
                    + "-"
                    + f(this.getUTCMonth() + 1)
                    + "-"
                    + f(this.getUTCDate())
                    + "T"
                    + f(this.getUTCHours())
                    + ":"
                    + f(this.getUTCMinutes())
                    + ":"
                    + f(this.getUTCSeconds())
                    + "Z"
                )
                : null;
        };

        Boolean.prototype.toJSON = this_value;
        Number.prototype.toJSON = this_value;
        String.prototype.toJSON = this_value;
    }

    var gap;
    var indent;
    var meta;
    var rep;


    function quote(string) {

        rx_escapable.lastIndex = 0;
        return rx_escapable.test(string)
            ? "\"" + string.replace(rx_escapable, function (a) {
                var c = meta[a];
                return typeof c === "string"
                    ? c
                    : "\\u" + ("0000" + a.charCodeAt(0).toString(16)).slice(-4);
            }) + "\""
            : "\"" + string + "\"";
    }


    function str(key, holder) {

// Produce a string from holder[key].

        var i;          // The loop counter.
        var k;          // The member key.
        var v;          // The member value.
        var length;
        var mind = gap;
        var partial;
        var value = holder[key];

// If the value has a toJSON method, call it to obtain a replacement value.

        if (
            value
            && typeof value === "object"
            && typeof value.toJSON === "function"
        ) {
            value = value.toJSON(key);
        }

// If we were called with a replacer function, then call the replacer to
// obtain a replacement value.

        if (typeof rep === "function") {
            value = rep.call(holder, key, value);
        }

// What happens next depends on the value's type.

        switch (typeof value) {
        case "string":
            return quote(value);

        case "number":

// JSON numbers must be finite. Encode non-finite numbers as null.

            return (isFinite(value))
                ? String(value)
                : "null";

        case "boolean":
        case "null":

// If the value is a boolean or null, convert it to a string. Note:
// typeof null does not produce "null". The case is included here in
// the remote chance that this gets fixed someday.

            return String(value);

// If the type is "object", we might be dealing with an object or an array or
// null.

        case "object":

// Due to a specification blunder in ECMAScript, typeof null is "object",
// so watch out for that case.

            if (!value) {
                return "null";
            }

// Make an array to hold the partial results of stringifying this object value.

            gap += indent;
            partial = [];

// Is the value an array?

            if (Object.prototype.toString.apply(value) === "[object Array]") {

// The value is an array. Stringify every element. Use null as a placeholder
// for non-JSON values.

                length = value.length;
                for (i = 0; i < length; i += 1) {
                    partial[i] = str(i, value) || "null";
                }

// Join all of the elements together, separated with commas, and wrap them in
// brackets.

                v = partial.length === 0
                    ? "[]"
                    : gap
                        ? (
                            "[\n"
                            + gap
                            + partial.join(",\n" + gap)
                            + "\n"
                            + mind
                            + "]"
                        )
                        : "[" + partial.join(",") + "]";
                gap = mind;
                return v;
            }

// If the replacer is an array, use it to select the members to be stringified.

            if (rep && typeof rep === "object") {
                length = rep.length;
                for (i = 0; i < length; i += 1) {
                    if (typeof rep[i] === "string") {
                        k = rep[i];
                        v = str(k, value);
                        if (v) {
                            partial.push(quote(k) + (
                                (gap)
                                    ? ": "
                                    : ":"
                            ) + v);
                        }
                    }
                }
            } else {

// Otherwise, iterate through all of the keys in the object.

                for (k in value) {
                    if (Object.prototype.hasOwnProperty.call(value, k)) {
                        v = str(k, value);
                        if (v) {
                            partial.push(quote(k) + (
                                (gap)
                                    ? ": "
                                    : ":"
                            ) + v);
                        }
                    }
                }
            }

// Join all of the member texts together, separated with commas,
// and wrap them in braces.

            v = partial.length === 0
                ? "{}"
                : gap
                    ? "{\n" + gap + partial.join(",\n" + gap) + "\n" + mind + "}"
                    : "{" + partial.join(",") + "}";
            gap = mind;
            return v;
        }
    }

// If the JSON object does not yet have a stringify method, give it one.

    if (typeof JSON.stringify !== "function") {
        meta = {    // table of character substitutions
            "\b": "\\b",
            "\t": "\\t",
            "\n": "\\n",
            "\f": "\\f",
            "\r": "\\r",
            "\"": "\\\"",
            "\\": "\\\\"
        };
        JSON.stringify = function (value, replacer, space) {

// The stringify method takes a value and an optional replacer, and an optional
// space parameter, and returns a JSON text. The replacer can be a function
// that can replace values, or an array of strings that will select the keys.
// A default replacer method can be provided. Use of the space parameter can
// produce text that is more easily readable.

            var i;
            gap = "";
            indent = "";

// If the space parameter is a number, make an indent string containing that
// many spaces.

            if (typeof space === "number") {
                for (i = 0; i < space; i += 1) {
                    indent += " ";
                }

// If the space parameter is a string, it will be used as the indent string.

            } else if (typeof space === "string") {
                indent = space;
            }

// If there is a replacer, it must be a function or an array.
// Otherwise, throw an error.

            rep = replacer;
            if (replacer && typeof replacer !== "function" && (
                typeof replacer !== "object"
                || typeof replacer.length !== "number"
            )) {
                throw new Error("JSON.stringify");
            }

// Make a fake root object containing our value under the key of "".
// Return the result of stringifying the value.

            return str("", {"": value});
        };
    }


// If the JSON object does not yet have a parse method, give it one.

    if (typeof JSON.parse !== "function") {
        JSON.parse = function (text, reviver) {

// The parse method takes a text and an optional reviver function, and returns
// a JavaScript value if the text is a valid JSON text.

            var j;

            function walk(holder, key) {

// The walk method is used to recursively walk the resulting structure so
// that modifications can be made.

                var k;
                var v;
                var value = holder[key];
                if (value && typeof value === "object") {
                    for (k in value) {
                        if (Object.prototype.hasOwnProperty.call(value, k)) {
                            v = walk(value, k);
                            if (v !== undefined) {
                                value[k] = v;
                            } else {
                                delete value[k];
                            }
                        }
                    }
                }
                return reviver.call(holder, key, value);
            }


// Parsing happens in four stages. In the first stage, we replace certain
// Unicode characters with escape sequences. JavaScript handles many characters
// incorrectly, either silently deleting them, or treating them as line endings.

            text = String(text);
            rx_dangerous.lastIndex = 0;
            if (rx_dangerous.test(text)) {
                text = text.replace(rx_dangerous, function (a) {
                    return (
                        "\\u"
                        + ("0000" + a.charCodeAt(0).toString(16)).slice(-4)
                    );
                });
            }

// In the second stage, we run the text against regular expressions that look
// for non-JSON patterns. We are especially concerned with "()" and "new"
// because they can cause invocation, and "=" because it can cause mutation.
// But just to be safe, we want to reject all unexpected forms.

// We split the second stage into 4 regexp operations in order to work around
// crippling inefficiencies in IE's and Safari's regexp engines. First we
// replace the JSON backslash pairs with "@" (a non-JSON character). Second, we
// replace all simple value tokens with "]" characters. Third, we delete all
// open brackets that follow a colon or comma or that begin the text. Finally,
// we look to see that the remaining characters are only whitespace or "]" or
// "," or ":" or "{" or "}". If that is so, then the text is safe for eval.

            if (
                rx_one.test(
                    text
                        .replace(rx_two, "@")
                        .replace(rx_three, "]")
                        .replace(rx_four, "")
                )
            ) {

// In the third stage we use the eval function to compile the text into a
// JavaScript structure. The "{" operator is subject to a syntactic ambiguity
// in JavaScript: it can begin a block or an object literal. We wrap the text
// in parens to eliminate the ambiguity.

                j = eval("(" + text + ")");

// In the optional fourth stage, we recursively walk the new structure, passing
// each name/value pair to a reviver function for possible transformation.

                return (typeof reviver === "function")
                    ? walk({"": j}, "")
                    : j;
            }

// If the text is not JSON parseable, then a SyntaxError is thrown.

            throw new SyntaxError("JSON.parse");
        };
    }
}());
</script>
<?php
    /* 결제시 최소포인트 설정하는 로직. 20210129 추가
     */
     $sql = "SELECT p01 FROM g5_pointuse ";
     $p01= sql_fetch($sql);
?>
<script type="text/javascript">
  $("#coin-apply").on("click",function(){
    let val = $('#pointpay_str').val();  
    var checkNum = isNaN(val);
        
    switch(checkNum){
        case true:
            alert("잘못된 입력을 하셨습니다. 숫자로 입력해주세요.");  
            location.reload();
            break;
        case false:
            var amt =  parseInt($("#amt_str").html().replaceAll(",","") );
            var point_hold = parseInt($("#point_str").html().replaceAll(",","") );
            var point_hold2 = parseInt($("#point_str2").val());
            var point_use =  parseInt($("#pointpay_str").val() );
            var p01 = $("#p01").val();            
            var amt_result = parseInt(amt)-parseInt(point_use);
            var pa_point = $("input[name=MallReserved]").val();
           
            
            $("#point_str").html( number_format(point_hold2-point_use) );            
            $("#pay_str").html( number_format(amt_result) );            
            $("input[name=MallReserved]").val(pa_point+point_use);
            
            if(parseInt(point_hold) < parseInt(point_use)){
                alert("보유 코인보다 사용할 포인트가 많습니다.");
                location.reload();
            }
            if(parseInt(point_use) <  p01 ){
                alert("최소 "+p01+"코인 이상 사용해야합니다.");
                location.reload();
            }
            if ( !Number.isInteger((parseInt(point_use)/1000)) ){
                alert("1000원 단위로만 입력할 수 있습니다.");
                location.reload();
            }
            if ( amt < point_use ){
                alert("코인으로만 결제할 수 없습니다.");
                location.reload();
            }
            //부가가치세 10% 추가.
            var amt1 = amt_result + (amt_result / 10) ;
            $("input[name=Amt]").val(amt1);          
            break;
        default :
            alert("알수 없는 에러가 발생하였습니다. 숫자로 입력해주세요.");
            break;
    }      
  });
</script>
<script type="text/javascript">
  /*
   * 비회원 결제 스크립트
   */
    let non_remember_payment = {
        init:function(){
            console.log("init:function");
            $("#non_submit_btn").on("click",()=>{
                let check_result = this.check();
                switch(check_result){
                    case true:
//                        console.log("핸드폰값이 올바르니 입력할 값을 수정하고 버튼이벤트를 강제발생");
                        let no_hyphen_phone = $("input[name=order_hp]").val().replaceAll("-","");
                        let moid = $("input[name=Moid]").val();
                        $("input[name=Moid]").val(moid+no_hyphen_phone);

                        $.ajax({
                            type : "POST",
                            url : "<?php echo G5_URL; ?>/ajax_auth.php",
                            data : "chk_val="+$("input[name=coin_count]:checked").val(),
                            success : function(data){
                                //console.log(data);
                                is_auth = data;

                                if (is_auth == "NO2") {
                                    alert("해당 상품은 2번만 구매가 가능한 상품입니다.");
                                    return;
                                }
                                //alert(is_auth);return;
                                if ( $("#frm").find("input[name=PayMethod]:checked").val() == "CARS" ) {
                                    send();
                                }
                                else if ( $("#frm").find("input[name=PayMethod]:checked").val() == "무통장" ) {
                                    $("#frm").attr("action","./payment_bank_result.php");
                                    $(this).hide();
                                    $("#frm").submit();
                                }
                                else {
                                    $("#frm").attr("action","./payment_result.php");
                                    $(this).hide();
                                    goPay(document.frm);
                                }
                            },
                            error : function(data){
                                console.log(data);
                                //alert("통신에러");
                            }
                        });

                        break;
                    case false:
//                        console.log("핸드폰입력값이 올바르지 않으니 휴대전화입력칸을 포커싱한다");
                        alert("휴대폰번호를 입력해주세요.");
                        $("input[name=order_hp]").select();
                        break;
                }
            });            
        }
        ,
        check:function(){
//            console.log("check:function");
            let non_member_tel = $("input[name=order_hp]").val();
            const regExp = /^\d{3}-\d{3,4}-\d{4}$/;
            switch(regExp.test(non_member_tel)){
                case true:
                    return true;
                case false:
                    return false;
            }
        }
    }
    <?php if ( $member['mb_id'] == null ) {
        $member['mb_id'] = "no_member:01054676757";
        $sq = substr($member['mb_id'], 0, 9);
        ?>
        non_remember_payment.init();
        console.log("non_remember_payment.init()");
        console.log("<?=$sq?>");
    <?php }?>
</script>
<input type="hidden" value="<?=$p01['p01']?>" id="p01">
<?php
include_once(G5_PATH.'/tail.php');
?>
