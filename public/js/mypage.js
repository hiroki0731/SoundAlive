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
                showSelectBox: function () {
                    alert('アイエエエエエ！？');
                    this.hideSelectBox = !this.hideSelectBox;
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


// 下記、駅データjpのAPIを用いるためのScript

var xml = {};

/**
 *
 * @param isLine　変更が沿線である場合true, それ以外はfalse
 * @param code
 */
function setMenuItem(isLine, code) {
    let initLineMessage = "路線を選択";
    let initStationMessage = "駅を選択";
    let s = document.getElementsByTagName("head")[0].appendChild(document.createElement("script"));
    s.type = "text/javascript";
    s.charset = "utf-8";

    let optionIndex0 = document.concertForm.line.options.length;	//沿線のOPTION数取得
    let optionIndex1 = document.concertForm.station.options.length;	//駅のOPTION数取得

    if (isLine === false) {
        for (i = 0; i <= optionIndex0; i++) {
            document.concertForm.line.options[0] = null
        }	//沿線削除
        for (i = 0; i <= optionIndex1; i++) {
            document.concertForm.station.options[0] = null
        }	//駅削除
        document.concertForm.station.options[0] = new Option(initStationMessage, 0);	//駅OPTIONを空に
        if (code == 0) {
            document.concertForm.line.options[0] = new Option(initLineMessage, 0);	//沿線OPTIONを空に
        } else {
            s.src = "http://www.ekidata.jp/api/p/" + code + ".json";	//沿線JSONデータURL
        }
    } else {
        for (i = 0; i <= optionIndex1; i++) {
            document.concertForm.station.options[0] = null
        }	//駅削除
        if (code == 0) {
            document.concertForm.station.options[0] = new Option(initStationMessage, 0);	//駅OPTIONを空に
        } else {
            s.src = "http://www.ekidata.jp/api/l/" + code + ".json";	//駅JSONデータURL
        }
    }
    xml.onload = function (data) {
        var line = data["line"];
        var station_l = data["station_l"];
        if (line != null) {
            document.concertForm.line.options[0] = new Option(initLineMessage, 0);	//OPTION1番目はNull
            for (i = 0; i < line.length; i++) {
                ii = i + 1	//OPTIONは2番目から表示
                var op_line_name = line[i].line_name;
                var op_line_cd = line[i].line_cd;
                document.concertForm.line.options[ii] = new Option(op_line_name, op_line_cd);
            }
        }
        if (station_l != null) {
            document.concertForm.station.options[0] = new Option(initStationMessage, 0);	//OPTION1番目はNull
            for (i = 0; i < station_l.length; i++) {
                ii = i + 1	//OPTIONは2番目から表示
                var op_station_name = station_l[i].station_name;
                var op_station_cd = station_l[i].station_cd;
                document.concertForm.station.options[ii] = new Option(op_station_name, op_station_cd);
            }
        }
    }
}

function setPulldown(pref) {
    var pulldown_option_pref = document.getElementById('pref').getElementsByTagName('option');

    for (let i = 0; i < pulldown_option_pref.length; i++) {
        if (pulldown_option_pref[i].value == pref) {
            pulldown_option_pref[i].selected = true;
            setMenuItem(false, pref);
            break;
        }
    }
}
