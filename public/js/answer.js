Vue.component('items-answer', {
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
        }
    },
    data: function() {
        return {
            isActiveLikeUsers: false,
            isActiveVoteUsers: false,
            isActiveBattleVoteUsers: false,
            user: user
        }
    },
    template: `
        <div class="item answer" v-bind:class="{'liked-answer':isLiked()}">

            <p class="vote-msg" v-if="isVoted() && item['answer'].kind === 1">※あなたがナゲットしました</p>

            <a v-bind:href="'/grouped_answer/' + item['answer'].question_id" class="question-text">{{item['question_text']}}</a>

            <h3 class="text">{{item['answer'].text}}</h3>

            <p class="info">
                <a class="maker" v-bind:href="'/user/' + item['answer'].user_id">{{item['maker']}}</a> 
                <span class="like" v-on:click="activeLikeUsers()">{{likeUsers['like'].length}}ポテト</span> 
                <span class="vote" v-on:click="activeVoteUsers()" v-if="item['question_situation'] == 'finished'">{{likeUsers['vote'].length}}ナゲット</span>
                <span class="battle-vote" v-on:click="activeBattleVoteUsers()" v-if="item['question_situation'] == 'fast'">{{likeUsers['vote'].length}}シェイク</span>
            </p>

            <div class="like-users" v-if="isActiveLikeUsers">
                <a v-for="(likeUser, index) in likeUsers['like']" :key="likeUser.id" v-bind:href="'/user/' + likeUser.id" class="likeUser">{{likeUser.name}} </a>
            </div>

            <div class="vote-users" v-if="isActiveVoteUsers">
                <a v-for="(voteUser, index) in likeUsers['vote']" :key="voteUser.id" v-bind:href="'/user/' + voteUser.id" class="voteUser">{{voteUser.name}} </a>
            </div>

            <div class="battle-vote-users" v-if="isActiveBattleVoteUsers">
                <a v-for="(voteUser, index) in likeUsers['vote']" :key="voteUser.id" v-bind:href="'/user/' + voteUser.id" class="voteUser">{{voteUser.name}} </a>
            </div>

            <div class="answer-footer">
                <p>{{item['answer'].created_at}}</p>
                <img class="like-btn" src="/images/icon/frenchfry.png" alt="" v-on:click="like()" v-if="btnType === 'like' && user != 'undefined'">
                <img class="vote-btn" src="/images/icon/chicken_nugget.png" alt="" v-on:click="vote()" v-if="btnType === 'vote' && user != 'undefined'">
                <img class="like-btn" src="/images/icon/frenchfry.png" alt="" v-if="btnType === 'like' && user === 'undefined'">
                <img class="vote-btn" src="/images/icon/chicken_nugget.png" alt="" v-if="btnType === 'vote' && user === 'undefined'">
                <button class="delete-btn" v-if="btnType === 'delete'" v-on:click="deleteAnswer()">削除</button>
            </div>
        </div>
    `,    
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

            console.log(this.user);

            if(this.item["answer"].user_id == this.user.id){
                return;
            }

            axios.post("/like",{
                id: this.item["answer"].id,
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

            if(this.item["answer"].user_id == this.user.id){
                return;
            }

            axios.post("/vote",{
                id: this.item["answer"].id,
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
                    id: this.item["answer"].id,
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
})








