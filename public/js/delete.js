$(function(){

    let deleteBtn = $('.item').find('.delete-btn');
    deleteBtn.on('click', function(event){
        if(confirm("本当に削除しますか？"))
        {
            // いいねされたのが回答かお題か判定
            let itemType;
            if($(this).closest('.answer').length){
                itemType = 'answer';
            }else{
                itemType = 'question';
            }

            let index = $(this).closest('.item').index('.item');
            let id = items[index]['id'];
            let item = $('.item');

            $.ajaxSetup( {
                headers: {
                    'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
                }
            } );


            $.ajax({

                type: 'POST',
                url: '/delete',
                data: {
                    "id" : id,
                    "itemType" : itemType
                },
                dataType : 'json'

            }).done(function(data){

                for(let i=0; i<item.length; ++i) {
                    if(items[i]['id'] === id && itemType === 'answer' && item.eq(i).hasClass('answer')) {

                        item.eq(i).addClass('off');

                    } 
                }

            }).fail(function(XMLHttpRequest, status, e){
                alert(e);
            });
        }
    });
});