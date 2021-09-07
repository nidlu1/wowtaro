<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
?>

<?php if($config['cf_kakao_js_apikey']) { ?>
<script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>
<script src="<?php echo G5_JS_URL; ?>/kakaolink.js"></script>
<script>
    // 사용할 앱의 Javascript 키를 설정해 주세요.
    Kakao.init("<?php echo $config['cf_kakao_js_apikey']; ?>");
</script>
<?php } ?>

<form name="fitem" action="<?php echo $action_url; ?>" method="post" onsubmit="return fitem_submit(this);">
<input type="hidden" name="it_id[]" value="<?php echo $it['it_id']; ?>">
<input type="hidden" name="sw_direct">
<input type="hidden" name="url">

<script>

  function goBack(){
    window.history.back();
  }
</script>

<div class="navi clearfix">
  <div class="left" onclick="goBack();">
    <a href="#">
      <i class="xi-angle-left"></i><span>목록으로</span>
    </a>
  </div>

  <div class="right">
    <a href="/index.php" class="home"><i class="xi-home"></i></a>
    <i class="xi-angle-right-min"></i>
    <a href="/shop/list.php?ca_id=10#" class="txt">타로</a>
  </div>
</div><!--navi-->

<div class="inner">
  <div id="sit_ov_wrap">
  <div class="sit-buttons clearfix">
    <div class="counsel">
      <div class="avail">
        <p>상담가능</p>
      </div>

    </div>
    <div class="regular-cus">
        <a href="javascript:item_wish(document.fitem, '<?php echo $it['it_id']; ?>');"><i class="xi-home-o"></i><spsan>단골등록</spsan></a>
    </div>
  </div>

  <!--상품 이미지 시작-->
  <div class="sit_img">
    <?php
    // 이미지(중) 썸네일
    $thumb_img = '';
    $thumb_img_w = 450; // 넓이
    $thumb_img_h = 248; // 높이
    for ($i=1; $i<=10; $i++)
    {
        if(!$it['it_img'.$i])
            continue;

        $thumb = get_it_thumbnail($it['it_img'.$i], $thumb_img_w, $thumb_img_h);

        if(!$thumb)
            continue;

        $thumb_img .= '<li>';
        $thumb_img .= '<a href="'.G5_SHOP_URL.'/largeimage.php?it_id='.$it['it_id'].'&amp;no='.$i.'" class="popup_item_image slide_img" target="_blank">'.$thumb.'</a>';
        $thumb_img .= '</li>'.PHP_EOL;
    }
    if ($thumb_img)
    {
        echo '<div id="sit_pvi">'.PHP_EOL;
        // echo '<button type="button" id="sit_pvi_prev" class="sit_pvi_btn" >이전</button>'.PHP_EOL;
        // echo '<button type="button" id="sit_pvi_next" class="sit_pvi_btn">다음</button>'.PHP_EOL;
        echo '<ul id="sit_pvi_slide">'.PHP_EOL;
        echo $thumb_img;
        echo '</ul>'.PHP_EOL;
        echo '</div>';
    }
    ?>
  </div><!--sit-img-->

  <div class="sit_ov_top">
    <h2 id="sit_title"><?php echo stripslashes($it['it_name']); ?><span class="sct_icon"><?php echo item_icon($it); ?></span></h2>
    <p id="sit_desc"><?php echo $it['it_basic']; ?></p>
    <!-- <p id="sit_url">https://www.sinsun.com/profile/홍길동 <button type="button" class="url_copy">URL복사</button></p> -->
  </div>
  <div class="sit_ov_middle">
    <ul>
      <li>상담을 하고 나면 다시 찾게 되는 정확한 상담</li>
      <li>심리상담 1급, 심리분석 1급 보유</li>
      <li>타로심리상담 1급 보유</li>
      <li>커플궁합, 속마음 전문 타로 마스터</li>
    </ul>
  </div>

  <!--분류 추가-->
  <div class="sorting">
    <span>재회/이별</span>
    <span>연애/속마음</span>
    <span>궁합/속궁합</span>
  </div>

<!--전화연결 시작-->
  <div class="call-wr">
    <div class="btn-wr clearfix">
      <a class="" href="tel:060-300-6700">
        일반전화상담
      </a>
      <a class="discount" href="tel:02-3433-1177">
        할인전화상담
      </a>
    </div>
<!--전화연결 끝-->


    <p class="txt">전화연결 후 + 고유번호 001번을 눌러주세요.</p>
  </div>

  <div class="num-wr">
    <span class="txt_wr">
      <i class="xi-star"></i> 평점 <b>5.0</b>
    </span>
    <span class="txt_wr">
      상담후기 <b><?php echo $it['it_use_cnt']; ?></b>
    </span>

    <span class="txt_wr">
      상담사 댓글 <b>5782</b>
    </span>
</div><!--num-wr-->
</div>



    <!-- 다른 상품 보기 시작 { -->
    <!-- <div id="sit_siblings"> -->
        <!-- <?php
        if ($prev_href || $next_href) {
            $prev_title = '<i class="fa fa-caret-left" aria-hidden="true"></i> '.$prev_title;
            $next_title = $next_title.' <i class="fa fa-caret-right" aria-hidden="true"></i>';

            echo $prev_href.$prev_title.$prev_href2;
            echo $next_href.$next_title.$next_href2;
        } else {
            echo '<span class="sound_only">이 분류에 등록된 다른 상품이 없습니다.</span>';
        }
        ?> -->
        <!-- <a href="<?php echo G5_SHOP_URL; ?>/largeimage.php?it_id=<?php echo $it['it_id']; ?>&amp;no=1" target="_blank" class="popup_item_image "><i class="fa fa-search-plus" aria-hidden="true"></i><span class="sound_only">확대보기</span></a>
    </div> -->
    <!-- } 다른 상품 보기 끝 -->

    <!-- <div id="sit_star_sns">
        <?php
        $sns_title = get_text($it['it_name']).' | '.get_text($config['cf_title']);
        $sns_url  = G5_SHOP_URL.'/item.php?it_id='.$it['it_id'];

        if ($score = get_star_image($it['it_id'])) { ?>
        <span class="sound_only">고객평점 <?php echo $score?>개</span>
        <img src="<?php echo G5_SHOP_URL; ?>/img/s_star<?php echo $score?>.png" alt="" class="sit_star" width="100"> <span class="st_bg"></span>
        <?php } ?>


         <i class="fa fa-commenting-o" aria-hidden="true"></i><span class="sound_only">리뷰</span> <?php echo $it['it_use_cnt']; ?>


        <span class="st_bg"></span> <i class="fa fa-heart-o" aria-hidden="true"></i><span class="sound_only">위시</span> <?php echo get_wishlist_count_by_item($it['it_id']); ?>
        <button type="button" class="btn_sns_share"><i class="fa fa-share-alt" aria-hidden="true"></i><span class="sound_only">sns 공유</span></button>
        <div class="sns_area">-->
            <!-- <?php echo get_sns_share_link('facebook', $sns_url, $sns_title, G5_MSHOP_SKIN_URL.'/img/facebook.png'); ?>
            <?php echo get_sns_share_link('twitter', $sns_url, $sns_title, G5_MSHOP_SKIN_URL.'/img/twitter.png'); ?>
            <?php echo get_sns_share_link('googleplus', $sns_url, $sns_title, G5_MSHOP_SKIN_URL.'/img/gplus.png'); ?>
            <?php echo get_sns_share_link('kakaotalk', $sns_url, $sns_title, G5_MSHOP_SKIN_URL.'/img/sns_kakao.png'); ?>
            <?php
            $href = G5_SHOP_URL.'/iteminfo.php?it_id='.$it_id;
            ?> -->
            <!-- <a href="javascript:popup_item_recommend('<?php echo $it['it_id']; ?>');" id="sit_btn_rec"><i class="fa fa-envelope-o" aria-hidden="true"></i><span class="sound_only">추천하기</span></a></div>
        </div>
    <script>
    $(".btn_sns_share").click(function(){
        $(".sns_area").show();
    });
    $(document).mouseup(function (e){
        var container = $(".sns_area");
        if( container.has(e.target).length === 0)
        container.hide();
    });


  </script>-->
</div><!--inner-->



<div id="sit_tab">
    <ul class="tab_tit">
        <li><button type="button" rel="#sit_inf" class="selected">인사말</button></li>
        <li><button type="button" rel="#sit_use">상담후기</button></li>
        <li><button type="button" rel="#sit_qa">상담문의</button></li>
    </ul>
    <ul class="tab_con">

        <!-- 인사말 시작 { -->
        <li id="sit_inf">
            <h2 class="contents_tit"><span>인사말</span></h2>

            <?php if ($it['it_explan'] || $it['it_mobile_explan']) { // 상품 상세설명 ?>
            <h3>상품 상세설명</h3>
            <div id="sit_inf_explan">
                <?php echo ($it['it_mobile_explan'] ? conv_content($it['it_mobile_explan'], 1) : conv_content($it['it_explan'], 1)); ?>
            </div>
            <?php } ?>


            <?php
            if ($it['it_info_value']) { // 상품 정보 고시
                $info_data = unserialize(stripslashes($it['it_info_value']));
                if(is_array($info_data)) {
                    $gubun = $it['it_info_gubun'];
                    $info_array = $item_info[$gubun]['article'];
            ?>
            <!-- <h3>상품 정보 고시</h3>
            <table id="sit_inf_open">
            <tbody>
            <?php
            foreach($info_data as $key=>$val) {
                $ii_title = $info_array[$key][0];
                $ii_value = $val;
            ?>
            <tr>
                <th scope="row"><?php echo $ii_title; ?></th>
                <td><?php echo $ii_value; ?></td>
            </tr>
            <?php } //foreach?>
            </tbody>
            </table> -->
            <!-- 상품정보고시 end -->
            <!-- <?php
                } else {
                    if($is_admin) {
                        echo '<p>상품 정보 고시 정보가 올바르게 저장되지 않았습니다.<br>config.php 파일의 G5_ESCAPE_FUNCTION 설정을 addslashes 로<br>변경하신 후 관리자 &gt; 상품정보 수정에서 상품 정보를 다시 저장해주세요. </p>';
                    }
                }
            } //if
            ?> -->

        </li>
        <!-- 상담후기 시작 { -->
        <li id="sit_use">
            <h2>상담후기</h2>
            <div id="itemuse"><?php include_once(G5_SHOP_PATH.'/itemuse.php'); ?></div>
        </li>
        <!-- } 사용후기 끝 -->

        <!-- 상품문의 시작 { -->
        <li id="sit_qa">
            <h2>상담문의</h2>

            <div id="itemqa"><?php include_once(G5_SHOP_PATH.'/itemqa.php'); ?></div>
        </li>
        <!-- } 상품문의 끝 -->


    </ul>
</div>
<script>
$(function (){
    $(".tab_con>li").hide();
    $(".tab_con>li:first").show();
    $(".tab_tit li button").click(function(){
        $(".tab_tit li button").removeClass("selected");
        $(this).addClass("selected");
        $(".tab_con>li").hide();
        $($(this).attr("rel")).show();
    });
});
</script>
</form>




<script>
$(window).bind("pageshow", function(event) {
    if (event.originalEvent.persisted) {
        document.location.reload();
    }
});

$(function(){
    // 상품이미지 슬라이드
    var time = 500;
    var idx = idx2 = 0;
    var slide_width = $("#sit_pvi_slide").width();
    var slide_count = $("#sit_pvi_slide li").size();
    $("#sit_pvi_slide li:first").css("display", "block");
    if(slide_count > 1)
        $(".sit_pvi_btn").css("display", "inline");

    $("#sit_pvi_prev").click(function() {
        if(slide_count > 1) {
            idx2 = (idx - 1) % slide_count;
            if(idx2 < 0)
                idx2 = slide_count - 1;
            $("#sit_pvi_slide li:hidden").css("left", "-"+slide_width+"px");
            $("#sit_pvi_slide li:eq("+idx+")").filter(":not(:animated)").animate({ left: "+="+slide_width+"px" }, time, function() {
                $(this).css("display", "none").css("left", "-"+slide_width+"px");
            });
            $("#sit_pvi_slide li:eq("+idx2+")").css("display", "block").filter(":not(:animated)").animate({ left: "+="+slide_width+"px" }, time,
                function() {
                    idx = idx2;
                }
            );
        }
    });

    $("#sit_pvi_next").click(function() {
        if(slide_count > 1) {
            idx2 = (idx + 1) % slide_count;
            $("#sit_pvi_slide li:hidden").css("left", slide_width+"px");
            $("#sit_pvi_slide li:eq("+idx+")").filter(":not(:animated)").animate({ left: "-="+slide_width+"px" }, time, function() {
                $(this).css("display", "none").css("left", slide_width+"px");
            });
            $("#sit_pvi_slide li:eq("+idx2+")").css("display", "block").filter(":not(:animated)").animate({ left: "-="+slide_width+"px" }, time,
                function() {
                    idx = idx2;
                }
            );
        }
    });

    // 상품이미지 크게보기
    $(".popup_item_image").click(function() {
        var url = $(this).attr("href");
        var top = 10;
        var left = 10;
        var opt = 'scrollbars=yes,top='+top+',left='+left;
        popup_window(url, "largeimage", opt);

        return false;
    });
});

// 상품보관
function item_wish(f, it_id)
{
    f.url.value = "<?php echo G5_SHOP_URL; ?>/wishupdate.php?it_id="+it_id;
    f.action = "<?php echo G5_SHOP_URL; ?>/wishupdate.php";
    f.submit();
}

// 추천메일
function popup_item_recommend(it_id)
{
    if (!g5_is_member)
    {
        if (confirm("회원만 추천하실 수 있습니다."))
            document.location.href = "<?php echo G5_BBS_URL; ?>/login.php?url=<?php echo urlencode(G5_SHOP_URL."/item.php?it_id=$it_id"); ?>";
    }
    else
    {
        url = "<?php echo G5_SHOP_URL; ?>/itemrecommend.php?it_id=" + it_id;
        opt = "scrollbars=yes,width=616,height=420,top=10,left=10";
        popup_window(url, "itemrecommend", opt);
    }
}

// 재입고SMS 알림
function popup_stocksms(it_id)
{
    url = "<?php echo G5_SHOP_URL; ?>/itemstocksms.php?it_id=" + it_id;
    opt = "scrollbars=yes,width=616,height=420,top=10,left=10";
    popup_window(url, "itemstocksms", opt);
}

function fsubmit_check(f)
{
    // 판매가격이 0 보다 작다면
    if (document.getElementById("it_price").value < 0) {
        alert("전화로 문의해 주시면 감사하겠습니다.");
        return false;
    }

    if($(".sit_opt_list").size() < 1) {
        alert("상품의 선택옵션을 선택해 주십시오.");
        return false;
    }

    var val, io_type, result = true;
    var sum_qty = 0;
    var min_qty = parseInt(<?php echo $it['it_buy_min_qty']; ?>);
    var max_qty = parseInt(<?php echo $it['it_buy_max_qty']; ?>);
    var $el_type = $("input[name^=io_type]");

    $("input[name^=ct_qty]").each(function(index) {
        val = $(this).val();

        if(val.length < 1) {
            alert("수량을 입력해 주십시오.");
            result = false;
            return false;
        }

        if(val.replace(/[0-9]/g, "").length > 0) {
            alert("수량은 숫자로 입력해 주십시오.");
            result = false;
            return false;
        }

        if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
            alert("수량은 1이상 입력해 주십시오.");
            result = false;
            return false;
        }

        io_type = $el_type.eq(index).val();
        if(io_type == "0")
            sum_qty += parseInt(val);
    });

    if(!result) {
        return false;
    }

    if(min_qty > 0 && sum_qty < min_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(min_qty))+"개 이상 주문해 주십시오.");
        return false;
    }

    if(max_qty > 0 && sum_qty > max_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(max_qty))+"개 이하로 주문해 주십시오.");
        return false;
    }

    return true;
}

// 바로구매, 장바구니 폼 전송
function fitem_submit(f)
{
    f.action = "<?php echo $action_url; ?>";
    f.target = "";

    if (document.pressed == "장바구니") {
        f.sw_direct.value = 0;
    } else { // 바로구매
        f.sw_direct.value = 1;
    }

    // 판매가격이 0 보다 작다면
    if (document.getElementById("it_price").value < 0) {
        alert("전화로 문의해 주시면 감사하겠습니다.");
        return false;
    }

    if($(".sit_opt_list").size() < 1) {
        alert("상품의 선택옵션을 선택해 주십시오.");
        return false;
    }

    var val, io_type, result = true;
    var sum_qty = 0;
    var min_qty = parseInt(<?php echo $it['it_buy_min_qty']; ?>);
    var max_qty = parseInt(<?php echo $it['it_buy_max_qty']; ?>);
    var $el_type = $("input[name^=io_type]");

    $("input[name^=ct_qty]").each(function(index) {
        val = $(this).val();

        if(val.length < 1) {
            alert("수량을 입력해 주십시오.");
            result = false;
            return false;
        }

        if(val.replace(/[0-9]/g, "").length > 0) {
            alert("수량은 숫자로 입력해 주십시오.");
            result = false;
            return false;
        }

        if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
            alert("수량은 1이상 입력해 주십시오.");
            result = false;
            return false;
        }

        io_type = $el_type.eq(index).val();
        if(io_type == "0")
            sum_qty += parseInt(val);
    });

    if(!result) {
        return false;
    }

    if(min_qty > 0 && sum_qty < min_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(min_qty))+"개 이상 주문해 주십시오.");
        return false;
    }

    if(max_qty > 0 && sum_qty > max_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(max_qty))+"개 이하로 주문해 주십시오.");
        return false;
    }

    return true;
}
</script>
<?php /* 2017 리뉴얼한 테마 적용 스크립트입니다. 기존 스크립트를 오버라이드 합니다. */ ?>
<script src="<?php echo G5_JS_URL; ?>/shop.override.js"></script>
