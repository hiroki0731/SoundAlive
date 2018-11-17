(function () {
    'use strict';

    var vm = new Vue({
            el: '#vue-contents',
            data: {
            },
            methods: {
                moveToTop: function() {
                    window.location.href = '/';
                },
                moveToDetail: function (id) {
                    window.location.href = '/detail?id=' + id;
                },
                moveToRegister: function() {
                    window.location.href = '/register';
                },
                moveToSearch: function() {
                    window.location.href = '/search';
                },
            }
        })
    ;
})();