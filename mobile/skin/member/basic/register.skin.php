<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div class="sub_banner" id="sub_join">
  <h2>일반회원 가입</h2>
</div>

<div class="mbskin">

    <?php
    // 소셜로그인 사용시 소셜로그인 버튼
    @include_once(get_social_skin_path().'/social_register.skin.php');
    ?>

    <form name="fregister" id="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">

    <div class="chk_all">
        <input type="checkbox" name="chk_all" id="chk_all">
        <label for="chk_all">전체선택</label>

    </div>
    <section id="fregister_term">
        <h2>회원가입약관
          <fieldset class="fregister_agree">
              <input type="checkbox" name="agree" value="1" id="agree11">
              <label for="agree11">회원가입약관 내용에 동의합니다.</label>
          </fieldset>
        </h2>
        <textarea readonly><?php echo get_text($config['cf_stipulation']) ?></textarea>
    </section>

    <section id="fregister_private">
        <h2>개인정보처리방침
          <fieldset class="fregister_agree">
              <input type="checkbox" name="agree2" value="1" id="agree21">
               <label for="agree21">개인정보처리방침 내용에 동의합니다.</label>
         </fieldset>
       </h2>
        <div class="tbl_head01 tbl_wrap">
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
    </section>

    <div class=" btn_top">
        <input type="submit" class="btn_submit" value="회원가입">
    </div>

    </form>

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

    jQuery(function($){
        // 모두선택
        $("input[name=chk_all]").click(function() {
            if ($(this).prop('checked')) {
                $("input[name^=agree]").prop('checked', true);
            } else {
                $("input[name^=agree]").prop("checked", false);
            }
        });
    });
    </script>

</div>