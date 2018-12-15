(function () {
    'use strict';

    var vm = new Vue({
        el: '#top',
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
            window.addEventListener('resize', this.handleResize);
            this.setSlideShow();
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
            moveToAbout: function () {
                window.location.href = '/about';
            },
            changeSlide: function (isNext) {
                if (isNext) {
                    let limitWidth = this.parentWidth - this.slideWidth;
                    if (this.nowWidth >= limitWidth) {
                        return;
                    }
                    this.nowWidth += this.slideWidth;
                } else {
                    if (this.nowWidth <= 0) {
                        return;
                    }
                    this.nowWidth -= this.slideWidth;
                }
                let pageWidthStr = this.nowWidth.toString() + "px";
                this.parentSlider.transform = "translateX(-" + pageWidthStr + ")";
                console.log("pageWidth:" + this.parentSlider.transform);
            },
            handleResize: function () {
                this.setSlideShow();
            },
            setSlideShow: function () {
                if (this.$refs.slideNum != null) {
                    this.slideCount = this.$refs.slideNum.innerHTML;
                    //画面幅を取得
                    this.slideWidth = window.innerWidth;
                    //画面幅×スライド数をセット
                    this.parentWidth = (window.innerWidth * this.slideCount);
                    //画面幅をcssにセット
                    this.parentSlider.width = this.parentWidth.toString() + "px";
                    //100% / スライドの数の割り当て
                    this.childSlider.width = (100 / this.slideCount).toString() + "%";
                }
            },
        },
        beforeDestroy: function () {
            window.removeEventListener('resize', this.handleResize);
        }
    });
})();