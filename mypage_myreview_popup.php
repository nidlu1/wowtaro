<?php
include_once('./_common.php');
$fm_id = 24;
$sql = " select * from {$g5['faq_master_table']} where fm_id = '$fm_id' ";
$fm = sql_fetch($sql);


//echo $fa['fa_content'];
?>
<!--후기게시글 규정 팝업-->
<div class="review_pop">
    <div class="review_pop_container">
      <div class="review_pop_header">
        <i class="xi-close review_pop_close"></i>
      </div>
      <div class="review_pop_content">
        <h2>상담후기 코인 정책</h2>
        <div class="review_pop_list">
            <p>신선운세 상담후기는 회원가입 하고 상담한 회원만 후기를 쓸수가 있습니다.</p>
              <p>
                <span class="num_style">1</span>
                상담댓글 쓰기<br>
                <span class="review_help">상담후기는 로그인한 회원만 작성가능 하고 상담한 이력이 5분 이상인 분만 마이페이지에서 상담후기를 확인 하실수 있습니다. </span>
              </p>
              <p>
                <span class="num_style">2</span>
                상담댓글 작성시 코인지급 기준 <br>
                <span class="review_help">일반댓글 30자 이상 댓글 100코인</span> <br>
                <span class="review_help">손편지 댓글 상담인증 사진 첨부 500코인</span> <br>
                <span class="review_help">베스트 댓글 당첩시 3000코인</span>
              </p>
            <div class="sub_text">
                <h5>*상담후기 코인 지급 안내</h5>
                <p>1. 일반후기는 30자 이상 후기를 작성 하면 자동으로  코인지급 </p>
                <p>2. 손편지 사진첨부시 관리자에서 확인 하고 지급 개인적 연락처나 개인정보 노출되는 부분은 확인시 차감 됩니다. </p>
                <p>3. 베스트 댓글은 관리자가 매주 금요일날 지난 주 후기중 베스트 댓글 확인후 지급 합니다. </p>
                <p>4. 마이페이지 에서 확인 가능. </p>
            </div>
            <div class="sub_text">
                <h5>*손편지 꿀팁</h5>
                <p>1. 종이에 말하고 싶은 내용을 적은후 휴대폰 사진으로 찍은후 사진을 업로더 하는 방식.</p>
                <p>2. 추가 댓글을 적용시  관리자 에서 더 빠르게 지급 됩니다. </p>
            </div>
            <div class="sub_text">
                <h5>*베스트 상담후기 꿀팁</h5>
                <p>1. 300 이상 내용을 적어  주시고  손편지 까지 내용 첨부시 베스트 댓글 대상자가 될 확률이  더 높아집니다. </p>
                <p>2. 추가 댓글을 적용시  관리자 에서 더 빠르게 지급 됩니다. </p>
            </div>
        </div>
      </div>

      <div class="review_pop_content">
        <h2>상담사 댓글 관리규정</h2>
        <div class="review_pop_list">
          <p>
            <span class="num_style">1</span>
            카카오톡, SNS, 이메일, 전화번호와 같은 개인정보는 후기내용에 포함시키지 마세요.
          </p>
          <p>
            <span class="num_style">2</span>
            욕설과 비방, 명예훼손, 의미없는 글, 반복된 내용복사 등은 피해주세요.
          </p>
          <p>
            <span class="num_style">3</span>
            저작권, 초상권에 문제가 있는 사진과 게시물은 올리지 마세요.
          </p>
          <p>
            <span class="num_style">4</span>
            작성된 후기글에 작성자와 상담사 외 다른 고객이 쓴 후기는 관리자가 임의 삭제할 수 있습니다.<br>
            <span class="review_help">(타인의 후기에 댓글을 달 때 발생할 수 있는 감정적인 문제를 예방하기 위함입니다.)</span>
          </p>

          <div class="sub_text">
            <p>* 후기 게시글 규정에 어긋나는 글에 대해서는 어떠한 알림없이 삭제될 수 있습니다.</p>
            <p>* 상담시 발생하는 고객들의 불만사항에 대해서는 삭제하지 않습니다.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
$(function() {


  //상담후기 운영정책 팝업
  $('.review_pop_open').click(function(){
    $('.review_pop').show();
  });
  $('.review_pop_close').click(function(){
    $('.review_pop').hide();
  });
});
</script>
