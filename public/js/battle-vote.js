$(function(){

    let voteBtn = $('.answer').find('.vote-btn');
    voteBtn.on('click', function(event){


        let index = $(this).closest('.answer').index('.answer');
        let answer = $('.answer');

        // 自分の投稿にはいいね出来ない
        if(Number(userId) === answers[index]['user_id']) {
            return;
        };

        let id = answers[index]['id'];

        $.ajaxSetup( {
            headers: {
                'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
            }
        } );

        $.ajax({

            type: 'POST',
            url: '/battle/vote',
            data: {
                "id" : id,
                "questionId" : question["id"]
            },
            dataType : 'json'

        }).done(function(data){

        }).fail(function(XMLHttpRequest, status, e){
            alert(e);
        });
    });
});