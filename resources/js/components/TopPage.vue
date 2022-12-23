<template>
    <div>
        <div class="avator">
            <p class="avator-comment">
                こんなガリガリじゃはずかしいよ…
            </p>
            <img src="/images/avator/avator(1).png" alt="">
        </div>

        <p>大喜利をいっぱいして、デブにしてあげよう！</p>

        <div class="imgs align-items-center">
            <img src="/images/icon/hamburger.png" alt="">
            <img src="/images/icon/chicken_nugget.png" alt="">
            <img src="/images/icon/frenchfry.png" alt="">
            <img src="/images/icon/cola.png" alt="">
            <img src="/images/icon/shake.png" alt="">
            <img src="/images/icon/hamburger.png" alt="">
            <img src="/images/icon/chicken_nugget.png" alt="">
            <img src="/images/icon/frenchfry.png" alt="">
            <img src="/images/icon/cola.png" alt="">
            <img src="/images/icon/shake.png" alt="">
        </div>


        <div class="avator">
            <p class="avator-comment">
                ありがと
            </p>
            <img src="/images/avator/avator(150).png" alt="">
        </div>
    </div>
</template>

<script>
export default {
    
}
</script>

<style scoped>
    .avator img {
        width: 100%;
    }

    .imgs {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .imgs img {
        width: 30px;
    }

    .avator {
        position: relative;
    }

    .avator-comment {
        position: absolute;
        top: 0;
        right: 0;
        width: 30%;
    }
</style>