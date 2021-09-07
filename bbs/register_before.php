<?php
include_once('./_common.php');

// 로그인중인 경우 회원가입 할 수 없습니다.
if ($is_member) {
    goto_url(G5_URL);
}


$g5['title'] = '회원가입';
include_once('./_head.php');

include_once($member_skin_path.'/register_before.skin.php');

include_once('./_tail.php');
?>
