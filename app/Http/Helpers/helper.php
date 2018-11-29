<?php

namespace App\Http\Helpers;


use Illuminate\Support\Facades\Config;

class Helper
{
    const URL_FOR_LINE = 'http://www.ekidata.jp/api/l/';
    const URL_FOR_STATION = 'http://www.ekidata.jp/api/s/';
    const DATA_TYPE_XML = '.xml';
    const NO_DATA = 'unknown';

    /**
     * 駅コードを渡すと駅名を返す。
     * @param $stationCode
     * @return string
     */
    public static function getStationName($stationCode): string
    {
        if (empty($stationCode) || !is_numeric($stationCode)) {
            return self::NO_DATA;
        }

        $url = self::URL_FOR_STATION . $stationCode . self::DATA_TYPE_XML;

        $stationXml = simplexml_load_file($url);

        if ($stationXml === false) {
            return self::NO_DATA;
        }

        return (string)$stationXml->station->station_name ?? '';
    }

    /**
     * 路線コードを渡すと路線名を返す。
     * @param $lineCode
     * @return string
     */
    public static function getLineName($lineCode): string
    {
        if (empty($lineCode) || !is_numeric($lineCode)) {
            return self::NO_DATA;
        }

        $url = self::URL_FOR_LINE . $lineCode . self::DATA_TYPE_XML;

        $lineXml = simplexml_load_file($url);

        if ($lineXml === false) {
            return self::NO_DATA;
        }

        return (string)$lineXml->line->line_name ?? '';
    }

    /**
     * 路線コードから路線上の駅データを配列で返す
     * @param $lineCode
     * @return array
     */
    public static function getStationsByLine($lineCode): array
    {
        $url = self::URL_FOR_LINE . $lineCode . self::DATA_TYPE_XML;
        $lineXml = simplexml_load_file($url);
        $lineArray = get_object_vars($lineXml);
        return $lineArray['station'];
    }

    /**
     * 都道府県のデータを連想配列で返す。
     * @return array
     */
    public static function getPref(): array
    {
        return Config::get('const.prefecture') ?? array();
    }

    /**
     * 音楽ジャンルのデータを連想配列で返す
     * @return array
     */
    public static function getMusicType(): array
    {
        return Config::get('const.music_type') ?? array();
    }

    /**
     * 都道府県codeから都道府県名を返す
     * @param $code
     * @return string
     */
    public static function getPrefName($code): string
    {
        $prefectures = Config::get('const.prefecture') ?? array();

        return $prefectures[$code] ?? self::NO_DATA;
    }

    /**
     * 音楽ジャンルのcodeからジャンル名を返す
     * @param $code
     * @return string
     */
    public static function getMusicTypeName($code): string
    {
        $musicTypes = Config::get('const.music_type') ?? array();

        return $musicTypes[$code] ?? self::NO_DATA;
    }

}
