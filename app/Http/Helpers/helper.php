<?php

namespace App\Http\Helpers;


use Illuminate\Support\Facades\Config;

class Helper
{
    const URL_FOR_LINE = 'http://www.ekidata.jp/api/l/';
    const URL_FOR_STATION = 'http://www.ekidata.jp/api/s/';
    const DATA_TYPE_XML = '.xml';

    /**
     * 駅コードを渡すと駅名を返す。
     * @param $stationCode
     * @return string
     */
    public static function getStationName($stationCode):string
    {
        if(empty($stationCode) || !is_numeric($stationCode)){
            return 'NoData';
        }

        $url = self::URL_FOR_STATION . $stationCode . self::DATA_TYPE_XML;

        $stationXml = simplexml_load_file($url);

        if($stationXml === false){
            return 'NoData';
        }

        return (string)$stationXml->station->station_name ?? '';
    }

    /**
     * 駅コードを渡すと路線名を返す。
     * @param $stationCode
     * @return string
     */
    public static function getStationLine($stationCode):string
    {
        if(empty($stationCode) || !is_numeric($stationCode)){
            return 'NoData';
        }

        $url = self::URL_FOR_STATION . $stationCode . self::DATA_TYPE_XML;

        $stationXml = simplexml_load_file($url);

        if($stationXml === false){
            return 'NoData';
        }

        return (string)$stationXml->station->line_name ?? '';
    }

    /**
     * 都道府県のデータを連想配列で返す。
     * @return array
     */
    public static function getPref():array
    {
        return Config::get('const.prefecture') ?? array();
    }

    /**
     * 音楽ジャンルのデータを連想配列で返す
     * @return array
     */
    public static function getMusicType():array
    {
        return Config::get('const.music_type') ?? array();
    }

}
