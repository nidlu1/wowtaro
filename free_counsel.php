<?php
include_once('./_common.php');

if (!$is_member)
	alert('로그인 후 이용하여 주십시오.', G5_BBS_URL."/login.php?url=".G5_URL."/free_counsel.php");

if (G5_IS_MOBILE) {
include_once(G5_MOBILE_PATH.'/free_counsel.php');
return;
}


$g5['title'] =$config['cf_1'].'분무료상담';

include_once('./_head.php');

$arr_telnum = explode("-", $member['mb_hp']);
?>

<div class="c_hero">
		<strong>신선운세 <mark><?=$config['cf_1']?> 분무료상담</mark></strong>
</div>
<div class="c_list">
	<div class="cl_menu">
		<a href="<?php echo G5_URL; ?>"><i></i><span class="blind">HOME</span></a>
		<span>신선운세</span>
		<span><mark><a href="/free_counsel.php" class="sct_here"><?=$config['cf_1']?>분무료상담</a></mark></span>
	</div>
</div>
<div class="c_area counsel">
	<!-- 5분무료상담 폼 시작-->
	<div class="ca_event">
		<div class="cae_pic">
				<img src="/images/counsel/pic_event.jpg" alt="5분 코인 무료 이미지">
			</div>
		<div class="cae_form">
			<h3 class="blind">결제방법 선택<h3>
			<p class="caef_title">
				<?php
				$time = date('Y-m-d',time());
				$sqlcc = "select count(*)as cnt from ".$g5['g5_shop_order_table']." where is_free=1 and od_time BETWEEN '".date("Y-m-d")." 00:00:00' AND '".date("Y-m-d")." 23:59:59'";
				$recc = sql_fetch($sqlcc);
						echo "<span>오늘의 <mark>잔여 상담코인</mark> 수 <mark> <i>:</i> ".($config['cf_2']-$recc['cnt'])." / ".$config['cf_2']."</mark></span>";
				?>
			</p>
			<form id="freeform" name="freeform">
				<input type="hidden" name="mb_id" value="<?= $member['mb_id']?>">
				<input type="hidden" name="mb_name" value="<?= $member['mb_nick']?>"> 	
				<div class="caef_content">
					<div class="caefc_item">
						<label>
							선생님 선택
						</label>
						<select class="caefc_select" name="smb_id" id="smb_id">
							<option value="" selected>선생님을 선택해주세요</option>
						<?php
						$qry = "SELECT * FROM ".$g5['member_table']." WHERE mb_level='3' AND mb_free5='1' ORDER BY mb_nick ASC";
						$qres = sql_query($qry);
						while ( $qrow = sql_fetch_array($qres) ) {
							if ( $qrow['mb_status'] == 1 ) $stat = "상담중";
							else if ( $qrow['mb_status'] == 2 ) $stat = "상담가능";
							else $stat = "예약대기";
								echo "<option value='".$qrow['mb_no']."/".$qrow['mb_use']."'>".$qrow['mb_nick']." ".$qrow['mb_id']." (".$stat.")</option>";
						//echo "<option value='".$qrow['mb_id']."'>".$qrow['mb_nick']." ".$qrow['mb_id']." (".$stat.")</option>";
						}
						?>
						</select>
					</div>
					<!--2020.11.06 메세지 입력 기능 추가.
						작성자: 한승희: nidlu123@gmail.com
					-->
					<div class="caefc_item">
						<label for="">
							응원메세지 선택
						</label>
						<select class="caefc_select" name="smb_mungu" id="smb_mungu">
							<option value="" selected>메세지를 선택해주세요</option>
							<?php
							$result = sql_query("SELECT * FROM g5_mungu where mg_YN = 'Y'");
								for ($i=0; $row=sql_fetch_array($result); $i++) {
							?>
									<option value="<?=$row['mg_content']?>"><?=$row['mg_content']?></option>
							<?php
								}
							?>
							
						</select>
					</div>
					<div class="caefc_item">
						<label for="">전화번호</label>
						<input  type="num" name="mb_hp1" class="caefc_select t1" value="<?php echo $arr_telnum[0]; ?>" readOnly>
						<input type="num" name="mb_hp2" class="caefc_select t1" value="<?php echo $arr_telnum[1]; ?>" readOnly>
						<input type="num" name="mb_hp3" class="caefc_select t1" value="<?php echo $arr_telnum[2]; ?>" readOnly>
					</div>
				</div>
				<button type="button" id="submit_btn" name="button" class="caef_btn">무료상담 신청하기</button>
			</form>
		</div>
	<!-- 5분무료상담 폼 끝-->
	</div>
</div> <!--inner-->
<script type="text/javascript">
$(document).ready(function () {
	var mb_id = <?php echo $member['mb_id'] ? "true" : "false" ?>;

	$("#submit_btn").click(function() {
		if ( mb_id ) {
			// 무료상담 신청
			if ( $("#smb_id").val() == "" ) {
				alert ( "선생님을 선택해 주세요." );
				return;
			}
						if ( $("#smb_mungu").val() == "" ) {
				alert ( "메세지를 선택해 주세요." );
				return;
			}

			$.ajax({
				url:"<?php echo G5_URL; ?>/check_dup_free.php",
				data:{"od_hp":"<?php echo str_replace("-","",$member['mb_hp']); ?>"},
				type:"post",
				success:function(data){
//					console.log(data);
										alert("5분 무료 신청시 유의사항 반복으로 다른 번호이용시 요금이 부과 됩니다 \n(1인 1회사용 무료신청)");
					if(data ==="time"){
						alert("지금은 신청시간이 아닙니다.\n07시부터 24시까지 신청가능합니다.\n감사합니다.");
						return;
										}else if(data ==="over"){
						alert("오늘의 이벤트 신청이 모두 마감되었습니다\n내일 다시 신청해주세요\n감사합니다.");
						return;
					}else if(data ==="dup"){
						alert("이벤트는 한번만 참여가 가능합니다.");
						return;
					}else{
//						$("#freeform").attr("action", "<?php echo G5_URL; ?>/free_charge.php");
						//window.open('','pay_win','width=450 height=500 location=no resizable=no');
						//f.target="pay_win";
//						$("#freeform").submit();
					}
				}
			});
		}
		else {
			alert( "로그인 후 사용가능합니다." );
			return;
		}
	});
});
</script>
<?php
include_once(G5_PATH.'/tail.php');
?>
