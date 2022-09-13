
for(let i=0; i<items.length; i++){
    if(items[i]['myLikeAnswer'] === 1)
    {
        item[i].classList.add('liked-answer');
    }
}

for(let i=0; i<items.length; i++){
    if(items[i]['myLikeQuestion'] === 1)
    {
        item[i].classList.add('liked-question');
    }
}