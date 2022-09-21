$(function(){
    text = $('.answer').find('.text');
    text.on('click', function(event){


        let index = $(this).closest('.item').index('.item');
        item = items[index];
        $item = $('.item').eq(index);

        if(typeof $item.find('.img-container').html() != "undefined"){
            html = 
            "<a class='question-text' href='/grouped_answer/" + item["question_id"] + "'>" +
                $item.find('.question-text').html() +
            "</a>" +
            "<div class='img-container'>" +
                $item.find('.img-container').html() +
            "</div>" +
            "<div class='text-container'>" +
                "<h3 class='text'>" +
                    item["text"] +
                "</h3>" +
            "</div>" +
            "<div class='answer-footer'>" +
                "<p class='info'>" +
                    $item.find('.info').html() +
                "</p>" +
                "<div class='like-user-names off'>" +
                    $item.find('.like-user-names').html() +
                "</div>" +
                "<div class='vote-user-names off'>" +
                    $item.find('.vote-user-names').html() +
                "</div>" +
            "</div>";

        }else{

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
                "<div class='like-user-names off'>" +
                    $item.find('.like-user-names').html() +
                "</div>" +
                "<div class='vote-user-names off'>" +
                    $item.find('.vote-user-names').html() +
                "</div>" +
            "</div>";
        }

        $('.header').addClass('off');
        $('#container').addClass('off');
        $('#big-item-container').removeClass('off');
        $('#big-item').html(html);

        like = $('#big-item').find('.like');
        like.on('click', function(event){
            $('#big-item').find('.like-user-names').toggleClass('off');
        });

        vote = $('#big-item').find('.vote');
        vote.on('click', function(event){
            $('#big-item').find('.vote-user-names').toggleClass('off');
        });


    });







    closeBtn = $('.close-btn');
    closeBtn.on('click', function(event){
        $('.header').removeClass('off');
        $('#container').removeClass('off');
        $('#big-item-container').addClass('off');
    });
});