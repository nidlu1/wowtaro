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
                <span class="review_help">일반후기 (30자 이상): 100코인</span> <br>
                <span class="review_help">손편지 후기 상담인증 (사진 첨부): 500코인</span> <br>
                <span class="review_help">베스트 후기 당첨시: 3000코인</span>
              </p>
            <div class="sub_text">
                <h5>*상담후기 코인 지급 안내</h5>
                <p>1. 일반후기는 30자 이상 후기를 작성 하면 자동으로 코인지급 </p>
                <p>2. 손편지후기(사진첨부)는 관리자 확인 후 지급, 개인적 연락처나 개인정보 노출시 개인정보 보호법에따라 삭제 될수 있습니다.</p>
                <p>3. 베스트 댓글은 관리자가 매주 금요일날 지난 주 후기중 베스트 댓글 확인후 지급 합니다. </p>
                <p>4. 마이페이지 에서 확인 가능. </p>
            </div>
            <div class="sub_text">
                <h5>*손편지 꿀팁</h5>
                <p>1. 정성가득 성의있는 손편지</p>
            </div>
            <div class="sub_text">
                <h5>*베스트 상담후기 꿀팁</h5>
                <p>1. 300자 이상 후기작성 후 손편지(사진첨부)시 베스트 댓글에 선정될 확률이 더 높아집니다.</p>
            </div>
        </div>
      </div>
      <div class="review_pop_content">
        <h2>상담사 댓글 관리규정</h2>
        <div class="review_pop_list">
          <p>
            <span class="num_style">1</span>
            카카오톡, SNS, 이메일, 전화번호와 같은 개인정보는 쓰시면 안됩니다.
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
            <p>* 상담시 발생하는 고객들의 불만사항에 대해서는 삭제하지 않습니다. 더 질높은 상담을 유도하기 위함입니다 하지만 고의적인 의도가 있어보일시 어떠한 알림없이 삭제 될 수 있음을 알려드립니다.</p>            
          </div>
          <div class="sub_text">
            <h2>상담후기 작성시 유의사항</h2>
            <p>1. 3자 미만의 제목, 30자 이하의 성의 없는 후기</p>
            <p>2. 상담과 무관한 내용의 후기</p>
            <p>3. 다른 후기와 중복하여(카피 또는 도용) 작성한 경우</p>
            <p>4. 한번의 상담으로 여러번의 반복적인 후기를 남긴 경우</p>
            <p>5. 관리자 판단으로 코인지급이 불가능한 후기</p>
            <p>6. 고의적인 후기작성이라 판단 되는 후기</p>
            <p>위의 조항들은 내담자님의 질높은 상담을 위한 유의 사항입니다.</p>
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
