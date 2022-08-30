let question = document.getElementsByClassName('question')
for(let i=0; i<question.length; i++) {

    let likeUserNames = question[i].getElementsByClassName('like-user-names');
    let like = question[i].getElementsByClassName('like');
    
    like[0].addEventListener('click' , () => {
        if(likeUserNames[0].classList.contains('on')) {
            likeUserNames[0].classList.remove('on');
        }else{
            likeUserNames[0].classList.add('on');
        }
    });
}