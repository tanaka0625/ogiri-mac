$(function(){

    let avator = $('.avator');
    let msg = avator.find('.msg');
    let choiceBtn = avator.find('.choice-btn');
    choiceBtn.on('click', function(event){

        let index = $(this).closest('.avator').index('.avator');

        $.ajaxSetup( {
            headers: {
                'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
            }
        } );

        $.ajax({

            type: 'POST',
            url: '/avator',
            data: {
                "id" : id,
                "avator" : avators[index]
            },
            dataType : 'json'

        }).done(function(data){

            msg.text("");
            msg.eq(index).text("選択中です");

        }).fail(function(XMLHttpRequest, status, e){
            alert(e);
        });
    });
});