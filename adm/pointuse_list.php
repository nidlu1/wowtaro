<?php
$sub_menu = '400210';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '포인트획득관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');


$sql_common = " from g5_pointuse ";
$sql = " select * $sql_common ";

$result = sql_fetch($sql);

?>

<form action="pointuse_update.php">
<div class="btn_fixed_top">
        <input type="submit" value="수정" class="btn btn_01">
</div>
<div class="tbl_head01 tbl_wrap">
    <table style="width: 70%">
        <caption><?php echo $g5['title']; ?> 목록</caption>
        <thead>
        <tr>
            <th scope="col">종류</th>
            <th scope="col">적립 코인</th>
        </tr>
        </thead>
        <tbody>
        <tr class="<?php echo $bg; ?>">
            <td class="td_id"><?=$result['p01_subj']?></td>
            <td class="td_id"><input type="text" class="frm_input" name="p01" value="<?=$result['p01']?>"></td>
        </tr>
        <tr class="<?php echo $bg; ?>">
            <td class="td_id"><?=$result['p02_subj']?></td>
            <td class="td_id"><input type="text" class="frm_input" name="p02" value="<?=$result['p02']?>"></td>
        </tr>
        <tr class="<?php echo $bg; ?>">
            <td class="td_id"><?=$result['p03_subj']?></td>
            <td class="td_id"><input type="text" class="frm_input" name="p03" value="<?=$result['p03']?>"></td>
        </tr>
        <tr class="<?php echo $bg; ?>">
            <td class="td_id"><?=$result['p04_subj']?></td>
            <td class="td_id"><input type="text" class="frm_input" name="p04" value="<?=$result['p04']?>"></td>
        </tr>
        <tr class="<?php echo $bg; ?>">
            <td class="td_id"><?=$result['p05_subj']?></td>
            <td class="td_id"><input type="text" class="frm_input" name="p05" value="<?=$result['p05']?>"></td>
        </tr>
<!--        <tr class="<?php echo $bg; ?>">
            <td class="td_id"><?=$result['p06_subj']?></td>
            <td class="td_id"><input type="text" class="frm_input" name="p06" value="<?=$result['p06']?>"></td>
        </tr>-->
        <?php
        ?>
        </tbody>
        </table>
</div>
</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
