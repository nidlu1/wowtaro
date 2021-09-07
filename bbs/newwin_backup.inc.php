<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (!defined('_SHOP_')) {
    $pop_division = 'comm';
} else {
    $pop_division = 'shop';
}

$sql = " select * from {$g5['new_win_table']}
          where nw_id = 13 ";
$result = sql_query($sql, false);

$sql2 = " select * from {$g5['new_win_table']}
          where '".G5_TIME_YMDHIS."' between nw_begin_time and nw_end_time
            and nw_device IN ( 'both', 'pc' ) and nw_division IN ( 'both', '".$pop_division."' )
          order by nw_id asc ";
$result2 = sql_query($sql2, false);
?>

<!-- 팝업레이어 시작 { -->
<div id="hd_pop">
    <h2>팝업레이어 알림</h2>

<?php
for ($i=0; $nw=sql_fetch_array($result); $i++)
{
    // 이미 체크 되었다면 Continue
    if ($_COOKIE["hd_pops_{$nw['nw_id']}"])
        continue;
?>

    <div id="hd_pops_<?php echo $nw['nw_id'] ?>" class="hd_pops" style="top:<?php echo $nw['nw_top']?>px;left:<?php echo $nw['nw_left']?>px">
        <div class="hd_pops_con" style="width:<?php echo $nw['nw_width'] ?>px;height:<?php echo $nw['nw_height'] ?>px">
            
            <div class="bx-wrapper" style="max-width: 100%;">
                    <div class="bx-viewport">
                            <ul class="slide-wrap" style="display: block; width: auto; position: relative;">
                                <?php
                                while($nw2=sql_fetch_array($result2)){
                                ?>
                                    <li>
                                            <a href="<?=$nw2['nw_link']?>"><?php echo conv_content($nw2['nw_content'], 1); ?></a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                    </div>
            </div>  
            
        </div>
        <div class="hd_pops_footer">
            <input type="checkbox" class="hd_pops_reject_check" >
            <button class="hd_pops_reject hd_pops_<?php echo $nw['nw_id']; ?> <?php echo $nw['nw_disable_hours']; ?>"><strong><?php echo $nw['nw_disable_hours']; ?></strong>시간 동안 다시 열람하지 않습니다.</button>
            <button class="hd_pops_close hd_pops_<?php echo $nw['nw_id']; ?>">닫기 <i class="fa fa-times" aria-hidden="true"></i></button>
        </div>
    </div>
<?php }
if ($i == 0) echo '<span class="sound_only">팝업레이어 알림이 없습니다.</span>';
?>
</div>

<script>
$(function() {    
    $(".hd_pops_reject").click(function() {
        if($(".hd_pops_reject_check").is(":checked")){
            var id = $(this).attr('class').split(' ');
            var ck_name = id[1];
            var exp_time = parseInt(id[2]);
            $("#"+id[1]).css("display", "none");
            set_cookie(ck_name, 1, exp_time, g5_cookie_domain);
        }
    });
    $('.hd_pops_close').click(function() {
        console.log("qkfthd");
        var idb = $(this).attr('class').split(' ');
        $('#'+idb[1]).css('display','none');
    });
    $("#hd").css("z-index", 1000);
});
</script>
<!-- } 팝업레이어 끝 -->