for(let i=0; i<likeUsers.length; i++){

    //回答かお題か判別
    if(typeof likeUsers[i]["vote"] != "undefined"){

        for(let x=0; x<likeUsers[i]["vote"].length; x++){
            if(likeUsers[i]["vote"][x]["id"] == userId && item[i].getElementsByClassName('vote-msg').length > 0){
                item[i].getElementsByClassName('vote-msg')[0].classList.add('on');
            }
        }
    }
}