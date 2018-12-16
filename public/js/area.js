// 下記、駅データjpのAPIを用いるためのScript

var xml = {};

/**
 *
 * @param isLine　変更が沿線である場合true, それ以外はfalse
 * @param code
 */
function setMenuItem(isLine, code) {
    //初期表示メッセージ
    let initLineMessage = "路線を選択";
    let initStationMessage = "駅を選択";
    //路線と駅の要素を取得
    let lineElement = document.getElementById('line');
    let stationElement = document.getElementById('station');
    //head要素下にscriptを新規作成
    let s = document.getElementsByTagName("head")[0].appendChild(document.createElement("script"));
    s.type = "text/javascript";
    s.charset = "utf-8";

    if (isLine === false) {
        for (i = 0; i <= lineElement.options.length; i++) {
            lineElement.options[0] = null
        }	//沿線削除
        for (j = 0; j <= stationElement.options.length; j++) {
            stationElement.options[0] = null
        }	//駅削除
        stationElement.options[0] = new Option(initStationMessage, 0);	//駅OPTIONを空に
        if (code == 0) {
            lineElement.options[0] = new Option(initLineMessage, 0);
        } else {
            s.src = "http://www.ekidata.jp/api/p/" + code + ".json";	//沿線JSONデータURL
        }
    } else {
        for (i = 0; i <= stationElement.options.length; i++) {
            stationElement.options[0] = null
        }	//駅削除
        if (code == 0) {
            stationElement.options[0] = new Option(initStationMessage, 0);	//駅OPTIONを空に
        } else {
            s.src = "http://www.ekidata.jp/api/l/" + code + ".json";	//駅JSONデータURL
        }
    }
    xml.onload = function (data) {
        var line = data["line"];
        var station_l = data["station_l"];
        if (line != null) {
            lineElement.options[0] = new Option(initLineMessage, 0);	//OPTION1番目はNull
            for (i = 0; i < line.length; i++) {
                ii = i + 1	//OPTIONは2番目から表示
                var op_line_name = line[i].line_name;
                var op_line_cd = line[i].line_cd;
                lineElement.options[ii] = new Option(op_line_name, op_line_cd);
            }
        }
        if (station_l != null) {
            stationElement.options[0] = new Option(initStationMessage, 0);	//OPTION1番目はNull
            for (i = 0; i < station_l.length; i++) {
                ii = i + 1	//OPTIONは2番目から表示
                var op_station_name = station_l[i].station_name;
                var op_station_cd = station_l[i].station_cd;
                stationElement.options[ii] = new Option(op_station_name, op_station_cd);
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
