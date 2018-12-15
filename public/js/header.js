(function () {
    'use strict';

    var vm = new Vue({
        el: '#header',
        data: {
            //モバイルメニューの横幅
            menuWidth: 0,
            //モバイルメニュークリック判定
            menuClicked: false,
            mobileMenu: {
                "right": "",
            },
        },
        mounted: function () {
            this.setMobileMenu();
        },
        methods: {
            setMobileMenu: function(){
                this.menuWidth = document.getElementById('mobile-menu').scrollWidth;
                this.mobileMenu.right = "-" + this.menuWidth + "px";
            },
            toggleMobileMenu: function(){
                this.menuClicked = !this.menuClicked;
                if(this.menuClicked){
                    this.mobileMenu.right = 0 + "px";
                }else{
                    this.mobileMenu.right = "-" + this.menuWidth + "px";
                }
            }
        },
    });
})();