<?php
$sub_menu = '100600';
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

check_admin_token();

for ($i=0; $i<count($_POST['mb_no']); $i++)
{
    $sql = "update {$g5['member_table']}
               set mb_use = '{$_POST['mb_use'][$i]}',
				   mb_hide = '{$_POST['mb_hide'][$i]}',
				   mb_type1 = '{$_POST['mb_type1'][$i]}',
                   mb_type2 = '{$_POST['mb_type2'][$i]}',
                   mb_type3 = '{$_POST['mb_type3'][$i]}',
                   mb_type4 = '{$_POST['mb_type4'][$i]}',
                   mb_type5 = '{$_POST['mb_type5'][$i]}',
				   mb_free5 = '{$_POST['mb_free5'][$i]}',
				   mb_free10 = '{$_POST['mb_free10'][$i]}'
             where mb_no = '{$_POST['mb_no'][$i]}' ";
    sql_query($sql);
}

//goto_url("./itemtypelist.php?sort1=$sort&amp;sort2=$sort2&amp;sel_ca_id=$sel_ca_id&amp;sel_field=$sel_field&amp;search=$search&amp;page=$page");
goto_url("itemtypelist.php?sca=$sca&amp;sst=$sst&amp;sod=$sod&amp;sfl=$sfl&amp;stx=$stx&amp;page=$page");
?>
