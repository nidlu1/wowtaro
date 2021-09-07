<?php
include_once('./_common.php');

//if (!$is_member)
//	alert('로그인 후 이용하여 주십시오.', G5_BBS_URL."/login.php?url=".G5_URL."/payment.php");


$g5['title'] =  '코인충전';

include_once(G5_PATH.'/head.php');

$moid = date("YmdHis")."S".str_replace("-","",$member['mb_hp']);

$sql = "SELECT * FROM ".$g5['pay_table']." WHERE pa_use='1' order by pa_no ";
$result = sql_query($sql);
?>
<div class="sub_banner" id="sub_coin">
	<h2>결제완료</h2>
</div>
<div class="inner content_inner">
	<div class="coin_sub_title end">
		<h3>결제완료 되었습니다.</h3>
		<a href="/">메인으로 이동</a>
	</div>
</div>
<?php
include_once(G5_PATH.'/tail.php');
?>