<?php
$sub_menu = '100700';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '결제상품관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$sql_common = " from {$g5['pay_table']} ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = "select * $sql_common order by pa_no limit $from_record, {$config['cf_page_rows']} ";
$result = sql_query($sql);
?>

<div class="local_ov01 local_ov">
    <?php if ($page > 1) {?><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">처음으로</a><?php } ?>
    <span class="btn_ov01"><span class="ov_txt">전체 내용</span><span class="ov_num"> <?php echo $total_count; ?>건</span></span>
</div>

<div class="btn_fixed_top">
    <a href="./payform.php" class="btn btn_01">내용 추가</a>
</div>

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">문구</th>
        <th scope="col">결제금액(원)</th>
        <th scope="col">상담시간(분)</th>
        <th scope="col">적립코인</th>
        <th scope="col">결재상품 사용여부</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php for ($i=0; $row=sql_fetch_array($result); $i++) {
        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_id"><?php echo $row['pa_no']; ?></td>
        <td class="td_id"><?php echo $row['pa_mungu']; ?></td>
        <td class="td_left"><?php echo number_format($row['pa_amt']); ?></td>
        <td class="td_left"><?php echo ($row['pa_time'] / 60); ?></td>
        <td class="td_left"><?php echo ($row['pa_point']); ?></td>
        <td class="td_left"><?php echo $row['pa_use'] == 1 ? "사용" : "미사용"; ?></td>
        <td class="td_mng td_mng_l">
            <a href="./payform.php?w=u&amp;pa_no=<?php echo $row['pa_no']; ?>" class="btn btn_03"><span class="sound_only">수정 </span>수정</a>
            <a href="./payformupdate.php?w=d&amp;pa_no=<?php echo $row['pa_no']; ?>" onclick="return delete_confirm(this);" class="btn btn_02"><span class="sound_only">삭제 </span>삭제</a>
        </td>
    </tr>
    <?php
    }
    if ($i == 0) {
        echo '<tr><td colspan="5" class="empty_table">자료가 한건도 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
</div>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
