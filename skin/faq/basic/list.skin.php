<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$faq_skin_url.'/style.css">', 0);

// if ($admin_href)
//     echo '<div class="faq_admin"><a href="'.$admin_href.'" class="btn_admin btn">FAQ 수정</a></div>';
// ?>

<div id="review">
  <div class="sub_banner" id="sub_callcenter">
    <h2>고객센터</h2>
    <p>고객님들의 궁금증을 해결해드립니다.</p>
  </div>
</div>

<div id="sct" class="navi">
<div class="sc_wrap">
<div class="inner">
<div id="sct_location">
    <a href="/index.php" class="sct_bg"><i class="xi-home"></i></a>
    <a href="/bbs/faq.php?fm_id=2" class="sct_here ">고객센터</a></div>
<div id="sct_hhtml"></div>
<div id="sct_sortlst">
<!-- 상품 정렬 선택 시작 { -->
<!-- <section id="sct_sort">
    <h2>상품 정렬</h2>
    <ul id="ssch_sort">
        <li><a href="/shop/list.php?ca_id=50&amp;sort=it_sum_qty&amp;sortodr=desc">조회순</a></li>
        <li><a href="/shop/list.php?ca_id=50&amp;sort=it_use_cnt&amp;sortodr=desc">후기많은순</a></li>
        <li><a href="/shop/list.php?ca_id=50&amp;sort=it_use_avg&amp;sortodr=desc">별점높은순</a></li>
    </ul>
</section> -->
</div>
</div>
</div>
</div>

<div class="review_tabs">
  <ul>
    <li class="active"><a href="/bbs/faq.php?fm_id=4">FAQ</a></li>
    <li><a href="/bbs/qalist.php">1:1고객문의</a></li>
    <li><a href="/bbs/faq2.php?fm_id=3">이용안내</a></li>
    <li><a href="/bbs/board.php?bo_table=notice">공지사항</a></li>
  </ul>
</div>

<!-- FAQ 시작 { -->
<div class="inner">
  <div class="sub-inner">
<?php
if ($himg_src)
    echo '<div id="faq_himg" class="faq_img"><img src="'.$himg_src.'" alt=""></div>';

// 상단 HTML
echo '<div id="faq_hhtml">'.conv_content($fm['fm_head_html'], 1).'</div>';
?>

<fieldset id="faq_sch">
    <legend>FAQ 검색</legend>

    <form name="faq_search_form" method="get">
    <span class="sch_tit">FAQ 검색</span>
    <input type="hidden" name="fm_id" value="<?php echo $fm_id;?>">
    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
    <input type="text" name="stx" value="<?php echo $stx;?>" required id="stx" class="frm_input " size="15" maxlength="15">
    <button type="submit" value="검색" class="btn_submit"><i class="fa fa-search" aria-hidden="true"></i> 검색</button>
    </form>
</fieldset>

<!--
<?php
if( count($faq_master_list) ){
?>
<nav id="bo_cate">
    <h2>자주하시는질문 분류</h2>
    <ul id="bo_cate_ul">
        <?php
        foreach( $faq_master_list as $v ){
            $category_msg = '';
            $category_option = '';
            if($v['fm_id'] == $fm_id){ // 현재 선택된 카테고리라면
                $category_option = ' id="bo_cate_on"';
                $category_msg = '<span class="sound_only">열린 분류 </span>';
            }
        ?>
        <li><a href="<?php echo $category_href;?>?fm_id=<?php echo $v['fm_id'];?>" <?php echo $category_option;?> ><?php echo $category_msg.$v['fm_subject'];?></a></li>
        <?php
        }
        ?>
    </ul>
</nav>
<?php } ?>
 -->
<div id="faq_wrap" class="faq_<?php echo $fm_id; ?>">
    <?php // FAQ 내용
    if( count($faq_list) ){
    ?>
    <section id="faq_con">
        <h2><?php echo $g5['title']; ?> 목록</h2>
        <ol>
            <?php
            foreach($faq_list as $key=>$v){
                if(empty($v))
                    continue;
            ?>
            <li>
                <h3><span class="tit_bg">Q</span><a href="#none" onclick="return faq_open(this);"><?php echo conv_content($v['fa_subject'], 1); ?></a></h3>
                <div class="con_inner">
                    <span class="tit_bg">A</span>
                    <?php echo conv_content($v['fa_content'], 1); ?>
                    <div class="con_closer"><button type="button" class="closer_btn btn_b03">닫기</button></div>
                </div>
            </li>
            <?php
            }
            ?>
        </ol>
    </section>
    <?php

    } else {
        if($stx){
            echo '<p class="empty_list">검색된 게시물이 없습니다.</p>';
        } else {
            echo '<div class="empty_list">등록된 FAQ가 없습니다.';
            if($is_admin)
                echo '<br><a href="'.G5_ADMIN_URL.'/faqmasterlist.php">FAQ를 새로 등록하시려면 FAQ관리</a> 메뉴를 이용하십시오.';
            echo '</div>';
        }
    }
    ?>
</div>

<?php echo get_paging($page_rows, $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>

<?php
// 하단 HTML
echo '<div id="faq_thtml">'.conv_content($fm['fm_tail_html'], 1).'</div>';

if ($timg_src)
    echo '<div id="faq_timg" class="faq_img"><img src="'.$timg_src.'" alt=""></div>';
?>
</div>
</div>

<!-- } FAQ 끝 -->

<!-- <?php
if ($admin_href)
    echo '<div class="faq_admin"><a href="'.$admin_href.'" class="btn_admin btn">FAQ 수정</a></div>';
?> -->

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<script>
$(function() {
    $(".closer_btn").on("click", function() {
        $(this).closest(".con_inner").slideToggle();
    });
});

function faq_open(el)
{
    var $con = $(el).closest("li").find(".con_inner");

    if($con.is(":visible")) {
        $con.slideUp();

    } else {
        $("#faq_con .con_inner:visible").css("display", "none");

        $con.slideDown(
            function() {
                // 이미지 리사이즈
                $con.viewimageresize2();
            }
        );
    }

    return false;
}
</script>
