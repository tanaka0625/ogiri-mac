<template>
    
    <div class="header">
        <div id="title">
            <h3>{{title}}</h3>
        </div>


        <button class="menu-btn" v-if="isActive" v-on:click="active()">メニュー</button>

        <div class="menu" v-if="!isActive">
            <p class="link-btn"><a href="/" >トップ</a></p>
            <p class="link-btn"><a href="/answer_list" >回答一覧</a></p>
            <p class="link-btn"><a href="/question_list" >お題一覧</a></p>
            <p class="link-btn"><a href="/search" >検索</a></p>
            <p class="link-btn"><a href="/question_list?situation=recruting">回答する</a></p>
            <p class="link-btn"><a href="/question_list?situation=voting">ナゲット</a></p>
            <p class="link-btn" v-if="myUser != null"><a href="/my_page">マイページ</a></p>
            <p class="link-btn" v-if="myUser != null"><a href="/notice">通知</a></p>
            <p class="link-btn" v-if="myUser === null"><a href="/login">ログイン</a></p>
            <p class="link-btn"><a href="/ranking">ランキング</a></p>
            <p class="link-btn"><a href="/rule">ルール</a></p>
            
            <p class="close" v-on:click="active()">閉じる</p>
        </div>

        <p id="logged-in-user-cnt">10分以内にログインしたユーザー:{{loggedInUserCnt}}人</p>

    </div>

</template>

<script>
export default {
    props: {
        title: {
            type: String,
            required: true
        },
        myUser: {
            required: true
        }

    },
    data: function() {
        return {
            isActive: true,
            loggedInUserCnt: '',
        }
    },
    mounted: function() {

        axios.post("/countLoginedUser",{

        })
        .then(function (response) {
            this.loggedInUserCnt = response.data.loginedUserCnt;

        }.bind(this))
        .catch(function (error){
        })
    },
    methods: {
        active: function () {

            this.isActive = !this.isActive;
        },
    }
}
</script>

<style scoped>
    .menu {
        position: absolute;
        top: 0;
        right: 0;
        z-index: 2;
        color: white;
        background-color: black;
    }
    .menu a {
        color: white;
    }

    .menu-btn {
        position: absolute;
        top: 0;
        right: 0;
        z-index: 2;
        background-color: black;
        color: white;
        height: 40px;
        padding: 0;
        margin: 0;

    }

    .header {
        position: fixed;
        left: 50%;
        top: 0;
        transform: translate(-50%);
        margin: auto;
        background-color:yellow;
        z-index: 4;
        width: 100%;
    }

    #title {
        width: 84%;
        z-index: 1;
        margin: 0;
    }

    #title h3 {
        margin: 0;
        word-break: break-all;
    }

    /* デザインB（タブレット） */
    @media screen and (min-width: 600px) {

        .header {
            width: 375px;
            margin: 0 auto;
        }
    }


    /* デザインC(PC) */
    @media screen and (min-width: 1025px) {

        .header {
            width: 375px;
            margin: 0 auto;
        }
    }
</style>