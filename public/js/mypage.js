(function () {
    'use strict';

    var vm = new Vue({
            el: '#mypage',
            data: {
                displays: {
                    list: 'dispNonList',
                    create: 'dispNonCreate',
                },
                activateArray: {
                    dispNonList: false,
                    dispNonCreate: true,
                }
            },
            methods: {
                switchDisplay: function (name) {
                    var obj = this.activateArray;
                    Object.keys(obj).forEach(function (key) {
                        if (key === name){
                            obj[key] = false;
                        }else{
                            obj[key] = true;
                        }
                    });
                    this.activateArray = obj;
                },
            }
        })
    ;
})();