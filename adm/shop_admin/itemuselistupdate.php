<?php
$sub_menu = '400650';
include_once('./_common.php');

check_demo();

check_admin_token();

if (!count($_POST['chk'])) {
    alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

if ($_POST['act_button'] == "선택수정") {
    auth_check($auth[$sub_menu], 'w');
} else if ($_POST['act_button'] == "선택삭제") {
    auth_check($auth[$sub_menu], 'd');
} else {
    alert("선택수정이나 선택삭제 작업이 아닙니다.");
}

for ($i=0; $i<count($_POST['chk']); $i++)
{
    $k = $_POST['chk'][$i]; // 실제 번호를 넘김

    if ($_POST['act_button'] == "선택수정")
    {
        $sql = "update {$g5['g5_shop_item_use_table']}
                   set is_score   = '{$_POST['is_score'][$k]}',
				       is_best    = '{$_POST['is_best'][$k]}',
                       is_confirm = '{$_POST['is_confirm'][$k]}'
                 where is_id      = '{$_POST['is_id'][$k]}' ";
        sql_query($sql);
        
    // 베스트 선정 포인트 부여 로직                 
        $sql_common = " from g5_pointuse ";
        $point_sql = " select * $sql_common ";
        $result = sql_fetch($point_sql);
            switch ($_POST['is_best'][$k]){
                case 0:
                    insert_point($_POST['mb_id'][$k], $result['p05']*(-1), "베스트 후기 선정 취소로 인한 코인 반환");
                    break;
                case 1:
                    insert_point($_POST['mb_id'][$k], $result['p05'], "베스트 후기 선정으로 인한 코인 부여");
                    break;
            }
    // 베스트 선정 포인트 부여 로직 끝 
        
    }
    else if ($_POST['act_button'] == "선택삭제")
    {
        $sql = "delete from {$g5['g5_shop_item_use_table']} where is_id = '{$_POST['is_id'][$k]}' ";
        sql_query($sql);
        
        //삭제시 포인트 반환                
        $sql_common = " from g5_pointuse ";
        $point_sql = " select * $sql_common ";
        $result = sql_fetch($point_sql);
        insert_point($_POST['mb_id'][$k], $result['p05']*(-1), "관리자 후기 삭제로 인한 코인 반환");
    }

    update_use_cnt($_POST['it_id'][$k]);
    update_use_avg($_POST['it_id'][$k]);
}

goto_url("./itemuselist.php?sca=$sca&amp;sst=$sst&amp;sod=$sod&amp;sfl=$sfl&amp;stx=$stx&amp;page=$page");
?>
