<?php

namespace App\Http\Helpers;


use Illuminate\Support\Facades\Config;

/**
 * View Helperとして活用できる静的関数クラス。
 *
 * @package App\Http\Helpers
 */
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
        $result = self::curl_get_contents($url, 120);

        if (isset($result)) {
            $stationXml = simplexml_load_string($result);

            if ($stationXml === false) {
                return self::NO_DATA;
            }
            return (string)$stationXml->station->station_name ?? '';
        } else {
            return self::NO_DATA;
        }
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
        $result = self::curl_get_contents($url, 120);

        if (isset($result)) {
            $lineXml = simplexml_load_string($result);

            if ($lineXml === false) {
                return self::NO_DATA;
            }
            return (string)$lineXml->line->line_name ?? '';
        } else {
            return self::NO_DATA;
        }

    }

    /**
     * 路線コードから路線上の駅データを配列で返す
     * @param $lineCode
     * @return array
     */
    public static function getStationsByLine($lineCode): array
    {
        $url = self::URL_FOR_LINE . $lineCode . self::DATA_TYPE_XML;
        $result = self::curl_get_contents($url, 120);
        $lineXml = simplexml_load_string($result);
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

    /**
     * Google MapのAPIキーを返す
     * @return string
     */
    public static function getGoogleMapKey(): string
    {
        return Config::get('keys.google_map');
    }

    /**
     * CurlでAPIにアクセスする
     * @param $url
     * @param int $timeout
     * @return mixed
     */
    private static function curl_get_contents($url, $timeout = 60)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
