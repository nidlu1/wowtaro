<?php
include_once('./_common.php');

include_once(G5_EDITOR_LIB);
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);


$g5['title'] =  '나의 상담후기';

include_once(G5_PATH.'/head.php');

$sql_common = " from `{$g5['g5_shop_item_use_table']}` a JOIN `{$g5['member_table']}` b ON a.mb_id=b.mb_id where a.it_id = '{$member['mb_no']}' and a.is_confirm = '1' ";

// 테이블의 전체 레코드수만 얻음
$sql = " select COUNT(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 10;
$total_page  = ceil($total_count / $rows); // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 레코드 구함

$sql = "select a.*,b.mb_nick $sql_common order by a.is_id desc limit $from_record, $rows ";
$result = sql_query($sql);
//echo $sql;
?>

<div class="layer_pop" id="layer">
  <div class="layer_pop_container">
    <div class="pop_header">
      <h3>사용후기 쓰기</h3>
      <button type="button" class="pop_close"><i class="xi-close"></i></button>
    </div>
    <div class="pop_body">
      <?php $is_dhtml_editor = false;
      // 모바일에서는 DHTML 에디터 사용불가
      if ($config['cf_editor'] && (!is_mobile() || defined('G5_IS_MOBILE_DHTML_USE') && G5_IS_MOBILE_DHTML_USE)) {
          $is_dhtml_editor = true;
      }
      $editor_html = editor_html('is_content', get_text(html_purifier($use['is_content']), 0), $is_dhtml_editor);
      $editor_js = '';
      $editor_js .= get_editor_js('is_content', $is_dhtml_editor);
      $editor_js .= chk_editor_js('is_content', $is_dhtml_editor);

      $itemuseform_skin = G5_SHOP_SKIN_PATH.'/itemuseform2.skin.php';

      if(!file_exists($itemuseform_skin)) {
          echo str_replace(G5_PATH.'/', '', $itemuseform_skin).' 스킨 파일이 존재하지 않습니다.';
      } else {
          include_once($itemuseform_skin);
      } ?>
    </div>
  </div>
  <div class="dim_bg"></div>
</div>

<div class="review_pop">
    <div class="review_pop_container">
      <div class="review_pop_header">
        <i class="xi-close review_pop_close"></i>
      </div>
      <div class="review_pop_content">
        <h2>후기게시글 규정</h2>
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
            작성된 후기글에 작성자와 상담사 외 다른 고객이 쓴 댓글을 관리자가 임의 삭제할 수 있습니다.<br>
            <span class="review_help">(타인의 후기에 댓글을 달 때 발생할 수 있는 감정적인 문제를 예방하기 위함입니다.)</span>
          </p>

          <div class="sub_text">
            <p>* 후기 게시글 규정에 어긋나는 글에 대해서는 어떠한 알림없이 삭제될 수 있습니다.</p>
            <p>* 상담시 발생하는 고객들의 불만사항에 대해서는 삭제하지 않습니다.</p>
          </div>
        </div>
      </div>

      <div class="review_pop_content">
        <h2 class="margin_top_25">후기게시글 규정</h2>
        <div class="review_pop_list">
          <p>
            <span class="num_style">1</span>
            3자 미만의 제목, 30자 이하의 내용일 경우
          </p>
          <p>
            <span class="num_style">2</span>
            상담과 무관한 내용의 후기를 작성한 경우
          </p>
          <p>
            <span class="num_style">3</span>
            다른후기와 중복하여(카피 또는 도용) 작성한 경우
          </p>
          <p>
            <span class="num_style">4</span>
            한번의 상담으로 여러번의 반복적인 후기를 남긴 경우
          </p>
        </div>
      </div>
    </div>
  </div>
<div class="c_hero">
	<strong>신선운세 <mark>나의 상담후기</mark></strong>
</div>
<div class="c_list">
	<div class="cl_menu t1">
		<span>마이페이지</span>
		<span><mark>나의 상담후기</mark></span>
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
		<!-- 주문 내역 시작 { -->
		<div id="mypage-content">
		<p>나의 상담후기</p>
		<div class="ca_policy mypage">
			<a href="#review">상담후기 운영 정책</a>
		</div>
		<!--div class="myreview_tabs">
			<ul>
			  <li class="active"><a href="/mypage_myreview.php">작성 가능한 상담후기(2)</a></li>
			  <li><a href="/mypage_myreview2.php">작성 완료한 상담 후기(1)</a></li>
			</ul>
		</div-->
		<div class="ca_board">
		  <table class="cab_table">
			<thead>
			  <tr>
				<th>분류</th>
				<th>작성자</th>
				<th>상담날짜</th>
				<th></th>
			  </tr>
			</thead>
			<tbody>
<?php
$thumbnail_width = 500;

for ($i=0; $row=sql_fetch_array($result); $i++)
{
	$is_num     = $total_count - ($page - 1) * $rows - $i;
	$is_star    = get_star($row['is_score']);
	$is_name    = get_text($row['is_name']);
	$is_subject = conv_subject($row['is_subject'],50,"…");
	$is_content = get_view_thumbnail(conv_content($row['is_content'], 1), $thumbnail_width);
	$is_reply_name = !empty($row['is_reply_name']) ? get_text($row['is_reply_name']) : '';
	$is_reply_subject = !empty($row['is_reply_subject']) ? conv_subject($row['is_reply_subject'],50,"…") : '';
	$is_reply_content = !empty($row['is_reply_content']) ? get_view_thumbnail(conv_content($row['is_reply_content'], 1), $thumbnail_width) : '';
	$is_time    = substr($row['is_time'], 2, 8);
	$is_href    = './itemuselist.php?bo_table=itemuse&amp;wr_id='.$row['wr_id'];

	$hash = md5($row['is_id'].$row['is_time'].$row['is_ip']);

	//if ($i == 0) echo '<ol>';
	$star_str = "";
	for ($jj = 1; $jj <= 5; $jj++) {
		if ($jj <= $is_star) $star_str .= "<i class='ca_icon on'></i>";
		else $star_str .= "<i class='ca_icon off'></i>";
	}
?>
			<tr>
				<td class="cg"><strong>분류</strong><?php echo $row['is_cat']; ?></td><!--할인상담/일반상담-->
				<td><strong>작성자</strong><?php echo $row['mb_nick']; ?></td>
				<td><strong>제목</strong><?php echo $is_subject; // 사용후기 내용 ?></td>
				<td><strong>상담날짜</strong><?php echo $is_time; ?></td>
				<td>
					<strong>상세</strong>
					<button type="button" class="btn t2 little text tiny load_col cabt_btn open">자세히보기</button>
					<button type="button" class="btn little text tiny cw load_col cabt_btn close">닫기</button>
				</td>
			</tr>
			<tr class="reply_col">
				<td colspan="6" class="reply">
				<div class="cabt_reply">
					<div class="cabtr_wrap">
						<h3>후기내용</h3>
						<p>
						<?php echo $is_content; // 후기 내용 ?>
						</p>
						<div class="cabtr_comment">
							<?php if( $is_reply_subject ){  ?>
							<button type="button" class="toggle_reply">1개의 댓글이 있습니다.</button>
							 <?php } ?>
							<?php if( $is_reply_subject ){  //  사용후기 답변 내용이 있다면 ?>
							<div class="cabtrc_txt">
								<?php echo $is_reply_content; // 답변 내용 ?>
							</div>
							<?php } //end if ?>
						 
						<?php
						if ($is_admin || $row['it_id'] == $member['mb_no']) {
							$itemuse_form2 = "./shop/itemuseform2.php?it_id=".$row['it_id']."&is_cat2=".$row['is_cat2'];
						?>
							<a href="<?php echo $itemuse_form2."&amp;is_id={$row['is_id']}&amp;w=u"; ?>" class="itemuse_form btn minor text tiny t2" onclick="return false;">답변</a>
						<?php } ?>
						</div>
					</div>
				</div>
                </td>
              </tr>
<?php
}
?>
            </tbody>
          </table>
        </div>
      </div>
  </div><!--order-wr-->
</div> <!--inner-->
<!-- } 주문 내역 끝 -->

<script>
$(function() {
  $('#check_pop').click(function(){
    $('#layer').show();
  });
  $('.dim_bg, .pop_close').click(function(){
    $('#layer').hide();
  });
  $('.load_col').click(function(){
    var originParent = $(this).parents('tr');
    originParent.next('.reply_col').toggle();
	if(originParent.hasClass("on")){
		originParent.removeClass("on");
	}else{
		originParent.addClass("on");
	}
  });
  $('.reply_cancel').click(function(){
    $(this).parents('.reply_col').hide();
  });

  //상담후기 운영정책 팝업
  $('.review_pop_open').click(function(){
    $('.review_pop').show();
  });
  $('.review_pop_close').click(function(){
    $('.review_pop').hide();
  });

	$(".itemuse_form").click(function(){
		window.open(this.href, "itemuse_form", "width=810,height=680,scrollbars=1");
		return false;
	});
	$(".toggle_reply").click(function(){
	  var $con = $(this).parents('.cabtr_comment').children().eq(1);
	  if($con.is(":visible")) {
		  $con.hide();
		  $(this).html("1개의 댓글이 있습니다.");
	  } else {
		$con.show();
		$(this).html("접기");
	  }
	});
});
</script>



<?php
include_once(G5_PATH.'/tail.php');
?>
