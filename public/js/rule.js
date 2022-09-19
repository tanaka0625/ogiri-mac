$(function(){
    ruleBtn = $('.rule-btn');

    ruleBtn.on('click', function(event){

        ruleMsg = $(this).closest('.rule').find('.rule-msg');
        ruleMsg.toggleClass('off');

    });


});