
for(let i=0; i<items.length; i++){
    if(items[i]['myVoteAnswer'] === 1)
    {
        voteMsg = item[i].getElementsByClassName('vote-msg')[0];

        voteMsg.classList.add('on');

    }
}
