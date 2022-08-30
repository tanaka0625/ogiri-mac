
let answer = document.getElementsByClassName('answer')
for(let i=0; i<answer.length; i++) {

    let likeUserNames = answer[i].getElementsByClassName('like-user-names');
    let like = answer[i].getElementsByClassName('like');
    
    like[0].addEventListener('click' , () => {
        if(likeUserNames[0].classList.contains('on')) {
            likeUserNames[0].classList.remove('on');
        }else{
            likeUserNames[0].classList.add('on');
        }
    });
}


