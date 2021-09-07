<?php
//ini_set('display_errors', 1); // set to 0 for production version
//error_reporting(E_ALL);
include_once('./_common.php');
exit;
/*
$od['mb_hp'] = "01046001784";
$od_dc_pwd = substr($od['mb_hp'],-4) ;
$tel = trim(str_replace("-","",$od['mb_hp']));
$amt = 3300;
$sec = 900;
$params = "cp=$cp&svc=$svc&tel=$tel&pwd=$od_dc_pwd&amt=$amt&sec=$sec";
$url = $user_refund_addr."?".$params;
echo $url."<br>";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$ret = curl_exec($ch);
curl_close($ch);
var_dump($ret);
*/
// {"mid":"","tid":"","svcCd":"01","partialCancelCode":"0","cancelAmt":"0","cancelMsg":"","cancelPwd":""}
// object(stdClass)#4 (10) { ["resultCode"]=> string(4) "2013" ["resultMsg"]=> string(20) "취소 완료 거래" ["pgResultCode"]=> NULL ["pgResultMsg"]=> NULL ["pgTid"]=> string(30) "pgwowenttm01081906212104398903" ["pgApprovalNo"]=> string(0) "" ["pgApprovalAmt"]=> string(5) "33000" ["pgAppDate"]=> string(8) "20190625" ["pgAppTime"]=> string(6) "165927" ["stateCd"]=> string(1) "2" }
/*
$json = "{\"mid\":\"pgwowenttm\",\"tid\":\"pgwowenttm01081906212104398903\",\"svcCd\":\"01\",\"partialCancelCode\":\"0\",\"cancelAmt\":\"33000\",\"cancelMsg\":\"\",\"cancelPwd\":\"123456\"}";
$ret = Curl($pg_cancel_url, $json, $http_status);
$arr = json_decode($ret);
var_dump($ret);
var_dump($arr);
var_dump($arr->resultCode);
*/
/*
$url = "http://060300.co.kr/dc-comm/user_prepay.php?cp=287&svc=0234331177&tel=01055919609&pwd=9609&amt=33000&sec=900";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$ret = curl_exec($ch);
curl_close($ch);
echo $ret;exit;
*/
exit;
//$size = getimagesize("/home/fortune/public_html/data/banner/1");
//print_r($size);
?>
<script src="https://apis.google.com/js/api.js"></script>
<script>
  /**
   * Sample JavaScript code for youtube.liveChatMessages.list
   * See instructions for running APIs Explorer code samples locally:
   * https://developers.google.com/explorer-help/guides/code_samples#javascript
   */

  function authenticate() {
    return gapi.auth2.getAuthInstance()
        .signIn({scope: "https://www.googleapis.com/auth/youtube.readonly"})
        .then(function() { console.log("Sign-in successful"); },
              function(err) { console.error("Error signing in", err); });
  }
  function loadClient() {
    gapi.client.setApiKey("AIzaSyCzj36qDqkfw96hnZbE4NCvgnJG33-EjVo");
    return gapi.client.load("https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest")
        .then(function() { console.log("GAPI client loaded for API"); },
              function(err) { console.error("Error loading GAPI client for API", err); });
  }
  // Make sure the client is loaded and sign-in is complete before calling this method.
  function execute() {
    return gapi.client.youtube.liveChatMessages.list({
      "liveChatId": "DSGyEsJ17cI",
      "part": "snippet,authorDetails"
    })
        .then(function(response) {
                // Handle the results here (response.result has the parsed body).
                console.log("Response", response);
              },
              function(err) { console.error("Execute error", err); });
  }
  gapi.load("client:auth2", function() {
    gapi.auth2.init({client_id: "805162485883-3d3j3kuuu7cjuld7jnnnb2kb8d1nd4tk.apps.googleusercontent.com"});
  });
</script>
<button onclick="authenticate().then(loadClient)">authorize and load</button>
<button onclick="execute()">execute</button>
<!--iframe title='YTN 데일리 라이브' width='640px' height='360px' src='https://tv.kakao.com/embed/player/livelink/5386012?width=640&height=360&service=kakao_tv' frameborder='0' scrolling='no' ></iframe>

<iframe width="560" height="315" src="https://www.youtube.com/embed/DSGyEsJ17cI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
<iframe width="560" height="315" src="https://www.youtube.com/live_chat?v=DSGyEsJ17cI&embed_domain=fortune.urbannet.co.kr" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe-->