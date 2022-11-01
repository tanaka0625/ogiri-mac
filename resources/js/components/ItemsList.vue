<template>

    <div class="items-list">

        <div v-for="(item, index) in variableItems" :key="item['key']">
            <Answer v-if="item['item_type'] === 'answer'" :item="item" :like-users="variableLikeUsersList[index]" :myUser="myUser" :btn-type="answerBtnType" v-on:add-answer-like="addAnswerLike"
            v-on:minus-answer-like="minusAnswerLike" v-on:add-vote="addVote" v-on:minus-vote="minusVote" v-on:delete-answer="deleteAnswer" v-on:enlarge-answer="enlargeAnswer"></Answer>

            <Question v-if="item['item_type'] === 'question'" :item="item" :like-users="variableLikeUsersList[index]" :myUser="myUser" v-on:add-question-like="addQuestionLike" 
            v-on:minus-question-like="minusQuestionLike"></Question>
        </div>

        <enlarged-answer v-if="isActiveEnlargedAnswer" :item="enlargedAnswer" :like-users="likeUsersOfEnlargedAnswer" :btn-type="answerBtnType" :my-user="myUser" :created_at="created_atOfEnlargedAnswer" v-on:back="back()"
        v-on:add-answer-like="addAnswerLike" v-on:minus-answer-like="minusAnswerLike" v-on:add-vote="addVote" v-on:minus-vote="minusVote" v-on:delete-answer="deleteAnswer" v-on:enlarge-answer="enlargeAnswer"></enlarged-answer>
    </div>


</template>

<script>
    import Answer from "./Answer.vue";
    import Question from "./Question.vue";
    import EnlargedAnswer from "./EnlargedAnswer.vue";

    export default {
        components: {Answer, Question, EnlargedAnswer},
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
        mounted (){
            // console.log(this.items[0]["content"]);
        },
        data: function() {
            return {
                variableItems: this.items,
                variableLikeUsersList: this.likeUsersList,
                isActiveEnlargedAnswer: false,
                enlargedAnswer: 0,
                likeUsersOfEnlargedAnswer: 0,
                created_atOfEnlargedAnswer: 0

            }
        },
        methods: {

            addAnswerLike: function(likeUsers, myUser) {

                for(let i=0; i<this.likeUsersList.length; i++){
                    
                    if(likeUsers == this.likeUsersList[i]){
                        
                        this.likeUsersList[i]['like'].push(myUser);
                        break;
                    }
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

                    // 他に投票してたら削除
                    for(let x=0; x<this.likeUsersList[i]['vote'].length; x++){
                        if(this.likeUsersList[i]['vote'][x].id === this.myUser.id){
                            this.likeUsersList[i]['vote'].splice(this.likeUsersList[i]['vote'].findIndex(element => element.id === this.myUser.id));
                        }
                    }

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
            },
            enlargeAnswer: function(item, likeusers, created_at){
                this.enlargedAnswer = item;
                this.likeUsersOfEnlargedAnswer = likeusers;
                this.isActiveEnlargedAnswer = true;
                this.created_atOfEnlargedAnswer = created_at;
            },
            back: function(){
                this.isActiveEnlargedAnswer = false;
            }
        }
    }
</script>

<style scoped>
    
</style>