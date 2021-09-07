<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>


<div class="c_hero" id="sub_review">
	<strong>신선운세 <mark>상담사례</mark></strong>
</div>
<div class="c_list">
	<div class="cl_menu">
		<a href="<?php echo G5_URL; ?>"><i></i><span class="blind">HOME</span></a>
		<span>신선운세</span>
		<span><mark><a href="/bbs/board.php?bo_table=best" class="sct_here ">상담사례</a></mark></span>
	</div>
</div>
<!-- 게시판 목록 시작 { -->
<div class="c_area best">
	<div class="wrap">
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

		<!-- 게시판 검색 시작 { -->
		<!-- <fieldset id="bo_sch">
			<legend>게시물 검색</legend>
		
			<form name="fsearch" method="get">
			<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
			<input type="hidden" name="sca" value="<?php echo $sca ?>">
			<input type="hidden" name="sop" value="and">
			<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
			<input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="sch_input" size="25" maxlength="20" placeholder="검색어를 입력해주세요">
			<button type="submit" name="button" class="sch_btn" role="검색"><span class="sound_only">검색</span></button>
			</form>
		</fieldset> -->
		<!-- } 게시판 검색 끝 -->

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
		<ul class="ca_member">
			<?php
			for ($i=0; $i<count($list); $i++) {
				$qrow = sql_fetch("SELECT * FROM ".$g5['member_table']." WHERE mb_id='".$list[$i]['wr_1']."'");

				$bcat_arr = b_cat_func($qrow['mb_1']);
				$scat_arr = s_cat_func($qrow['mb_2']);

				$j = searchForId3($qrow['mb_use'],$bcat_arr);

				switch ($bcat_arr[$j]['ca_id']) {
					case '10' :
						$bcat_str = "타로";
						$bcat_bg = "back_taro";
						break;
					case '20' :
						$bcat_str = "신점";
						$bcat_bg = "back_shinjeom";
						break;
					case '30' :
						$bcat_str = "사주";
						$bcat_bg = "back_saju";
						break;
					case '40' :
						$bcat_str = "펫타로";
						$bcat_bg = "back_pettaro";
						break;
					case '50' :
						$bcat_str = "꿈해몽";
						$bcat_bg = "back_dream";
						break;
					default :
						$bcat_str = "펫타로";
						$bcat_bg = "back_taro";
						break;
				}
			?>
			<li>
				<div class="cam_wrap">
					<a href="<?php echo $list[$i]['href'] ?>">
						<div class="cam_pic">
							<div>
								<img src="<?php echo G5_DATA_URL; ?>/temp/<?php echo $qrow['mb_no']; ?>/<?php echo $qrow['mb_8']; ?>" alt="<?php echo $qrow['mb_nick']; ?> <?php echo $qrow['mb_id']; ?>번">
								<div class="camp_status">
									<span><?php echo $bcat_str ?></span>
								</div>
							</div>
						</div>
						<div class="cam_info">
							<div class="cami_title">
								<span><?php echo $qrow['mb_nick']; ?> <mark><?php echo $qrow['mb_id']; ?>번</mark></span>
							</div>
							<div class="cami_txt">
								<span class="cami_hover">
									<?php echo $list[$i]['subject'] ?>
								</span>
							</div>
						</div>
						<div class="cam_etc">
							<div class="fl">
								<div class="came_item">
									<i class="time"></i>
									<span class="text cg tiny s05"><?php echo $list[$i]['datetime'] ?></span>
								</div>
							</div>
							<div class="fr">
								<div class="came_item">
									<i class="like"></i>
									<span class="text cg tiny s05"><?php echo $list[$i]['wr_good'] ?></span>
								</div>
								<div class="came_item ml18">
									<i class="look"></i>
									<span class="text cg tiny s05"><?php echo $list[$i]['wr_hit'] ?></span>
								</div>
							</div>
						</div>
					</a>
				</div>
			</li>
			<?php } ?>
		</ul>
			<?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
			<!-- 예시 테이블 정보 -->
		<!-- 페이지 -->
		<?php echo $write_pages;  ?>
		<?php if ($list_href || $is_checkbox || $write_href) { ?>
		<div class="pg_buttons">
			<?php if ($list_href || $write_href) { ?>
			<ul>
				<?php if ($is_checkbox) { ?>
				<li><button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="btn t2">선택삭제</button></li>
				<li><button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value" class="btn t2">선택복사</button></li>
				<li><button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value" class="btn t2">선택이동</button></li>
				<?php } ?>
				<?php if ($list_href) { ?><li><a href="<?php echo $list_href ?>" class="btn t1"><i class="fa fa-list" aria-hidden="true"></i> 목록</a></li><?php } ?>
				<?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn t1">글쓰기</a></li><?php } ?>
			</ul>
			<?php } ?>
		</div>
		<?php } ?>
		</form>
	</div>
</div>

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

    if (sw == "copy")
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
<!-- } 게시판 목록 끝 -->
