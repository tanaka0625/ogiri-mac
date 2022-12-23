<template>

    <div>


        <button class="rule-btn btn btn-dark" v-on:click="activeRule()">ルール</button>
        <p class="rule-msg" v-if="isActiveRule">
            回答時間2分→シェイク時間20秒で1位の回答を決めます。<br>
            1位になった人が次のお題を投稿します。1位になった人が60秒以内にお題を投稿しなかった場合お題を募集します。<br>
            回答は制限時間内なら何答でも出来ます。<br>
            時間内に3答以上回答が集まらない場合、もう一度2分間の回答時間となります。<br>
            シェイクが同数の場合、先に投稿された回答の勝利となります。
            <span v-on:click="activeRule()" class="rule-btn" style="color: blue">閉じる</span>
        </p>


        <h2>{{title}}</h2>
        <p id="timer" v-if="situation != 'recrutingQuestion'">残り{{timer}}秒</p>


        <div id="question-form" v-if="situation === 'watingQuestion' && winnerId === myUser.id">
            <form action=/battle/addQuestion  method="post">
                <label for="text">お題</label>
                <textarea name="text" id="text" cols="30" rows="10"></textarea>
                <br>
                <button type="submit" class="btn btn-dark">送信</button>
                <input type="hidden" name="kind" value=1>
                <input type="hidden" name="_token" :value="csrf">
            </form>
        </div>


        <div id="question-form" v-if="situation === 'recrutingQuestion'">
            <form action=/battle/addQuestion  method="post">
                <label for="text">お題</label>
                <textarea name="text" id="text" cols="30" rows="10"></textarea>
                <br>
                <button type="submit" class="btn btn-dark">送信</button>
                <input type="hidden" name="kind" value=1>
                <input type="hidden" name="_token" :value="csrf">

            </form>
        </div>



        <h1 v-if="situation === 'watingQuestion' || situation === 'recrutingQuestion'">前回の結果</h1>
        <h2>お題</h2>
        <ItemsList :items="question" :like-users-list="questionLikeUsers" :my-user="myUser" answer-btn-type="like"></ItemsList>


        <div id="answer-form" v-if="situation === 'recrutingAnswer'">
            <form action=/battle/addAnswer method="post">
                <label for="text">回答</label>
                <textarea name="text" id="text" cols="30" rows="10"></textarea>
                <input type="hidden" name='kind' value=2>
                <input type="hidden" name="_token" :value="csrf">
                <br>
                <button type="submit" class="btn btn-dark">送信</button>
            </form>
        </div>

        <div id="items-container" v-if="situation != 'recrutingAnswer'">
            <ItemsList v-if="situation === 'voting' || situation === 'recrutingQuestion' || situation === 'watingQuestion'" :items="items" :like-users-list="likeUsersList" :my-user="myUser" :answer-btn-type="answerBtnType"></ItemsList>
        </div>

        <div v-if="situation === 'recrutingAnswer'">
            <h1>前回の結果</h1>

            <ItemsList :items="previousItems" :like-users-list="previousLikeUsersList" :my-user="myUser" answer-btn-type="like"></ItemsList>
            
        </div>


    </div>
    

</template>

<script>
import ItemsList from './ItemsList.vue';
export default {
    components: {ItemsList},
    props: {
 
        myUser: {
            required: true
        }
    },
    created () {
        setInterval(function(){
            axios.post("/battle",{
                id: 1,
            })
            .then(function (response) {

                this.question.splice(0);
                this.questionLikeUsers.splice(0);

                this.items.splice(0);
                this.likeUsersList.splice(0);

                this.previousItems.splice(0);
                this.previousLikeUsersList.splice(0);

                if(response.data.situation === "recrutingQuestion") {

                    this.situation = response.data.situation;

                    for(let i=0; i<response.data.items.length; i++) {
                        this.$set(this.items, i, response.data.items[i]);
                        this.$set(this.likeUsersList, i, response.data.likeUsersList[i]);
                    }

                    this.$set(this.questionLikeUsers, 0, response.data.questionLikeUsers[0]);
                    this.$set(this.question, 0, response.data.question[0]);

                    this.title = "お題募集中";
                    this.answerBtnType = "like";

                }else if(response.data.situation === "recrutingAnswer") {

                    this.situation = response.data.situation;
                    this.timer = response.data.limit_answer - response.data.now;

                    this.question.push(response.data.question[0]);
                    this.questionLikeUsers.push(response.data.questionLikeUsers[0]);

                    for(let i=0; i<response.data.previousItems.length; i++) {
                        this.$set(this.previousItems, i, response.data.previousItems[i]);
                        this.$set(this.previousLikeUsersList, i, response.data.previousLikeUsersList[i]);
                    }

                    this.title = "回答受付中";
                    this.answerBtnType = "like";

                }else if(response.data.situation === "voting") {

                    this.situation = response.data.situation;

                    for(let i=0; i<response.data.items.length; i++) {
                        this.$set(this.items, i, response.data.items[i]);
                        this.$set(this.likeUsersList, i, response.data.likeUsersList[i]);
                    }

                    this.$set(this.questionLikeUsers, 0, response.data.questionLikeUsers[0]);
                    this.$set(this.question, 0, response.data.question[0]);

                    this.timer = response.data.limit_vote - response.data.now;
                    this.title = "投票中";
                    this.answerBtnType = "fast";

                }else if(response.data.situation === "watingQuestion") {

                    this.situation = response.data.situation;

                    for(let i=0; i<response.data.items.length; i++) {
                        this.$set(this.items, i, response.data.items[i]);
                        this.$set(this.likeUsersList, i, response.data.likeUsersList[i]);
                    }

                    this.$set(this.questionLikeUsers, 0, response.data.questionLikeUsers[0]);
                    this.$set(this.question, 0, response.data.question[0]);

                    this.timer = response.data.limit_question - response.data.now;
                    this.title = "お題待機時間";
                    this.answerBtnType = "like";
                    this.winnerId = response.data.winner.id;

                }
                
            }.bind(this))
            .catch(function (error){
            })
        }.bind(this), 1000)
    },
    data: function() {
        return {
            items: [],
            likeUsersList: [],
            question: [],
            questionLikeUsers: [],
            situation: 0,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            timer: 0,
            title: 0,
            answerBtnType: 0,
            winnerId: 0,
            previousItems: [],
            previousLikeUsersList: [],
            isActiveRule: false
        }
    },
    methods: {
        activeRule: function () {
            this.isActiveRule = !this.isActiveRule;
        }
    }
}
</script>