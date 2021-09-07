<?php
include_once("./_common.php");
include_once(G5_LIB_PATH."/register.lib.php");

$mb_recommend = trim($_POST["reg_mb_recommend"]);

if ($msg = valid_mb_email($mb_recommend)) {
    die("추천인의 아이디는 email 형식입니다.");
}
/*if ($msg = exist_mb_recommend($mb_recommend)) {
    die("이미 추천인으로 등록된 아이디입니다.");
}*/
if (!($msg = exist_mb_id($mb_recommend))) {
    die("입력하신 추천인은 존재하지 않는 아이디 입니다.");
}
if (!($msg = exist_mb_recommend2($mb_recommend))) {
    die("입력하신 추천인은 한번도 결제를 하지 않은 아이디입니다. 상담서비스를 결제한 아이디만 추천인 등록이 가능합니다.");
}
?>