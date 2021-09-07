<?php
include_once('./_common.php');

if (!$is_member)
    goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_URL.'/mypage_mycounsel2.php'));

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/mypage_mycounsel2.php');
    return;
}

add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);


$g5['title'] =  '나의 상담문의';

include_once(G5_PATH.'/head.php');

$sql_common = " from `{$g5['g5_shop_item_qa_table']}` a JOIN `{$g5['member_table']}` b ON a.mb_id=b.mb_id where a.it_id = '{$member['mb_no']}' ";

// 테이블의 전체 레코드수만 얻음
$sql = " select COUNT(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 10;
$total_page  = ceil($total_count / $rows); // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 레코드 구함

$sql = "select a.*, b.mb_no it_id, b.mb_nick it_name $sql_common order by iq_id desc limit $from_record, $rows ";
//echo $sql;
$result = sql_query($sql);
?>


<div class="c_hero">
	<strong>신선운세 <mark>나의 상담문의</mark></strong>
</div>
<div class="c_list">
	<div class="cl_menu">
		<a href="<?php echo G5_URL; ?>"><i></i><span class="blind">HOME</span></a>
		<span>신선운세</span>
		<span>마이페이지</span>
		<span><mark><a href="/mypage_mycounsel2.php" class="sct_here">나의 상담문의</a></mark></span>
	</div>
	<div class="cl_function mypage">
		<li>
			<span><?php echo $member['mb_name']; ?>님</span>
			<span><?php echo $member['mb_nick']; ?>님</span>
		</li>
	</div>
</div>

<div class="c_area">
	<div class="wrap">
		<ul id="mypage-tab">
		<?php
		include_once(G5_SHOP_PATH.'/mymenu.php');
		?>
		</ul>
  <!-- 주문 내역 시작 { -->
    <div id="mypage-content">

      <p>나의 상담문의</p>

       <div class="ca_board">
		  <table class="cab_table">
            <colgroup>
              <col class="w120">
              <col class="w120">
              <col width="*">
              <col class="w120">
              <col class="w120">
            </colgroup>
            <thead>
              <tr>
                <th>상태</th>
                <th>작성자</th>
                <th>문의내용</th>
                <th>문의날짜</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
<?php
$thumbnail_width = 500;
$iq_num     = $total_count - ($page - 1) * $rows;

for ($i=0; $row=sql_fetch_array($result); $i++)
{
	$iq_name    = get_text($row['iq_name']);
	$iq_subject = conv_subject($row['iq_subject'],50,"…");

	$is_secret = false;
	if($row['iq_secret']) {
		$iq_subject .= ' <img src="'.G5_SHOP_SKIN_URL.'/img/icon_secret.gif" alt="비밀글">';

		//if($is_admin || $member['mb_id' ] == $row['mb_id']) {
			$iq_question = get_view_thumbnail(conv_content($row['iq_question'], 1), $thumbnail_width);
		//} else {
		//	$iq_question = '비밀글로 보호된 문의입니다.';
		//	$is_secret = true;
		//}
	} else {
		$iq_question = get_view_thumbnail(conv_content($row['iq_question'], 1), $thumbnail_width);
	}
	$iq_time    = substr($row['iq_time'], 2, 8);

	$hash = md5($row['iq_id'].$row['iq_time'].$row['iq_ip']);

	$iq_stats = '';
	$iq_style = '';
	$iq_answer = '';

	if ($row['iq_answer'])
	{
		$iq_answer = get_view_thumbnail(conv_content($row['iq_answer'], 1), $thumbnail_width);
		$iq_stats = '답변완료';
		$iq_style = 'sit_qaa_done';
		$is_answer = true;
	} else {
		$iq_stats = '답변대기';
		$iq_style = 'sit_qaa_yet';
		$iq_answer = '답변이 등록되지 않았습니다.';
		$is_answer = false;
	}

	if ($i == 0) echo '<ol id="sit_qa_ol">';
?>
				<tr>
					<td class="cg"><?php echo $iq_stats; ?></td><!--답변대기/답변완료-->
					<td><?php echo $row['it_name']; ?></td>
					<td class="cabt_subject "><?php echo $iq_subject; ?></td>
					<td><?php echo $iq_time; ?></td>
					<td>
					<?php if($member['mb_level'] == 3) { ?>
					<button type="button" class="btn t2 little text small load_col cabt_btn open">답변하기</button>
					<button type="button" class="btn little text small cw load_col cabt_btn close">닫기</button>
					<?php } else { ?>
					<button type="button" class="btn t2 little text small load_col cabt_btn open">자세히보기</button>
					<button type="button" class="btn little text small cw load_col cabt_btn close">닫기</button>
					<?php } ?>
					</td>
				</tr>
				<tr class="reply_col">
					<td colspan="5" class="reply">
					<div class="cabt_reply">
						<div class="cabtr_wrap">
							<h3>문의내용</h3>
							<?php echo $iq_question; // 상품 문의 내용 ?>

						</div>
					</div>
					<?php if(!$is_secret) { ?>
						<?php if($member['mb_level'] == 3) { ?>
					<div class="cabt_txt">
						<h3>답변작성</h3>
						<form class="" method="post" action="./mypage_mycounsel2_update.php">
						<input type="hidden" name="iq_id" value="<?php echo $row['iq_id']; ?>">
						<textarea name="iq_answer" class="cabtt_wrap t1 reply_textarea" placeholder="답변내용을 입력하세요"><?php echo $iq_answer; // 상품 문의 내용 ?></textarea>
						<div class="button_area">
							<button type="button" name="button" class="btn minor text tiny t2">취소</button>
							<button type="submit" name="button" class="btn minor text tiny t1">저장</button>
						</div>
						</form>
					</div>
						<?php } else { ?>
					<div class="cabt_txt">
						<h3>답변내용</h3>
						<div class="cabtt_wrap">
						<?php echo $iq_answer; // 상품 문의 내용 ?>
						</div>
					</div>
						<?php } ?>
					<?php } ?>
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
  /*$('.load_col').click(function(){
    var originParent = $(this).parents('tr');
    originParent.next('.reply_col').show();
  });*/
  $('.reply_cancel').click(function(){
    $(this).parents('.reply_col').hide();
  });
  $(".load_col").click(function(){
    var originParent = $(this).parents('tr');console.log(originParent.next(".reply_col p").text());
    originParent.next('.reply_col').toggle();
	if(originParent.hasClass("on")){
		originParent.removeClass("on");
	}else{
		originParent.addClass("on");
	}
  });
});
</script>

<?php
include_once(G5_PATH.'/tail.php');
?>
