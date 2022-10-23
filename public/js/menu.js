new Vue({
    el: ".header",
    data: {
        isActive: false
    },  
    methods: {
        active: function () {
            this.isActive = !this.isActive;
        }  
    }
})


