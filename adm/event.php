<?php
$sub_menu = '100320';
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');


$g5['title'] = '5분/10분무료 설정';
include_once('./admin.head.php');

if (isset($_POST['act_mode']) && $_POST['act_mode'] == "y") {
	//echo "UPDATE ".$g5['config_table']." SET cf_1='".$_POST['min']."'";
	sql_query("UPDATE ".$g5['config_table']." SET cf_1='".$_POST['min']."'");
}
if (isset($_POST['act_mode2']) && $_POST['act_mode2'] == "y") {
	sql_query("UPDATE ".$g5['config_table']." SET cf_2='".$_POST['eventcount']."'");
}
if (isset($_POST['act_mode3']) && $_POST['act_mode3'] == "y") {
    echo '<script>alert("수정되었습니다");</script>';
    $result = sql_query("SELECT * FROM g5_mungu");
    
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $mg_id = $i + 1;
        switch ($_POST['mg_YN_'.$mg_id]){
            case "Y": $mg_YN= "Y";
                break;
            default : $mg_YN= "N";
        }
        $mg_content= $_POST['mg_content_'.$mg_id];
        $sql = "update g5_mungu set mg_content = '$mg_content', mg_YN = '$mg_YN' where mg_id = $mg_id ";
        sql_query($sql);
    }
}

$config = sql_fetch(" select * from {$g5['config_table']} ");
//print_r($config);
?>

<section>
    <h2>5분/10분무료 설정</h2>
    <div class="local_desc02 local_desc">
        <p>
            5분/10분무료 중 선택하세요.
        </p>
    </div>
    <form name="fsendmailtest" method="post">
	<input type="hidden" name="act_mode" value="y">
    <fieldset id="fsendmailtest">
        <legend>5분/10분무료 설정</legend>
        <label for="min5">5분무료<strong class="sound_only"> 필수</strong></label>
        <input type="radio" name="min" value="5" id="min5" class="frm_input" <?php echo $config['cf_1'] == "5" || !$config['cf_1'] ? "checked" : ""; ?>>
		<label for="min10">10분무료<strong class="sound_only"> 필수</strong></label>
		<input type="radio" name="min" value="10" id="min10" class="frm_input" <?php echo $config['cf_1'] == "10" ? "checked" : ""; ?>>
        <input type="submit" value="설정" class="btn_submit">
    </fieldset>
    </form>
<!--    <div class="local_desc02 local_desc">
        <p>
            만약 [메일검사] 라는 내용으로 테스트 메일이 도착하지 않는다면 보내는 메일서버 혹은 받는 메일서버 중 문제가 발생했을 가능성이 있습니다.<br>
            따라서 보다 정확한 테스트를 원하신다면 여러 곳으로 테스트 메일을 발송하시기 바랍니다.<br>
        </p>
    </div>-->
</section>
<section>
    <h2>사용가능한 무료코인 횟수</h2>
    <div class="local_desc02 local_desc">
        <p>
            하루에 사용가능한 무료코인 수를 입력하세요.
        </p>
    </div>
    <form name="fsendmailtest" method="post">
	<input type="hidden" name="act_mode2" value="y">
    <fieldset id="fsendmailtest">
        <legend>무료코인 횟수 설정</legend>
        <label for="eventcount">무료코인 횟수 설정<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="eventcount" value="<?=$config['cf_2']?>" id="eventcount" class="frm_input">		
        <input type="submit" value="설정" class="btn_submit">
    </fieldset>
    </form>
</section>
<section>
    <h2>문구 설정</h2>
    <div class="local_desc02 local_desc">
        <p>
            5분 무료코인 신청시 작성할 문구선택
        </p>
    </div>
    <form name="fsendmailtest" method="post">
	<input type="hidden" name="act_mode3" value="y">
        <fieldset id="fsendmailtest">
            <legend>문구 선택</legend>
            <input type="submit" value="일괄적용" class="btn_submit" style="float: right;">
        <div class="tbl_head01 tbl_wrap">
            <table>
            <caption><?php echo $g5['title']; ?> 목록</caption>
            <thead>
            <tr>
                <th scope="col">번호</th>
                <th scope="col">문구</th>
                <th scope="col">사용여부</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $result = sql_query("SELECT * FROM g5_mungu");
            for ($i=0; $row=sql_fetch_array($result); $i++) {
                $bg = 'bg'.($i%2);

            ?>
            <tr class="<?php echo $bg; ?>">
                <td class="td_num"><?=$row['mg_id']; ?></td>
                <td class="td_left"><input type="text" size="80" name="mg_content_<?=$row['mg_id']; ?>" value="<?= $row['mg_content']; ?>" ></td>
                <td class="td_num">
                    <select name="mg_YN_<?=$row['mg_id']; ?>">
                        <option value="Y" <?php echo $row['mg_YN'] == "Y" ? "selected" : ""; ?>>사용</option>
                        <option value="N" <?php echo $row['mg_YN'] == "N" ? "selected" : ""; ?>>미사용</option>
                    </select>
                </td>
            </tr>
            <?php
            }
            if ($i == 0) {
                echo '<tr><td colspan="11" class="empty_table">자료가 한건도 없습니다.</td></tr>';
            }
            ?>
            </tbody>
            </table>
        </div>

        </fieldset>
    </form>
</section>


<?php
include_once('./admin.tail.php');
?>
