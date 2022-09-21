
for(let i=0; i<answer.length; i++) {

    let likeUserNames = answer[i].getElementsByClassName('like-user-names');
    let like = answer[i].getElementsByClassName('like');

    
    if(typeof like[0] != "undefined") {

        like[0].addEventListener('click' , () => {
            if(likeUserNames[0].classList.contains('on')) {
                likeUserNames[0].classList.remove('on');
            }else{
                likeUserNames[0].classList.add('on');
            }
        });

    }


    let voteUserNames = answer[i].getElementsByClassName('vote-user-names');
    let vote = answer[i].getElementsByClassName('vote');

    
    if(typeof vote[0] != "undefined") {

        vote[0].addEventListener('click' , () => {
            if(voteUserNames[0].classList.contains('on')) {
                voteUserNames[0].classList.remove('on');
            }else{
                voteUserNames[0].classList.add('on');
            }
        });

    }

}


