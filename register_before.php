<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/register_before.php');
    return;
}
$g5['title'] = '회원가입';

include_once(G5_THEME_PATH.'/head.php');
?>

<div class="sub_banner" id="sub_join">
  <h2>회원가입</h2>
</div>
<div id="sub_wrap">
  <div class="inner">
    <div class="join_type">
      <div class="join_column">
        <a href="/bbs/register.php">
        <i class="xi-user"></i>
        <h4>일반회원</h4>
        <span class="button_label">가입하기</span>
        </a>
      </div>
      <div class="join_column">
        <a href="/bbs/register2.php">
        <i class="xi-message-o"></i>
        <h4>상담사회원</h4>
        <span class="button_label">가입하기</span>
        </a>
      </div>
    </div>
  </div>
</div>


<?php
include_once(G5_THEME_PATH.'/tail.php');
?>
