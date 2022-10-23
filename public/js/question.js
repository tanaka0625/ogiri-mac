Vue.component('items-question',{
    props: {
        item: {
            type: Object,
            required: true
        },
        likeUsers: {
            type: Object,
            required: true
        }
    },
    data: function() {
        return {
            isActiveLikeUsers: false,
            user: user
        }
    },
    template: `
        <div class='item question' v-bind:class="{'liked-question':isLiked()}">
            <a v-bind:href="'/grouped_answer/' + item['question'].id" class="text"><h3>{{item['question'].text}}</h3></a>

            <p class="info">作:<a v-bind:href="'/user/' + item['question'].user_id">{{item['maker']}}</a> <span class="answer-number">{{item['question'].answer_number}}回答</span> <span class="like" v-on:click="activeLikeUsers()">{{likeUsers['like'].length}}コーラ</span></p>

            <div class='like-users' v-if="isActiveLikeUsers">
                <a v-for="(likeUser, index) in likeUsers['like']" :key="likeUser.id" v-bind:href="'/user/' + likeUser.id" class="likeUser">{{likeUser.name}} </a>
            </div>

            <div class='question-footer'>
                <p v-if="item['situation'] === 'recruting'">回答期限:{{item['question'].limit_answer}}</p>
                <p v-if="item['situation'] === 'voting'">ナゲット期限:{{item['question'].limit_vote}}</p>
                <p v-if="item['situation'] === 'finished' || item['situation'] === 'fast'">{{item['question'].created_at}}</p>
                <img class="like-btn" src="/images/icon/cola.png" alt="" v-on:click='like()' v-if="user != 'undefined'">
                <img class="like-btn" src="/images/icon/cola.png" alt="" v-if="user === 'undefined'">
            </div>
        </div>
    
    
    `,
    methods: {

        isLiked: function(){
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
        like: function(){

            if(this.item["question"].user_id == this.user.id){
                return;
            }

            console.log(this.item['question']);

            axios.post("/like",{
                id: this.item["question"].id,
                itemType: "question"
            })
            .then(function (response) {

                if(!this.likeUsers['like'].some(user => user.id == this.user.id)){
                    this.$emit('add-question-like', this.likeUsers, this.user);
                }else{
                    this.$emit('minus-question-like', this.likeUsers, this.user);
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

})