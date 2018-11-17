(function () {
    'use strict';

    var vm = new Vue({
            el: '#mypage',
            data: {
                nowDisp: '',
                displays: {
                    list: 'dispNonList',
                    create: 'dispNonCreate',
                },
                activateArray: {
                    dispNonList: false,
                    dispNonCreate: true,
                }
            },
            watch : {
              nowDisp: function(){
                  localStorage.setItem('nowDisp', JSON.stringify(this.nowDisp));
              }
            },
            mounted: function() {
                this.nowDisp = JSON.parse(localStorage.getItem('nowDisp')) || 'dispNonList';
                this.switchDisplay(this.nowDisp);
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
                    this.nowDisp = name;
                    this.activateArray = obj;
                },
            }
        })
    ;
})();