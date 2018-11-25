(function () {
    'use strict';

    var vm = new Vue({
        el: '#vue-contents',
        data: {
            //スライドの数
            slideCount: 0,
            //スライドの画面幅
            slideWidth: 0,
            //スライドショー全体の幅
            parentWidth: 0,
            //現在のスライド位置
            nowWidth: 0,
            parentSlider: {
                "width": "",
                "transform": "",
            },
            childSlider: {
                "width": "",
            },
        },
        mounted: function () {
            this.slideCount = this.$refs.slideNum.innerHTML;
            //画面幅を取得
            this.slideWidth = window.innerWidth;
            //画面幅×スライド数をセット
            this.parentWidth = (window.innerWidth * this.slideCount);
            //画面幅をcssにセット
            this.parentSlider.width = this.parentWidth.toString() + "px";
            // console.log("parentSlider:" + (window.innerWidth * this.slideCount).toString()); TODO:削除
            //100% / スライドの数の割り当て
            this.childSlider.width = (100 / this.slideCount).toString() + "%";
            // console.log("childSlider:" + this.childSlider.width); TODO:削除
        },
        methods: {
            moveToDetail: function (id) {
                window.location.href = '/detail/' + id;
            },
            moveToRegister: function () {
                window.location.href = '/register';
            },
            moveToSearch: function () {
                window.location.href = '/search';
            },
            changeSlide: function (isNext) {
                if(isNext){
                    let limitWidth = this.parentWidth - this.slideWidth;
                    if(this.nowWidth >= limitWidth){
                        return;
                    }
                    this.nowWidth += this.slideWidth;
                }else{
                    if(this.nowWidth <= 0){
                        return;
                    }
                    this.nowWidth -= this.slideWidth;
                }
                let pageWidthStr = this.nowWidth.toString() + "px";
                this.parentSlider.transform = "translateX(-" + pageWidthStr + ")";
                console.log("pageWidth:" + this.parentSlider.transform);
            },
        }
    });
})();