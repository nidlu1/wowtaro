<?php
$sub_menu = '100600';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '추천해시태그관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$sql_common = " from {$g5['recommhash_table']} ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = "select * $sql_common order by ht_no";// limit $from_record, {$config['cf_page_rows']} ";
$result = sql_query($sql);
?>

<div class="local_ov01 local_ov">
    <?php if ($page > 1) {?><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">처음으로</a><?php } ?>
    <span class="btn_ov01"><span class="ov_txt">전체 내용</span><span class="ov_num"> <?php echo $total_count; ?>건</span></span>
</div>

<div class="btn_fixed_top">
    <a href="./recommhashform.php" class="btn btn_01">내용 추가</a>
</div>

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">No</th>
		<!--th scope="col">고유코드</th-->
        <th scope="col">추천해시태그</th>
		<th scope="col">링크주소</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php for ($i=0; $row=sql_fetch_array($result); $i++) {
        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_id"><?php echo ($i+1); ?></td>
		<!--td class="td_id"><?php echo $row['ht_no']; ?></td-->
        <td class="td_left"><?php echo htmlspecialchars2($row['ht_name']); ?></td>
		<td class="td_left"><?php echo htmlspecialchars2($row['ht_link']); ?></td>
        <td class="td_mng td_mng_l">
            <a href="./recommhashform.php?w=u&amp;ht_no=<?php echo $row['ht_no']; ?>" class="btn btn_03"><span class="sound_only"><?php echo htmlspecialchars2($row['ht_name']); ?> </span>수정</a>
            <a href="./recommhashformupdate.php?w=d&amp;ht_no=<?php echo $row['ht_no']; ?>" onclick="return delete_confirm(this);" class="btn btn_02"><span class="sound_only"><?php echo htmlspecialchars2($row['ht_name']); ?> </span>삭제</a>
        </td>
    </tr>
    <?php
    }
    if ($i == 0) {
        echo '<tr><td colspan="4" class="empty_table">자료가 한건도 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
</div>

<?php //echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
