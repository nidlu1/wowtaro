<?php
//include_once $_SERVER['DOCUMENT_ROOT']."/EmmaSMS/sms/xmlrpc.inc.php";
$sub_menu = "900100";
include_once("./_common.php");

include G5_PATH."/class.http.php";
include_once G5_PATH."/class.EmmaSMS.php";
$sms_id = "wowunse";
//$sms_passwd = "qwe690769**";
$sms_passwd = "kim341034**";

$sms_from = "1522-7229";
$sms_date = $_POST['sms_date'];
$sms_msg = $_POST['sms_msg'];
$sms_type = "L";    // 설정 하지 않는다면 80byte 넘는 메시지는 쪼개져서 sms로 발송, L 로 설정하면 80byte 넘으면 자동으로 lms 변환

/*if(substr($sms_to,0,1)==',') $sms_to=substr($sms_to,1,strlen($sms_to));
if(substr($sms_to,(strlen($sms_to)-1),1)==',') $sms_to=substr($sms_to,0,(strlen($sms_to)-1));*/

$sms = new EmmaSMS();
$sms->login($sms_id, $sms_passwd);
$point = $sms->point();

auth_check($auth[$sub_menu], "r");

$g5['title'] = "SMS 문자보내기&nbsp;-&nbsp;[".$point."]포인트 남음";

include_once(G5_ADMIN_PATH.'/admin.head.php');	?>
<script type="text/javascript">
    function smsByteChk(content)    {
        var temp_str = content.value;
        var remain = document.getElementById("sms_remain");
        remain.value = getByte(temp_str);
        //남은 바이트수를 표시 하기
        /*if(remain.value < 80){
            alert(80 + "Bytes를 초과할 수 없습니다.");
            while(remain.value < 0){
                temp_str = temp_str.substring(0, temp_str.length-1);
                content.value = temp_str;
                remain.value = 80 - getByte(temp_str);
            }
            content.focus();
        }*/
    }
 
    function getByte(str){
        var resultSize = 0;
        if(str == null){
            return 0;
        }
        for(var i=0; i<str.length; i++){
            var c = escape(str.charAt(i));
            if(c.length == 1){	//기본 아스키코드
                resultSize ++;
            }else if(c.indexOf("%u") != -1){	//한글 혹은 기타
                resultSize += 2;
            }else{
                resultSize ++;
            }
        }         
        return resultSize;
    }
</script>

<div class="local_desc01 local_desc">
	<form method="post">
		<table>
		<colgroup>
			<col class="grid_3">
			<col>
		</colgroup>
		<tbody>


		<tr>
			<th scope="row">메시지</th>
			<td>
			    <?php
				$count = 1;
				$qry = sql_query("select * from {$g5['sms5_form_table']} where fg_no='2' order by fo_no desc");
				for($i=0;$res = sql_fetch_array($qry);$i++) {
				?>
				<textarea onClick="$('#sms_msg').val(this.value);" style="width:130px;height:150px;font-size:10pt;line-height:120%;" readonly><?php echo $res['fo_content']; ?></textarea>
				<?php
				}
				?>
			
			
			</td>
		</tr>

	<?php if($_SERVER['REQUEST_METHOD'] == "POST") {
		for($i = 0; $i<sizeof($sms_to); $i++){
			if($sms_to[$i]!=''){
				sql_query("insert into sms5_write2 set wr_renum=0, wr_hp='".$sms_to[$i]."', wr_reply='1522-7229', wr_message='$sms_msg', wr_success='1', wr_failure='0', wr_memo='', wr_booking='0000-00-00 00:00:00', wr_total='1', wr_datetime='".G5_TIME_YMDHIS."'");
				$ret = $sms->send($sms_to[$i], "1522-7229", $sms_msg, $sms_date, $sms_type);
				echo "<tr height='35'><td colspan='2'>&nbsp;&nbsp;&nbsp;";
				if($ret){
					print_r($ret);
					echo " : ".$sms_to[$i]."<br>";
				}else{
					echo $sms->errMsg;
					echo " : ".$sms_to[$i]."<br>";
				}
				echo "</td></tr>";
			}
		}
		echo "<tr><td colspan='2' align='center'><br><br>전송이 모두 완료되었습니다. <input type='button' value='확 인' onclick='location.replace(\"sms_send.php\");' style='cursor:pointer;padding:7px;background-color:red;color:#ffffff;border:1px solid red;'><br><br></td></tr>";

	}else{?>
		<tr>
			<th scope="row">메시지<div>[<input type="text" readonly name="sms_remain" id="sms_remain" size="3" value="0" style="color:#000000;background-color:#f9f9f9;border:0px;text-align:right;font-weight:bold;"> Byte]</div></th>
			<td><textarea id="sms_msg" name="sms_msg" style="width:150px;height:150px;font-size:14pt;line-height:120%;" required class="frm_input" onkeyup="smsByteChk(this);" onkeydown="smsByteChk(this);"></textarea></td><?//placeholder="주의) 기본 80 Byte가 1개의 문자메세지로 전송되며, 초과시 여러개로 나누어 발송됩니다."//?>
		</tr>
		<tr>
			<th style="line-height:200%;">받는사람 번호<div>
			<!--<select name='level' class="frm_input" onchange="location.href='config.php?level='+this.value;">
				<option value=''>모두선택</option>
				<option value='5'<?if($level=='5') echo ' selected';?>>맨토</option>
				<option value='2'<?if($level=='2') echo ' selected';?>>맨티</option>
			</select>-->
			</div>
			<div>총 
			<?php



			//해당쿼리로 바뀌어야 할듯 /선생님별 중복 번호 제거 하기 위함  ( 대기 )
			//$sql = "select * from g5_board ";
			//$sql.=" where gr_id='tarot' and bo_4_subj<>'' group by bo_4_subj";


			$sql = "select * from ".$g5['member_table']."";
			$sql.=" where mb_level='3' and mb_hp<>''";
			$stmt = sql_query($sql);
			$row=sql_num_rows($stmt);
			echo $row;?>명</div></th>
			<td><select name = "sms_to[]" class="frm_input" multiple style="height:300px;" required>
			<?php while($rs = sql_fetch_array($stmt)){
				$rs['mb_hp']=preg_replace('/[^0-9]/','',$rs['mb_hp']);
				if($rs['mb_hp']!=''){
					echo "<option value=".$rs['mb_hp'].">"; echo $rs['mb_hp']." [".$rs['mb_nick']."]"; 
				}
			}?></td>
		</tr>
		<tr>
			<th>보내는 사람 번호</th>
			<td><input name="sms_from" value="1522-7229" class="frm_input" required> <!--주의) 기본 80 Byte가 1개의 문자메세지로 전송되며, 초과시 여러개로 나누어 발송됩니다.--></td>
		</tr>
		<tr style="display:none;">
			<th>예약시간</th>
			<td>
			<!-- 예약시에는 20070614180000 (년월일시분초) 형태로 넣어주세요. -->
			<select name="sms_date" class="frm_input">
			<option value="">즉시발송
			<!--<option value="20070614180000">2007년 06월 14일 18시-->
			</select>
			</td>
		</tr>
		<tr>
			<td colspan="2" align='center' height="50"><input class="btn_submit" type="submit" value="보내기" style="padding:7px;"></td>
		</tr>
	<?php }?>
		</tbody>
		</table>
	</form>
</div>
<?php include_once(G5_ADMIN_PATH.'/admin.tail.php');	?>