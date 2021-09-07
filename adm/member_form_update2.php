<?php
$sub_menu = "200110";
include_once("./_common.php");
include_once(G5_LIB_PATH."/register.lib.php");
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

if ($w == 'u')
    check_demo();

auth_check($auth[$sub_menu], 'w');

check_admin_token();

$mb_no = trim($_POST['mb_no']);
$mb_id = trim($_POST['mb_id']);

// 휴대폰번호 체크
$mb_hp = hyphen_hp_number($_POST['mb_hp']);
if($mb_hp) {
    //$result = exist_mb_hp($mb_hp, $mb_id);
    //if ($result)
        //alert($result);
}

// 인증정보처리
if($_POST['mb_certify_case'] && $_POST['mb_certify']) {
    $mb_certify = $_POST['mb_certify_case'];
    $mb_adult = $_POST['mb_adult'];
} else {
    $mb_certify = '';
    $mb_adult = 0;
}

$mb_zip1 = substr($_POST['mb_zip'], 0, 3);
$mb_zip2 = substr($_POST['mb_zip'], 3);

$mb_email = isset($_POST['mb_email']) ? get_email_address(trim($_POST['mb_email'])) : '';
$mb_nick = isset($_POST['mb_nick']) ? trim(strip_tags($_POST['mb_nick'])) : '';

if ($msg = valid_mb_nick($mb_nick))     alert($msg, "", true, true);

$mb_con_time_cnt = !$mb_con_time_cnt ? 0 : $mb_con_time_cnt;
$mb_con_hour = !$mb_con_hour ? 0 : $mb_con_hour;
$mb_con_min = !$mb_con_min ? 0 : $mb_con_min;
$mb_con_sec = !$mb_con_sec ? 0 : $mb_con_sec;
$mb_con_time = $mb_con_hour.":".$mb_con_min.":".$mb_con_sec;

$mb_con_time2_cnt = !$mb_con_time2_cnt ? 0 : $mb_con_time2_cnt;
$mb_con_hour2 = !$mb_con_hour2 ? 0 : $mb_con_hour2;
$mb_con_min2 = !$mb_con_min2 ? 0 : $mb_con_min2;
$mb_con_sec2 = !$mb_con_sec2 ? 0 : $mb_con_sec2;
$mb_con_time2 = $mb_con_hour2.":".$mb_con_min2.":".$mb_con_sec2;

$sql_common = "  mb_name = '{$_POST['mb_name']}',
                 mb_nick = '{$mb_nick}',
                 mb_email = '{$mb_email}',
                 mb_homepage = '{$_POST['mb_homepage']}',
                 mb_tel = '{$_POST['mb_tel']}',
                 mb_hp = '{$mb_hp}',
                 mb_certify = '{$mb_certify}',
                 mb_adult = '{$mb_adult}',
                 mb_zip1 = '$mb_zip1',
                 mb_zip2 = '$mb_zip2',
                 mb_addr1 = '{$_POST['mb_addr1']}',
                 mb_addr2 = '{$_POST['mb_addr2']}',
                 mb_addr3 = '{$_POST['mb_addr3']}',
                 mb_addr_jibeon = '{$_POST['mb_addr_jibeon']}',
                 mb_signature = '{$_POST['mb_signature']}',
                 mb_leave_date = '{$_POST['mb_leave_date']}',
                 mb_intercept_date='{$_POST['mb_intercept_date']}',
                 mb_memo = '{$_POST['mb_memo']}',
                 mb_mailling = '{$_POST['mb_mailling']}',
                 mb_sms = '{$_POST['mb_sms']}',
                 mb_open = '{$_POST['mb_open']}',
                 mb_profile = '{$_POST['mb_profile']}',
                 mb_level = '{$_POST['mb_level']}',
				 mb_gubun = '{$_POST['mb_gubun']}',
				 mb_con_time_cnt = '{$mb_con_time_cnt}',
                 mb_con_time2_cnt = '{$mb_con_time2_cnt}',
                 mb_con_time = '{$mb_con_time}',
				 mb_con_time2 = '{$mb_con_time2}',
				 mb_con_mon = '{$mb_con_mon}',
				 mb_cal_money = '{$mb_cal_money}',
				 mb_miss = '{$mb_miss}',
				 mb_miss2 = '{$mb_miss2}',
				 mb_lock = '{$mb_lock}',
                 mb_1 = '".implode(",",$_POST['mb_1'])."',
                 mb_2 = '".implode(",",$_POST['mb_2'])."',
                 mb_9 = '{$_POST['mb_9']}',
                 mb_10 = '{$_POST['mb_10']}' ";

if ( $_POST['mb_status'] != 2 ) {
	$sql_common .= " ,mb_status = '{$_POST['mb_status']}'";
}

// 파일업로드 처리
$image_regex = "/(\.(gif|jpe?g|png))$/i";
$upload_dir = G5_DATA_PATH.'/temp/';
if( !is_dir($upload_dir) ){
	@mkdir($upload_dir, G5_DIR_PERMISSION);
	@chmod($upload_dir, G5_DIR_PERMISSION);
}
$upload_dir .= $mb_no;

$sub_sql = NULL;
$sub_sql[] = file_up_func ( "mb_3", $image_regex, $upload_dir, $mb_no );
$sub_sql[] = file_up_func ( "mb_4", $image_regex, $upload_dir, $mb_no );
$sub_sql[] = file_up_func ( "mb_5", $image_regex, $upload_dir, $mb_no );
$sub_sql[] = file_up_func ( "mb_6", $image_regex, $upload_dir, $mb_no );
$sub_sql[] = file_up_func ( "mb_7", $image_regex, $upload_dir, $mb_no );
$sub_sql[] = file_up_func ( "mb_8", $image_regex, $upload_dir, $mb_no );
$sub_sql = array_filter(array_map('trim',$sub_sql));

if ( count($sub_sql) > 0 ) {
	$sql_common .= " , ".implode(" , ", $sub_sql);
}


if ($w == '')
{
    $mb = get_member($mb_id);
    if ($mb['mb_id'])
        alert('이미 존재하는 회원아이디입니다.\\nＩＤ : '.$mb['mb_id'].'\\n이름 : '.$mb['mb_name'].'\\n닉네임 : '.$mb['mb_nick'].'\\n메일 : '.$mb['mb_email']);

    // 닉네임중복체크
    $sql = " select mb_id, mb_name, mb_nick, mb_email from {$g5['member_table']} where mb_nick = '{$mb_nick}' ";
    $row = sql_fetch($sql);
    if ($row['mb_id'])
        alert('이미 존재하는 닉네임입니다.\\nＩＤ : '.$row['mb_id'].'\\n이름 : '.$row['mb_name'].'\\n닉네임 : '.$row['mb_nick'].'\\n메일 : '.$row['mb_email']);

    // 이메일중복체크
    $sql = " select mb_id, mb_name, mb_nick, mb_email from {$g5['member_table']} where mb_email = '{$mb_email}' ";
    $row = sql_fetch($sql);
    if ($row['mb_id'])
        alert('이미 존재하는 이메일입니다.\\nＩＤ : '.$row['mb_id'].'\\n이름 : '.$row['mb_name'].'\\n닉네임 : '.$row['mb_nick'].'\\n메일 : '.$row['mb_email']);

    sql_query(" insert into {$g5['member_table']} set mb_id = '{$mb_id}', mb_password = '".get_encrypt_string($mb_password)."', mb_datetime = '".G5_TIME_YMDHIS."', mb_ip = '{$_SERVER['REMOTE_ADDR']}', mb_email_certify = '".G5_TIME_YMDHIS."', {$sql_common} ");

	$str_mb_id = $mb_id;
}
else if ($w == 'u')
{
    $mb = get_member($mb_id);
    if (!$mb['mb_id'])
        alert('존재하지 않는 회원자료입니다.');

    if ($is_admin != 'super' && $mb['mb_level'] >= $member['mb_level'])
        alert('자신보다 권한이 높거나 같은 회원은 수정할 수 없습니다.');

    if ($is_admin !== 'super' && is_admin($mb['mb_id']) === 'super' ) {
        alert('최고관리자의 비밀번호를 수정할수 없습니다.');
    }

    if ($_POST['mb_id'] == $member['mb_id'] && $_POST['mb_level'] != $mb['mb_level'])
        alert($mb['mb_id'].' : 로그인 중인 관리자 레벨은 수정 할 수 없습니다.');

    // 닉네임중복체크
    $sql = " select mb_id, mb_name, mb_nick, mb_email from {$g5['member_table']} where mb_nick = '{$mb_nick}' and mb_id <> '$mb_id' ";
    $row = sql_fetch($sql);
    if ($row['mb_id'])
        alert('이미 존재하는 닉네임입니다.\\nＩＤ : '.$row['mb_id'].'\\n이름 : '.$row['mb_name'].'\\n닉네임 : '.$row['mb_nick'].'\\n메일 : '.$row['mb_email']);

    // 이메일중복체크
    $sql = " select mb_id, mb_name, mb_nick, mb_email from {$g5['member_table']} where mb_email = '{$mb_email}' and mb_id <> '$mb_id' ";
    $row = sql_fetch($sql);
    if ($row['mb_id'])
        alert('이미 존재하는 이메일입니다.\\nＩＤ : '.$row['mb_id'].'\\n이름 : '.$row['mb_name'].'\\n닉네임 : '.$row['mb_nick'].'\\n메일 : '.$row['mb_email']);

    $mb_dir = substr($mb_id,0,2);

    // 회원 아이콘 삭제
    if ($del_mb_icon)
        @unlink(G5_DATA_PATH.'/member/'.$mb_dir.'/'.$mb_id.'.gif');

    // 주민등록증사진 삭제
    if ($del_mb_3) {
        @unlink(G5_DATA_PATH.'/temp/'.$mb['mb_no'].'/'.$mb['mb_3']);
		$sql_common .= " ,mb_3=''";
	}

    // 주민등록증사진 삭제
    if ($del_mb_4) {
        @unlink(G5_DATA_PATH.'/temp/'.$mb['mb_no'].'/'.$mb['mb_4']);
		$sql_common .= " ,mb_4=''";
	}

    // 주민등록증사진 삭제
    if ($del_mb_5) {
        @unlink(G5_DATA_PATH.'/temp/'.$mb['mb_no'].'/'.$mb['mb_5']);
		$sql_common .= " ,mb_5=''";
	}

    // 주민등록증사진 삭제
    if ($del_mb_6) {
        @unlink(G5_DATA_PATH.'/temp/'.$mb['mb_no'].'/'.$mb['mb_6']);
		$sql_common .= " ,mb_6=''";
	}

    // 주민등록증사진 삭제
    if ($del_mb_7) {
        @unlink(G5_DATA_PATH.'/temp/'.$mb['mb_no'].'/'.$mb['mb_7']);
		$sql_common .= " ,mb_7=''";
	}

    // 주민등록증사진 삭제
    if ($del_mb_8) {
        @unlink(G5_DATA_PATH.'/temp/'.$mb['mb_no'].'/'.$mb['mb_8']);
		$sql_common .= " ,mb_8=''";
	}

    $image_regex = "/(\.(gif|jpe?g|png))$/i";
    $mb_icon_img = $mb_id.'.gif';

    // 아이콘 업로드
    if (isset($_FILES['mb_icon']) && is_uploaded_file($_FILES['mb_icon']['tmp_name'])) {
        if (!preg_match($image_regex, $_FILES['mb_icon']['name'])) {
            alert($_FILES['mb_icon']['name'] . '은(는) 이미지 파일이 아닙니다.');
        }

        if (preg_match($image_regex, $_FILES['mb_icon']['name'])) {
            $mb_icon_dir = G5_DATA_PATH.'/member/'.$mb_dir;
            @mkdir($mb_icon_dir, G5_DIR_PERMISSION);
            @chmod($mb_icon_dir, G5_DIR_PERMISSION);

            $dest_path = $mb_icon_dir.'/'.$mb_icon_img;

            move_uploaded_file($_FILES['mb_icon']['tmp_name'], $dest_path);
            chmod($dest_path, G5_FILE_PERMISSION);
            
            if (file_exists($dest_path)) {
                $size = @getimagesize($dest_path);
                if ($size[0] > $config['cf_member_icon_width'] || $size[1] > $config['cf_member_icon_height']) {
                    $thumb = null;
                    if($size[2] === 2 || $size[2] === 3) {
                        //jpg 또는 png 파일 적용
                        $thumb = thumbnail($mb_icon_img, $mb_icon_dir, $mb_icon_dir, $config['cf_member_icon_width'], $config['cf_member_icon_height'], true, true);
                        if($thumb) {
                            @unlink($dest_path);
                            rename($mb_icon_dir.'/'.$thumb, $dest_path);
                        }
                    }
                    if( !$thumb ){
                        // 아이콘의 폭 또는 높이가 설정값 보다 크다면 이미 업로드 된 아이콘 삭제
                        @unlink($dest_path);
                    }
                }
            }
        }
    }
    
    $mb_img_dir = G5_DATA_PATH.'/member_image/';
    if( !is_dir($mb_img_dir) ){
        @mkdir($mb_img_dir, G5_DIR_PERMISSION);
        @chmod($mb_img_dir, G5_DIR_PERMISSION);
    }
    $mb_img_dir .= substr($mb_id,0,2);

    // 회원 이미지 삭제
    if ($del_mb_img)
        @unlink($mb_img_dir.'/'.$mb_icon_img);

    // 아이콘 업로드
    if (isset($_FILES['mb_img']) && is_uploaded_file($_FILES['mb_img']['tmp_name'])) {
        if (!preg_match($image_regex, $_FILES['mb_img']['name'])) {
            alert($_FILES['mb_img']['name'] . '은(는) 이미지 파일이 아닙니다.');
        }
        
        if (preg_match($image_regex, $_FILES['mb_img']['name'])) {
            @mkdir($mb_img_dir, G5_DIR_PERMISSION);
            @chmod($mb_img_dir, G5_DIR_PERMISSION);
            
            $dest_path = $mb_img_dir.'/'.$mb_icon_img;
            
            move_uploaded_file($_FILES['mb_img']['tmp_name'], $dest_path);
            chmod($dest_path, G5_FILE_PERMISSION);

            if (file_exists($dest_path)) {
                $size = @getimagesize($dest_path);
                if ($size[0] > $config['cf_member_img_width'] || $size[1] > $config['cf_member_img_height']) {
                    $thumb = null;
                    if($size[2] === 2 || $size[2] === 3) {
                        //jpg 또는 png 파일 적용
                        $thumb = thumbnail($mb_icon_img, $mb_img_dir, $mb_img_dir, $config['cf_member_img_width'], $config['cf_member_img_height'], true, true);
                        if($thumb) {
                            @unlink($dest_path);
                            rename($mb_img_dir.'/'.$thumb, $dest_path);
                        }
                    }
                    if( !$thumb ){
                        // 아이콘의 폭 또는 높이가 설정값 보다 크다면 이미 업로드 된 아이콘 삭제
                        @unlink($dest_path);
                    }
                }
            }
        }
    }

    if ($mb_password)
        $sql_password = " , mb_password = '".get_encrypt_string($mb_password)."' ";
    else
        $sql_password = "";

    if ($passive_certify)
        $sql_certify = " , mb_email_certify = '".G5_TIME_YMDHIS."' ";
    else
        $sql_certify = "";

    $sql = " update {$g5['member_table']}
                set mb_id='".$_POST['mb_id2']."',
					{$sql_common}
                     {$sql_password}
                     {$sql_certify}
                where mb_no = '".$mb['mb_no']."' ";
    sql_query($sql);

	$str_mb_id = $_POST['mb_id2'];
}
else
    alert('제대로 된 값이 넘어오지 않았습니다.');

//goto_url('./member_form.php?'.$qstr.'&amp;w=u&amp;mb_id='.$str_mb_id, false);
goto_url('./member_list2.php', false);
?>