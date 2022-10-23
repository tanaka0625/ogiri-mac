// for(let i=0; i<likeUsers.length; i++){

//     //回答かお題か判別
//     if(typeof likeUsers[i]["vote"] != "undefined"){

//         console.log(1);

//         for(let x=0; x<likeUsers[i]["vote"].length; x++){
//             if(likeUsers[i]["vote"][x]["id"] == userId && item[i].getElementsByClassName('vote-msg').length > 0){
//                 item[i].getElementsByClassName('vote-msg')[0].classList.add('on');
//             }
//         }
//     }
// }



let addVoteMsg = new Vue({

    el: ".content",
    data: {
        items: items,
        userId: userId,
        likeUsers: likeUsers
    },
    methods: {
        isVoted: function (n) {


            if(typeof this.likeUsers[n]["vote"] != "undefined"){

                for(let x=0; x<this.likeUsers[n]["vote"].length; x++)
                {

                    if(this.likeUsers[n]["vote"][x]["id"] == this.userId)
                    {
                        return true;
            
                    }else if(x == this.likeUsers[n]["vote"].length - 1)
                    {
                        return false;
                    }
                }
            }else{

                return false;
            }
        }  
    },
})