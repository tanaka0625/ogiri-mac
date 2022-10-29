<template>
    <div class="user-info">

        <div class="avators">
            <img v-for="num in createArray()" :key="num" class="avator" :src="'/images/' + user.avator + '/' + user.avator + '(150).png'" alt="">
            <img :src="'/images/' + user.avator + '/' + user.avator + '(' + avatorNumber +').png'" alt="" class="avator">
        </div>

        <p>体重: {{point["total"]}}kg</p>
        <table>
            <tr>
                <td><img src='/images/icon/frenchfry.png' alt=""></td>
                <td>{{point["answerLike"]}}kg</td>
            </tr>

            <tr>
                <td><img src="/images/icon/chicken_nugget.png" alt=""></td>
                <td>{{point["vote"]}}kg</td>
            </tr>

            <tr>
                <td><img src="/images/icon/shake.png" alt=""></td>
                <td>{{point["battleVote"]}}kg</td>
            </tr>

            <tr>
                <td><img src="/images/icon/cola.png" alt=""></td>
                <td>{{point["questionLike"]}}kg</td>
            </tr>

            <tr>
                <td><img src="/images/icon/hamburger.png" alt=""></td>
                <td>{{point["won"]}}kg</td>
            </tr>

            <tr>
                <td>所持金</td>
                <td>{{user.energy}}円</td>
            </tr>
        </table>


        <div id="comment">
            <p>{{user.comment}}</p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        user: {
            type: Object,
            required: true
        },
        point: {
            type: Object,
            required: true
        },
        avatorNumber: {
            type: Number
        }

    },
    data: function () {
        return {
            avatorCnt: parseInt(this.point["total"] / 300),
        }

    },
    methods: {
        createArray: function () {
            let array = [];
            for(let i=0; i<this.avatorCnt; i++){
                array.push(i);
            }

            return array;
        }
    }

}
</script>

<style scoped>
    .user-info {
        position: relative;
    }

    #comment {
        position: absolute;
        top: 0;
        right: 0;
        width: 30%;
        word-break: break-all;
    }

    .avator {
        width: 100%;
    }

    img {
        width: 30px;
    }
</style>