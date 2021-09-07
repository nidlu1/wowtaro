<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/free_counsel.php');
    return;
}

// add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

$g5['title'] =  '5분무료상담';

include_once('./_head.php');

?>



<div class="sub_banner" id="sub_freecounsel">
  <h2>5분무료상담</h2>
</div>

<div class="sc_wrap free_counsel">
<div class="inner">
<div id="sct_location">
    <a href="/index.php" class="sct_bg"><i class="xi-home"></i></a>
    <a href="/free_conunsel.php" class="sct_here ">5분무료상담</a></div>
<div id="sct_hhtml"></div>

</div>
</div>

<div class="inner">
  <div class="banner_free">
    <h3>5분 무료 상담하기</h3>
    <p>
      신규회원가입을 하면 원하는 분야의 원하는 선생님과
      <b>5분동안 상담을 할 수 있는 코인을 선물</b>로 드립니다.
    </p>

    <div class="banner_free_how">
      <h4>이벤트 참여방법</h4>

      <div class="banner_free_how_info">
        <div class="">
          <p class="how_tit">신규회원가입</p>
          <p class="how_txt">휴대폰 본인인증 후 <br>신규 회원가입을 완료합니다.</p>
        </div>
        <div class="">
          <i></i>
          <p class="how_tit">5분 무료상담 신청</p>
          <p class="how_txt">5분 무료상담 페이지에서<br>무료상담 신청하세요.</p>
        </div>
        <div class="">
          <i></i>
          <p class="how_tit">상담하기</p>
          <p class="how_txt">1522-7229로 전화걸어<br>원하는 선생님과 상담하세요.</p>
        </div>

        <!--회원가입 시 안내사항~-->
      </div>
    </div>
  </div>

  <!-- 5분무료상담 폼 시작-->
  <div class="form_free">
    <h3>결제방법 선택</h3>
    <p class="chance">오늘의 잔여 상담권 수 : 30 / 30</p>

    <form class="">
      <div class="from_free_area">
        <div class="from_free_01">
          <label for="">
            선생님 선택
          </label>
          <select class="" name="">
            <option value="" selected>선생님을 선택해주세요</option>
          </select>
        </div>

        <div class="from_free_02">
          <label for="">전화번호</label><!--
          --><input type="num" name="" value=""><!--
          --><span class="bar"></span><!--
          --><input type="num" name="" value=""><!--
          --><span class="bar"></span><!--
          --><input type="num" name="" value="">
        </div>
      </div>

      <button type="submit" name="button">무료상담 신청하기</button>
    </form>
  </div>
  <!-- 5분무료상담 폼 끝-->

</div> <!--inner-->


<?php
include_once(G5_PATH.'/tail.php');
?>
