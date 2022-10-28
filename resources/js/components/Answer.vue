<template>
    <div class="item answer" v-bind:class="{'liked-answer':isLiked()}">

        <p class="vote-msg" v-if="isVoted() && item['content'].kind === 1">※あなたがナゲットしました</p>

        <a v-bind:href="'/grouped_answer/' + item['content'].question_id" class="question-text">{{item['question_text']}}</a>

        <h3 class="text">{{item['content'].text}}</h3>

        <p class="info">
            <a class="maker" v-bind:href="'/user/' + item['content'].user_id">{{item['maker']}}</a> 
            <span class="like" v-on:click="activeLikeUsers()">{{likeUsers['like'].length}}ポテト</span> 
            <span class="vote" v-on:click="activeVoteUsers()" v-if="item['question_situation'] == 'finished'">{{likeUsers['vote'].length}}ナゲット</span>
            <span class="battle-vote" v-on:click="activeBattleVoteUsers()" v-if="item['question_situation'] == 'fast'">{{likeUsers['vote'].length}}シェイク</span>
        </p>

        <div class="like-users" v-if="isActiveLikeUsers">
            <p class="users-title">ポテトしたユーザー</p>
            <a class="like-user-name" v-for="likeUser in likeUsers['like']" :key="likeUser.id" v-bind:href="'/user/' + likeUser.id">{{likeUser.name}} </a>
        </div>

        <div class="vote-users" v-if="isActiveVoteUsers">
            <p class="users-title">ナゲットしたユーザー</p>
            <a class="vote-user-name" v-for="voteUser in likeUsers['vote']" :key="voteUser.id" v-bind:href="'/user/' + voteUser.id">{{voteUser.name}} </a>
        </div>

        <div class="battle-vote-users" v-if="isActiveBattleVoteUsers">
            <p class="users-title">シェイクしたユーザー</p>
            <a class="vote-user-name" v-for="voteUser in likeUsers['vote']" :key="voteUser.id" v-bind:href="'/user/' + voteUser.id">{{voteUser.name}} </a>
        </div>

        <div class="answer-footer">
            <p>{{item['content'].created_at}}</p>
            <img class="like-btn" src="/images/icon/frenchfry.png" alt="" v-on:click="like()" v-if="btnType === 'like' && user != 'undefined'">
            <img class="vote-btn" src="/images/icon/chicken_nugget.png" alt="" v-on:click="vote()" v-if="btnType === 'vote' && user != 'undefined'">
            <img class="like-btn" src="/images/icon/frenchfry.png" alt="" v-if="btnType === 'like' && user === 'undefined'">
            <img class="vote-btn" src="/images/icon/chicken_nugget.png" alt="" v-if="btnType === 'vote' && user === 'undefined'">
            <button class="delete-btn" v-if="btnType === 'delete'" v-on:click="deleteAnswer()">削除</button>
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
            btnType: {
                type: String,
                required: true
            },
            user: {
                type: Object,
                required: false
            }
        },
        data: function() {
            return {
                isActiveLikeUsers: false,
                isActiveVoteUsers: false,
                isActiveBattleVoteUsers: false
            }
        },
        methods: {
            isLiked: function () {

                for(let x=0; x<this.likeUsers['like'].length; x++)
                {

                    if(this.likeUsers['like'][x]["id"] == this.user.id)
                    {
                        return true;
            
                    }else if(x == this.likeUsers['like'].length - 1)
                    {
                        return false;
                    }
                }
            },
            isVoted: function () {

                for(let x=0; x<this.likeUsers['vote'].length; x++)
                {

                    if(this.likeUsers['vote'][x]["id"] == this.user.id)
                    {
                        return true;
            
                    }else if(x == this.likeUsers['vote'].length - 1)
                    {
                        return false;
                    }
                }

            },
            activeLikeUsers: function () {

                if(this.isActiveLikeUsers === false)
                {
                    this.isActiveLikeUsers = true;
                }else{
                    this.isActiveLikeUsers = false;
                }

            },
            activeVoteUsers: function () {

                if(this.isActiveVoteUsers === false)
                {
                    this.isActiveVoteUsers = true;
                }else{
                    this.isActiveVoteUsers = false;
                }

            },
            activeBattleVoteUsers: function () {
                if(this.isActiveBattleVoteUsers === false)
                {
                    this.isActiveBattleVoteUsers = true;
                }else{
                    this.isActiveBattleVoteUsers = false;
                }

            },
            like: function () {

                if(this.item["content"].user_id == this.user.id){
                    return;
                }

                axios.post("/like",{
                    id: this.item["content"].id,
                    itemType: "answer"
                })
                .then(function (response) {

                    if(!this.likeUsers['like'].some(user => user.id == this.user.id)){
                        this.$emit('add-answer-like', this.likeUsers, this.user);
                    }else{
                        this.$emit('minus-answer-like', this.likeUsers, this.user);
                    }

                }.bind(this))
                .catch(function (error){
                })
            },
            vote: function () {

                if(this.item["content"].user_id == this.user.id){
                    return;
                }

                axios.post("/vote",{
                    id: this.item["content"].id,
                    itemType: "answer"
                })
                .then(function (response) {

                    // 投票
                    if(!this.likeUsers['vote'].some(user => user.id == this.user.id)){
                        this.$emit('add-vote', this.likeUsers, this.user);
                    }else{
                        this.$emit('minus-vote', this.likeUsers, this.user);
                    }

                    // いいね
                    if(!this.likeUsers['like'].some(user => user.id == this.user.id)){
                        this.$emit('add-like', this.likeUsers, this.user);
                    }

                }.bind(this))
                .catch(function (error){
                })
            },
            deleteAnswer: function(){
                if(window.confirm("本当に削除しますか？")){

                    console.log(this.user);
        
                    axios.post("/delete",{
                        id: this.item["content"].id,
                        itemType: "answer"
                    })
                    .then(function (response) {
                        this.$emit('delete-answer', this.item, this.likeUsers);
                    }.bind(this))
                    .catch(function (error){
                    })
                }
            }
        }
    }
</script>

<style scoped>
    .answer {
        border: solid yellow 10px;
        margin-bottom: 4px;
        position: relative;
        word-break: break-all;
        background-color: white;
    }

    .liked-answer {
        border: solid red 10px;
        margin-bottom: 4px;
        position: relative;
    }

    .question-img {
        width: 100%;
    }

    .text {
        margin-bottom: 20px;
        margin-top: 10px;
    }

    .like-btn {
        background-color: white;
        width: 10%;
        position: absolute;
        right: 0%;
        bottom: 0%;
    }

    .vote-btn {
        background-color: white;
        width: 10%;
        position: absolute;
        right: 0%;
        bottom: 0%;
    }

    .delete-btn {
        position: absolute;
        right: 0%;
        bottom: 0%;
    }

    .info {
        margin: 0;
        width: 80%;
    }

    .answer-footer p {
        margin: 0;
    }

    .question-text {
        margin: 0;
        color: black;
    }

    .like-users {
        width: 80%;
    }

    .like-user-name {
        text-decoration: none;
    }

    .vote-users {
        width: 80%;
    }

    .battle-vote-users {
        width: 80%;
    }

    .vote-user-name {
        text-decoration: none;
    }

    .users-title {
        margin: 0;
    }

    .vote-msg {
        color: red;
        margin: 0;
    }

    .maker {
        text-decoration: none;
    }

</style>
