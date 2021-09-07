/* 
 * 20210127 포인트 결제 추가 로직
 */
//$("#coin-apply").click(coin($('#pointpay_str').val()));
function coin(val){
//    console.log(val);
    var checkNum = isNaN(val);
        
    switch(checkNum){
        case true:
            alert("잘못된 입력을 하셨습니다. 숫자로 입력해주세요.");  
            location.reload();
            break;
        case false:
            var amt =  parseInt($("#amt_str").html().replaceAll(",","") );
            var point_hold = parseInt($("#point_str").html().replaceAll(",","") );
            var point_hold2 = parseInt($("#point_str2").val());
            var point_use =  parseInt($("#pointpay_str").val() );
            var p01 = $("#p01").val();            
            var amt_result = parseInt(amt)-parseInt(point_use);
            var pa_point = $("input[name=MallReserved]").val();
           
            
            $("#point_str").html( number_format(point_hold2-point_use) );            
            $("#pay_str").html( number_format(amt_result) );            
            $("input[name=MallReserved]").val(pa_point+point_use);
            
            if(parseInt(point_hold) < parseInt(point_use)){
                alert("보유 코인보다 사용할 포인트가 많습니다.");
                location.reload();
            }
            if(parseInt(point_use) <  p01 ){
                alert("최소 "+p01+"코인 이상 사용해야합니다.");
                location.reload();
            }
            if ( !Number.isInteger((parseInt(point_use)/1000)) ){
                alert("1000원 단위로만 입력할 수 있습니다.");
                location.reload();
            }
            if ( amt < point_use ){
                alert("코인으로만 결제할 수 없습니다.");
                location.reload();
            }
            //부가가치세 10% 추가.
            var amt1 = amt_result + (amt_result / 10) ;
            $("input[name=Amt]").val(amt1);          
            break;
        default :
            alert("알수 없는 에러가 발생하였습니다. 숫자로 입력해주세요.");
            break;
    }
}