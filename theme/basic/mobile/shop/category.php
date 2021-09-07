<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

function get_mshop_category($ca_id, $len)
{
    global $g5;

    $sql = " select ca_id, ca_name from {$g5['g5_shop_category_table']}
                where ca_use = '1' ";
    if($ca_id)
        $sql .= " and ca_id like '$ca_id%' ";
    $sql .= " and length(ca_id) = '$len' order by ca_order, ca_id ";

    return $sql;
}
?>

<div id="category" class="menu">

    <div class="menu_wr">
      <div class="menu-top">
        <button type="button" class="menu_close"><img src="/m-fortune-img/menu_close.png" alt="메뉴닫기"><span class="sound_only">메뉴닫기</span></button>
        <div class="logo">
          <a href="<?php echo G5_URL; ?>/index.php"><img src="/m-fortune-img/menu_logo.png" alt="신선운세 로고"></a>
        </div>
      </div>

      <div class="login-wr clearfix">
      <?php if ($is_member) { ?>
        <div class="logout">
          <a href="<?php echo G5_BBS_URL; ?>/logout.php?url=shop">
            <img src="/m-fortune-img/logout_icon.png" alt=""><span>로그아웃</span>
          </a>
        </div>
        <div class="mypage">
		<?php if ($member['mb_level'] == 3) {  ?>
		  <a href="<?php echo G5_SHOP_URL; ?>/orderinquiry2.php">
		<?php } else { ?>
		  <a href="<?php echo G5_URL; ?>/mypage_payment_list.php">
		<?php } ?>
            <i class="xi-profile-o"></i><span>마이페이지</span>
        </a>
        </div>
      <?php } else { ?>
        <div class="login">
          <a href="<?php echo G5_BBS_URL; ?>/login.php?url=%2Fshop%2F">
            <img src="/m-fortune-img/login_icon.png" alt=""><span>로그인</span>
          </a>
        </div>
        <div class="signin">
          <a href="<?php echo G5_BBS_URL; ?>/register.php">
            <img src="/m-fortune-img/signin_icon.png" alt=""><span>회원가입</span>
        </a>
        </div>
      <?php } ?>


      </div>




        <!--카테고리 시작-->
        <div class="cate01">
          <h2>카테고리</h2>
          <ul class="cate01-ul clearfix">
        <?php
        $mshop_ca_href = G5_SHOP_URL.'/list.php?ca_id=';
        $mshop_ca_res1 = sql_query(get_mshop_category('', 2));
        for($i=0; $mshop_ca_row1=sql_fetch_array($mshop_ca_res1); $i++) {
            //if($i == 0)
                //echo '<ul class="cate">'.PHP_EOL;
        ?>
            <li>
                <a href="<?php echo $mshop_ca_href.$mshop_ca_row1['ca_id']; ?>">
				  <img src="/m-fortune-img/cate_icon<?php echo $mshop_ca_row1['ca_id'][0]; ?>.png" alt="<?php echo get_text($mshop_ca_row1['ca_name']); ?>">
				  <p><?php echo get_text($mshop_ca_row1['ca_name']); ?></p>
				</a>
            </li>
        <?php
        }
        ?>
            <li>
              <a href="<?php echo G5_SHOP_URL; ?>/itemuselist.php">
                <img src="/m-fortune-img/cate_icon6.png" alt="상담후기">
                <p>상담후기</p>
              </a>
            </li>
            <li>
              <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=best">
                <img src="/m-fortune-img/cate_icon7.png" alt="상담사례">
                <p>상담사례</p>
              </a>
            </li>
            <li>
              <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=event">
                <img src="/m-fortune-img/cate_icon8.png" alt="이벤트/혜택">
                <p>이벤트/혜택</p>
              </a>
            </li>
            <li>
              <a href="<?php echo G5_URL; ?>/shop/itemuselist.php?gubun=best">
                <img src="/m-fortune-img/cate_icon9.png" alt="베스트후기">
                <p class="best">베스트후기</p>
              </a>
            </li>
          </ul>
        </div><!--cate01-->

        <div class="cate02">
          <ul class="cate02-ul">
            <?php if(!$is_member){ ?>
            <li>
                <a href=""id="no_member_time_check">비회원 조회</a>
            </li>
            <?php }?>
            <li>
              <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=notice">공지사항</a>
            </li>
            <li>
              <a href="<?php echo G5_BBS_URL; ?>/qalist.php">1:1 고객문의</a>
            </li>
            <li>
              <a href="<?php echo G5_BBS_URL; ?>/faq2.php?fm_id=3">이용안내</a>
            </li>
            <li>
              <a href="<?php echo G5_BBS_URL; ?>/faq.php?fm_id=4">FAQ</a>
            </li>
            <li>
              <a href="#!" class="hashtag">#추천해시태그</a>
            </li>
            <li>
              <a href="https://open.kakao.com/o/sSPKf93b" target="_blank">카카오톡 문의 (AM 10:00 ~ PM 22:00)</a>
            </li>

          </ul>
        </div>
    </div><!--menu-wr-->

</div>

<!-- 추천해시태그 -->
<div class="hashtag_pop" id="layer_recommhash" style="display:none;z-index: 99999;">
	<ul>
	<?php
	$sql = "select * FROM ".$g5['recommhash_table']." order by ht_no";
	$recommhash_res = sql_query($sql);
	while ( $recommhash_row = sql_fetch_array($recommhash_res) ) {
	?>
		<li><a href="<?php echo $recommhash_row['ht_link']; ?>"><?php echo $recommhash_row['ht_name']; ?></a></li>
	<?php
	}
	?>
	</ul>
	<a href="#!" class="hashtag">닫기</a>
</div>
<!-- 추천해시태그 -->
<script>
$(function (){

	$('.hashtag').click(function (){
		$('.hashtag_pop').stop().toggleClass('on');
	});

	$("#recommhash_btn").on("click", function() {
		$("#layer_recommhash").show();
	});

    $("button.sub_ct_toggle").on("click", function() {
        var $this = $(this);
        $sub_ul = $(this).closest("li").children("ul.sub_cate");

        if($sub_ul.size() > 0) {
            var txt = $this.text();

            if($sub_ul.is(":visible")) {
                txt = txt.replace(/닫기$/, "열기");
                $this
                    .removeClass("ct_cl")
                    .text(txt);
            } else {
                txt = txt.replace(/열기$/, "닫기");
                $this
                    .addClass("ct_cl")
                    .text(txt);
            }

            $sub_ul.toggle();
        }
    });


    $(".content li.con").hide();
    $(".content li.con:first").show();
    $(".cate_tab li a").click(function(){
        $(".cate_tab li a").removeClass("selected");
        $(this).addClass("selected");
        $(".content li.con").hide();
        //$($(this).attr("href")).show();
        $($(this).attr("href")).fadeIn();
    });

});
</script>
<script>
    let no_member_time_check = {
        init:function(){
          $("#no_member_time_check").on("click",()=>{
              let no_member_time = this.phone_check();
                switch(no_member_time){
                    case false:
                        alert("핸드폰번호를 다시 입력해주세요");
                        return false;
                    default :
                        no_member_time = no_member_time.toString().replaceAll("-","");
                        alert("화면이 표시됩니다.");
                        console.log(no_member_time);
                        this.create_bar();
                        this.time_check(no_member_time);
                        return false;
                }
          });
        },
        phone_check : function(){
            //올바른 핸드폰번호인지 체크하기
            let phone = prompt("핸드폰번호를 입력하세요. ex) 010-0000-0000");
            const regExp = /^\d{3}-\d{3,4}-\d{4}$/;
            let phone_check = regExp.test(phone)
            switch(phone_check){
                case true:
                    return phone;
                case false:
                    return false;
            }
        },
        create_bar:function(){
            alert("크리에이트바 생성");
            let bar = '<div class="my_time"><p></p></div>';
            $("#container").append(bar);
        },
        time_check: function(no_member_time){
            $.ajax({
                    url : "<?=G5_URL?>/ajax_time.php",
                    type : "GET",
                    contentType: "text/html; charset=utf-8",
                    data : {tel:no_member_time},
                    success : function(data){
                            alert("성공");
                            console.log(data);
                            $('.my_time > p').html(data);
                    },
                    error : function(data){
                            alert("에러");
                            console.log(data);
                    }
            });                
        }
    };
    no_member_time_check.init();
</script>