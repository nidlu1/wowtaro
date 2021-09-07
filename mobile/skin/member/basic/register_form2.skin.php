<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $member_skin_url . '/style.css">', 0);
?>
<!-- 회원정보 입력/수정 시작 { -->
<?php if ($w != 'u') { ?>
	<div class="c_hero">
		<strong>신선운세 <mark>베스트 상담사 신청</mark></strong>
	</div>
	<div class="c_list">
		<div class="cl_menu">
			<a href="<?php echo G5_URL; ?>"><i></i><span class="blind">HOME</span></a>
			<span>신선운세</span>
			<span><mark><a href="/bbs/register_form2.php" class="sct_here">베스트 상담사 신청</a></mark></span>
		</div>
	</div>
<?php } else { ?>
	<div class="c_hero">
		<strong>신선운세 <mark>상담사정보수정</mark></strong>
	</div>
	<div class="c_list t1">
		<div class="cl_menu">
			<span>마이페이지</span>
			<span><mark>상담사정보수정</mark></span>
		</div>
		<button type="button" class="cl_btn"><span class="blind"></span></button>
	</div>
	<ul id="mypage-tab">
		<?php
		include_once(G5_SHOP_PATH.'/mymenu.php');
		?>
	</ul>
	<div class="c_area mypage">
		<div class="wrap">
			<ul class="ca_function teacher">
				<li><span><?php echo $member['mb_name']; ?>님</span></li>
				<li><span><?php echo $member['mb_nick']; ?>님</span></li>
			</ul>
			<div id="mypage-content">
<?php } ?>
<div class="c_area mypage">
	<div class="wrap small">
		<script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
		<?php if ($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
			<script src="<?php echo G5_JS_URL ?>/certify.js?v=<?php echo G5_JS_VER; ?>"></script>
		<?php } ?>
		<form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
			<input type="hidden" name="w" value="<?php echo $w ?>">
			<input type="hidden" name="url" value="<?php echo $urlencode ?>">
			<input type="hidden" name="agree" value="<?php echo $agree ?>">
			<input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
			<input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
			<input type="hidden" name="cert_no" value="">
			<?php if (isset($member['mb_sex'])) { ?><input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>"><?php } ?>
			<?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면   ?>
				<input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick']) ?>">
				<input type="hidden" name="mb_nick" value="<?php echo get_text($member['mb_nick']) ?>">
			<?php } ?>
			<div id="register_form" class="ca_form register">
				<div class="from_wrap mb50">
						<?php if ($w != 'u') { ?>
							<input type="hidden" name="mb_id" placeholder="이메일만 사용가능합니다" value="temp_id_<?php echo time(); ?>" id="reg_mb_id">
							<input type="hidden" name="mb_password" id="reg_mb_password" value="temp_pw_<?php echo time(); ?>">
							<input type="hidden" name="mb_password_re" id="reg_mb_password_re" value="temp_pw_<?php echo time(); ?>">
						<?php } else { ?>

							<!--승인받은날짜 노출하기-->
							<div class="caf_title">
								<strong>상담사 정보 수정</strong>
							</div>
							<div class="caf_item">
								<label for="" class="form_label">승인받은 날짜</label>
								<label for="" class="sound_only">아이디<strong>필수</strong></label>
								<input type="text" name="mb_cert" placeholder="승인받은 날짜 노출" value="<?php echo $member['mb_cert']; ?>" readonly class="caf_input strip_input" ">
							</div>
							<!--//승인받은날짜 노출하기-->

							<div class="caf_item">
								<label for="reg_mb_id" class="form_label">아이디</label>
								<label for="reg_mb_id" class="sound_only">아이디<strong>필수</strong></label>
								<input type="text" name="mb_id" placeholder="이메일만 사용가능합니다" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" <?php echo $required ?> <?php echo $readonly ?> class="caf_input strip_input <?php echo $required ?> <?php echo $readonly ?>" minlength="3" maxlength="20" placeholder="아이디""><!--button type="button" class="btn_frmline">인증확인</button-->
								<span id="msg_mb_id"></span>
							</div>
							<div class="caf_item">
								<label for="reg_mb_password" class="form_label">비밀번호</label>
								<label for="reg_mb_password" class="sound_only">비밀번호<strong class="sound_only">필수</strong></label>
								<input type="password" name="mb_password" id="reg_mb_password" placeholder="비밀번호를 입력해주세요" <?php echo $required ?> class="caf_input  <?php echo $required ?>" minlength="3" maxlength="20" placeholder="비밀번호">
							</div>
							<div class="caf_item">
								<label for="reg_mb_password_re" class="form_label">비밀번호 확인</label>
								<label for="reg_mb_password_re" class="sound_only">비밀번호 확인<strong>필수</strong></label>
								<input type="password" name="mb_password_re" id="reg_mb_password_re" placeholder="비밀번호를 한번 더 입력해주세요" <?php echo $required ?> class="caf_input  <?php echo $required ?>" minlength="3" maxlength="20" placeholder="비밀번호 확인">
							</div>
						<?php } ?>
						<?php if ($w != 'u') { ?>
							<div class="caf_title">
								<strong>베스트 상담사 신청</strong>
							</div>
						<?php } ?>
						<div class="caf_item">
							<label for="reg_mb_name" class="form_label">이름</label>
							<label for="reg_mb_name" class="sound_only">이름<strong>필수</strong></label>
							<input type="text" id="reg_mb_name" name="mb_name" value="<?php echo get_text($member['mb_name']) ?>" <?php echo $required ?> <?php echo $readonly; ?> class="caf_input strip_input <?php echo $required ?> <?php echo $readonly ?>" size="10" placeholder="이름" <?php echo $w == 'u' ? '' : ''; ?>>
						</div>
						<?php if ($req_nick) { ?>
						<div class="caf_item">
							<label for="reg_mb_nick" class="form_label">예명</label>
							<label for="reg_mb_nick" class="sound_only">닉네임<strong>필수</strong></label>
							<?php if ($w != 'u') { ?>
								<input type="hidden" name="mb_nick_default" value="<?php echo isset($member['mb_nick']) ? get_text($member['mb_nick']) : ''; ?>">
								<input type="text" name="mb_nick" value="<?php echo isset($member['mb_nick']) ? get_text($member['mb_nick']) : ''; ?>" id="reg_mb_nick" required class="caf_input required nospace  strip_input" size="10" maxlength="20" placeholder="타사이트 닉네임 불가 / 네이버 페이 광고성 상담 카톡문자 개인적으로 활동 하고 있는 닉네임 불가"><button type="button" class="caf_btn" id="dup_nick">중복검사</button>
								<span id="msg_mb_nick"></span>
								<span class="frm_info blind">
									공백없이 한글,영문,숫자만 입력 가능 (한글2자, 영문4자 이상)<br>
									닉네임을 바꾸시면 앞으로 <?php echo (int) $config['cf_nick_modify'] ?>일 이내에는 변경 할 수 없습니다.
								</span>
							<?php } else { ?>
								<input type="hidden" name="mb_nick_default" value="<?php echo isset($member['mb_nick']) ? get_text($member['mb_nick']) : ''; ?>">
								<input type="text" name="mb_nick" value="<?php echo isset($member['mb_nick']) ? get_text($member['mb_nick']) : ''; ?>" id="reg_mb_nick" class="caf_input nospace strip_input"  size="10" maxlength="20" readOnly>
							<?php } ?>
						</div>
						<?php } ?>

						<!-- <li>
							<label for="reg_mb_email" class="sound_only">E-mail<strong>필수</strong></label>
			
						<?php if ($config['cf_use_email_certify']) { ?>
									<span class="frm_info">
							<?php
							if ($w == '') {
								echo "E-mail 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다.";
							}
							?>
							<?php
							if ($w == 'u') {
								echo "E-mail 주소를 변경하시면 다시 인증하셔야 합니다.";
							}
							?>
									</span>
						<?php } ?>
							<input type="hidden" name="old_email" value="<?php echo $member['mb_email'] ?>">
							<input type="text" name="mb_email" value="<?php echo isset($member['mb_email']) ? $member['mb_email'] : ''; ?>" id="reg_mb_email" required class="caf_input email full_input required" size="70" maxlength="100" placeholder="E-mail">
			
						</li> -->

						<?php if ($config['cf_use_homepage']) { ?>
							<div class="caf_item">
								<label for="reg_mb_homepage" class="sound_only">홈페이지<?php if ($config['cf_req_homepage']) { ?><strong>필수</strong><?php } ?></label>
								<input type="text" name="mb_homepage" value="<?php echo get_text($member['mb_homepage']) ?>" id="reg_mb_homepage" <?php echo $config['cf_req_homepage'] ? "required" : ""; ?> class="caf_input full_input <?php echo $config['cf_req_homepage'] ? "required" : ""; ?>" size="70" maxlength="255" placeholder="홈페이지">
							</div>
						<?php } ?>

						<div class="caf_item">
							<?php if ($config['cf_use_hp'] || $config['cf_cert_hp']) { ?>
								<label for="reg_mb_hp" class="form_label">휴대폰번호</label>
								<label for="reg_mb_hp" class="sound_only">휴대폰번호<?php if ($config['cf_req_hp']) { ?><strong>필수</strong><?php } ?></label>

								<input type="hidden" name="mb_hp" id="reg_mb_hp" value="<?php echo get_text($member['mb_hp']) ?>">
	<?php $arr_hp = explode("-", $member['mb_hp']); ?>
								<select id="mb_hp1" name="mb_hp1" class="caf_select third_input" onchange="resetAuth()">
									<option value="010" <?php if ($arr_hp[0] == "010") echo "selected" ?>>010</option>
									<option value="011" <?php if ($arr_hp[0] == "011") echo "selected" ?>>011</option>
									<option value="016" <?php if ($arr_hp[0] == "016") echo "selected" ?>>016</option>
									<option value="017" <?php if ($arr_hp[0] == "017") echo "selected" ?>>017</option>
									<option value="019" <?php if ($arr_hp[0] == "019") echo "selected" ?>>019</option>
								</select>
								<input type="text" name="mb_hp2" value="<?php echo get_text($arr_hp[1]) ?>" id="mb_hp2" <?php echo ($config['cf_req_hp']) ? "required" : ""; ?> class="caf_select third_input <?php echo ($config['cf_req_hp']) ? "required" : ""; ?>" maxlength="4" onchange="resetAuth()">
								<input type="text" name="mb_hp3" value="<?php echo get_text($arr_hp[2]) ?>" id="mb_hp3" <?php echo ($config['cf_req_hp']) ? "required" : ""; ?> class="caf_select third_input <?php echo ($config['cf_req_hp']) ? "required" : ""; ?>" maxlength="4" onchange="resetAuth()">
								<!-- 화면 확인 상 넣은 버튼으로 실제 인증번호 개발시 현 버튼은 필요없음 2019-05-02 -->
								<button type="button" id="btnSmsSend" class="caf_btn">인증번호 요청</button>
								<!-- //화면 확인 상 넣은 버튼으로 실제 인증번호 개발시 현 버튼은 필요없음 2019-05-02 -->
								<?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
									<input type="hidden" name="old_mb_hp" value="<?php echo get_text($member['mb_hp']) ?>">
								<?php } ?>
								<?php
								if ($config['cf_cert_use']) {
									if ($config['cf_cert_ipin'])
										echo '<button type="button" id="win_ipin_cert" class="btn_frmline">아이핀 본인확인</button>' . PHP_EOL;
									if ($config['cf_cert_hp'])
										echo '<button type="button" id="win_hp_cert" class="btn_frmline">인증번호 요청</button>' . PHP_EOL;

									echo '<noscript>본인확인을 위해서는 자바스크립트 사용이 가능해야합니다.</noscript>' . PHP_EOL;
								}
								?>
								<?php
								if ($config['cf_cert_use'] && $member['mb_certify']) {
									if ($member['mb_certify'] == 'ipin')
										$mb_cert = '아이핀';
									else
										$mb_cert = '휴대폰';
									?>

									<div id="msg_certify">
										<strong><?php echo $mb_cert; ?> 본인확인</strong><?php if ($member['mb_adult']) { ?> 및 <strong>성인인증</strong><?php } ?> 완료
									</div>
								<?php } ?>
	<?php if ($config['cf_cert_use']) { ?>
									<span class="frm_info">본인확인 후에는 이름과 휴대폰번호가 자동 입력되어 수동으로 입력할수 없게 됩니다.</span>
	<?php } ?>
<?php } ?>
						</div>
						<div class="caf_item">
							<label for="cf_cert_code" class="form_label">인증번호</label>
							<input type="text" name="certify_code" value="" id="cf_cert_code" class="caf_input strip_input"><button type="button" id="btnAuth" class="caf_btn t1">인증확인</button>
						</div>
						<div class="caf_item">
							<label for="reg_mb_email" class="form_label">이메일</label>

								<?php if ($config['cf_use_email_certify']) { ?>
								<span class="frm_info">
									<?php
									if ($w == '') {
										echo "E-mail 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다.";
									}
									?>
	<?php
	if ($w == 'u') {
		echo "E-mail 주소를 변경하시면 다시 인증하셔야 합니다.";
	}
	?>
								</span>
<?php } ?>
							<input type="hidden" name="old_email" value="<?php echo $member['mb_email'] ?>">
							<input type="text" name="mb_email" value="<?php echo isset($member['mb_email']) ? $member['mb_email'] : ''; ?>" id="reg_mb_email" required class="caf_input email full_input required" size="70" maxlength="100" placeholder="E-mail">
						</div>
<?php if ($config['cf_use_addr']) { ?>
							<div class="caf_item">
	<?php if ($config['cf_req_addr']) { ?><strong class="sound_only">필수</strong><?php } ?>
								<label for="reg_mb_zip" class="form_label" >주소<?php echo $config['cf_req_addr'] ? '<strong class="sound_only"> 필수</strong>' : ''; ?></label>
								<input type="text" name="mb_zip" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');"value="<?php echo $member['mb_zip1'] . $member['mb_zip2']; ?>" id="reg_mb_zip" <?php echo $config['cf_req_addr'] ? "required" : ""; ?> class="caf_input strip_input <?php echo $config['cf_req_addr'] ? "required" : ""; ?>" size="5" maxlength="6"  placeholder="우편번호" readOnly>


								<button type="button" class="caf_btn" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소 검색</button>
								<label for="reg_mb_addr1" class="form_label"></label>
								<input type="text" name="mb_addr1" value="<?php echo get_text($member['mb_addr1']) ?>" id="reg_mb_addr1" <?php echo $config['cf_req_addr'] ? "required" : ""; ?> class="caf_input frm_address <?php echo $config['cf_req_addr'] ? "required" : ""; ?>" size="50"  placeholder="기본주소" readOnly>

								<label for="reg_mb_addr3" class="form_label"></label>
								<input type="text" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']) ?>" id="reg_mb_addr3" class="caf_input frm_address " size="50" readonly="readonly"  placeholder="참고항목" readOnly>
								<input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>">

								<label for="reg_mb_addr2" class="form_label"></label>
								<input type="text" name="mb_addr2" value="<?php echo get_text($member['mb_addr2']) ?>" id="reg_mb_addr2" class="caf_input frm_address " size="50"  placeholder="상세주소">

							</div>
								<?php } ?>
						<div class="caf_item">
							<label class="form_label">상담분야</label>
							<div class="caf_input w100p t1 required">
<?php
$bcat_arr = explode(",", $member['mb_1']);
for ($ii = 0; $ii < count($qdt); $ii++) {
	?>
									<label class="type_chk"><input type="checkbox" class="cafi_check" id="mb_1_<?php echo $qdt[$ii]['ca_id']; ?>" name="mb_1[]" value="<?php echo $qdt[$ii]['ca_id']; ?>" <?php echo in_array($qdt[$ii]['ca_id'], $bcat_arr) ? "checked" : ""; ?>><i></i><?php echo $qdt[$ii]['ca_name']; ?></label>
									<?php
								}
								?>
								<div class="caf_comment t1">
									* 상담분야는 2개까지 선택 가능합니다.
								</div>
							</div>
						</div>
						<div class="caf_item">
							<label class="form_label">세부분야</label>
							<div class="caf_input w100p t1 required">
<?php
$scat_arr = explode(",", $member['mb_2']);
for ($ii = 0; $ii < count($qdt2); $ii++) {
	?>
									<label class="type_chk"><input type="checkbox" class="cafi_check" id="mb_2_<?php echo $qdt2[$ii]['ht_no']; ?>" name="mb_2[]" value="<?php echo $qdt2[$ii]['ht_no']; ?>" <?php echo in_array($qdt2[$ii]['ht_no'], $scat_arr) ? "checked" : ""; ?>><i></i><?php echo $qdt2[$ii]['ht_name']; ?></label>
	<?php
}
?>
								<div class="caf_comment t1">
									* 세부분야는 3개까지 선택 가능합니다.
								</div>
							</div>
						</div>
						<div class="caf_item">
							<label class="form_label">한줄소개</label>
							<input type="text" name="mb_9" value="<?php echo $member['mb_9'] ?>" id="reg_mb_9" class="caf_input w100p" maxlength="20" placeholder="한줄소개">
							<span class="caf_comment">20자 이내</span>
						</div>
						<div class="caf_item">
							<label class="form_label">상담사 경력</label>
							<textarea name="mb_profile" id="reg_mb_profile" <?php echo $config['cf_req_profile'] ? "required" : ""; ?> class="caf_textarea <?php echo $config['cf_req_profile'] ? "required" : ""; ?>" style="height:80px;" placeholder="상담사 경력" <?php echo $w == 'u' ? ' readOnly' : ''; ?>><?php echo $member['mb_profile'] ?></textarea>
						</div>
						<div class="caf_item">
							<label class="form_label">상담사 소개글</label>
							<div class="editor">
								<textarea name="mb_memo" id="reg_mb_memo" class="caf_textarea" style="height:120px;<?php echo $w == 'u' ? 'border: 0;' : ''; ?>" placeholder="상담사 소개글" <?php echo $w == 'u' ? ' readOnly' : ''; ?>><?php echo $member['mb_memo'] ?></textarea>
<?php //echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출     ?>
								<span class="caf_comment t2">300자 이내</span>
							</div>
						</div>
						<div class="caf_item">
							<label class="form_label">주민등록사진#1</label>
							<input type="file" name= "mb_3" id="reg_mb_3" class="caf_file" placeholder="주민등록사진">
						</div>
						<div class="caf_item">
							<label class="form_label">통장앞면사진#2</label>
							<input type="file" name="mb_4" id="reg_mb_4" class="caf_file" placeholder="주민등록사진">
						</div>
						<div class="caf_item">
							<label class="form_label">프로필사진#1</label>
							<input type="file" name="mb_5" id="reg_mb_5" class="caf_file" placeholder="주민등록사진">
						</div>
						<div class="caf_item">
							<label class="form_label">프로필사진#2</label>
							<input type="file" name="mb_6" id="reg_mb_6" class="caf_file" placeholder="주민등록사진">
						</div>
						<?php if ($w != 'u') { ?>
							<input type="button" class="btn t2 mt25 mb10" id="btn-digital-signature" value="전자계약서 보기">
							<div class="digital-signature" style="display: none;">
							<div class="caf_item">
								<label class="form_label ">전자서명</label>
								<div id="lightgallery">
									<a href="/img/_contract01.jpg" class="cafi_wrap">
										<img src="/img/_contract01.jpg">
										<i></i>
									</a>
								</div>
							</div>
							<div class="caf_item">
								<label class="form_label"></label>
								<div id="lightgallery2">
									<a href="/img/_contract02.jpg" class="cafi_wrap">
										<img src="/img/_contract02.jpg">
										<i></i>
									</a>
								</div>
							</div>
							<div class="caf_item">
								<label class="form_label"></label>
								<div id="lightgallery3">
									<a href="/img/_contract03.jpg" class="cafi_wrap">
										<img src="/img/_contract03.jpg">
										<i></i>
									</a>
								</div>
							</div>
							<div class="caf_item">
								<label class="form_label"></label>
								<div id="lightgallery4">
									<a href="/img/_contract04.jpg" class="cafi_wrap">
										<img src="/img/_contract04.jpg">
										<i></i>
									</a>
								</div>
							</div>
							<div class="caf_item">
								<label class="form_label">주민번호</label>
								<input id="draw_text" required value="" placeholder="주민번호를 입력해주세요" class="caf_input w100p required">
							</div>
							<div class="caf_item">
								<label class="form_label">계좌번호</label>
								<input id="draw_text2" required value="" placeholder="계좌번호를 입력해주세요" class="caf_input w100p required">
							</div>
							<div class="caf_item">
								<label class="form_label">주소</label>
								<input id="draw_text3" required value="" placeholder="주소를 입력해주세요" class="caf_input w100p required">
							</div>
							<div class="caf_item">
								<label class="form_label">이름</label>
								<input id="draw_text4" required value="" placeholder="이름을 입력해주세요" class="caf_input w100p required">
							</div>
							<div class="caf_item">
								<label class="form_label"></label>
								<div id="lightgallery5">
									<a href="/img/_contract05.jpg" class="cafi_wrap">
										<canvas id="myCanvas" style="background-color:aliceblue" width="650" height="920"></canvas>
										<i></i>
									</a>
								</div>
							</div>
							<div class="caf_item">
								<label class="form_label">계약서 첨부</label>
								<input type="file" name="mb_10" id="reg_mb_10" required class="caf_file required" placeholder="계약서를 저장한 후 첨부해주세요.">
							</div>
						<?php } ?>
					</div>
					<!--li>
						  <label class="form_label">계약내용 동의</label>
						  <button type="button" class="btn_submit full_btn" id="check_pop">계약내용 확인하기</button>
						</li>
						<li>
						  <label class="form_label"></label>
						  <div class="caf_input">
							<label class="frm_agree"><input type="checkbox" id="dochk" name="thisAgree"> 위의 계약내용을 확인하였고 계약내용 사항에 동의합니다.</label>
						  </div>
						</li-->
				</div>
				<ul class="caf_buttons">
					<li><a href="<?php echo G5_URL ?>" class="btn">취소</a></li>
					<li><input type="submit" value="<?php echo $w == '' ? '상담사신청' : '정보수정'; ?>" id="btn_submit" class="btn t1" accesskey="s"></li>
				</ul>

			</div>
		</form>
	</div>
</div>
</div>
<?php if ($w == 'u') { ?>
		</div>
<?php } ?>

	<script>
		var authYn = "<?php echo $w == "" ? "N" : "Y" ?>";
		var authNo = "";
		var hpNo = "";
		$(function () {

			$("input[name='mb_1[]']").click(function () {
				var cnt = 0;
				$("input[name='mb_1[]']").each(function () {
					if ($(this).is(":checked") == true) {
						cnt++;
					}
				});

				if (cnt > 2) {
					alert("상담분야는 2개까지 선택가능합니다.");
					$(this).attr("checked", false);
				} else {
					//$(this).attr("checked", true);
				}
			});

			$("input[name='mb_2[]']").click(function () {
				var cnt = 0;
				$("input[name='mb_2[]']").each(function () {
					if ($(this).is(":checked") == true) {
						cnt++;
					}
				});

				if (cnt > 3) {
					alert("세부분야는 3개까지 선택가능합니다.");
					$(this).attr("checked", false);
				} else {
					//$(this).attr("checked", true);
				}
			});

			$("#dup_nick").click(function () {
				var msg = reg_mb_nick_check();
				if (msg) {
					alert(msg);
					$("#reg_mb_nick").select();
					return;
				} else {
					alert("사용가능한 닉네임 입니다.");
					return;
				}
			});

			$("#btnAuth").click(function () {
				if (authNo != "")
				{
					if (authNo == $("#cf_cert_code").val())
					{
						authYn = "Y";
						$("input[name=mb_hp").val(hpNo);
						alert("휴대폰 번호 인증이 완료되었습니다.");
					} else
					{
						authYn = "N";
						alert("인증번호가 일치하지 않습니다.");
					}
				}
			});

			$("#btnSmsSend").click(function () {

				if ($("#mb_hp1").val() && $("#mb_hp2").val() && $("#mb_hp3").val()) {
					hpNo = $("#mb_hp1").val() + "-" + $("#mb_hp2").val() + "-" + $("#mb_hp3").val();
					$.post("/sms_send.php", {hp: hpNo}, function (result) {
						var json = $.parseJSON(result);
						if (json.ret == "OK")
						{
							alert("입력하신 " + hpNo + "번호로 인증번호가 발송되었습니다.");
							//authNo = result;
							authNo = json.rand;
						} else {
							alert(json.msg);
						}
					});
				} else {
					alert('핸드폰번호를 입력해주세요');
				}
			});

			$('#check_pop').click(function () {
				$('#layer').show();
			});
			$('.dim_bg, .pop_close').click(function () {
				$('#layer').hide();
			});

			$('#fregister_submit').click(function () {
				$('#layer').hide();
				$('#register_form').submit();
			});
			/*
			 $('#chkAgree').click(function(){
			 if( $(this).is(':checked') == true ) {
			 $('#dochk').attr('checked','checked');
			 } else {
			 $('#dochk').removeAttr('checked');
			 }
			 });
			 */

			$("#reg_zip_find").css("display", "inline-block");

<?php if ($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
				// 아이핀인증
				$("#win_ipin_cert").click(function () {
					if (!cert_confirm())
						return false;

					var url = "<?php echo G5_OKNAME_URL; ?>/ipin1.php";
					certify_win_open('kcb-ipin', url);
					return;
				});

<?php } ?>
<?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
				// 휴대폰인증
				$("#win_hp_cert").click(function () {
					if (!cert_confirm())
						return false;

	<?php
	switch ($config['cf_cert_hp']) {
		case 'kcb':
			$cert_url = G5_OKNAME_URL . '/hpcert1.php';
			$cert_type = 'kcb-hp';
			break;
		case 'kcp':
			$cert_url = G5_KCPCERT_URL . '/kcpcert_form.php';
			$cert_type = 'kcp-hp';
			break;
		case 'lg':
			$cert_url = G5_LGXPAY_URL . '/AuthOnlyReq.php';
			$cert_type = 'lg-hp';
			break;
		default:
			echo 'alert("기본환경설정에서 휴대폰 본인확인 설정을 해주십시오");';
			echo 'return false;';
			break;
	}
	?>

					certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>");
					return;
				});
<?php } ?>
		});

		function resetAuth() {
			var hpNo = $("#mb_hp1").val() + "-" + $("#mb_hp2").val() + "-" + $("#mb_hp3").val();
			;
			authYn = ($("input[name=mb_hp]").val() == hpNo ? "Y" : "N");
		}

		// submit 최종 폼체크
		function fregisterform_submit(f)
		{
			/*
			 // 회원아이디 검사
			 if (f.w.value == "") {
			 var msg = reg_mb_id_check();
			 if (msg) {
			 alert(msg);
			 f.mb_id.select();
			 return false;
			 }
			 }
			 */

			if (f.w.value == "") {
				if (f.mb_password.value.length < 3) {
					alert("비밀번호를 3글자 이상 입력하십시오.");
					f.mb_password.focus();
					return false;
				}
			}

			if (f.mb_password.value != f.mb_password_re.value) {
				alert("비밀번호가 같지 않습니다.");
				f.mb_password_re.focus();
				return false;
			}

			if (f.mb_password.value.length > 0) {
				if (f.mb_password_re.value.length < 3) {
					alert("비밀번호를 3글자 이상 입력하십시오.");
					f.mb_password_re.focus();
					return false;
				}
			}

			// 이름 검사
			if (f.w.value == "") {
				if (f.mb_name.value.length < 1) {
					alert("이름을 입력하십시오.");
					f.mb_name.focus();
					return false;
				}

				/*
				 var pattern = /([^가-힣\x20])/i;
				 if (pattern.test(f.mb_name.value)) {
				 alert("이름은 한글로 입력하십시오.");
				 f.mb_name.select();
				 return false;
				 }
				 */
			}

<?php if ($w == '' && $config['cf_cert_use'] && $config['cf_cert_req']) { ?>
				// 본인확인 체크
				if (f.cert_no.value == "") {
					alert("회원가입을 위해서는 본인확인을 해주셔야 합니다.");
					return false;
				}
<?php } ?>

			// 닉네임 검사
			if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
				var msg = reg_mb_nick_check();
				if (msg) {
					alert(msg);
					f.reg_mb_nick.select();
					return false;
				}
			}

			// E-mail 검사
			if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
				var msg = reg_mb_email_check();
				if (msg) {
					alert(msg);
					f.reg_mb_email.select();
					return false;
				}
			}

<?php if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) { ?>
				// 휴대폰번호 체크
				var msg = reg_mb_hp_check();
				if (msg) {
					alert(msg);
					f.reg_mb_hp.select();
					return false;
				}
<?php } ?>

			if (authYn != "Y")
			{
				alert("휴대폰 번호 인증을 해주세요.");
				return false;
			}

			var cnt1 = 0;
			$("input[name='mb_1[]']").each(function () {
				if ($(this).is(":checked") == true) {
					cnt1++;
				}
			});
			if (cnt1 <= 0) {
				alert("상담분야를 선택해주세요.");
				return false;
			}

			var cnt2 = 0;
			$("input[name='mb_2[]']").each(function () {
				if ($(this).is(":checked") == true) {
					cnt2++;
				}
			});
			if (cnt2 <= 0) {
				alert("세부분야를 선택해주세요.");
				return false;
			}

			var cnt_byte = check_byte2("reg_mb_9");
			//alert("test => " + cnt_byte);return false;
			if (cnt_byte > 40) {
				alert("한줄소개는 20자 이내로 작성해 주세요.");
				f.mb_9.focus();
				return false;
			}

			var nwln = f.mb_profile.value.split("\n").length;
			if (nwln > 5) {
				alert("5줄까지만 등록가능합니다.");
				f.mb_profile.focus();
				return false;
			}

			var cnt_byte2 = check_byte2("reg_mb_memo");
			//alert("test => " + cnt_byte2);return false;
			if (cnt_byte2 > 600) {
				alert("인사말은 300자 이내로 작성해 주세요. 현재 " + (cnt_byte2 / 2) + "자 입니다.");
				f.mb_memo.focus();
				return false;
			}
<?php //echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함     ?>
			//alert(f.mb_memo.value);return false;

			if (typeof f.mb_icon != "undefined") {
				if (f.mb_icon.value) {
					if (!f.mb_icon.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
						alert("회원아이콘이 이미지 파일이 아닙니다.");
						f.mb_icon.focus();
						return false;
					}
				}
			}

			if (typeof f.mb_img != "undefined") {
				if (f.mb_img.value) {
					if (!f.mb_img.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
						alert("회원이미지가 이미지 파일이 아닙니다.");
						f.mb_img.focus();
						return false;
					}
				}
			}

			if (typeof (f.mb_recommend) != "undefined" && f.mb_recommend.value) {
				if (f.mb_id.value == f.mb_recommend.value) {
					alert("본인을 추천할 수 없습니다.");
					f.mb_recommend.focus();
					return false;
				}

				var msg = reg_mb_recommend_check();
				if (msg) {
					alert(msg);
					f.mb_recommend.select();
					return false;
				}
			}

<?php
//echo chk_captcha_js();
?>

			document.getElementById("btn_submit").disabled = "disabled";

			return true;
		}
		
		let digitalSignatureChk = true;
		$("#btn-digital-signature").click(()=>{
			if(digitalSignatureChk){
				$(".digital-signature").css("display","inline");
				digitalSignatureChk = false;
			}else{
				$(".digital-signature").css("display","none");
				digitalSignatureChk = true;
			}
			
		});
	</script>
	<script src="<?= G5_JS_URL ?>/register_canvas.js"></script>
	<!-- } 회원정보 입력/수정 끝 -->