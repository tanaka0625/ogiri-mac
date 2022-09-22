console.log(likeUsers[0]["like"]);
for(let i=0; i<likeUsers.length; i++){

    for(let x=0; x<likeUsers[i]["like"].length; x++)
    {
        if(likeUsers[i]["like"][x]["id"] == userId && typeof items[i]["question_id"] != "undefined")
        {
            item[i].classList.add("liked-answer");

        }else if(likeUsers[i]["like"][x]["id"] == userId){

            item[i].classList.add("liked-question");

        }
    }
}


