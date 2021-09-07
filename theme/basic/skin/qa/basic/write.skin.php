<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/style.css">', 0);
?>

<div class="c_hero" id="sub_callcenter">
	<strong>신선운세 <mark>1:1고객문의</mark></strong>
</div>
<div class="c_list">
	<div class="cl_menu">
		<a href="<?php echo G5_URL; ?>"><i></i><span class="blind">HOME</span></a>
		<span>신선운세</span>
		<span>고객센터</span>
		<span><mark><a href="/bbs/qalist.php" class="sct_here">1:1고객문의</a></mark></span>
	</div>
</div>

<div class="c_area write">
	<div class="wrap">
		<section class="ca_board">
			<div class="cab_form">
				<h2 class="blind">1:1문의 작성</h2>
				<!-- 게시물 작성/수정 시작 { -->
				<form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
				<input type="hidden" name="w" value="<?php echo $w ?>">
				<input type="hidden" name="qa_id" value="<?php echo $qa_id ?>">
				<input type="hidden" name="sca" value="<?php echo $sca ?>">
				<input type="hidden" name="stx" value="<?php echo $stx ?>">
				<input type="hidden" name="page" value="<?php echo $page ?>">
				<?php
				$option = '';
				$option_hidden = '';
				$option = '';

				if ($is_dhtml_editor) {
					$option_hidden .= '<input type="hidden" name="qa_html" value="1">';
				} else {
					$option .= "\n".'<input type="checkbox" id="qa_html" name="qa_html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label for="qa_html">html</label>';
				}

				echo $option_hidden;
				?>
					<?php if ($category_option) { ?>
					<div class="cabf_wrap">
						<div class="cabf_title">
							<label class="text middle cb s05" for="qa_category">상담 분류<strong class="blind">필수</strong></label>
						</div>
						<div class="cabf_content t1">
							<select name="qa_category" id="qa_category" class="cabfc_select required" required >
								<option value="">분류를 선택하세요</option>
								<?php echo $category_option ?>
							</select>
							<i class="arrow"></i>
						</div>
					</div>
					<?php } ?>


					<?php if ($is_email) { ?>
					<div class="cabf_wrap w50p">
						<div class="cabf_title">
							<label class="text middle cb s05" for="qa_email">이메일</label>
						</div>
						<div class="cabf_content">
							<input type="text" name="qa_email" value="<?php echo get_text($write['qa_email']); ?>" id="qa_email" <?php echo $req_email; ?> class="<?php echo $req_email.' '; ?>frm_input full_input email" size="50" maxlength="100" placeholder="이메일">
							<div class="cabfc_btn t1">
								<input type="checkbox" class="cab_check" name="qa_email_recv" id="qa_email_recv" value="1" <?php if($write['qa_email_recv']) echo 'checked="checked"'; ?>>
								<i></i>
								<label for="qa_email_recv" class="frm_info">답변받기</label>
							</div>
						</div>
					</div>
					<?php } ?>

					<?php if ($is_hp) { ?>
					<div class="cabf_wrap w50p">
						<div class="cabf_title">
							<label class="text middle cb s05" for="qa_hp">휴대폰</label>
						</div>
						<div class="cabf_content">
							<input type="text" name="qa_hp" value="<?php echo get_text($write['qa_hp']); ?>" id="qa_hp" <?php echo $req_hp; ?> class="<?php echo $req_hp.' '; ?>frm_input full_input" size="30" placeholder="휴대폰">
							<div class="cabfc_btn t1">
								<?php if($qaconfig['qa_use_sms']) { ?>
								<input type="checkbox" class="cab_check" name="qa_sms_recv" id="qa_sms_recv" value="1" <?php if($write['qa_sms_recv']) echo 'checked="checked"'; ?>>
								<i></i>
								<label for="qa_sms_recv" class="frm_info">답변등록 SMS알림 수신</label>
								<?php } ?>
							</div>
						</div>
					</div>
					<?php } ?>

					<div class="cabf_wrap">
						<div class="cabf_title">
							<label class="text middle cb s05" for="qa_subject">제목<strong class="sound_only">필수</strong></label>
						</div>
						<div class="cabf_content">
							<input type="text" name="qa_subject" value="<?php echo get_text($write['qa_subject']); ?>" id="qa_subject" required class="frm_input full_input required" size="50" maxlength="255">
						</div>
					</div>
					<div class="cabf_wrap">
						<div class="cabf_title">
							<label class="text middle cb s05" for="qa_content">내용<strong class="sound_only">필수</strong></label>
						</div>
						<div class="cabf_content" <?php echo $is_dhtml_editor ? $config['cf_editor'] : ''; ?>">
							<?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
						</div>
					</div>
					<?php if ($option) { ?>
					<li>
						옵션
						<?php echo $option; ?>
					</li>
					<?php } ?>
					<div class="cabf_wrap">
						<div class="cabf_title">
							<label for="bf_file_1" class="lb_icon"><span class="text middle cb s05"> 첨부파일 #1</span></label>
						</div>
						<div class="cabf_content t1">
							<input type="file" name="bf_file[1]" id="bf_file_1" title="파일첨부 1 :  용량 <?php echo $upload_max_filesize; ?> 이하만 업로드 가능" class="frm_file">
						</div>
						<?php if($w == 'u' && $write['qa_file1']) { ?>
						<span class="file_del">
							<input type="checkbox" id="bf_file_del1" name="bf_file_del[1]" value="1"> <label for="bf_file_del1"><?php echo $write['qa_source1']; ?> 파일 삭제</label>
						</span>
						<?php } ?>
					</div>

					<div class="cabf_wrap">
						<div class="cabf_title">
							<label for="bf_file_2" class="lb_icon"><span class="text middle cb s05"> 첨부파일 #2</span></label>
						</div>
						<div class="cabf_content t1">
							<input type="file" name="bf_file[2]" id="bf_file_2" title="파일첨부 2 :  용량 <?php echo $upload_max_filesize; ?> 이하만 업로드 가능" class="frm_file">
						</div>
						<?php if($w == 'u' && $write['qa_file2']) { ?>
						<span class="file_del">
							<input type="checkbox" id="bf_file_del2" name="bf_file_del[2]" value="1"> <label for="bf_file_del2"><?php echo $write['qa_source2']; ?> 파일 삭제</label>
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="pg_buttons">
					<ul>
						<li><a href="<?php echo $list_href; ?>" class="btn">목록</a></li>
						<li><button type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn t1">등록</button></li>
					</ul>
				</div>
				</form>
			</div>
		</section>
</div><!--inner-->
    <script>
    function html_auto_br(obj)
    {
        if (obj.checked) {
            result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
            if (result)
                obj.value = "2";
            else
                obj.value = "1";
        }
        else
            obj.value = "";
    }

    function fwrite_submit(f)
    {
        <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

        var subject = "";
        var content = "";
        $.ajax({
            url: g5_bbs_url+"/ajax.filter.php",
            type: "POST",
            data: {
                "subject": f.qa_subject.value,
                "content": f.qa_content.value
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function(data, textStatus) {
                subject = data.subject;
                content = data.content;
            }
        });

        if (subject) {
            alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
            f.qa_subject.focus();
            return false;
        }

        if (content) {
            alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
            if (typeof(ed_qa_content) != "undefined")
                ed_qa_content.returnFalse();
            else
                f.qa_content.focus();
            return false;
        }

        <?php if ($is_hp) { ?>
        var hp = f.qa_hp.value.replace(/[0-9\-]/g, "");
        if(hp.length > 0) {
            alert("휴대폰번호는 숫자, - 으로만 입력해 주십시오.");
            return false;
        }
        <?php } ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }
    </script>

<!-- } 게시물 작성/수정 끝 -->
