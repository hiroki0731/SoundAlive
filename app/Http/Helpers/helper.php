<?php

namespace App\Http\Helpers;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

/**
 * View Helperとして活用できる静的関数クラス。
 *
 * @package App\Http\Helpers
 */
class Helper
{
    const URL_FOR_LINE = 'https://www.ekidata.jp/api/l/';
    const URL_FOR_STATION = 'https://www.ekidata.jp/api/s/';
    const DATA_TYPE_XML = '.xml';
    const NO_DATA = 'データなし';
    const CACHE_MINUTES = 1440 * 7; // 1日 * 7 = 1週間
    const CURL_TIMEOUT_SECOND = 120;

    /**
     * 駅コードを渡すと駅名を返す。
     *
     * URLをそのままkeyにして、Cacheに入れる
     * @param $stationCode
     * @return string
     */
    public static function getStationName($stationCode): string
    {
        if (empty($stationCode) || !is_numeric($stationCode)) {
            return self::NO_DATA;
        }
        // APIから駅情報を取得
        $url = self::URL_FOR_STATION . $stationCode . self::DATA_TYPE_XML;
        $result = Cache::remember($url, self::CACHE_MINUTES, function () use ($url) {
            return $result = self::curl_get_contents($url, self::CURL_TIMEOUT_SECOND);
        });
        // API返却値不正の場合の処理
        if (empty($result)) {
            return self::NO_DATA;
        }
        try {
            $stationXml = simplexml_load_string($result);
            if ($stationXml === false) {
                return self::NO_DATA;
            }
        } catch (Exception $e) {
            return self::NO_DATA;
        }

        // 駅名を返却
        return (string)$stationXml->station->station_name ?? '';
    }

    /**
     * 路線コードを渡すと路線名を返す。
     *
     * URLをそのままkeyにして、Cacheに入れる
     * @param $lineCode
     * @return string
     */
    public static function getLineName($lineCode): string
    {
        if (empty($lineCode) || !is_numeric($lineCode)) {
            return self::NO_DATA;
        }
        // APIから路線情報を取得
        $url = self::URL_FOR_LINE . $lineCode . self::DATA_TYPE_XML;
        $result = Cache::remember($url, self::CACHE_MINUTES, function () use ($url) {
            return $result = self::curl_get_contents($url, self::CURL_TIMEOUT_SECOND);
        });
        // API返却値不正の場合の処理
        if (empty($result)) {
            return self::NO_DATA;
        }
        try {
            $lineXml = simplexml_load_string($result);
            if ($lineXml === false) {
                return self::NO_DATA;
            }
        } catch (Exception $e) {
            return self::NO_DATA;
        }

        // 路線名を返却
        return (string)$lineXml->line->line_name ?? '';
    }

    /**
     * 路線コードから路線上の駅データを配列で返す
     * @param $lineCode
     * @return array
     */
    public static function getStationsByLine($lineCode): array
    {
        if (empty($lineCode) || !is_numeric($lineCode)) {
            return [];
        }
        // APIから路線情報を取得
        $url = self::URL_FOR_LINE . $lineCode . self::DATA_TYPE_XML;
        $result = Cache::remember($url, self::CACHE_MINUTES, function () use ($url) {
            return $result = self::curl_get_contents($url, self::CURL_TIMEOUT_SECOND);
        });

        // API返却値不正の場合の処理
        if (empty($result)) {
            return [];
        }
        try {
            $lineXml = simplexml_load_string($result);
            if ($lineXml === false) {
                return [];
            }
        } catch (Exception $e) {
            return [];
        }

        // XMLを配列にパースして駅一覧を返却
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

    /**
     * コンサート日付をY年m月d日(D)に整形して返却する
     * @param $concertDate
     * @return string
     */
    public static function formatConcertDate($concertDate): string
    {
        if (empty($concertDate)) {
            return $concertDate;
        }
        $weekNumber = date('w', strtotime($concertDate));
        $weekArray = Config::get('const.week');
        $concertDate = date('Y年m月d日', strtotime($concertDate));

        return $concertDate . "(" . $weekArray[$weekNumber] . ")";
    }
}
