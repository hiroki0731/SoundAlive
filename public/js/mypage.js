(function () {
    'use strict';

    var vm = new Vue({
            el: '#mypage',
            data: {
                nowDisp: '',
                hideSelectBox: true,
                popupOpacity: {
                    "opacity": "",
                    "pointer-events": ""
                },
                displays: {
                    list: 'dispNonList',
                    create: 'dispNonCreate',
                    change: 'dispNonChange',
                },
                //falseで表示、trueで非表示
                dispNonArray: {
                    dispNonList: false,
                    dispNonCreate: true,
                    dispNonChange: true,
                },
                uploadedImage: '',
            },
            watch: {
                nowDisp: function () {
                    sessionStorage.setItem('nowDisp', JSON.stringify(this.nowDisp));
                }
            },
            //直前に表示していたページを表示する
            mounted: function () {
                this.nowDisp = JSON.parse(sessionStorage.getItem('nowDisp')) || 'dispNonList';
                this.switchDisplay(this.nowDisp);
            },
            methods: {
                //ページの切り替え
                switchDisplay: function (name) {
                    let obj = this.dispNonArray;
                    Object.keys(obj).forEach(function (key) {
                        if (key === name) {
                            obj[key] = false;
                        } else {
                            obj[key] = true;
                        }
                    });
                    this.nowDisp = name;
                    this.dispNonArray = obj;
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
                popupToggle: function() {
                    sessionStorage.setItem('prefVal', JSON.stringify(document.getElementById('pref').value));
                    sessionStorage.setItem('lineVal', JSON.stringify(document.getElementById('line').value));
                    sessionStorage.setItem('stationVal', JSON.stringify(document.getElementById('station').value));
                    this.popupOpacity.opacity = '1';
                    this.popupOpacity["pointer-events"] = 'auto';
                },
                closePopup: function() {
                    this.popupOpacity.opacity = '0';
                    this.popupOpacity["pointer-events"] = 'none';
                }
            }
        })
    ;
})();