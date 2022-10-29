<template>

    <div class="items-list">
        <div v-for="(item, index) in variableItems" :key="item['key']">
            <Answer v-if="item['item_type'] === 'answer'" :item="item" :like-users="variableLikeUsersList[index]" :myUser="myUser" :btn-type="answerBtnType" v-on:add-answer-like="addAnswerLike"
            v-on:minus-answer-like="minusAnswerLike" v-on:add-vote="addVote" v-on:minus-vote="minusVote" v-on:delete-answer="deleteAnswer"></Answer>

            <Question v-if="item['item_type'] === 'question'" :item="item" :like-users="variableLikeUsersList[index]" :myUser="myUser" v-on:add-question-like="addQuestionLike" 
            v-on:minus-question-like="minusQuestionLike"></Question>
        </div>
    </div>


</template>

<script>
    import Answer from "./Answer.vue";
    import Question from "./Question.vue";

    export default {
        components: {Answer, Question},
        props: {
            items: {
                type: Array,
                required: true
            },
            likeUsersList: {
                type: Array,
                required: true
            },
            myUser: {
                required: true
            },
            answerBtnType: {
                type: String,
                required: true
            }
        },
        data: function() {
            return {
                variableItems: this.items,
                variableLikeUsersList: this.likeUsersList
            }
        },
        methods: {

            addAnswerLike: function(likeUsers, myUser) {

                for(let i=0; i<this.likeUsersList.length; i++){
                    
                    if(likeUsers == this.likeUsersList[i]){
                        
                        this.likeUsersList[i]['like'].push(myUser);
                        break;
                    }
                    console.log(2);
                }
            },
            minusAnswerLike: function(likeUsers, myUser) {

                for(let i=0; i<this.likeUsersList.length; i++){

                    if(likeUsers == this.likeUsersList[i]){
                        
                        this.likeUsersList[i]['like'].splice(likeUsers['like'].findIndex(element => element.id === myUser.id),1);

                        break;
                    }
                }
            },
            addVote: function(likeUsers, myUser) {

                for(let i=0; i<this.likeUsersList.length; i++){
                    
                    if(likeUsers == this.likeUsersList[i]){
                        
                        this.likeUsersList[i]['vote'].push(myUser);
                    }
                }
            },
            minusVote: function(likeUsers, myUser) {

                for(let i=0; i<this.likeUsersList.length; i++){

                    if(likeUsers == this.likeUsersList[i]){
                        
                        this.likeUsersList[i]['vote'].splice(likeUsers['vote'].findIndex(element => element.id == myUser.id),1);
                        
                    }
                }
            },
            addQuestionLike: function(likeUsers, myUser) {

                for(let i=0; i<this.likeUsersList.length; i++){
                    
                    if(likeUsers == this.likeUsersList[i]){
                        
                        this.likeUsersList[i]['like'].push(myUser);
                    }
                }
            },
            minusQuestionLike: function(likeUsers, myUser) {

                for(let i=0; i<this.likeUsersList.length; i++){

                    if(likeUsers == this.likeUsersList[i]){
                        
                        this.likeUsersList[i]['like'].splice(likeUsers['like'].findIndex(element => element.id == myUser.id));
                        
                    }
                }
            },
            deleteAnswer: function(item, likeUsers) {
                for(let i=0; i<this.items.length; i++) {
                    if(item === this.items[i]) {
                        this.items.splice(this.items.findIndex(element => element === item),1);
                        this.likeUsersList.splice(this.likeUsersList.findIndex(element => element === likeUsers),1);
                        break;
                    }
                }
            }
        }
    }
</script>