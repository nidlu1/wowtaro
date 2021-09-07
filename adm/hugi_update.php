<?php
$sub_menu = "200210";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');
check_admin_token();

$content1 = $_REQUEST['content1'];

$sql = "update from g5_hugi 
        set  content1 = '$content1'
";
echo $sql;
//sql_query($sql);
//goto_url('./hugi.php');
?>
