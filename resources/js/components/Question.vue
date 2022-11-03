<template>
    <div class='item question' v-bind:class="{'liked-question':isLiked()}">
        <a v-bind:href="'/grouped_answer/' + item['content'].id" class="text"><h3>{{item['content'].text}}</h3></a>

        <div class="question-img-container" v-if="item['content'].image_name != null">
            <img :src="'/storage/question/' + item['content'].image_name" alt="" class="question-img">
        </div>

        <p class="info">作:<a v-bind:href="'/user/' + item['content'].user_id">{{item['maker']}}</a> <span class="answer-number">{{item['content'].answer_number}}回答</span> <span class="like" v-on:click="activeLikeUsers()">{{likeUsers['like'].length}}コーラ</span></p>

        <div class='like-users' v-if="isActiveLikeUsers">
            <a v-for="likeUser in likeUsers['like']" :key="likeUser.id" v-bind:href="'/user/' + likeUser.id" class="like-user-name">{{likeUser.name}} </a>
        </div>

        <div class='question-footer'>
            <p v-if="item['situation'] === 'recruting'">回答期限:{{item['content'].limit_answer}}</p>
            <p v-if="item['situation'] === 'voting'">ナゲット期限:{{item['content'].limit_vote}}</p>
            <p v-if="item['situation'] === 'finished' || item['situation'] === 'fast'">{{created_at}}</p>
            <img class="like-btn" src="/images/icon/cola.png" alt="" v-on:click='like()' v-if="myUser != null">
            <img class="like-btn" src="/images/icon/cola.png" alt="" v-if="myUser === null">
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            item: {
                type: Object,
                required: true
            },
            likeUsers: {
                required: true
            },
            myUser: {
                required: true
            }
        },
        data: function() {
            return {
                isActiveLikeUsers: false,
                created_at: ''
            }
        },
        mounted () {

            let date = new Date(this.item["content"].created_at);

            const year = date.getFullYear().toString().padStart(4, '0');
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const day = date.getDate().toString().padStart(2, '0');
            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            const seconds = date.getSeconds().toString().padStart(2, '0');

            const dateText = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
            this.created_at = dateText;
        },
        methods: {

            isLiked: function(){

                if(this.myUser === null){
                    return;
                }

                for(let x=0; x<this.likeUsers['like'].length; x++)
                {

                    if(this.likeUsers['like'][x]["id"] == this.myUser.id)
                    {
                        return true;
            
                    }else if(x == this.likeUsers['like'].length - 1)
                    {
                        return false;
                    }
                }
            },
            like: function(){

                if(this.item['content'].user_id == this.myUser.id){
                    return;
                }


                axios.post("/like",{
                    id: this.item['content'].id,
                    itemType: "question"
                })
                .then(function (response) {

                    if(!this.likeUsers['like'].some(user => user.id == this.myUser.id)){
                        this.$emit('add-question-like', this.likeUsers, this.myUser);
                    }else{
                        this.$emit('minus-question-like', this.likeUsers, this.myUser);
                    }

                }.bind(this))
                .catch(function (error){
                })
            },
            activeLikeUsers: function () {

                if(this.isActiveLikeUsers === false)
                {
                    this.isActiveLikeUsers = true;
                }else{
                    this.isActiveLikeUsers = false;
                }
            }
        }
    }
</script>

<style scoped>
    .question {
        border: solid black 10px;
        margin-bottom: 4px;
        position: relative;
        word-break: break-all;

    }

    .liked-question {
        border: solid brown 10px;
    }

    .text {
        margin-bottom: 20px;
        margin-top: 10px;
        color: black;
    }

    .like-btn {
        background-color: white;
        width: 10%;
        position: absolute;
        right: 0%;
        bottom: 0%;
    }

    .info {
        margin: 0;
        width: 80%;
    }

    .question-footer p {
        margin: 0;
    }

    .question-img {
        width: 100%;
    }

    .like-users {
        width: 80%;
    }

    .like-user-name {
        text-decoration: none;
    }

    .question-img-container {
        width: 100%;
    }

    .question-img {
        width: 100%;
    }

</style>
