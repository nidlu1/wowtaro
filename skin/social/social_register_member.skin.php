<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가

if (!$config['cf_social_login_use']) {     //소셜 로그인을 사용하지 않으면
    return;
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . G5_JS_URL . '/remodal/remodal.css">', 11);
add_stylesheet('<link rel="stylesheet" href="' . G5_JS_URL . '/remodal/remodal-default-theme.css">', 12);
add_stylesheet('<link rel="stylesheet" href="' . get_social_skin_url() . '/style.css">', 13);
add_javascript('<script src="' . G5_JS_URL . '/remodal/remodal.js"></script>', 10);
add_stylesheet('<link rel="stylesheet" href="' . $member_skin_url . '/style.css">', 0);

$email_msg = $is_exists_email ? '등록할 이메일이 중복되었습니다.다른 이메일을 입력해 주세요.' : '';
?>

<div class="sub_banner"  id="sub_join">
    <h2>SNS 가입</h2>
</div>
<!-- 회원가입약관 동의 시작 { -->
<div class="mbskin" id="register_member" style="width: 70%; border: 0px;">
    <script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
    <form id="fregister" name="fregisterform" action="<?php echo $register_action_url; ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="w" value="<?php echo $w; ?>">
        <input type="hidden" name="url" value="<?php echo $urlencode; ?>">
        <input type="hidden" name="mb_name" value="<?php echo $user_name ? $user_name : $user_nick ?>" >
        <input type="hidden" name="provider" value="<?php echo $provider_name; ?>" >
        <input type="hidden" name="action" value="register">
        <input type="hidden" name="mb_id" value="<?php echo $user_id; ?>" id="reg_mb_id">
        <input type="hidden" name="mb_nick_default" value="<?php echo isset($user_nick) ? get_text($user_nick) : ''; ?>">
        <input type="hidden" name="mb_nick" value="<?php echo isset($user_nick) ? get_text($user_nick) : ''; ?>" id="reg_mb_nick">

        <p>회원가입약관 및 개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.</p>
        <div id="fregister_chkall">
            <label for="chk_all">전체선택</label>
            <input type="checkbox" name="chk_all"  value="1"  id="chk_all">

        </div>
        <section id="fregister_term">
            <h2><i class="fa fa-check-square-o" aria-hidden="true"></i> 회원가입약관</h2>
            <textarea readonly><?php echo get_text($config['cf_stipulation']) ?></textarea>
            <fieldset class="fregister_agree">
                <label for="agree11">회원가입약관의 내용에 동의합니다.</label>
                <input type="checkbox" name="agree" value="1" id="agree11">
            </fieldset>
        </section>

        <section id="fregister_private">
            <h2><i class="fa fa-check-square-o" aria-hidden="true"></i> 개인정보처리방침안내</h2>
            <div>
                <table>
                    <caption>개인정보처리방침안내</caption>
                    <thead>
                        <tr>
                            <th>목적</th>
                            <th>항목</th>
                            <th>보유기간</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>이용자 식별 및 본인여부 확인</td>
                            <td>아이디, 이름, 비밀번호</td>
                            <td>회원 탈퇴 시까지</td>
                        </tr>
                        <tr>
                            <td>고객서비스 이용에 관한 통지,<br>CS대응을 위한 이용자 식별</td>
                            <td>연락처 (이메일, 휴대전화번호)</td>
                            <td>회원 탈퇴 시까지</td>
                        </tr>
                    </tbody>
                </table>
                <br>
                - 휴대폰 본인확인 시 타인 명의를 도용할 경우, "정보통신망법 제 49조"에 의거하여 5년 이하의 징역 또는 5천만원 이하의 벌금에 처할 수 있습니다.
            </div>

            <fieldset class="fregister_agree">
                <label for="agree21">개인정보처리방침안내의 내용에 동의합니다.</label>
                <input type="checkbox" name="agree2" value="1" id="agree21">
            </fieldset>
        </section>
        
        
        <div class="sns_tbl tbl_wrap">
            <table>
                <caption>개인정보 입력</caption>
                <tbody>
                    <tr>
                        <th scope="row"><label for="reg_mb_email">E-mail<strong class="sound_only">필수</strong></label></th>
                        <td>
                            <input type="text" name="mb_email" value="<?php echo isset($user_email) ? $user_email : ''; ?>" id="reg_mb_email" required class="frm_input email required" size="70" maxlength="100" placeholder="이메일을 입력해주세요." >
                            <!--<p class="email_msg"><?php echo $email_msg; ?></p>-->
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="btn_confirm">
            <input type="submit" value="회원가입" id="btn_submit" class="btn_submit" accesskey="s" style="width: 100px; padding: 0 0 0 0;">
        </div>
    </form>
        <div class="member_connect">
        <p class="strong">혹시 기존 회원이신가요?</p>
        <button type="button" class="connect-opener btn-txt" data-remodal-target="modal">
            기존 계정에 연결하기
            <i class="fa fa-angle-double-right"></i>
        </button>
    </div>

    <div id="sns-link-pnl" class="remodal" data-remodal-id="modal" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
        <button type="button" class="connect-close" data-remodal-action="close">
            <i class="fa fa-close"></i>
            <span class="txt">닫기</span>
        </button>
        <div class="connect-fg">
            <form method="post" action="<?php echo $login_action_url ?>" onsubmit="return social_obj.flogin_submit(this);">
                <input type="hidden" id="url" name="url" value="<?php echo $login_url ?>">
                <input type="hidden" id="provider" name="provider" value="<?php echo $provider_name ?>">
                <input type="hidden" id="action" name="action" value="social_account_linking">

                <div class="connect-title">기존 계정에 연결하기</div>

                <div class="connect-desc">
                    기존 아이디에 SNS 아이디를 연결합니다.<br>
                    이 후 SNS 아이디로 로그인 하시면 기존 아이디로 로그인 할 수 있습니다.
                </div>

                <div id="login_fs">
                    <label for="login_id" class="login_id">아이디<strong class="sound_only"> 필수</strong></label>
                    <span class="lg_id"><input type="text" name="mb_id" id="login_id" class="frm_input required" size="20" maxLength="20" ></span>
                    <label for="login_pw" class="login_pw">비밀번호<strong class="sound_only"> 필수</strong></label>
                    <span class="lg_pw"><input type="password" name="mb_password" id="login_pw" class="frm_input required" size="20" maxLength="20"></span>
                    <br>
                    <input type="submit" value="연결하기" class="login_submit btn_submit">
                </div>

            </form>
        </div>
    </div>
    
    <script>
        function fregister_submit(f)
        {
            if (!f.agree.checked) {
                alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
                f.agree.focus();
                return false;
            }

            if (!f.agree2.checked) {
                alert("개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
                f.agree2.focus();
                return false;
            }

            return true;
        }

        jQuery(function ($) {
            // 모두선택
            $("input[name=chk_all]").click(function () {
                if ($(this).prop('checked')) {
                    $("input[name^=agree]").prop('checked', true);
                } else {
                    $("input[name^=agree]").prop("checked", false);
                }
            });
        });

    </script>
</div>
<!-- } 회원가입 약관 동의 끝 -->
