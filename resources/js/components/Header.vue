<template>
    <div class="header">
        <div id="title">
            <h3>{{title}}</h3>
        </div>
        <div class="menu dropdown">
            <button class="btn btn-dark dropdown-toggle"  id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                メニュー
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <li><a class="dropdown-item link-primary" href="/">トップ</a></li>
                <li><a class="dropdown-item link-primary" href="/answer_list">回答一覧</a></li>
                <li><a class="dropdown-item link-primary" href="/question_list">お題一覧</a></li>
                <li><a class="dropdown-item link-primary" href="/search">検索</a></li>
                <li><a class="dropdown-item link-primary" href="/question_list?situation=recruting">回答する</a></li>
                <li><a class="dropdown-item link-primary" href="/question_list?situation=voting">ナゲット</a></li>
                <li><a class="dropdown-item link-primary" href="/battle">ファスト</a></li>
                <li v-if="myUser != null"><a class="dropdown-item link-primary" href="/my_page">マイページ</a></li>
                <li v-if="myUser != null"><a class="dropdown-item link-primary" href="/notice">通知</a></li>
                <li v-if="myUser === null"><a class="dropdown-item link-primary" href="/login">ログイン</a></li>
                <li><a class="dropdown-item link-primary" href="/ranking">ランキング</a></li>
                <li><a class="dropdown-item link-primary" href="/rule">ルール</a></li>
            </ul>
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
    }
}
</script>

<style scoped>
    .menu {
        position: absolute;
        top: 0;
        right: 0;
        z-index: 2;
    }

    .header {
        position: fixed;
        left: 50%;
        top: 0;
        transform: translate(-50%);
        margin: auto;
        background-color:yellow;
        z-index: 1;
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