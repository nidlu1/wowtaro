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


<div class="sub_banner" id="sub_mypage">
  <h2>나의 상담후기</h2>
    <h3 style="color: white "><?=$member['mb_name']?> / <?=$member['mb_nick']?></h3>
</div>

  <div class="order-wr clearfix">
    <ul class="mypage-tab">
	<?php
	include_once(G5_SHOP_PATH.'/mymenu.php');

  if ( $member['mb_level'] == 3 ) {}else{
	?>
  <li><a>&nbsp;</a></li>
  <?php }  ?>
    </ul>
  <!-- 주문 내역 시작 { -->
    <div id="sod_v">
      <!-- <div class="myreview_tabs">
        <ul>
          <li class="active"><a href="/mypage_myreview.php">작성 가능한 상담후기(2)</a></li>
          <li><a href="mypage_myreview2.php">작성 완료한 상담 후기(1)</a></li>
        </ul>
      </div> -->

      <div class="policy review_pop_open">
        <p>상담후기 운영 정책</p>
      </div>

        <div class="tbl_head03 tbl_wrap">
          <table>
            <thead>
              <tr>
                <th scope="col">분류</th>
                <th scope="col">작성자</th>
                <th scope="col">상담날짜</th>
                <th scope="col"></th>
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

	//if ($i == 0) echo '<ol id="sit_use_ol">';
	$star_str = "";
	for ($jj = 1; $jj <= 5; $jj++) {
		if ($jj <= $is_star) $star_str .= "<i class='xi-star'></i>";
		else $star_str .= "<i class='xi-star-o'></i>";
	}
?>
              <tr>
                <td><?php echo $row['is_cat']; ?></td><!--할인상담/일반상담-->
                <td><?php echo $row['mb_nick']; ?></td>
                <td><?php echo $is_time; ?></td>
                <td>
                  <!-- 상담사 회원일 시에는 출력하지 않음 -->
                  <button class="myrev_btn load_col">자세히보기</button>
                  <!-- //상담사 회원일 시에는 출력하지 않음 -->
                  <!-- 상담사 회원일 시 -->
                  <!-- <button class="myrev_btn load_col">답변하기</button> -->
                  <!-- //상담사 회원일 시 -->
                </td>
              </tr>
              <tr class="reply_col">
                <td colspan="4">
                  <div class="origin_text">
                    <h3>후기내용</h3>
                    <p>
                      <?php echo $is_content; // 후기 내용 ?>
                    </p>

				  <?php
				  if ($is_admin || $row['it_id'] == $member['mb_no']) {
					$itemuse_form2 = "./shop/itemuseform2.php?it_id=".$row['it_id']."&is_cat2=".$row['is_cat2'];
				  ?>
                    <a href="<?php echo $itemuse_form2."&amp;is_id={$row['is_id']}&amp;w=u"; ?>" class="itemuse_form btn01" onclick="return false;">답글</a>
                  <?php } ?>

                  <?php if( $is_reply_subject ){  //  사용후기 답변 내용이 있다면 ?>
				  <button type="button" class="toggle_reply">1개의 댓글이 있습니다.</button>

                  <div class="sit_use_reply">
                      <div class="use_reply_p">
                          <?php echo $is_reply_content; // 답변 내용 ?>
                      </div>
                  </div>
                  <?php } //end if ?>
                  </div>
                </td>
              </tr>
              <?php
              }

              if ($i == 0)
                  echo '<tr><td colspan="6" class="empty_table"> 상담후기 내역이 없습니다.</td></tr>';
              ?>
            </tbody>
          </table>
        </div>
      </div>
  </div><!--order-wr-->
<!-- } 주문 내역 끝 -->

<script>
$(function() {
  //$('#check_pop').click(function(){
    //$('#layer').show();
  //});
  $('.dim_bg, .pop_close').click(function(){
    $('#layer').hide();
  });
  $('.load_col').click(function(){
    var originParent = $(this).parents('tr');
    originParent.next('.reply_col').toggle();
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
      var $con = $(this).next('.sit_use_reply');
      if($con.is(":visible")) {
          $con.hide();
          $(this).html("1개의 댓글이 있습니다.");
      } else {
        $con.show();
        $(this).html("댓글접기");
      }
  });

});
</script>



<?php
include_once(G5_PATH.'/tail.php');
?>
