<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<div class="c_hero" id="sub_callcenter">
	<strong>신선운세 <mark>이벤트 의뢰 신청</mark></strong>
</div>
<div class="c_list">
	<div class="cl_menu">
		<a href="<?php echo G5_URL; ?>"><i></i><span class="blind">HOME</span></a>
		<span>신선운세</span>
		<span><mark><a href="/bbs/board.php?bo_table=event_form" class="sct_here ">이벤트 의뢰 신청</a></mark></span>
	</div>
</div>

<!-- 게시물 읽기 시작 { -->

<div class="c_area">
	<div class="wrap">
	<!-- 게시물 읽기 시작 { -->
	<section class="ca_board">
			<div class="cab_form">
				<div class="cabf_wrap">
					<div class="cabf_title">
						<span class="text middle cb s05">제목</span>
					</div>
					<div class="cabf_content">
						<h2 class="text middle bold cb s05">
							<?php if ($category_name) { ?>
							<?php echo $view['ca_name']; // 분류 출력 끝 ?>
							<?php } ?>
							<?php
							echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력
							?>
						</h2>
						<div class="fr">
							<div class="cabf_item">
								<i class="time"></i>
								<span class="text cg tiny s05"><?php echo date("Y.m.d", strtotime($view['wr_datetime'])) ?></span>
							</div>
						</div>
					</div>
				</div>
				<div class="cabf_wrap">
					<div class="cabf_title">
						<span class="text middle cb s05">선생님 인원</span>
					</div>
					<div class="cabf_content">
						<div class="fl">
							<span class="text middle cb s05">
								 남자 : <?php echo $view['wr_5'] ?> / 여자 : <?php echo $view['wr_6'] ?>
							</span>
						</div>
					</div>
				</div>
				<div class="cabf_wrap">
					<div class="cabf_title">
						<span class="text middle cb s05">기간</span>
					</div>
					<div class="cabf_content">
						<div class="fl">
							<span class="text middle cb s05">
								<?php echo $view['wr_3'] ?> ~ <?php echo $view['wr_4'] ?>
							</span>
						</div>
					</div>
				</div>
				<div class="cabf_wrap">
					<div class="cabf_title">
						<span class="text middle cb s05">지역</span>
					</div>
					<div class="cabf_content">
						<div class="fl">
							<span class="text middle cb s05">
								<?php echo $view['wr_2'] ?>
							</span>
						</div>
					</div>
				</div>
				<div class="cabf_wrap">
					<div class="cabf_title">
						<span class="text middle cb s05">연락처</span>
					</div>
					<div class="cabf_content">
						<div class="fl">
							<span class="text middle cb s05">
								<?php echo $view['wr_1'] ?>
							</span>
						</div>
					</div>
				</div>
				<div class="cabf_wrap">
					<div class="cabf_title">
						<span class="text middle cb s05">이메일</span>
					</div>
					<div class="cabf_content">
						<div class="fl">
							<span class="text middle cb s05">
								<?php echo $view['wr_email'] ?>
							</span>
						</div>
					</div>
				</div>
			</div>
			
				<!-- 2021-08-02<section id="bo_v_info">
					<h2>페이지 정보</h2>
					<span class="sound_only">작성자</span> <strong><?php echo $view['name'] ?><?php if ($is_ip_view) { echo "&nbsp;($ip)"; } ?></strong>
					<span class="sound_only">댓글</span><strong><a href="#bo_vc"> <i class="fa fa-commenting-o" aria-hidden="true"></i> <?php echo number_format($view['wr_comment']) ?>건</a></strong>
					<span class="sound_only">조회</span><strong><i class="fa fa-eye" aria-hidden="true"></i> <?php echo number_format($view['wr_hit']) ?>회</strong>
					<strong class="if_date"><span class="sound_only">작성일</span><?php echo date("y-m-d H:i", strtotime($view['wr_datetime'])) ?></strong>
				
				</section> -->

   <!--  <section id="bo_v_info">
        <h2>페이지 정보</h2>
        <strong class="if_date">
			<span class="sound_only">선생님인원</span>남자 : <?php echo $view['wr_5'] ?> / 여자 : <?php echo $view['wr_6'] ?><br />
			<span class="sound_only">기간</span><?php echo $view['wr_3'] ?> ~ <?php echo $view['wr_4'] ?><br />
			<span class="sound_only">지역</span><?php echo $view['wr_2'] ?><br />
			<span class="sound_only">연락처</span><?php echo $view['wr_1'] ?><br />
			<span class="sound_only">이메일</span><?php echo $view['wr_email'] ?>
		</strong>

    </section>
 -->
   	<section class="cab_body">
        <h2 class="blind">본문</h2>

        <?php
        // 파일 출력
        $v_img_count = count($view['file']);
        if($v_img_count) {
            echo "<div id=\"bo_v_img\">\n";

            for ($i=0; $i<=count($view['file']); $i++) {
                if ($view['file'][$i]['view']) {
                    //echo $view['file'][$i]['view'];
                    echo get_view_thumbnail($view['file'][$i]['view']);
                }
            }

            echo "</div>\n";
        }
         ?>

        <!-- 본문 내용 시작 { -->
        <div class="cabb_txt"><?php echo get_view_thumbnail($view['content']); ?></div>
        <?php //echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
        <!-- } 본문 내용 끝 -->

        <?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>


        <!--  추천 비추천 시작 { -->
        <?php if ( $good_href || $nogood_href) { ?>
        <div id="bo_v_act">
            <?php if ($good_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $good_href.'&amp;'.$qstr ?>" id="good_button" class="bo_v_good"><span class="sound_only">추천</span><strong><?php echo number_format($view['wr_good']) ?></strong></a>
                <b id="bo_v_act_good"></b>
            </span>
            <?php } ?>
            <?php if ($nogood_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $nogood_href.'&amp;'.$qstr ?>" id="nogood_button" class="bo_v_nogood"><span class="sound_only">비추천</span><strong><?php echo number_format($view['wr_nogood']) ?></strong></a>
                <b id="bo_v_act_nogood"></b>
            </span>
            <?php } ?>
        </div>
        <?php } else {
            if($board['bo_use_good'] || $board['bo_use_nogood']) {
        ?>
        <div id="bo_v_act">
            <?php if($board['bo_use_good']) { ?><span class="bo_v_good"><span class="sound_only">추천</span><strong><?php echo number_format($view['wr_good']) ?></strong></span><?php } ?>
            <?php if($board['bo_use_nogood']) { ?><span class="bo_v_nogood"><span class="sound_only">비추천</span><strong><?php echo number_format($view['wr_nogood']) ?></strong></span><?php } ?>
        </div>
        <?php
            }
        }
        ?>
        <!-- }  추천 비추천 끝 -->
		<?php
		$cnt = 0;
		if ($view['file']['count']) {
			for ($i=0; $i<count($view['file']); $i++) {
				if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
					$cnt++;
			}
		}
		 ?>
		<?php if(isset($view['link'][1]) && $view['link'][1]) { ?>
		<!-- 관련링크 시작 { -->
		<div class="cabb_data link cabb_link">
			<h2 class="blind">관련링크</h2>
			<ul>
			<?php
			// 링크
			$cnt = 0;
			for ($i=1; $i<=count($view['link']); $i++) {
				if ($view['link'][$i]) {
					$cnt++;
					$link = cut_str($view['link'][$i], 70);
				?>
				<li>
					<div class="cabbd_item cabbl_item">
						<a href="<?php echo $view['link_href'][$i] ?>" class="text small cb" target="_blank"><?php echo $link ?></a>
					</div>
				</li>
				<?php
				}
			}
			?>
			</ul>
		</div>
		<!-- } 관련링크 끝 -->
		<?php } ?>

		<?php if($cnt) { ?>
		<!-- 첨부파일 시작 { -->
		<div class="cabb_data download">
			<h2 class="blind">첨부파일</h2>
			<ul>
			<?php
			// 가변 파일
			for ($i=0; $i<count($view['file']); $i++) {
				if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
			 ?>
				<li>
					<div class="cabbd_item">
						<a href="<?php echo $view['file'][$i]['href'];  ?>" class="text small cb"><?php echo $view['file'][$i]['source'] ?></a>
					</div>
					<!-- <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
					<span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?>회 다운로드 | DATE : <?php echo $view['file'][$i]['datetime'] ?></span> -->
				</li>
			<?php
				}
			}
			 ?>
			</ul>
		</div>
		<!-- } 첨부파일 끝 -->
		<?php } ?>
    </section>

    <!-- <div id="bo_v_share">
        <?php if ($scrap_href) { ?><a href="<?php echo $scrap_href;  ?>" target="_blank" class="btn btn_b03" onclick="win_scrap(this.href); return false;"><i class="fa fa-thumb-tack" aria-hidden="true"></i> 스크랩</a><?php } ?>

        <?php
        include_once(G5_SNS_PATH."/view.sns.skin.php");
        ?>
    </div> -->

    
	<!-- 게시물 상단 버튼 시작 { -->
	<div class="cab_buttons">
		<?php
		ob_start();
		?>
		<ul class="cabb_wrap t1">
			<li><a href="<?php echo $list_href ?>" class="btn t1"> 목록</a></li>
			<?php if ($reply_href) { ?><li><a href="<?php echo $reply_href ?>" class="btn t1"> 답변</a></li><?php } ?>
			<?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn t1"> 글쓰기</a></li><?php } ?>
		</ul>
		<ul class="cabb_wrap t2">
			<?php if ($prev_href) { ?><li><a href="<?php echo $prev_href ?>"  class="btn">이전글</a></li><?php } ?>
			<?php if ($next_href) { ?><li><a href="<?php echo $next_href ?>"  class="btn">다음글</a></li><?php } ?>
		</ul>
		<ul class="cabb_wrap t3">
			<?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>" class="btn t2">수정</a></li><?php } ?>
			<?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" class="btn t2" onclick="del(this.href); return false;"> 삭제</a></li><?php } ?>
			<!-- <?php if ($copy_href) { ?><li><a href="<?php echo $copy_href ?>" class="btn t2" onclick="board_move(this.href); return false;">복사</a></li><?php } ?>
			<?php if ($move_href) { ?><li><a href="<?php echo $move_href ?>" class="btn t2" onclick="board_move(this.href); return false;"> 이동</a></li><?php } ?> -->
		</ul>
		<?php
		$link_buttons = ob_get_contents();
		ob_end_flush();
		 ?>
	</div>
	<!-- } 게시물 상단 버튼 끝 -->
    <!-- 게시물 상단 버튼 시작 { -->
  
       <!--  <ul class="bo_v_nb">
            <?php if ($prev_href) { ?><li class="btn_prv"><span class="nb_tit"><i class="fa fa-caret-up" aria-hidden="true"></i> 이전글</span><a href="<?php echo $prev_href ?>"><?php echo $prev_wr_subject;?></a> <span class="nb_date"><?php echo str_replace('-', '.', substr($prev_wr_date, '2', '8')); ?></span></li><?php } ?>
            <?php if ($next_href) { ?><li class="btn_next"><span class="nb_tit"><i class="fa fa-caret-down" aria-hidden="true"></i> 다음글</span><a href="<?php echo $next_href ?>"><?php echo $next_wr_subject;?></a>  <span class="nb_date"><?php echo str_replace('-', '.', substr($next_wr_date, '2', '8')); ?></span></li><?php } ?>
        </ul> -->
  </div><!--inner-->
  </div>
    <?php
    // 코멘트 입출력
    include_once(G5_BBS_PATH.'/view_comment.php');
     ?>


<!-- } 게시판 읽기 끝 -->

<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }

        var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

        if(confirm(msg)) {
            var href = $(this).attr("href")+"&js=on";
            $(this).attr("href", href);

            return true;
        } else {
            return false;
        }
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<script>
$(function() {
    $("a.view_image").click(function() {
      //이미지 크게보기 팝업띄우고싶으면 주석 해제
        // window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();

    //sns공유
    $(".btn_share").click(function(){
        $("#bo_v_sns").fadeIn();

    });

    $(document).mouseup(function (e) {
        var container = $("#bo_v_sns");
        if (!container.is(e.target) && container.has(e.target).length === 0){
        container.css("display","none");
        }
    });
});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("이 글을 비추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                } else {
                    $tx.text("이 글을 추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                }
            }
        }, "json"
    );
}
</script>
<!-- } 게시글 읽기 끝 -->
