(function () {
    'use strict';

    var vm = new Vue({
            el: '#mypage',
            data: {
                nowDisp: '',
                hideSelectBox: true,
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
            watch: {
                nowDisp: function () {
                    localStorage.setItem('nowDisp', JSON.stringify(this.nowDisp));
                }
            },
            //直前に表示していたページを表示する
            mounted: function () {
                this.nowDisp = JSON.parse(localStorage.getItem('nowDisp')) || 'dispNonList';
                this.switchDisplay(this.nowDisp);
            },
            methods: {
                //ページの切り替え
                switchDisplay: function (name) {
                    let obj = this.activateArray;
                    Object.keys(obj).forEach(function (key) {
                        if (key === name) {
                            obj[key] = false;
                        } else {
                            obj[key] = true;
                        }
                    });
                    this.nowDisp = name;
                    this.activateArray = obj;
                },
                //最寄駅編集ようのセレクトボックスを表示する
                toggleSelectBox: function () {
                    this.hideSelectBox = !this.hideSelectBox;
                    if(this.hideSelectBox){
                        document.getElementById('show-area-button').innerHTML = '変更';
                    } else {
                        document.getElementById('show-area-button').innerHTML = '閉じる';
                    }
                },
                //ライブ編集ページへ遷移
                moveToDetail: function (id) {
                    window.location.href = '/mypage/update/' + id;
                },
                //アップロード画像を表示する
                onFileChange(event) {
                    let files = event.target.files;
                    this.createImage(files[0]);
                },
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