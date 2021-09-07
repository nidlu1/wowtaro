<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

if ($is_member) {
    alert("이미 로그인중입니다.");
}

$g5['title'] = '회원정보 찾기';
include_once(G5_PATH.'/head.sub.php');

if ( $hp ) {
	$sql = " select count(*) as cnt from {$g5['member_table']} where mb_hp = '$hp' ";
	$row = sql_fetch($sql);
	if ($row['cnt'] > 1)
		alert('동일한 메일주소가 2개 이상 존재합니다.\\n\\n관리자에게 문의하여 주십시오.');

	$sql = " select mb_no, mb_id, mb_name, mb_nick, mb_email, mb_datetime from {$g5['member_table']} where mb_hp = '$hp' ";
	$mb = sql_fetch($sql);
	if (!$mb['mb_id'])
		alert('존재하지 않는 회원입니다.');
	else if (is_admin($mb['mb_id']))
		alert('관리자 아이디는 접근 불가합니다.');
}

$action_url = G5_HTTPS_BBS_URL."/id_lost.php";
include_once($member_skin_path.'/id_lost.skin.php');

include_once(G5_PATH.'/tail.sub.php');
?>