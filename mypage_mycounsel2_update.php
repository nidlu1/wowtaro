<?php
include_once('./_common.php');

$sql = "update {$g5['g5_shop_item_qa_table']}
		   set iq_answer = '$iq_answer'
		 where iq_id = '$iq_id' ";
sql_query($sql);

alert("답변이 등록되었습니다.","./mypage_mycounsel2.php");
?>