$(function(){

    function countLoginedUser() {

        $.ajaxSetup( {
            headers: {
                'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
            }
        } );
    
        $.ajax({
    
            type: 'POST',
            url: '/countLoginedUser',
            data: {
    
            },
            dataType : 'json'
    
        }).done(function(data){
    
            $("#logined-user-cnt").text("10分以内にログインした人数 " + data["loginedUserCnt"] + "人");
    
        }).fail(function(XMLHttpRequest, status, e){
            if (!alert("セッションがタイムアウトしました。再度ログインしてください。")) {
                window.location.href = "/login";

            }
        });
    };

    countLoginedUser();

    // setInterval(function(){
    //     countLoginedUser();
    // }, 1000*10);

});