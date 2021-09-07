<?php
$sub_menu = "200210";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');
check_admin_token();

$p01 = $_REQUEST['p01'];
$p02 = $_REQUEST['p02'];
$p03 = $_REQUEST['p03'];
$p04 = $_REQUEST['p04'];
$p05 = $_REQUEST['p05'];
//$p06 = $_REQUEST['p06'];

$sql = "update g5_pointuse 
        set  p01 = $p01 ,
          p02 = $p02 ,
          p03 = $p03 ,
          p04 = $p04 ,
          p05 = $p05 
";
echo $sql;
sql_query($sql);
goto_url('./pointuse_list.php');
?>
