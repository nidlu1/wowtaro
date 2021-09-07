<?php
//include_once $_SERVER['DOCUMENT_ROOT']."/EmmaSMS/sms/xmlrpc.inc.php";
$sub_menu = "900700";
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
$g5['title'] = "SMS 문자 발송: &nbsp;-&nbsp;[".$point."]회 남음";

include_once(G5_ADMIN_PATH.'/admin.head.php');	?>
<script type="text/javascript">
    function smsByteChk(content)    {
        var temp_str = content.value;
        var remain = document.getElementById("sms_remain");
        remain.value = getByte(temp_str);
        //남은 바이트수를 표시 하기
        if(remain.value < 80){
//            alert(80 + "Bytes를 초과할 수 없습니다.");
//            while(remain.value < 0){
//                temp_str = temp_str.substring(0, temp_str.length-1);
//                content.value = temp_str;
//                remain.value = 80 - getByte(temp_str);
//            }
//            content.focus();
        }
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
    function selectAll(e){
        if($("#checkAll").is(":checked")){
//            console.log("체크");
            $("input[name='sms_to[]']").prop("checked",true);
        }else{
            $("input[name='sms_to[]']").prop("checked",false);
//            console.log("체크취소");
        }
        selectChk();
    }
    function selectChk(){
        var selectChk =  $("input[name='sms_to[]']:checked").length;
        $("#selectChk")[0].innerText = selectChk;
    }
    function selectChk2(e){
        const regexp1 = /^\d{2,3}\d{3,4}\d{4}$/;
        switch(regexp1.test(e)){
            case true :
                    var int = parseInt($("#selectChk")[0].innerText) + 1;
                    $("#selectChk")[0].innerText = int;
                    break;
            case false :
                    var int = parseInt($("#selectChk")[0].innerText) - 1;
                    $("#selectChk")[0].innerText = int;
                    break;
        }
        
    }
    function sendChk(e){
        console.log(e);
        switch(e){
            case "0":
                alert("문자 보낼 번호가 지정되지 않았습니다");
                return false;
            default :
                return true;
        }
    }
    
</script>
<style>
    .btn_submit{
        padding: 7px;
    }
    
</style>
<?php
/*
******************************************************
*************검색 관련 변수**********************
******************************************************
*/
$mb_level = filter_input(INPUT_POST, "sfl_1");
$sfl_2 = filter_input(INPUT_POST, "sfl_2");
$stx = filter_input(INPUT_POST, "stx");


prepare("select foo from baz where bar = :one");
$stmt->bindParam(":one", $myValue);
$stmt->execute();

$sql_common = " from {$g5['member_table']} ";
$sql_search = " where mb_hp<>'' ";

if(isset($stx)){
    $sql_search .= " and ( ";
    switch ($sfl_2){
        case "mb_hp" :
            $sql_search .= " {$sfl_2} like '%{$stx}%' ";
            break;
        case "" :
            break;
        default :
            $sql_search .= " {$sfl_2} like '{$stx}%' ";
            break;
    }
    $sql_search .= " ) ";
}
switch ($mb_level){
    case "all":
        break;
    case "":
        break;
    default :
        $sql_search .= " and mb_level='$mb_level' ";
        break;
}
$sql = "select mb_id, mb_nick, mb_name, mb_hp, mb_level {$sql_common} {$sql_search} ";
echo $sql;

?>
<div class="local_desc01 local_desc">
    <form method="post">
        <div>
            <h2 class="h2_frm">검색</h2>
            <label for="sfl_1" class="sound_only">회원구분</label>
            <p>회원구분:
                <input type="radio" checked name="sfl_1" value="all" <?= get_checked($_POST['sfl_1'], "all")?> >
                <label>전체</label>
                <input type="radio" name="sfl_1" value="2" <?= get_checked($_POST['sfl_1'], "2")?>>
                <label>일반회원</label>
                <input type="radio" name="sfl_1" value="3" <?= get_checked($_POST['sfl_1'], "3")?>>
                <label>상담사</label>
            </p>
<label for="sfl_2" class="sound_only">검색대상</label>
<select name="sfl_2" id="sfl_2">
    <option value="mb_id"<?= get_selected($_POST['sfl_2'], "mb_id"); ?>>회원아이디</option>
    <option value="mb_nick"<?= get_selected($_POST['sfl_2'], "mb_nick"); ?>>닉네임</option>
    <option value="mb_name"<?= get_selected($_POST['sfl_2'], "mb_name"); ?>>이름</option>
    <option value="mb_hp"<?= get_selected($_POST['sfl_2'], "mb_hp"); ?>>휴대폰번호</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?= $stx ?>" id="stx" class=" frm_input">
<input type="submit" class="btn_submit" value="검색" formaction="#">
        </div>
        <div>
        <?php $stmt = sql_query($sql); ?>
            <h2 class="h2_frm">검색대상: 총 <?= sql_num_rows($stmt)?>명&emsp;&emsp;&emsp;받는 사람: <span id="selectChk">0</span>명</h2>
            <span><input type="checkbox" onclick="selectAll(this)" id="checkAll">&emsp;전체선택</span>
<!--            ***********************************************************************
            ****************체크박스로 값넘기기************************
            ***********************************************************************-->
        <div style="height: 500px;overflow:scroll;background-color: white;">
            <table>
                <?php
                while($rs = sql_fetch_array($stmt)){
                    $rs['mb_hp']=preg_replace('/[^0-9]/','',$rs['mb_hp']);
                ?>
                <tr>
                    <td><input type="checkbox" value="<?=$rs['mb_hp']?>" name="sms_to[]" onclick="selectChk()"></td>
                    <td><?=$rs['mb_id']?></td>
                    <td><?=$rs['mb_nick']?></td>
                    <td><?=$rs['mb_name']?></td>
                    <td><?=$rs['mb_hp']?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        직접입력(1개만가능. -없이 작성): <input type='text' name='sms_to[]' onblur="selectChk2(this.value)">
        </div>
        
        <div>
            <h2 class="h2_frm">메시지 선택</h2>
            <?php
            $count = 1;
            $qry = sql_query("select * from {$g5['sms5_form_table']} where fg_no='2' or fg_no='1' order by fo_no desc");
            while ($res = sql_fetch_array($qry)){    
            ?>
            <textarea onClick="$('#sms_msg').val(this.value);" style="width:250px;height:200px;font-size:10pt;line-height:120%;" readonly><?php echo $res['fo_content']; ?></textarea>
            <?php
            }
            ?>
        </div>
        <div>
            <h2 class="h2_frm">메세지[<input type="text" readonly name="sms_remain" id="sms_remain" size="3" value="0" style="color:#000000;background-color:#f9f9f9;border:0px;text-align:right;font-weight:bold;"> Byte]</h2>
            <textarea id="sms_msg" name="sms_msg" style="width:250px;height:200px;font-size:11pt;line-height:120%;" required class="frm_input" onkeyup="smsByteChk(this);" onkeydown="smsByteChk(this);">Test</textarea>
        </div>
        <div>
            <h2 class="h2_frm">메시지 발송</h2>
            보내는 사람 번호: <input name="sms_from" value="1522-7229" class="frm_input" required> <!--주의) 기본 80 Byte가 1개의 문자메세지로 전송되며, 초과시 여러개로 나누어 발송됩니다.-->
            <input class="btn_submit" type="submit" value="보내기" formaction="sms_send_v1_send.php" onclick="return sendChk($('#selectChk')[0].innerText)">
        </div>
    </form>
</div>
<?php
    include_once G5_ADMIN_PATH.'/admin.tail.php';
?>