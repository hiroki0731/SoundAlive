(function () {
    'use strict';

    var vm = new Vue({
            el: '#search',
            methods: {
                //ライブ詳細ページへ遷移
                moveToDetail: function (id) {
                    window.location.href = '/detail/' + id;
                },
            }
        })
    ;
})();