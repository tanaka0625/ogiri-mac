$(function(){
    text = $('.answer').find('.text');
    text.on('click', function(event){

        let index = $(this).closest('.item').index('.item');
        item = items[index];
        $item = $('.item').eq(index);
        
        $('.header').addClass('off');
        $('#container').addClass('off');
        $('#big-item-container').removeClass('off');

        html = 
        "<a class='question-text' href='/grouped_answer/" + item["question_id"] + "'>" +
            $item.find('.question-text').html() +
        "</a>" +
        "<div class='text-container'>" +
            "<h3 class='text'>" +
                item["text"] +
            "</h3>" +
        "</div>" +
        "<div class='answer-footer'>" +
            "<p class='info'>" +
                $item.find('.info').html() +
            "</p>" +
            "<p>" +
                "ポテトしたユーザー" +
            "</p>" +
            "<div class='like-user-names'>" +
                $item.find('.like-user-names').html() +
            "</div>" +
        "</div>";

        $('#big-item').html(html);
    });

    closeBtn = $('.close-btn');
    closeBtn.on('click', function(event){
        $('.header').removeClass('off');
        $('#container').removeClass('off');
        $('#big-item-container').addClass('off');
    });
});