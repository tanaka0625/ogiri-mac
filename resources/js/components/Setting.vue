<template>
    <div>
        <div class="form">
            <p>コメントを変更する</p>
            <form action="/setting/changeComment" method="post" class="form">
                <input type="hidden" name="_token" :value="csrf">
                <textarea name="comment" id="" cols="30" rows="10" v-model="user.comment"></textarea>
                <input type="submit" value="変更">
            </form>
        </div>

        <div class="avators">
            <p>アバター変更</p>
            <div class="avator" v-for="avator in avators" :key="avator">
                <p class="msg" v-if="myUser.avator === avator">選択中です</p>
                <img v-bind:src="'/images/' + avator + '/' + avator + '(75).png'" alt="">
                <button class="choice-btn" v-on:click="select(avator)">選択</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        avators: {
            type: Array,
            required: true
        },
        myUser: {
            required: true
        }
    },
    data: function () {
        return {
            variableUser: this.myUser,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    methods: {
        select: function(avator){

            axios.post("/avator",{
                id: this.myUser.id,
                avator: avator
            })
            .then(function (response) {

                this.myUser.avator = avator;

            }.bind(this))
            .catch(function (error){
            })


        }
    }
}
</script>

<style scoped>
    .avator {
        border: solid 5px;
        margin-bottom: 5px;
    }

    .avator img {
        width: 100%;
    }

    .form {
        margin-bottom: 15px;
    }
</style>