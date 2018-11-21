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
                },
                uploadedImage: '',
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
                    let obj = this.activateArray;
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
                moveToDetail: function (id) {
                    window.location.href = '/mypage/update/' + id;
                },

                onFileChange(event) {
                    let files = event.target.files;
                    this.createImage(files[0]);
                },
                // アップロードした画像を表示
                createImage(file) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.uploadedImage = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },
            }
        })
    ;
})();