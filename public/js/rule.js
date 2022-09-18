ruleBtn = document.getElementsByClassName('rule-btn');
ruleMsg = document.getElementById('rule-msg');

for(let i=0; i<ruleBtn.length; i++){
    ruleBtn[i].addEventListener('click' , () => {

        ruleMsg.classList.toggle('off');
    });
}
