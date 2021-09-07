<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가

    
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css">', 0);
?>
<div class="c_hero" id="sub_callcenter">
	<strong>신선운세 <mark>이벤트 의뢰 신청</mark></strong>
</div>
<div class="c_list">
	<div class="cl_menu">
		<a href="<?php echo G5_URL; ?>"><i></i><span class="blind">HOME</span></a>
		<span>신선운세</span>
		<span><mark><a href="/bbs/write.php?bo_table=event_form" class="sct_here ">이벤트 의뢰 신청</a></mark></span>
	</div>
</div>
<div class="c_area">
	<div class="ca_top">
		<div class="cat_pic">
			<img src="/images/eventform/pic_top.jpg" alt="이미지">
		</div>
	</div>
	<div class="ca_event">
		<div class="wrap small">
			<div class="cae_wrap">
				<strong class="cae_title">캐리커쳐 행사</strong>
				<div class="cae_content">
					<div class="slide_type4 owl-carousel">
						<div class="item">
							<div class="caec_pic" style="background-image:url('../images/eventform/pic_chari01.jpg');">
								<img src="/images/eventform/pic_chari01.jpg" alt="캐리커쳐 이미지">
							</div>
							<img src="/images/ratio_4x3.png">
						</div>
						<div class="item">
							<div class="caec_pic" style="background-image:url('../images/eventform/pic_chari02.jpg');">
								<img src="/images/eventform/pic_chari02.jpg" alt="">
							</div>
							<img src="/images/ratio_4x3.png">
						</div>
						<div class="item">
							<div class="caec_pic" style="background-image:url('../images/eventform/pic_chari03.jpg');">
								<img src="/images/eventform/pic_chari03.jpg" alt="">
							</div>
							<img src="/images/ratio_4x3.png">
						</div>
						<div class="item">
							<div class="caec_pic" style="background-image:url('../images/eventform/pic_chari04.jpg');">
								<img src="/images/eventform/pic_chari04.jpg" alt="">
							</div>
							<img src="/images/ratio_4x3.png">
						</div>
						<div class="item">
							<div class="caec_pic" style="background-image:url('../images/eventform/pic_chari05.jpg');">
								<img src="/images/eventform/pic_chari05.jpg" alt="">
							</div>
							<img src="/images/ratio_4x3.png">
						</div>
						<div class="item">
							<div class="caec_pic" style="background-image:url('../images/eventform/pic_chari06.jpg');">
								<img src="/images/eventform/pic_chari06.jpg" alt="">
							</div>
							<img src="/images/ratio_4x3.png">
						</div>
					</div>
				</div>
			</div>
			<div class="cae_wrap">
				<strong class="cae_title">펫타로 이벤트 행사</strong>
				<div class="cae_content t1">
					<div class="slide_type4 owl-carousel">
						<div class="item">
							<div class="caec_pic" style="background-image:url('../images/eventform/pic_pet01.jpg');">
								<img src="/images/eventform/pic_pet01.jpg" alt="캐리커쳐 이미지">
							</div>
							<img src="/images/ratio_4x3.png">
						</div>
						<div class="item">
							<div class="caec_pic" style="background-image:url('../images/eventform/pic_pet02.jpg');">
								<img src="/images/eventform/pic_pet02.jpg" alt="">
							</div>
							<img src="/images/ratio_4x3.png">
						</div>
						<div class="item">
							<div class="caec_pic" style="background-image:url('../images/eventform/pic_pet03.jpg');">
								<img src="/images/eventform/pic_pet03.jpg" alt="">
							</div>
							<img src="/images/ratio_4x3.png">
						</div>
						<div class="item">
							<div class="caec_pic" style="background-image:url('../images/eventform/pic_pet04.jpg');">
								<img src="/images/eventform/pic_pet04.jpg" alt="">
							</div>
							<img src="/images/ratio_4x3.png">
						</div>
						<div class="item">
							<div class="caec_pic" style="background-image:url('../images/eventform/pic_pet05.jpg');">
								<img src="/images/eventform/pic_pet05.jpg" alt="">
							</div>
							<img src="/images/ratio_4x3.png">
						</div>
						<div class="item">
							<div class="caec_pic" style="background-image:url('../images/eventform/pic_pet06.jpg');">
								<img src="/images/eventform/pic_pet06.jpg" alt="">
							</div>
							<img src="/images/ratio_4x3.png">
						</div>
					</div>
				</div>
			</div>
			<div class="cae_wrap">
				<strong class="cae_title">타로 이벤트 행사</strong>
				<div class="cae_content">
					<div class="slide_type4 owl-carousel">
						<div class="item">
							<div class="caec_pic" style="background-image:url('../images/eventform/pic_taro01.jpg');">
								<img src="/images/eventform/pic_taro01.jpg" alt="캐리커쳐 이미지">
							</div>
							<img src="/images/ratio_4x3.png">
						</div>
						<div class="item">
							<div class="caec_pic" style="background-image:url('../images/eventform/pic_taro02.jpg');">
								<img src="/images/eventform/pic_taro02.jpg" alt="">
							</div>
							<img src="/images/ratio_4x3.png">
						</div>
						<div class="item">
							<div class="caec_pic" style="background-image:url('../images/eventform/pic_taro03.jpg');">
								<img src="/images/eventform/pic_taro03.jpg" alt="">
							</div>
							<img src="/images/ratio_4x3.png">
						</div>
						<div class="item">
							<div class="caec_pic" style="background-image:url('../images/eventform/pic_taro04.jpg');">
								<img src="/images/eventform/pic_taro04.jpg" alt="">
							</div>
							<img src="/images/ratio_4x3.png">
						</div>
						<div class="item">
							<div class="caec_pic" style="background-image:url('../images/eventform/pic_taro05.jpg');">
								<img src="/images/eventform/pic_taro05.jpg" alt="">
							</div>
							<img src="/images/ratio_4x3.png">
						</div>
						<div class="item">
							<div class="caec_pic" style="background-image:url('../images/eventform/pic_taro06.jpg');">
								<img src="/images/eventform/pic_taro06.jpg" alt="">
							</div>
							<img src="/images/ratio_4x3.png">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="wrap small">
		<h2 class="sound_only"><?php echo $g5['title'] ?></h2>
		<!-- 게시물 작성/수정 시작 { -->
		<form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" style="width:<?php echo $width; ?>">
			<input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
			<input type="hidden" name="w" value="<?php echo $w ?>">
			<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
			<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
			<input type="hidden" name="sca" value="<?php echo $sca ?>">
			<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
			<input type="hidden" name="stx" value="<?php echo $stx ?>">
			<input type="hidden" name="spt" value="<?php echo $spt ?>">
			<input type="hidden" name="sst" value="<?php echo $sst ?>">
			<input type="hidden" name="sod" value="<?php echo $sod ?>">
			<input type="hidden" name="page" value="<?php echo $page ?>">
			<input type="hidden" name="wr_name" value="<?php echo $name ? $name : $member['mb_name'] ?>">
			<?php
			$option = '';
			$option_hidden = '';
			if ($is_notice || $is_html || $is_secret || $is_mail) {
				$option = '';
				// if ($is_notice) {
				//     $option .= "\n".'<input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>'."\n".'<label for="notice">공지</label>';
				// }

				if ($is_html) {
					if ($is_dhtml_editor) {
						$option_hidden .= '<input type="hidden" value="html1" name="html">';
					} else {
						$option .= "\n" . '<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="' . $html_value . '" ' . $html_checked . '>' . "\n" . '<label for="html">HTML</label>';
					}
				}

				if ($is_secret) {
					if ($is_admin || $is_secret == 1) {
						$option .= "\n" . '<input type="checkbox" id="secret" name="secret" value="secret" ' . $secret_checked . '>' . "\n" . '<label for="secret">비밀글</label>';
					} else {
						$option_hidden .= '<input type="hidden" name="secret" value="secret">';
					}
				}

				if ($is_mail) {
					$option .= "\n" . '<input type="checkbox" id="mail" name="mail" value="mail" ' . $recv_email_checked . '>' . "\n" . '<label for="mail">답변메일받기</label>';
				}
			}

			echo $option_hidden;
			?>

			<!-- <div class="bo_w_info write_div">
			<?php if ($is_name) { ?>
					<label for="wr_name" class="sound_only">이름<strong>필수</strong></label>
					<input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="frm_input required" placeholder="이름">
			<?php } ?>
		
			<?php if ($is_password) { ?>
					<label for="wr_password" class="sound_only">비밀번호<strong>필수</strong></label>
					<input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="frm_input <?php echo $password_required ?>" placeholder="비밀번호">
			<?php } ?>
		
			<?php if ($is_email) { ?>
						<label for="wr_email" class="sound_only">이메일</label>
						<input type="text" name="wr_email" value="<?php echo $email ?>" id="wr_email" class="frm_input email " placeholder="이메일">
			<?php } ?>
			</div>
		
			<?php if ($is_homepage) { ?>
							<div class="write_div">
								<label for="wr_homepage" class="sound_only">홈페이지</label>
								<input type="text" name="wr_homepage" value="<?php echo $homepage ?>" id="wr_homepage" class="frm_input full_input" size="50" placeholder="홈페이지">
							</div>
						<?php } ?>
					
						<?php if ($option) { ?>
							<div class="write_div">
								<span class="sound_only">옵션</span>
							<?php echo $option ?>
							</div>
			<?php } ?> -->

						<!-- <div class="bo_w_tit write_div">
							<label for="wr_subject" class="sound_only">제목<strong>필수</strong></label>
					
							<div id="autosave_wrapper write_div">
								<input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="frm_input full_input required" size="50" maxlength="255" placeholder="제목">
						<?php if ($is_member) { // 임시 저장된 글 기능 ?>
									<script src="<?php echo G5_JS_URL; ?>/autosave.js"></script>
				<?php if ($editor_content_js) echo $editor_content_js; ?>
									<button type="button" id="btn_autosave" class="btn_frmline">임시 저장된 글 (<span id="autosave_count"><?php echo $autosave_count; ?></span>)</button>
									<div id="autosave_pop">
										<strong>임시 저장된 글 목록</strong>
										<ul></ul>
										<div><button type="button" class="autosave_close">닫기</button></div>
									</div>
			<?php } ?>
							</div>
						</div> -->

			<!--이벤트 모집 폼 시작-->
			<div class="ca_form mt50">
				<div class="from_wrap t1 mb50">
					<div class="caf_title">
						<strong>타로와 캐리커쳐를 동시에 진행할 수 있는 이벤트 행사</strong>
					</div>
					<div class="caf_item">
						<label for="" class="form_label">선생님경력</label>
						<input type="text"  placeholder="10년이상"  readonly class="caf_input w100p" ">
					</div>
					<div class="caf_item">
						<label for="" class="form_label">선생님인원</label>
						<div class="caf_wrap">
							<span class="mr5">남자</span>
							<i class="arrow"></i>
							<select class="caf_select t1 required" name="wr_5" required>
								<?php
								for ($i = 0; $i <= 30; $i++) {
									?>
									<option value="<?php echo $i; ?>" <?php echo $i == $write['wr_5'] ? "selected" : ""; ?>><?php echo $i; ?></option>
									<?php
								}
								?>
							</select>
							<span>명</span>
						</div>
						<div class="caf_wrap">
							<span class="mr5">여자</span>
							<i class="arrow"></i>
							<select class="caf_select t1 required" name="wr_6" required>
								<?php
								for ($i = 0; $i <= 30; $i++) {
									?>
									<option value="<?php echo $i; ?>" <?php echo $i == $write['wr_6'] ? "selected" : ""; ?>><?php echo $i; ?></option>
									<?php
								}
								?>
							</select>
							<span>명</span>
						</div>
					</div>
					<div class="caf_item t1">
						<label for="" class="form_label">기간</label>
						<input type="text" name="wr_3" value="<?php echo $write['wr_3']; ?>" class="caf_select t1 date_after required" id="datepicker1" placeholder="날짜선택" required>
						<span class="caf_txt">~</span>
						<input type="text" name="wr_4" value="<?php echo $write['wr_4']; ?>" class="caf_select t1 required"  id="datepicker2" placeholder="날짜선택" required>
					</div>
					<div class="caf_item">
						<label for="" class="form_label">지역선택</label>
						<div class="select_wrap">
							<i class="arrow t1"></i>
							<select class="caf_select t1 required" name="wr_2" id="wr_2" required>
								<option value="">선택</option>
								<option value="서울" <?php echo $write['wr_2'] == "서울" ? "selected" : ""; ?>>서울</option>
								<option value="경기" <?php echo $write['wr_2'] == "경기" ? "selected" : ""; ?>>경기</option>
								<option value="인천" <?php echo $write['wr_2'] == "인천" ? "selected" : ""; ?>>인천</option>
								<option value="충북" <?php echo $write['wr_2'] == "충북" ? "selected" : ""; ?>>충북</option>
								<option value="충남" <?php echo $write['wr_2'] == "충남" ? "selected" : ""; ?>>충남</option>
								<option value="전북" <?php echo $write['wr_2'] == "전북" ? "selected" : ""; ?>>전북</option>
								<option value="전남" <?php echo $write['wr_2'] == "전남" ? "selected" : ""; ?>>전남</option>
								<option value="경북" <?php echo $write['wr_2'] == "경북" ? "selected" : ""; ?>>경북</option>
								<option value="경남" <?php echo $write['wr_2'] == "경남" ? "selected" : ""; ?>>경남</option>
								<option value="강원" <?php echo $write['wr_2'] == "강원" ? "selected" : ""; ?>>강원</option>
								<option value="제주" <?php echo $write['wr_2'] == "제주" ? "selected" : ""; ?>>제주</option>
							</select>
						</div>
					</div>
					<div class="caf_item">
						<label for="" class="form_label">회사명</label>
						<input type="text" name="wr_subject" id="wr_subject" value="<?php echo $subject ?>" class="caf_input w100p required" placeholder="회사명을 입력하세요." required>
					</div>
					<div class="caf_item">
						<label for="" class="form_label">연락처</label>
						<input type="tel" name="wr_1" id="wr_1" value="<?php echo $write['wr_1']; ?>" class="caf_input w100p required" placeholder="연락받으실 연락처를 입력하세요." required>
					</div>
					<div class="caf_item">
						<label for="" class="form_label">이메일</label>
						<input type="email" name="wr_email" id="wr_email" value="<?php echo $email ?>" class="caf_input w100p required" placeholder="연락받으실 이메일을 입력하세요" required>
					</div>
					<div class="caf_item">
						<label for="" class="form_label">추가사항</label>
						<div class="write_div">
							<label for="caf_textarea" class="sound_only">내용<strong>필수</strong></label>
							<textarea id="wr_content" name="wr_content" class="caf_textarea required" style="Height:170px;" placeholder="추가사항을 입력하세요." required></textarea>
								<!--<div class="caf_textareawrap <?php echo $is_dhtml_editor ? $config['cf_editor'] : ''; ?>">
								<?php if ($write_min || $write_max) { ?>
												<p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
																<?php } ?>
									<?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출  ?>
																		<?php if ($write_min || $write_max) { ?>
																			<div id="char_count_wrap"><span id="char_count"></span>글자</div>
									<?php } ?>
									</div>
									-->
						</div>
					</div>


						<!--이벤트 모집 폼 끝-->

						<!-- <?php for ($i = 1; $is_link && $i <= G5_LINK_COUNT; $i++) { ?>
							<div class="bo_w_link write_div">
								<label for="wr_link<?php echo $i ?>"><i class="fa fa-link" aria-hidden="true"></i><span class="sound_only"> 링크  #<?php echo $i ?></span></label>
								<input type="text" name="wr_link<?php echo $i ?>" value="<?php if ($w == "u") {
							echo$write['wr_link' . $i];
						} ?>" id="wr_link<?php echo $i ?>" class="frm_input full_input" size="50">
							</div>
						<?php } ?>
								
						<?php for ($i = 0; $is_file && $i < $file_count; $i++) { ?>
										<div class="bo_w_flie write_div">
											<div class="file_wr write_div">
												<label for="bf_file_<?php echo $i + 1 ?>" class="lb_icon"><i class="fa fa-download" aria-hidden="true"></i><span class="sound_only"> 파일 #<?php echo $i + 1 ?></span></label>
												<input type="file" name="bf_file[]" id="bf_file_<?php echo $i + 1 ?>" title="파일첨부 <?php echo $i + 1 ?> : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file ">
											</div>
										<?php if ($is_file_content) { ?>
												<input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="full_input frm_input" size="50" placeholder="파일 설명을 입력해주세요.">
							<?php } ?>
									
										<?php if ($w == 'u' && $file[$i]['file']) { ?>
												<span class="file_del">
													<input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i; ?>]" value="1"> <label for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'] . '(' . $file[$i]['size'] . ')'; ?> 파일 삭제</label>
												</span>
							<?php } ?>
									
										</div>
									<?php } ?>
								
								
									<?php if ($is_use_captcha) { //자동등록방지  ?>
										<div class="write_div">
							<?php echo $captcha_html ?>
										</div>
					<?php } ?>
						-->
				</div>
			<div class="caf_buttons">
				<a href="/index.php" class="btn  middle mr20 fl text bold font">취소</a>
				<input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn t1 middle fl text bold font">
			</div>
		</form>
	</div>
	<!-- } 게시물 작성/수정 끝 -->
	</div>
</div><!--c_area-->




<script>

    //데이트피커
    $(function () {
        $("#datepicker1, #datepicker2").datepicker({
            dateFormat: 'yy.mm.dd'
        });
    });

<?php if ($write_min || $write_max) { ?>
        // 글자수 제한
        var char_min = parseInt(<?php echo $write_min; ?>); // 최소
        var char_max = parseInt(<?php echo $write_max; ?>); // 최대
        check_byte("wr_content", "char_count");

        $(function () {
            $("#wr_content").on("keyup", function () {
                check_byte("wr_content", "char_count");
            });
        });

<?php } ?>
    function html_auto_br(obj)
    {
        if (obj.checked) {
            result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
            if (result)
                obj.value = "html2";
            else
                obj.value = "html1";
        } else
            obj.value = "";
    }

    function fwrite_submit(f)
    {
<?php //echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함    ?>

        var subject = "";
        var content = "";
        $.ajax({
            url: g5_bbs_url + "/ajax.filter.php",
            type: "POST",
            data: {
                "subject": f.wr_subject.value,
                "content": f.wr_content.value
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function (data, textStatus) {
                subject = data.subject;
                content = data.content;
            }
        });

        if (subject) {
            alert("제목에 금지단어('" + subject + "')가 포함되어있습니다");
            f.wr_subject.focus();
            return false;
        }

        if (content) {
            alert("내용에 금지단어('" + content + "')가 포함되어있습니다");
            if (typeof (ed_wr_content) != "undefined")
                ed_wr_content.returnFalse();
            else
                f.wr_content.focus();
            return false;
        }

        if (document.getElementById("char_count")) {
            if (char_min > 0 || char_max > 0) {
                var cnt = parseInt(check_byte("wr_content", "char_count"));
                if (char_min > 0 && char_min > cnt) {
                    alert("내용은 " + char_min + "글자 이상 쓰셔야 합니다.");
                    return false;
                } else if (char_max > 0 && char_max < cnt) {
                    alert("내용은 " + char_max + "글자 이하로 쓰셔야 합니다.");
                    return false;
                }
            }
        }

        if (f.wr_name.value == "") {
            f.wr_name.value = f.wr_subject.value;
        }

<?php //echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함   ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }
</script>
