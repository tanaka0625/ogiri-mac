<template>
    <div>
        <div v-for="(item, index) in variableItems" :key="item['key']">
            <Answer v-if="item['item_type'] === 'answer'" :item="item" :like-users="variableLikeUsersList[index]" :user="user" btn-type="like" v-on:add-answer-like="addAnswerLike"
            v-on:minus-answer-like="minusAnswerLike"></Answer>

            <AnswerLikeNotice v-if="item['item_type'] === 'answer_like'" :item="item"></AnswerLikeNotice>

            <QuestionLikeNotice v-if="item['item_type'] === 'question_like'" :item="item"></QuestionLikeNotice>
        </div>
    </div>
</template>

<script>
    import Answer from "./Answer.vue"; 
    import AnswerLikeNotice from "./AnswerLikeNotice.vue";
    import QuestionLikeNotice from "./QuestionLikeNotice.vue";

    export default {
        components: {Answer, AnswerLikeNotice, QuestionLikeNotice},
        props: {
            items: {
                type: Array,
                required: true
            },
            likeUsersList: {
                type: Array,
                required: true
            },
            user: {
                type: Object,
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
            addAnswerLike: function(likeUsers, user) {

                for(let i=0; i<this.likeUsersList.length; i++){
                    
                    if(likeUsers == this.likeUsersList[i]){
                        
                        this.likeUsersList[i]['like'].push(user);
                        console.log(this.likeUsersList[i]['like']);
                        break;
                    }
                    console.log(2);
                }
            },
            minusAnswerLike: function(likeUsers, user) {

                for(let i=0; i<this.likeUsersList.length; i++){

                    if(likeUsers == this.likeUsersList[i]){
                        
                        this.likeUsersList[i]['like'].splice(likeUsers['like'].findIndex(element => element.id === user.id),1);
                        console.log(this.likeUsersList[i]['like']);

                        break;
                    }
                }
            },
        }
    }
</script>

<style scoped>

</style>
