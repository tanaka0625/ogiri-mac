<template>
    <div class="item notice answer-like-notice" v-if="item['item_type'] === 'answer_like'">
        <img src="/images/icon/frenchfry.png" alt="">
        <div class="text-container">
            <p><a v-bind:href="'user/' + item['user'].id">{{item['user'].name}}</a> がポテトしました</p>
            <a v-bind:href="'grouped_answer/' + item['question_id']" class="text">{{item['answer_text']}}</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            item: {
                type: Object,
                required: true
            }
        },
        data: function() {
            return {

            }
        },
        methods: {
        }
    }
</script>

<style scoped>
    .notice {
        border: solid gray 10px;
        margin-bottom: 4px;
        word-break: break-all;
        position: relative;

    }

    .notice p {
        margin: 0;
    }

    .text {
        color: black;
    }

    .notice img {
        width: 10%;
        position: absolute;
        left: 0;
        top: 50%;
        transform: translate(0, -50%);
    }

    .text-container {
        margin-left: 10%;
    }
</style>