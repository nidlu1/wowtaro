<?php
include_once('./_common.php');

$g5['title'] =  '5분무료상담';

include_once('./_head.php');

$arr_telnum = explode("-", $member['mb_hp']);
?>



<div class="sub_banner" id="sub_freecounsel">
  <h2>5분무료상담</h2>
</div>

<!-- <div class="sc_wrap free_counsel">
<div class="inner">
<div id="sct_location">
    <a href="/index.php" class="sct_bg"><i class="xi-home"></i></a>
    <a href="/free_conunsel.php" class="sct_here ">5분무료상담</a></div>
<div id="sct_hhtml"></div>

</div>
</div> -->

<div class="inner">
  <div class="banner_free information_use">
    <h3 class="banner_title"><b>5분</b> 무료 상담하기
      <!--   -->
    </h3>
    <div class="banner_free_content">


      <div class="banner_free_how">
        <h4>이벤트 참여방법</h4>

        <div class="banner_free_how_info clearfix">
          <div class="">
            <i></i>

            <p class="how_tit"><span class="num_style">1</span>신규회원가입</p>
            <span class="free_img">
              <i class="fas fa-mobile-alt"></i>
            </span>
            <p class="how_txt">휴대폰 본인인증 후 <br>신규 회원가입을 완료합니다.</p>
          </div>
          <div class="">
            <i></i>

            <p class="how_tit"><span class="num_style">2</span>5분 무료상담 신청</p>
            <span class="free_img">
              <i class="far fa-clock"></i>
            </span>
            <p class="how_txt">5분 무료상담 페이지에서<br>무료상담 신청하세요.</p>
          </div>
          <div class="">
            <i></i>

            <p class="how_tit"><span class="num_style">3</span>상담하기</p>
            <span class="free_img">
              <i class="fas fa-phone-volume"></i>
            </span>
            <p class="how_txt">1661-3439로 전화걸어<br>원하는 선생님과 상담하세요.</p>
          </div>
        </div>

        <div class="information_use_banner">
          <p>
            <span class="num_style">1</span>
            회원가입 시, <b>휴대폰 본인확인이 필요</b>합니다.
          </p>
          <p>
            <span class="num_style">2</span>
            본 이벤트는 상담시간 5분에 해당하는 <b>코인을 충전해드리는 이벤트</b> 입니다.
          </p>
          <p>
            <span class="num_style">3</span>
            잔여 상담시간은 로그인 후, <b>홈페이지 하단에 표기</b>되어있습니다.
          </p>
          <p>
            <span class="num_style">4</span>
            지급받은 코인(상담시간)은 타로, 사주, 꿈해몽 등 <b>신선운세 내에서 자유롭게 이용 가능</b>합니다.
          </p>
          <p>
            <span class="num_style">5</span>
            본 코인은 <b>최초 회원가입 시, 1회만 지급</b>합니다.
          </p>

          <div class="sub_text_wrap">
            <span class="sub_text">
              * 본 이벤트는 선착순으로 <!--하루 <?=$config['cf_2']?>명에게만 --> 지급되는 이벤트이며, 잔여수량은 5분무료상담 신청페이지에서 확인가능합니다.
            </span>
            <span class="sub_text">
              ( 5분 무료건이 모두 소진되었을 경우, 다음날 신청 가능합니다. )
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 5분무료상담 폼 시작-->
  <div class="form_free">
    <h3>결제방법 선택</h3>
    <p class="chance">
		<?php
		$time = date('Y-m-d',time());
		$sqlcc = "select count(*)as cnt from ".$g5['g5_shop_order_table']." where is_free=1 and od_time BETWEEN '".date("Y-m-d")." 00:00:00' AND '".date("Y-m-d")." 23:59:59'";
		$recc = sql_fetch($sqlcc);
		echo "오늘의 잔여 상담권 수 : ".($config['cf_2']-$recc['cnt'])."/".$config['cf_2'];
		?>
	</p>

    <form id="freeform" name="freeform" class="">
        <input type="hidden" name="mb_id" value="<?= $member['mb_id']?>">
        <input type="hidden" name="mb_name" value="<?= $member['mb_nick']?>">  
        
      <div class="from_free_area">
        <div class="from_free_01">
          <label for="">
            선생님 선택
          </label>
          <select class="" name="smb_id" id="smb_id">
            <option value="" selected>선생님을 선택해주세요</option>
<?php
$qry = "SELECT * FROM ".$g5['member_table']." WHERE mb_level='3' AND mb_free5='1' ORDER BY mb_nick ASC";
$qres = sql_query($qry);
while ( $qrow = sql_fetch_array($qres) ) {
	if ( $qrow['mb_status'] == 1 ) $stat = "상담중";
	else if ( $qrow['mb_status'] == 2 ) $stat = "상담가능";
	else $stat = "예약대기";
        echo "<option value='".$qrow['mb_no']."/".$qrow['mb_use']."'>".$qrow['mb_nick']." ".$qrow['mb_id']." (".$stat.")</option>";
//        echo "<option value='".$qrow['mb_id']."'>".$qrow['mb_nick']." ".$qrow['mb_id']." (".$stat.")</option>";
}
?>
          </select>
        </div>

          <!--2020.11.06 메세지 입력 기능 추가.
            작성자: 한승희: nidlu123@gmail.com
          -->
        <div class="from_free_02">
            <label for="">
                응원메세지 선택
            </label>
            <select class="" name="smb_mungu" id="smb_mungu">
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

        <div class="from_free_02">
          <label for="">전화번호</label><!--
          --><input type="num" name="mb_hp1" value="<?php echo $arr_telnum[0]; ?>" readOnly><!--
          --><span class="bar"></span><!--
          --><input type="num" name="mb_hp2" value="<?php echo $arr_telnum[1]; ?>" readOnly><!--
          --><span class="bar"></span><!--
          --><input type="num" name="mb_hp3" value="<?php echo $arr_telnum[2]; ?>" readOnly>
        </div>
      </div>

      <button type="button" id="submit_btn" name="button">무료상담 신청하기</button>
    </form>
  </div>
  <!-- 5분무료상담 폼 끝-->

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
					console.log(data);
					if(data == "over"){
						alert("오늘의 이벤트 신청이 모두 마감되었습니다\n내일 다시 신청해주세요\n감사합니다.");
						return;
					}else if(data == "dup"){
						alert("이벤트는 한번만 참여가 가능합니다.");
						return;
					}else{
						$("#freeform").attr("action", "<?php echo G5_URL; ?>/free_charge.php");
						//window.open('','pay_win','width=450 height=500 location=no resizable=no');
						//f.target="pay_win";
						$("#freeform").submit();
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
