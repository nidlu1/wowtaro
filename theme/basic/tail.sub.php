<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<?php if ($is_admin == 'super') {  ?><!-- <div style='float:left; text-align:center;'>RUN TIME : <?php echo get_microtime()-$begin_time; ?><br></div> --><?php }  ?>
  <?php if(G5_IS_MOBILE) {
    echo '<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/m_layout.css">'.PHP_EOL;
  } else {
  echo '<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/layout.css">'.PHP_EOL;
  }
  ?>
<!-- ie6,7에서 사이드뷰가 게시판 목록에서 아래 사이드뷰에 가려지는 현상 수정 -->
<!--[if lte IE 7]>
<script>
$(function() {
    var $sv_use = $(".sv_use");
    var count = $sv_use.length;

    $sv_use.each(function() {
        $(this).css("z-index", count);
        $(this).css("position", "relative");
        count = count - 1;
    });
});
</script>
<![endif]-->

<!-- DSP 리타겟팅 Checking Script V.201603 Start-->
<script type="text/javascript" async="true">
function dsp_loadrtgJS(b,c){var d=document.getElementsByTagName("head")[0],a=document.createElement("script");a.type="text/javascript";null!=c&&(a.charset="euc-kr");a.src=b;a.async="true";d.appendChild(a)}function dsp_load_rtg(b){dsp_loadrtgJS(("https:"==document.location.protocol?" https://":" http://")+b,"euc-kr")}dsp_load_rtg("realdmp.realclick.co.kr/rtarget/rtget.js?dsp_adid=sinseonunse");
</script>
<!-- DSP 리타겟팅 Checking Script V.201603 End-->

<!-- Tracking Script Start 2.0 -->
<script type="text/javascript" async="true">
var dspu = "LI9c2luc2VvbnVuc2U";      // === (필수)광고주key (변경하지마세요) ===
var dspu,dspt,dspo,dspom;
function loadanalJS_dsp(b,c){var d=document.getElementsByTagName("head")[0],a=document.createElement("sc"+"ript");a.type="text/javasc"+"ript";null!=c&&(a.charset="UTF-8");
a.src=b;a.async="true";d.appendChild(a)}function loadanal_dsp(b){loadanalJS_dsp(("https:"==document.location.protocol?"https://":"http://")+b,"UTF-8");document.write("<span id=dsp_spn style=display:none;></span>");}
loadanal_dsp("tk.realclick.co.kr/tk_comm.js?dspu="+dspu+"&dspt="+dspt+"&dspo="+dspo+"&dspom="+dspom);
</script>
<!-- Tracking Script End 2.0 -->

<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script> 
<script type="text/javascript"> 
if (!wcs_add) var wcs_add={};
wcs_add["wa"] = "s_ce06baec61e";
if (!_nasa) var _nasa={};
wcs.inflow("sinseonunse.com");
wcs_do(_nasa);
</script>
</body>
</html>
<?php echo html_end(); // HTML 마지막 처리 함수 : 반드시 넣어주시기 바랍니다. ?>
