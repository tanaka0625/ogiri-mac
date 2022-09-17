$(function(){

    setInterval(function(){


        $.ajaxSetup( {
            headers: {
                'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
            }
        } );

        $.ajax({

            type: 'POST',
            url: '/battle',
            data: {
                "id" : 1
            },
            dataType : 'json'

        }).done(function(data){

            var html = 
            "<div class='item question'>" +
                "<h3 class='text'>" +
                    data["question"]["text"] +
                "</h3>" +
                "<p class='info'>" +
                    "作者: " +
                    "<a href='user/" + data["question"]["user_id"] + "'>" +
                        data["questionMakerName"] +
                    "</a>" +
                "</p>" +
            "</div>";


            if(data["situation"] === "recrutingAnswer"){

                $(".situation-msg").text("回答受付中");
                time = data["limit_answer"]-data["now"];
                $(".time-msg").text("回答制限時間 " + time + "秒");
                if(typeof userId != 'undefined'){
                    $("#question-form").addClass("off");
                    $("#answer-form").removeClass("off");
                }
                $(".items-msg").text("")
                $(".items").html(html);


            }else if(data["situation"] === "watingQuestion"){

                $(".situation-msg").text(data["answers"][0]["makerName"] + " さんの勝利です。" + data["answers"][0]["makerName"] + " さんは60秒以内にお題を投稿してください。");

                if(typeof userId != 'undefined' && data["answers"][0]["user_id"] == userId){

                    time = data["limit_question"] - data["now"];
                    $(".time-msg").text("お題投稿制限時間" + time + "秒");
                    $("#question-form").removeClass("off");

                }else{
                    $(".time-msg").text("");
                }

                $("#answer-form").addClass("off");
                $(".items-msg").text("前回の結果");

                for(let i=0; i<data["answers"].length; i++){
                    answer = data["answers"][i];
                    html = html +
                    "<div class='item answer'>" +
                        "<p class='vote-msg'>" +
                        "</p>" +
                        "<h3 class='text'>" +
                            answer["text"] +
                        "</h3>" +
                        "<p class='info'>" +
                            "作: " +
                            "<a href='user/" + answer["user_id"] + "'>" + answer["makerName"] + "</a>" +
                            " <span class='vote'>" +
                                answer["battle_vote"] +
                                "シェイク" +
                            "</span>" +
                        "</p>" +
                    "</div>";
                }

                $(".items").html(html);


                // vote-msg
                let answers = data["answers"];
                let $answer = $('.answer');
                for(let i=0; i<answers.length; i++){
                    if(answers[i]['myBattleVoteAnswer'] == 1){
                        $answer.eq(i).find('.vote-msg').text("あなたがシェイクしました");
                        $answer.eq(i).find('.vote-msg').addClass('on');

                    }
                }


            }else if(data["situation"] ==="recrutingQuestion" ){

                $(".situation-msg").text(data["answers"][0]["makerName"] + "さんがお題を投稿されませんでした。代理のお題を募集します。");
                $(".time-msg").text("");
                if(typeof userId != 'undefined'){
                    $("#question-form").removeClass("off");
                    $("#answer-form").addClass("off");
                }
                $(".items-msg").text("前回の結果");

                for(let i=0; i<data["answers"].length; i++){
                    answer = data["answers"][i];
                    html = html +
                    "<div class='item answer'>" +
                        "<p class='vote-msg'>" +
                        "</p>" +
                        "<h3 class='text'>" +
                            answer["text"] +
                        "</h3>" +
                        "<p class='info'>" +
                            "作: " +
                            "<a href='user/" + answer["user_id"] + "'>" + answer["makerName"] + "</a>" +
                            " <span class='vote'>" +
                                answer["battle_vote"] +
                                "シェイク" +
                            "</span>" +
                        "</p>" +
                    "</div>";
                }

                $(".items").html(html);

                // vote-msg
                let answers = data["answers"];
                let $answer = $('.answer');
                for(let i=0; i<answers.length; i++){
                    if(answers[i]['myBattleVoteAnswer'] == 1){
                        $answer.eq(i).find('.vote-msg').text("あなたがシェイクしました");
                        $answer.eq(i).find('.vote-msg').addClass('on');

                    }
                }


            }else if(data["situation"] === "voting"){

                $(".situation-msg").text("投票受付中");
                if(typeof userId != 'undefined'){
                    $("#answer-form").addClass("off");
                    $("#question-form").addClass("off");
                }

                time = data["limit_vote"]-data["now"];
                $(".time-msg").text("投票制限時間 " + time + "秒");

                for(let i=0; i<data["answers"].length; i++){
                    answer = data["answers"][i];
                    html = html +
                    "<div class='item answer'>" +
                        "<p class='vote-msg'>" +
                        "</p>" +
                        "<h3 class='text' style='margin-bottom: 50px'>" +
                            answer["text"] +
                        "</h3>" +
                        "<div class='answer-footer'>" +
                            "<img class='vote-btn' src='/images/icon/shake.png' alt='' style='width: 10%'>" +
                        "</div>" +
                    "</div>";
                }

                $(".items").html(html);


                // vote-msg
                let $answer = $('.answer');
                let answers = data["answers"];
                for(let i=0; i<answers.length; i++){
                    if(answers[i]['myBattleVoteAnswer'] == 1){
                        $answer.eq(i).find('.vote-msg').text("あなたがシェイクしました");
                        $answer.eq(i).find('.vote-msg').addClass('on');

                    }
                }

                // 投票
                if(typeof userId != 'undefined'){
                    let voteBtn = $('.answer').find('.vote-btn');
                    voteBtn.on('click', function(event){
    
    
                        let index = $(this).closest('.answer').index('.answer');
                
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
                                "questionId" : data["question"]["id"]
                            },
                            dataType : 'json'
                        }).done(function(data){
    
                        }).fail(function(XMLHttpRequest, status, e){
                            alert(e);
                        });
                    });
                }

            }

        }).fail(function(XMLHttpRequest, status, e){
            alert(e);
        });

    }, 900);

});