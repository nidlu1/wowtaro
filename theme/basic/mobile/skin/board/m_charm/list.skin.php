<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 2;

if ($is_checkbox) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<div class="c_hero">
	<strong>신선운세 <mark>찐 부적 무료</mark></strong>
</div>
<div class="c_list">
	<div class="cl_menu">
		<a href="<?php echo G5_URL; ?>"><i></i><span class="blind">HOME</span></a>
		<span>신선운세</span>
		<span><mark><a href="/bbs/board.php?bo_table=charm" class="sct_here ">찐 부적 무료</a></mark></span>
	</div>
</div>
<div class="c_area">
	<div class="wrap">
		<div>
			<!-- 게시판 페이지 정보 및 버튼 시작 { -->
			<!-- <div id="bo_btn_top">
				<div id="bo_list_total">
					<span>Total <?php echo number_format($total_count) ?>건</span>
					<?php echo $page ?> 페이지
				</div>

				<?php if ($rss_href || $write_href) { ?>
				<ul class="btn_bo_user">
					<?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01 btn"><i class="fa fa-rss" aria-hidden="true"></i> RSS</a></li><?php } ?>
					<?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin btn"><i class="fa fa-user-circle" aria-hidden="true"></i> 관리자</a></li><?php } ?>
					<?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02 btn"><i class="fa fa-pencil" aria-hidden="true"></i> 글쓰기</a></li><?php } ?>
				</ul>
				<?php } ?>
			</div> -->
			<!-- } 게시판 페이지 정보 및 버튼 끝 -->

			<!-- 게시판 카테고리 시작 { -->
			<?php if ($is_category) { ?>
			<nav id="bo_cate">
				<h2><?php echo $board['bo_subject'] ?> 카테고리</h2>
				<ul id="bo_cate_ul">
					<?php echo $category_option ?>
				</ul>
			</nav>
			<?php } ?>
			<!-- } 게시판 카테고리 끝 -->

			<form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
			<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
			<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
			<input type="hidden" name="stx" value="<?php echo $stx ?>">
			<input type="hidden" name="spt" value="<?php echo $spt ?>">
			<input type="hidden" name="sca" value="<?php echo $sca ?>">
			<input type="hidden" name="sst" value="<?php echo $sst ?>">
			<input type="hidden" name="sod" value="<?php echo $sod ?>">
			<input type="hidden" name="page" value="<?php echo $page ?>">
			<input type="hidden" name="sw" value="">

			<div class="ca_board">
				<table class="cab_table">
				<?php if ($is_checkbox) { ?>
				<div class="cab_chkall">
					<input type="checkbox" class="cab_check" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
					<i></i>	
					<label for="chkall">게시물 전체</label>
				</div>
				<?php } ?>
				<caption class="blind"><?php echo $board['bo_subject'] ?> 목록</caption>
				<thead>
				<tr>
					<?php if ($is_checkbox) { ?>
					 <th class="w50">
						<label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
						<input type="checkbox" class="cab_check" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
						<i></i>
					</th>
					<?php } ?>
					<th class="w50">번호</th>
					 <?php if ($is_checkbox) { ?>
					<th>제목</th>
					 <?php } else {?>
					  <th>제목</th>
					 <?php } ?>
					<!-- <th scope="col">글쓴이</th>
					<th scope="col"><?php echo subject_sort_link('wr_hit', $qstr2, 1) ?>조회 <i class="fa fa-sort" aria-hidden="true"></i></a></th>
					<?php if ($is_good) { ?><th scope="col"><?php echo subject_sort_link('wr_good', $qstr2, 1) ?>추천 <i class="fa fa-sort" aria-hidden="true"></i></a></th><?php } ?>
					<?php if ($is_nogood) { ?><th scope="col"><?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?>비추천 <i class="fa fa-sort" aria-hidden="true"></i></a></th><?php } ?> -->
					<th>등록일</th>
					<!--<th scope="col"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>날짜</th>-->
				</tr>
				</thead>
				<tbody>
				<?php
				for ($i=0; $i<count($list); $i++) {
				 ?>
				<tr class="<?php if ($list[$i]['is_notice']) echo "notice"; ?>">
					<?php if ($is_checkbox) { ?>
					<td class="cabt_chk">
						<label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
						<input type="checkbox" class="cab_check" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
						<i></i>
					</td>
					<?php } ?>
					<th class="cabt_num">
					<?php
					if ($list[$i]['is_notice']) // 공지사항
						echo '<span class="notice_icon"><i class="fa fa-bullhorn" aria-hidden="true"></i><span class="sound_only">공지</span></span>';
					else if ($wr_id == $list[$i]['wr_id'])
						echo "<span class=\"bo_current\">열람중</span>";
					else
						echo $list[$i]['num'];
					 ?>
					</th>
					 <td class="cabt_subject">
					 	<strong>제목</strong>
						<a href="<?php echo $list[$i]['href'] ?>">
							<?php echo $list[$i]['subject']; ?>
						</a>
					</td>
					<!-- <td class="td_name sv_use"><?php echo $list[$i]['name'] ?></td> -->
					<!-- <td class="td_num"><?php echo $list[$i]['wr_hit'] ?></td> -->
					<!-- <?php if ($is_good) { ?><td class="td_num"><?php echo $list[$i]['wr_good'] ?></td><?php } ?> -->
					<!-- <?php if ($is_nogood) { ?><td class="td_num"><?php echo $list[$i]['wr_nogood'] ?></td><?php } ?> -->
					<td class="cabt_datetime"><strong>등록일</strong><?php echo $list[$i]['datetime'] ?></td>
				</tr>
				<?php } ?>
				<?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
				</tbody>
				</table>
			</div>
			</form>

			<!-- 게시판 검색 시작 { -->
			<div class="search_wrap">
				 <fieldset class="ca_search">
					<legend>게시물 검색</legend>
					<form name="fsearch" method="get">
					<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
					<input type="hidden" name="sca" value="<?php echo $sca ?>">
					<input type="hidden" name="sop" value="and">
					<label for="sfl" class="sound_only">검색대상</label>
					<select name="sfl" id="sfl" class="cas_select">
						<option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
						<option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
						<option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
						<option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
						<option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
						<option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
						<option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
					</select>
					<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
					<input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="cas_input" size="25" maxlength="20" placeholder="검색어를 입력하세요">
					<input type="submit" value="검색" class="cas_search">
					<i class="icon_search"></i>
					</form>
				</fieldset>
			</div>
			<!-- } 게시판 검색 끝 -->
			<!-- 페이지 -->
			<?php echo $write_pages_moblie;?>
			<?php if ($list_href || $is_checkbox || $write_href) { ?>
			<div class="pg_buttons">
				<?php if ($list_href || $write_href) { ?>
				<ul class="t1">
					<?php if ($list_href) { ?><li><a href="<?php echo $list_href ?>" class="btn t1">목록</a></li><?php } ?>
					<?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn t1">글쓰기</a></li><?php } ?>
				</ul>
				<ul class="t2">
					<?php if ($is_checkbox) { ?>
					<li><input type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="btn t2"></li>
					<li><input type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value" class="btn t2"></li>
					<li><input type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value" class="btn t2"></li>
					<?php } ?>
				</ul>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
	</div>
</div><!--inner-->

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>


<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == 'copy')
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<?php } ?>
<!-- 게시판 목록 끝 -->
