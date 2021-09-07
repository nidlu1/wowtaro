<?php
$sub_menu = '400660';
include_once('./_common.php');

check_demo();

check_admin_token();

if (!count($_POST['chk'])) {
    alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

if ($_POST['act_button'] == "선택삭제") {

    auth_check($auth[$sub_menu], 'd');

    for ($i=0; $i<count($_POST['chk']); $i++) {
        // 실제 번호를 넘김
        $k = $_POST['chk'][$i];

        $sql = "delete from {$g5['g5_shop_item_qa_table']} where iq_id = '{$_POST['iq_id'][$k]}' ";
        sql_query($sql);
    }
	$msg = "삭제 되었습니다.";
}
else if ($_POST['act_button'] == "1대1문의이동") {

    auth_check($auth[$sub_menu], 'd');

    for ($i=0; $i<count($_POST['chk']); $i++) {
        // 실제 번호를 넘김
        $k = $_POST['chk'][$i];

        $sql = "select * from ".$g5['g5_shop_item_qa_table']." a JOIN ".$g5['member_table']." b ON a.mb_id=b.mb_id where a.iq_id = '{$_POST['iq_id'][$k]}' ";
		$arr = sql_fetch($sql);
                echo 'qa불러오기'.$sql."<br>";
		$row = sql_fetch(" select MIN(qa_num) as min_qa_num from {$g5['qa_content_table']} ");
        $qa_num = $row['min_qa_num'] - 1;

		$sql = " insert into {$g5['qa_content_table']}
					set qa_num          = '".$qa_num."',
						mb_id           = '".$arr['mb_id']."',
						qa_name         = '".addslashes($arr['mb_nick'])."',
						qa_email        = '".$arr['mb_email']."',
						qa_hp           = '".$arr['mb_hp']."',
						qa_type         = '0',
						qa_parent       = '0',
						qa_related      = '0',
						qa_category     = '상담관련',
						qa_email_recv   = '0',
						qa_sms_recv     = '0',
						qa_html         = '0',
						qa_subject      = '".$arr['iq_subject']."',
						qa_content      = '".$arr['iq_question']."',
						qa_status       = '0',
						qa_ip           = '".$arr['iq_ip']."',
						qa_datetime     = '".$arr['iq_time']."' ";
		sql_query($sql);
                echo 'qa입력'.$sql."<br>";
		$qa_id = sql_insert_id();
		$qa_related = $qa_id;

        $sql = " update {$g5['qa_content_table']}
                    set qa_parent   = '$qa_id',
                        qa_related  = '$qa_related'
                    where qa_id = '$qa_id' ";
        sql_query($sql);
        echo 'qaid'.$sql."<br>";
		// 답변이 있으면 답변도 등록
		if ( $arr['iq_answer'] != "" ) {

			$sql = " insert into {$g5['qa_content_table']}
						set qa_num          = '".$qa_num."',
							mb_id           = 'admin',
							qa_name         = '신선운세',
							qa_email        = '',
							qa_hp           = '',
							qa_type         = '1',
							qa_parent       = '".$qa_id."',
							qa_related      = '".$qa_related."',
							qa_category     = '상담관련',
							qa_email_recv   = '0',
							qa_sms_recv     = '0',
							qa_html         = '1',
							qa_subject      = '".$arr['iq_subject']."',
							qa_content      = '".$arr['iq_answer']."',
							qa_status       = '1',
							qa_ip           = '".$arr['iq_ip']."',
							qa_datetime     = '".$arr['iq_time']."' ";
			sql_query($sql);

			$sql = " update {$g5['qa_content_table']}
						set qa_status   = '1'
						where qa_id = '$qa_id' ";
			sql_query($sql);
                    
		}
        // 지우지 말고 이동되었다고 글내용 변경하기.
//        $sql = "delete from {$g5['g5_shop_item_qa_table']} where iq_id = '{$_POST['iq_id'][$k]}' ";
        $sql = "update {$g5['g5_shop_item_qa_table']}
                set iq_subject = '1대1 문의 게시판으로 이동되었습니다.' ,
                    iq_question = '<a href= /bbs/qalist.php>확인하기 (Click!)</a>'
                where iq_id = '{$_POST['iq_id'][$k]}' ";        
        echo $sql."<br>";
        sql_query($sql);

		$msg = "1:1문의로 게시글이 이동 되었습니다.";
    }
}

alert($msg, "./itemqalist.php?sca=$sca&amp;sst=$sst&amp;sod=$sod&amp;sfl=$sfl&amp;stx=$stx&amp;page=$page");
?>
