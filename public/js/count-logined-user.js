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
    
            console.log(data["loginedUserCnt"]);
            $("#logined-user-cnt").text("10分以内にログインした人数 " + data["loginedUserCnt"] + "人");
    
        }).fail(function(XMLHttpRequest, status, e){
            alert(e);
        });
    };

    countLoginedUser();

    setInterval(function(){
        countLoginedUser();
    }, 1000*10);

});