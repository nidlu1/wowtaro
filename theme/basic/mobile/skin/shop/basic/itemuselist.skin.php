<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<!--후기게시글 규정 팝업-->
<!--<div class="review_pop">
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
      </div>-->
        
<!--      <div class="review_pop_content">
        <h2>상담후기 작성시 유의사항</h2>
        <div class="review_pop_list">
          <p>
            <span class="num_style">1</span>
            3자 미만의 제목, 30자 이하의 성의없는 후기
          </p>
          <p>
            <span class="num_style">2</span>
            상담과 무관한 내용의 후기
          </p>
          <p>
            <span class="num_style">3</span>
            다른후기와 중복하여(카피 또는 도용) 작성한 경우
          </p>
          <p>
            <span class="num_style">4</span>
            한번의 상담으로 여러번의 반복적인 후기를 남긴 경우
          </p>
          <p>
            <span class="num_style">5</span>
            관리자 판단으로 코인지급이 불가능한 후기
          </p>
        </div>
      </div>-->
        
    </div>
  </div>

<!-- 전체 상품 사용후기 목록 시작 { -->
<!-- <form method="get" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
<div id="sps_sch">
    <div class="sch_wr">
        <label for="sfl" class="sound_only">검색항목</label>
        <select name="sfl" id="sfl" required>
            <option value="">선택</option>
            <option value="b.it_name"   <?php echo get_selected($sfl, "b.it_name"); ?>>상품명</option>
            <option value="a.it_id"     <?php echo get_selected($sfl, "a.it_id"); ?>>상품코드</option>
            <option value="a.is_subject"<?php echo get_selected($sfl, "a.is_subject"); ?>>후기제목</option>
            <option value="a.is_content"<?php echo get_selected($sfl, "a.is_content"); ?>>후기내용</option>
            <option value="a.is_name"   <?php echo get_selected($sfl, "a.is_name"); ?>>작성자명</option>
            <option value="a.mb_id"     <?php echo get_selected($sfl, "a.mb_id"); ?>>작성자아이디</option>
        </select>
        <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" required class="sch_input" size="10">
        <button type="submit" value="검색" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
    </div>
    <a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">전체보기</a>

</div>
</form> -->
<div class="navi clearfix">
  <div class="left">
    <a href="#">
    </a>
  </div>

  <div class="right">
    <a href="/index.php" class="home"><i class="xi-home"></i></a>
    <i class="xi-angle-right-min"></i>
    <a href="#" class="txt">상담후기</a>
  </div>
</div>

<div id="review">
  <div class="sub_banner" id="sub_review">
    <h2>상담후기</h2>
    <p>실제 상담한 회원만 작성 가능한 리얼 상담후기</p>
  </div>
</div>

<div class="review_tabs">
  <ul>
    <li<?php echo $_REQUEST['gubun']=="" ? " class='active'" : ""; ?>><a href="<?php echo G5_SHOP_URL; ?>/itemuselist.php">전체상담후기</a></li>
    <li<?php echo $_REQUEST['gubun']=="best" ? " class='active'" : ""; ?>><a href="<?php echo G5_SHOP_URL; ?>/itemuselist.php?gubun=best">베스트후기</a></li>
    <li<?php echo $_REQUEST['gubun']=="할인상담" ? " class='active'" : ""; ?>><a href="<?php echo G5_SHOP_URL; ?>/itemuselist.php?gubun=할인상담">할인상담후기</a></li>
    <li<?php echo $_REQUEST['gubun']=="일반상담" ? " class='active'" : ""; ?>><a href="<?php echo G5_SHOP_URL; ?>/itemuselist.php?gubun=일반상담">일반상담후기</a></li>
  </ul>
</div>

<!--div class="inner">
  <a href="<?php echo $itemuse_form; ?>" class="board_write_btn">후기등록</a>
</div-->

<div id="sps">

    <!-- <p><?php echo $config['cf_title']; ?> 전체 사용후기 목록입니다.</p> -->

      <div class="policy review_pop_open" style="float: none; margin-left: 10px;">
        <p>상담후기 운영 정책</p>
      </div>

    <?php
    $thumbnail_width = 500;

    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $num = $total_count - ($page - 1) * $rows - $i;
        $star = get_star($row['is_score']);

        $is_content = get_view_thumbnail(conv_content($row['is_content'], 1), $thumbnail_width);

        $row2 = sql_fetch(" select it_name from {$g5['g5_shop_item_table']} where it_id = '{$row['it_id']}' ");
        $it_href = G5_SHOP_URL."/item.php?it_id={$row['it_id']}";

        if ($i == 0) echo '<ol>';
    ?>
    <li class="sit_use_li">
      <div class="sps_img">
            <a href="<?php echo $it_href; ?>">
                <?php echo get_itemuselist_thumbnail($row['it_id'], $row['is_content'], 70, 70); ?>
                <span><?php echo $row2['it_name']; ?></span>
            </a>
        </div>
		<?php
		$bcat_arr = b_cat_func($row['mb_1']);
		$scat_arr = s_cat_func($row['mb_2']);

		$l = searchForId("ca_name", $row['is_cat2'], $bcat_arr);

		//switch ($bcat_arr[$j]['ca_id']) {
		switch ($row['is_cat2']) {
			case '타로' :
				$bcat_str = "taro";
				$bcat_bg = "back_taro";
				break;
			case '신점' :
				$bcat_str = "sin";
				$bcat_bg = "back_shinjeom";
				break;
			case '사주' :
				$bcat_str = "saju";
				$bcat_bg = "back_saju";
				break;
			case '펫타로' :
				$bcat_str = "pet";
				$bcat_bg = "back_pettaro";
				break;
			case '꿈해몽' :
				$bcat_str = "dream";
				$bcat_bg = "back_dream";
				break;
			default :
				$bcat_str = "taro";
				$bcat_bg = "back_taro";
				break;
		}
		?>
        <section class="sps_section clearfix">
  			<div class="sps_section_title">
    			<a href="<?php echo G5_SHOP_URL; ?>/item.php?ca_id=<?php echo $bcat_arr[$l]['ca_id']; ?>&it_id=<?php echo $row['mb_no']; ?>&anchor=sit_use">
            <div class="review_back teacher_back_common <?php echo $bcat_bg; ?>">
              <!-- 선생님 배경이미지 : 클래스, 배경이미지 바뀜(sct_img 뒤에 클래스 추가)
              타로 일때 : back_taro (현재 예시로 설정해 놓음)
              꿈해몽 일떄 : back_dream
              펫타로 일때 : back_taro
              사주 일떄 : back_saju
              신점 일때 : back_shinjeom -->
              <img src="<?php echo G5_DATA_URL; ?>/temp/<?php echo $row['mb_no']; ?>/<?php echo $row['mb_8']; ?>" height="145" alt="<?php echo $row['mb_nick']; ?> <?php echo $row['mb_id']; ?>번">
            </div>
            <div class="sps_section_title_title">
              <!--카테고리 스타일2-->
              <span class="sub_cate">
                <!--타로일때-->
                <span class="cate-<?php echo $bcat_str; ?>">
                  <?php echo $row['is_cat2'];//echo $bcat_arr[$j]['ca_name']; ?>
                </span>

                <!--사주일때
                <span class="cate-saju">
                  <?php echo $row['is_cat2']; ?>
                </span>-->

                <!--신점일때
                <span class="cate-sin">
                  <?php echo $row['is_cat2']; ?>
                </span>-->

                <!--꿈해몽일때
                <span class="cate-dream">
                  <?php echo $row['is_cat2']; ?>
                </span>-->

                <!--펫타로일때
                <span class="cate-dream">
                  <?php echo $row['is_cat2']; ?>
                </span>-->

              </span>
                <!--//카테고리 스타일2-->
              <?php echo $row['mb_nick']; ?>
              <?php echo $row['mb_id']; ?>번
            </div>
    			</a>
  			</div>
        <div class="sps_section_content">
          <div class="user_state">
              <span class="default"><?php echo $row['is_best'] == 1 ? "[BEST]" : ""; ?><?php echo $row['is_cat']; ?></span>
                <h2><?php echo $row['is_name']; ?></h2>
              <div class="user_data">
                <div class="user_star"><img src="<?php echo G5_URL; ?>/shop/img/s_star<?php echo $star; ?>.png" alt="별<?php echo $star; ?>개" width="80"></div>
                <!-- <div class="user_date"><?php echo substr($row['is_time'],0,10); ?></div> -->
              </div>
            </div>

            <div id="sps_con_<?php echo $i; ?>">
                <?php echo $is_content; // 사용후기 내용 ?>

                <?php
                if( !empty($row['is_reply_subject']) ){
                  echo "<a class=\"toggle_reply\">1개의 댓글이 있습니다.</a>";
                } ?>

                <?php
                if( !empty($row['is_reply_subject']) ){     //사용후기 답변이 있다면
                    $is_reply_content = get_view_thumbnail(conv_content($row['is_reply_content'], 1), $thumbnail_width);
                ?>
                <div class="sit_use_reply sps_reply" style="display: none;">
                        <div class="sps_dl">
                            <strong><?php echo $row['is_reply_name']; ?></strong> <!--span>2019-00-00</span-->
                        </div>

                        <div id="sps_con_<?php echo $i; ?>_reply">
                            <?php echo $is_reply_content; // 사용후기 답변 내용 ?>
                        </div>
                </div>
                <?php }     //end if ?>

        </div>

          </div>

            <!-- <div class="sps_con_btn"><button class="sps_con_<?php echo $i; ?>">내용보기 <i class="fa fa-caret-down" aria-hidden="true"></i></button></div> -->
        </section>

    </li>


    <?php }
    if ($i > 0) echo '</ol>';
    if ($i == 0) echo '<p id="sps_empty">자료가 없습니다.</p>';
    ?>
</div>

<?php echo get_paging($config['cf_mobile_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
$(function(){
    // 사용후기 더보기
    $(".toggle_reply").click(function(){
        var $con = $(this).next('.sps_reply');
        if($con.is(":visible")) {
            $con.hide();
            $(this).html("1개의 댓글이 있습니다.");
        } else {
          $con.show();
          $(this).html("댓글접기");
        }
    });

    $(".sps_con_btn button").click(function(){
        var $con = $(this).parent().prev();
        if($con.is(":visible")) {
            $con.slideUp();
            $(this).html("내용보기 <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i>");
        } else {
            $(".sps_con_btn button").html("내용보기 <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i>");
            $("div[id^=sps_con]:visible").hide();
            $con.slideDown(
                function() {
                    // 이미지 리사이즈
                    $con.viewimageresize2();
                }
            );
            $(this).html("내용닫기 <i class=\"fa fa-caret-up\" aria-hidden=\"true\"></i>");
        }
    });

  //상담후기 운영정책 팝업
  $('.review_pop_open').click(function(){
    $('.review_pop').show();
  });
  $('.review_pop_close').click(function(){
    $('.review_pop').hide();
  });
});
</script>
<!-- } 전체 상품 사용후기 목록 끝 -->
