<?php
$sub_menu = '400710';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '해시태그관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

if (isset($_POST['act_mode3']) && $_POST['act_mode3'] == "y") {
    echo '<script>alert("수정되었습니다");</script>';
    $sql = "SELECT * FROM g5_hashtag_v1";
    $result = sql_query($sql);
    
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $mg_id = $i + 1;
        switch ($_POST['mg_YN_'.$mg_id]){
            case "Y": $mg_YN= "Y";
                break;
            default : $mg_YN= "N";
        }
        $mg_hashtag = $_POST['mg_hashtag_'.$mg_id];
        $sql = "update g5_hashtag_v1 set mg_hashtag = '$mg_hashtag', mg_YN = '$mg_YN' where mg_id = $mg_id ";
        sql_query($sql);
//        echo $sql.'<br>';
    }
}

$sql = "SELECT * FROM g5_hashtag_v1";
$result = sql_query($sql);
?>

   <form name="fsendmailtest" method="post">
	<input type="hidden" name="act_mode3" value="y">
        <fieldset id="fsendmailtest">
            <legend>해시태그</legend>
            <input type="submit" value="일괄적용" class="btn_submit" style="float: right;">
        <div class="tbl_head01 tbl_wrap">
            <table>
            <caption><?php echo $g5['title']; ?> 목록</caption>
            <thead>
            <tr>
                <th scope="col">번호</th>
                <th scope="col">해시태그</th>
                <th scope="col" style="width: 80px;">사용여부</th>
            </tr>
            </thead>
            <tbody>
            <?php

            for ($i=0; $row=sql_fetch_array($result); $i++) {
                $bg = 'bg'.($i%2);

            ?>
            <tr class="<?php echo $bg; ?>">
                <td class="td_num"><?=$row['mg_id']; ?></td>
                <td class="td_left"><input style="font-size: 16px;" type="text" size="80" name="mg_hashtag_<?=$row['mg_id']; ?>" value="<?= $row['mg_hashtag']; ?>" ></td>
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
<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
