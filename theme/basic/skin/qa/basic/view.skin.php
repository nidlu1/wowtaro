<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 게시물 읽기 시작 { -->

<div class="c_hero" id="sub_callcenter">
	<strong>신선운세 <mark>1:1고객문의</mark></strong>
</div>
<div class="c_list">
	<div class="cl_menu">
		<a href="<?php echo G5_URL; ?>"><i></i><span class="blind">HOME</span></a>
		<span>신선운세</span>
		<span>고객센터</span>
		<span><mark><a href="/bbs/qalist.php" class="sct_here">1:1고객문의</a></mark></span>
	</div>
</div>
<div class="c_area">
	<div class="wrap">
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
							echo cut_str(get_text($view['subject']), 70); // 글제목 출력
							?>
						</h2>
						<div class="fr">
							<div class="cabf_item">
								<i class="time"></i>
								<span class="text cg tiny s05"><?php echo date("Y.m.d", strtotime($view['datetime'])) ?></span>
							</div>
						</div>
					</div>
				</div>
				<div class="cabf_wrap w50p">
					<div class="cabf_title">
						<span class="text middle cb s05">상담분류</span>
					</div>
					<div class="cabf_content">
						<div class="fl">
							<span class="text middle cb s05">
								<?php echo $view['category']; // 분류 출력 끝 ?>
							</span>
						</div>
					</div>
				</div>
				<div class="cabf_wrap w50p">
					<div class="cabf_title">
						<span class="text middle cb s05">글쓴이</span>
					</div>
					<div class="cabf_content">
						<div class="fl">
							<span class="text middle cb s05">
								<?php echo $view['name'] ?>
							</span>
						</div>
					</div>
				</div>
				<section class="cab_body">
					<h2 class="blind">본문</h2>
					<?php
					// 파일 출력
					$v_img_count = count($view['file']);
					if($v_img_count) {
						echo "<div class=\"cabb_pic\">\n";

						for ($i=0; $i<=count($view['file']); $i++) {
							if ($view['file'][$i]['view']) {
								echo $view['file'][$i]['view'];
								echo get_view_thumbnail($view['file'][$i]['view']);
							}
						}

						echo "</div>\n";
					}
					 ?>

					<!-- 본문 내용 시작 { -->
					<div class="cabb_txt">
                        <?php
                            $imgdoc = explode(".",$view['qa_file1']);
                            if($imgdoc[1] === "jpg" ||$imgdoc[1] === "png"){
                                echo "<img src='/data/qa/".$view['qa_file1']."'>";
                            }
                            $imgdoc = explode(".",$view['qa_file2']);
                            if($imgdoc[1] === "jpg" ||$imgdoc[1] === "png" ){
                                echo "<img src='/data/qa/".$view['qa_file2']."'>";
                            }
                        ?>
                        <?php 
                            echo get_view_thumbnail($view['content']);
                        ?>
                    </div>
					<?php //echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
					<!-- } 본문 내용 끝 -->

					<?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>
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
			</div>
			<!-- 게시물 상단 버튼 시작 { -->
			<div class="cab_buttons">
				<?php
				ob_start();
				 ?>
				<div class="cabb_wrap t1">
					<ul class="fl">
						<?php if ($prev_href) { ?><li><a href="<?php echo $prev_href ?>"  class="btn">이전글</a></li><?php } ?>
						<?php if ($next_href) { ?><li><a href="<?php echo $next_href ?>"  class="btn">다음글</a></li><?php } ?>
					</ul>
					<ul class="fr">
						<li><a href="<?php echo $list_href ?>" class="btn t1"> 목록</a></li>
						<?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn t1"> 글쓰기</a></li><?php } ?>
					</ul>
				</div>
				<div class="cabb_wrap t2">
					<ul class="fl">
						<?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>" class="btn t2">수정</a></li><?php } ?>
						<?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" class="btn t2" onclick="del(this.href); return false;">삭제</a></li><?php } ?>
					</ul>
				</div>
				<?php
				$link_buttons = ob_get_contents();
				ob_end_flush();
				 ?>
			</div>
			<!-- } 게시물 상단 버튼 끝 -->

			<?php
			// 질문글에서 답변이 있으면 답변 출력, 답변이 없고 관리자이면 답변등록폼 출력
			if(!$view['qa_type']) {
				if($view['qa_status'] && $answer['qa_id'])
					include_once($qa_skin_path.'/view.answer.skin.php');
				else
					include_once($qa_skin_path.'/view.answerform.skin.php');
			}
			?>

			<?php if($view['rel_count']) { ?>
			<section class="cab_wrap mt50">
				<h2 class="title t1 bold cb s05 mb15 left">연관질문</h2>
				<table class="cab_table">
				<thead>
				<tr>
					<th class="w100">상담분류</th>
					<th class="w850">제목</th>
					<th class="w150"">등록일</th>
					<th class="w100">상태</th>
				</tr>
				</thead>
				<tbody>
				<?php
				for($i=0; $i<$view['rel_count']; $i++) {
				?>
				<tr>
					<td class="cabt_category"><span><?php echo get_text($rel_list[$i]['category']); ?></span></td>
					<td class="cabt_subject">
						<a href="<?php echo $rel_list[$i]['view_href']; ?>" class="bo_tit">
							<?php echo $rel_list[$i]['subject']; ?>
						</a>
					</td>
					<td class="cabt_date"><?php echo date("Y-m-d", strtotime($rel_list[$i]['date'])) ?></td>
					<td class="cabt_stat"><span class=" <?php echo ($list[$i]['qa_status'] ? 'done' : 'rdy'); ?>"><?php echo ($list[$i]['qa_status'] ? '답변완료' : '답변대기'); ?></span></td>
				</tr>
				<?php
				}
				?>
				</tbody>
				</table>
			</section>
			<?php } ?>
			
		</section>
	</div>
</div><!--inner-->
<!-- } 게시판 읽기 끝 -->

<script>
$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});
</script>
