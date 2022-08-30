$(function(){

    let voteBtn = $('.answer').find('.like-btn');
    voteBtn.on('click', function(event){

        let index = $(this).closest('.item').index('.item');

        // 自分の投稿にはいいね出来ない
        if(Number(userId) === items[index]['user_id']) {
            return;
        };

        let id = items[index]['id'];
        let item = $('.item');

        $.ajaxSetup( {
            headers: {
                'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
            }
        } );

        $.ajax({

            type: 'POST',
            url: '/vote',
            data: {
                "id" : id,
                "questionId" : questionId
            },
            dataType : 'json'

        }).done(function(data){

            for(let i=0; i<item.length; ++i) {
                if(items[i]['id'] === id && item.eq(i).hasClass('answer') && items[i]['like'] != data['like']) {

                    item.eq(i).addClass('liked-answer');
                    item.eq(i).find('.like').text(data['like'] + 'ポテト');

                }
            }

            if(data['judgeVoted'] === 0){
                item.find('.vote-msg').removeClass('on');
                item.eq(index).find('.vote-msg').addClass('on');
            }else{
                item.eq(index).find('.vote-msg').removeClass('on');
            }


        }).fail(function(XMLHttpRequest, status, e){
            alert(e);
        });
    });
});