let rule = new Vue({
    el: ".content",
    data: {
        toggleList:[false, false]
    },  
    methods: {
        active: function (n) {
            this.$set(this.toggleList, n, !this.toggleList[n]);
        }  
    }
})