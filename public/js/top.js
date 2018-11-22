(function () {
    'use strict';

    var vm = new Vue({
        el: '#vue-contents',
        data: {
            visibleContent: 0,
            contents: [
                {
                    title: 'タイトル1',
                    imgUrl: 'storage/images/8r73r65K4E6p7Q1tlLFq84TprFbgwZasBgcCcasp.jpeg',
                },
                {
                    title: 'タイトル2',
                    imgUrl: 'storage/images/o8tLXs3hbpG7fTaC8Obqtbra8tGcIVyjv2BI1nu8.png',
                },
                {
                    title: 'タイトル3',
                    imgUrl: 'storage/images/Yvx8GeIGCjhUVDbaZsdIZwAkqFixnm3egRDqc71B.jpeg',
                },
            ]
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
            showPrevImg: function () {
                if (this.visibleContent === 0) {
                    this.visibleContent = this.contents.length - 1;
                } else {
                    this.visibleContent--;
                }
            },
            showNextImg: function () {
                if (this.contents.length - 1 === this.visibleContent) {
                    this.visibleContent = 0;
                } else {
                    this.visibleContent++;
                }
            }
        }
    });
})();