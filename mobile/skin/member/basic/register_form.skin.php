<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<?php if($w != 'u'){ ?>
<div class="c_hero">
	<strong>신선운세 <mark>회원가입</mark></strong>
</div>
<div class="c_list">
	<div class="cl_menu">
		<a href='<?php echo G5_URL; ?>/'><i></i><span class="blind">HOME</span></a>
		<span>신선운세</span>
		<span><mark><a href="/bbs/register_form.php" class="sct_here ">회원가입</a></mark></span>
	</div>
</div>
<div class="c_area registerform">
	<div class="wrap">
<?php } else { ?>
	<div class="c_hero">
	<strong>신선운세 <mark>회원 정보 수정</mark></strong>
	</div>
	<div class="c_list">
		<div class="cl_menu t1">
			<span>마이페이지</span>
			<span><mark>회원 정보 수정</mark></span>
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
			<ul class="ca_function">
				<li><span><?php echo $member['mb_name']; ?>님</span></li>
					<?php
				switch($member['mb_grade']) {
					case "1" :
						echo '<li><span><div class="caf_rank"><img src="/images/common/icon_rank01.svg"></div><b>나그네회원</b></span></li>';
						break;
					case "2" :
						echo '<li><span><div class="caf_rank"><img src="/images/common/icon_rank02.svg"></div><b>열심회원</b></span></li>';
						break;
					case "3" :
						echo '<li><span><div class="caf_rank"><img src="/images/common/icon_rank03.svg"></div><b>성실회원</b></span></li>';
						break;
					case "4" :
						echo '<li><span><div class="caf_rank"><img src="/images/common/icon_rank04.svg"></div><b>충성회원</b></span></li>';
						break;
					case "5" :
					case "6" :
						echo '<li><span><div class="caf_rank"><img src="/images/common/icon_rank05.svg"></div><b>신선회원</b></span></li>';
						break;
					default :
						echo '<li><span><div class="caf_rank"><img src="/images/common/icon_rank01.svg"></div><b>나그네회원</b></span></li>';
						break;
				}
				//보유 포인트 확인
				$sql = "select * from {$g5['point_table']} where mb_id = '{$member['mb_id']}' order by po_id DESC";
				$row = sql_fetch($sql);
				?>
				<li><span><i class="icon money"></i>보유 <mark class="cs"><?=number_format($row['po_mb_point'])?></mark> coin</span></li>
			</ul>
			<div id="mypage-content">
		<?php } ?>

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
            <div class="ca_form register">
<?php if ($w != 'u') { ?>
<?php } else { ?>
						<!--<div class="regi-rank">
							<label for="reg_mb_id" class="form_label">회원등급</label>

							<div class="caf_input">-->

								<!--나그네 회원일때 (이미지, 문구 변경)-->
								<!--<?php
								switch ($member['mb_grade']) {
									case "1" :
										echo '<span><img src="/add_img/rank/rank_icon_01.png">나그네회원</span>';
										break;
									case "2" :
										echo '<span><img src="/add_img/rank/rank_icon_02.png">열심회원</span>';
										break;
									case "3" :
										echo '<span><img src="/add_img/rank/rank_icon_03.png">성실회원</span>';
										break;
									case "4" :
										echo '<span><img src="/add_img/rank/rank_icon_04.png">충성회원</span>';
										break;
									case "5" :
									case "6" :
										echo '<span><img src="/add_img/rank/rank_icon_05.png">신선회원</span>';
										break;
									default :
										echo '<span><img src="/add_img/rank/rank_icon_01.png">나그네회원</span>';
										break;
								}
								?>-->
								 <!--span><img src="/add_img/rank/rank_icon_01.png">나그네회원</span-->
								<!--//나그네 회원일때 (이미지, 문구 변경)-->

								<!--열심 회원일때 (이미지, 문구 변경)-->
								<!-- <span><img src="/add_img/rank/rank_icon_02.png">열심회원</span> -->
								<!--열심 회원일때 (이미지, 문구 변경)-->

								<!--성실 회원일때 (이미지, 문구 변경)-->
								<!-- <span><img src="/add_img/rank/rank_icon_03.png">성실회원</span> -->
								<!--성실 회원일때 (이미지, 문구 변경)-->

								<!--충성 회원일때 (이미지, 문구 변경)-->
								<!-- <span><img src="/add_img/rank/rank_icon_04.png">충성회원</span> -->
								<!--충성 회원일때 (이미지, 문구 변경)-->

								<!--신선 회원일때 (이미지, 문구 변경)-->
								<!-- <span><img src="/add_img/rank/rank_icon_05.png">신선회원</span> -->
								<!--신선 회원일때 (이미지, 문구 변경)-->

							<!--</div>
						</div>-->
<?php } ?>
				<div class="from_wrap">
					<div class="caf_title">
						<strong>회원 정보</strong>
					</div>
					<div class="caf_item">
						<label for="reg_mb_id" class="form_label">아이디</label>
						<label for="reg_mb_id" class="sound_only">아이디<strong>필수</strong></label>
						<?php if ($w != 'u') { ?>
							<input type="text" name="mb_id" placeholder="이메일만 사용가능합니다" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" <?php echo $required ?> <?php echo $readonly ?> class="caf_input strip_input <?php echo $required ?> <?php echo $readonly ?>" minlength="3" maxlength="40" placeholder="아이디">
							<button type="button" id="dup_id" class="caf_btn">중복검사</button>
						<?php } else { ?>
							<input type="text" name="mb_id" placeholder="이메일만 사용가능합니다" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" <?php echo $required ?> <?php echo $readonly ?> class="caf_input <?php echo $required ?> <?php echo $readonly ?>" minlength="3" maxlength="20">
							<span id="msg_mb_id"></span>
					<?php } ?>
					</div>
<?php if ($w != 'u') { ?>
						<div class="caf_item">
						<label for="reg_mb_password" class="form_label">비밀번호</label>
						<label for="reg_mb_password" class="sound_only">비밀번호<strong>필수</strong></label>
						<input type="password" name="mb_password" id="reg_mb_password" placeholder="비밀번호를 입력해주세요" <?php echo $required ?> class="caf_input  <?php echo $required ?>" minlength="3" maxlength="20" placeholder="비밀번호 확인">
					</div>
					<div class="caf_item">
						<label for="reg_mb_password_re" class="form_label">비밀번호 확인</label>
						<label for="reg_mb_password_re" class="sound_only">비밀번호 확인<strong>필수</strong></label>
						<input type="password" name="mb_password_re" id="reg_mb_password_re" placeholder="비밀번호를 한번 더 입력해주세요" <?php echo $required ?> class="caf_input  <?php echo $required ?>" minlength="3" maxlength="20" placeholder="비밀번호 확인">
					</div>
<?php } ?>
					<div class="caf_item">
						<label for="reg_mb_nick" class="form_label">닉네임</label>
						<label for="reg_mb_nick" class="sound_only">닉네임<strong>필수</strong></label>
						<input type="hidden" name="mb_nick_default" value="<?php echo isset($member['mb_nick']) ? get_text($member['mb_nick']) : ''; ?>">
						<input type="text" name="mb_nick" value="<?php echo isset($member['mb_nick']) ? get_text($member['mb_nick']) : ''; ?>" id="reg_mb_nick" required class="caf_input required nospace strip_input" size="10" maxlength="20" placeholder="공백없이 한글,영문,숫자 입력가능(한글2자,영문 4자이상)">
						<button type="button" class="caf_btn" id="dup_nick">중복검사</button>
						<span id="msg_mb_nick"></span>
					</div>
<?php if ($w == 'u') { ?>
					<div class="caf_item">
						<label for="reg_mb_password" class="form_label">현재 비밀번호</label>
						<label for="reg_mb_password" class="sound_only">비밀번호 <strong class="sound_only">필수</strong></label>
						<input type="password" name="mb_password_origin" id="reg_mb_password_origin" placeholder="현재 비밀번호를 입력해주세요" class="caf_input  " minlength="3" maxlength="20" placeholder="비밀번호">
					</div>
					<div class="caf_item">
						<label for="reg_mb_password_re" class="form_label">새 비밀번호</label>
						<label for="reg_mb_password_re" class="sound_only">새 비밀번호<strong>필수</strong></label>
						<input type="password" name="mb_password" id="reg_mb_password" placeholder="새 비밀번호를 입력해주세요" class="caf_input  " minlength="3" maxlength="20" placeholder="비밀번호 확인">
					</div>
					<div class="caf_item">
						<label for="reg_mb_password_re" class="form_label">새 비밀번호 확인</label>
						<label for="reg_mb_password_re" class="sound_only">새 비밀번호 확인<strong>필수</strong></label>
						<input type="password" name="mb_password_re" id="reg_mb_password_re" placeholder="새 비밀번호를 한번 더 입력해주세요" class="caf_input  " minlength="3" maxlength="20" placeholder="비밀번호 확인">
					</div>
<?php } ?>
				</div>
					<!-- <div>
						<label for="reg_mb_email" class="sound_only">E-mail<strong>필수</strong></label>
		
					<?php if ($config['cf_use_email_certify']) { ?>
							<span class="frm_info">
						<?php if ($w == '') {
							echo "E-mail 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다.";
						} ?>
<?php if ($w == 'u') {
	echo "E-mail 주소를 변경하시면 다시 인증하셔야 합니다.";
} ?>
							</span>
					<?php } ?>
						<input type="hidden" name="old_email" value="<?php echo $member['mb_email'] ?>">
						<input type="text" name="mb_email" value="<?php echo isset($member['mb_email']) ? $member['mb_email'] : ''; ?>" id="reg_mb_email" required class="caf_input email full_input required" size="70" maxlength="100" placeholder="E-mail">
		
					</div> -->

<?php if ($config['cf_use_homepage']) { ?>
						<div>
							<label for="reg_mb_homepage" class="sound_only">홈페이지<?php if ($config['cf_req_homepage']) { ?><strong>필수</strong><?php } ?></label>
							<input type="text" name="mb_homepage" value="<?php echo get_text($member['mb_homepage']) ?>" id="reg_mb_homepage" <?php echo $config['cf_req_homepage'] ? "required" : ""; ?> class="caf_input full_input <?php echo $config['cf_req_homepage'] ? "required" : ""; ?>" size="70" maxlength="255" placeholder="홈페이지">
						</div>
						<?php } ?>

					<div>
					<div class="from_wrap mb25">
						<div class="caf_title">
							<strong>본인인증</strong>
						</div>
						<div class="caf_item">
							<label for="reg_mb_name" class="form_label">이름</label>
							<label for="reg_mb_name" class="sound_only">이름<strong>필수</strong></label>
							<input type="text" id="reg_mb_name" name="mb_name" value="<?php echo get_text($member['mb_name']) ?>" <?php echo $required ?> <?php echo $readonly; ?> class="caf_input  <?php echo $required ?> <?php echo $readonly ?>" size="10" placeholder="실명으로 입력해주세요">
						</div>
<?php if ($config['cf_use_hp'] || $config['cf_cert_hp']) { ?>
						<div class="caf_item">
							<label for="reg_mb_hp" class="form_label">휴대폰번호</label>
							<label for="reg_mb_hp" class="sound_only">휴대폰번호<?php if ($config['cf_req_hp']) { ?><strong>필수</strong><?php } ?></label>
							<input type="hidden" name="mb_hp" id="reg_mb_hp" value="<?php echo get_text($member['mb_hp']) ?>">
<?php $arr_hp = explode("-", $member['mb_hp']); ?>
							<select id="mb_hp1" name="mb_hp1" onchange="resetAuth()" class="caf_select third_input">
								<option value="010" <?php if ($arr_hp[0] == "010") echo "selected" ?>>010</option>
								<option value="011" <?php if ($arr_hp[0] == "011") echo "selected" ?>>011</option>
								<option value="016" <?php if ($arr_hp[0] == "016") echo "selected" ?>>016</option>
								<option value="017" <?php if ($arr_hp[0] == "017") echo "selected" ?>>017</option>
								<option value="019" <?php if ($arr_hp[0] == "019") echo "selected" ?>>019</option>
							</select>
							<input type="text" name="mb_hp2" value="<?php echo get_text($arr_hp[1]) ?>" id="mb_hp2" <?php echo ($config['cf_req_hp']) ? "required" : ""; ?> class="caf_select third_input <?php echo ($config['cf_req_hp']) ? "required" : ""; ?>" maxlength="4" onchange="resetAuth()">
							<input type="text" name="mb_hp3" value="<?php echo get_text($arr_hp[2]) ?>" id="mb_hp3" <?php echo ($config['cf_req_hp']) ? "required" : ""; ?>  class="caf_select third_input <?php echo ($config['cf_req_hp']) ? "required" : ""; ?>" maxlength="4" onchange="resetAuth()">
							<!-- 화면 확인 상 넣은 버튼으로 실제 인증번호 개발시 현 버튼은 필요없음 2019-05-02 -->
							<button type="button" id="btnSmsSend" class="caf_btn">인증번호 요청</button>
							<!-- //화면 확인 상 넣은 버튼으로 실제 인증번호 개발시 현 버튼은 필요없음 2019-05-02 -->
							<?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
								<input type="hidden" name="old_mb_hp" value="<?php echo get_text($member['mb_hp']) ?>">
							<?php } ?>
							<?php
							if ($config['cf_cert_use']) {
								if ($config['cf_cert_ipin'])
									echo '<button type="button" id="win_ipin_cert" class="caf_btn">아이핀 본인확인</button>' . PHP_EOL;
								if ($config['cf_cert_hp'])
									echo '<button type="button" id="win_hp_cert" class="caf_btn">인증번호 요청</button>' . PHP_EOL;

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
				</div>
					<?php if ($config['cf_use_profile'] && $w == 'u' && $member['mb_level'] >= $config['cf_icon_level']) { ?>
						<div>
							<label for="reg_mb_profile" class="form_label">자기소개</label>
							<textarea name="mb_profile" id="reg_mb_profile" class="<?php echo $config['cf_req_profile'] ? "required" : ""; ?>" <?php echo $config['cf_req_profile'] ? "required" : ""; ?> placeholder="자기소개"><?php echo $member['mb_profile'] ?></textarea>
						</div>
					<?php } ?>

					<?php if ($w == "" && $config['cf_use_recommend']) { ?>
						<!-- <div>
							<label for="reg_mb_recommend" class="form_label">추천인아이디</label>
							<input type="text" name="mb_recommend" id="reg_mb_recommend" class="caf_input full_input" placeholder="추천인아이디를 입력해 주세요.">
						</div> -->
<?php } ?>

<?php if ($config['cf_use_member_icon'] && $w == 'u' && $member['mb_level'] >= $config['cf_icon_level']) { ?>
						<div>
							<label for="reg_mb_icon" class="form_label">회원아이콘</label>
							<input type="file" name="mb_icon" id="reg_mb_icon">
							<span class="frm_info">
								이미지 크기는 가로 <?php echo $config['cf_member_icon_width'] ?>픽셀, 세로 <?php echo $config['cf_member_icon_height'] ?>픽셀 이하로 해주세요.<br>
								gif, jpg, png파일만 가능하며 용량 <?php echo number_format($config['cf_member_icon_size']) ?>바이트 이하만 등록됩니다.
							</span>
						<?php if ($w == 'u' && file_exists($mb_icon_path)) { ?>
								<img src="<?php echo $mb_icon_url ?>" alt="회원아이콘">
								<input type="checkbox" name="del_mb_icon" value="1" id="del_mb_icon">
								<label for="del_mb_icon">삭제</label>
						<?php } ?>

						</div>
					<?php } ?>

					<?php /* if ($config['cf_use_addr']) { ?>
					  <div>
					  <?php if ($config['cf_req_addr']) { ?><strong class="sound_only">필수</strong><?php }  ?>
					  <label for="reg_mb_zip" class="sound_only">우편번호<?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
					  <input type="text" name="mb_zip" value="<?php echo $member['mb_zip1'].$member['mb_zip2']; ?>" id="reg_mb_zip" <?php echo $config['cf_req_addr']?"required":""; ?> class="caf_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="5" maxlength="6"  placeholder="우편번호">
					  <button type="button" class="caf_btn" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소 검색</button><br>
					  <input type="text" name="mb_addr1" value="<?php echo get_text($member['mb_addr1']) ?>" id="reg_mb_addr1" <?php echo $config['cf_req_addr']?"required":""; ?> class="caf_input frm_address full_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="50"  placeholder="기본주소">
					  <label for="reg_mb_addr1" class="sound_only">기본주소<?php echo $config['cf_req_addr']?'<strong> 필수</strong>':''; ?></label><br>
					  <input type="text" name="mb_addr2" value="<?php echo get_text($member['mb_addr2']) ?>" id="reg_mb_addr2" class="caf_input frm_address full_input" size="50"  placeholder="상세주소">
					  <label for="reg_mb_addr2" class="sound_only">상세주소</label>
					  <br>
					  <input type="text" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']) ?>" id="reg_mb_addr3" class="caf_input frm_address full_input" size="50" readonly="readonly"  placeholder="참고항목">
					  <label for="reg_mb_addr3" class="sound_only">참고항목</label>
					  <input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>">

					  </div>
                          <?php } */ ?>

                <div class="ca_submit">
					<?php/* <a href="<?php echo G5_URL ?>" class="btn_cancel">취소</a> */ ?>
                    <input type="submit" value="<?php echo $w == '' ? '회원가입' : '정보수정'; ?>" id="btn_submit" class="btn_submit" accesskey="s">
                </div>
            </div>
        </form>
<?php if ($w == 'u') { ?>
			</div>
	
<?php } ?>
		</div>
	</div>
</div>

    <script>
        var authYn = "<?php echo $w == "" ? "N" : "Y" ?>";
        var authNo = "";
        var hpNo = "";
        $(function () {
            $("#dup_id").click(function () {
                var msg = reg_mb_id_check();
                if(msg.length===2){msg = 0;}

                if (msg) {
                    alert(msg);
                    $("#reg_mb_id").select();
                    return;
                } else {
                    alert("사용가능한 아이디 입니다.");
                    return;
                }
            });

            $("#dup_nick").click(function () {
                var msg = reg_mb_nick_check();
                if(msg.length===2){msg = 0;}
                
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

                    $("#reg_mb_hp").val(hpNo);
                    var msg = reg_mb_hp_check();
                    if(msg.length===2){msg = 0;}
                    
                    if (msg) {
                        alert(msg);
                        f.reg_mb_hp.select();
                        return false;
                    }

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
            // 회원아이디 검사
            if (f.w.value == "") {
                var msg = reg_mb_id_check();
                if(msg.length===2){msg = 0;}
                
                if (msg) {
                    alert(msg);
                    f.mb_id.select();
                    return false;
                }
            }

            if (f.w.value == "") {
                if (f.mb_password.value.length < 3) {
                    alert("비밀번호를 3글자 이상 입력하십시오.");
                    f.mb_password.focus();
                    return false;
                }
            }

            if (f.mb_password.value != f.mb_password_re.value) {
                alert("입력하신 비밀번호가 일치하지않습니다.");
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

<?php if ($w == 'u') { ?>
                if (f.mb_password_origin.value == "") {
                    alert("현재 비밀번호를 입력하십시오.");
                    f.mb_password_origin.focus();
                    return false;
                }
<?php } ?>

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
                if(msg.length===2){msg = 0;}
                
                if (msg) {
                    alert(msg);
                    f.reg_mb_nick.select();
                    return false;
                }
            }
            /*
             // E-mail 검사
             if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
             var msg = reg_mb_email_check();
             if (msg) {
             alert(msg);
             f.reg_mb_email.select();
             return false;
             }
             }
             */
<?php if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) { ?>
                // 휴대폰번호 체크
                var msg = reg_mb_hp_check();
                if(msg.length===2){msg = 0;}
                
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
                if(msg.length===2){msg = 0;}
                
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
    </script>

    <!-- } 회원정보 입력/수정 끝 -->
