$(function(){

    let likeBtn = $('.item').find('.like-btn');
    likeBtn.on('click', function(event){


        // いいねされたのが回答かお題か判定
        let itemType;
        if($(this).closest('.answer').length){
            itemType = 'answer';
        }else{
            itemType = 'question';
        }

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
            url: '/like',
            data: {
                "id" : id,
                "itemType" : itemType
            },
            dataType : 'json'

        }).done(function(data){

            for(let i=0; i<item.length; ++i) {
                if(items[i]['id'] === id && itemType === 'answer' && item.eq(i).hasClass('answer') && item.eq(i).hasClass('liked-answer')) {

                    item.eq(i).removeClass('liked-answer');
                    item.eq(i).find('.like').text(data['like'] + 'ポテト');

                } else if(items[i]['id'] === id && itemType === 'answer' && item.eq(i).hasClass('answer') && !item.eq(i).hasClass('liked-answer')) {

                    item.eq(i).addClass('liked-answer');
                    item.eq(i).find('.like').text(data['like'] + 'ポテト');

                } else if(items[i]['id'] === id && itemType === 'question' && item.eq(i).hasClass('question') && item.eq(i).hasClass('liked-question')) {

                    item.eq(i).removeClass('liked-question');
                    item.eq(i).find('.like').text(data['like'] + 'コーラ');

                } else if(items[i]['id'] === id && itemType === 'question' && item.eq(i).hasClass('question') && !item.eq(i).hasClass('liked-question')) {

                    item.eq(i).addClass('liked-question');
                    item.eq(i).find('.like').text(data['like'] + 'コーラ');

                }
                
            }

            console.log(data['item']);


        }).fail(function(XMLHttpRequest, status, e){
            alert(e);
        });
    });
});