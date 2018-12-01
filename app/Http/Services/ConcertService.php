<?php

namespace App\Http\Services;

use App\Http\Models\Concert;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Cache;

/**
 * Concertモデルのビジネスロジッククラス
 * @package App\Http\Service
 */
class ConcertService
{
    private $model;

    // detail_infoカラムに登録できる値を設定
    public const CONCERT_TABLE_COLUMNS = [
        'concert_name',
        'band_name',
        'band_member',
        'concert_date',
        'start_time',
        'end_time',
        'concert_money',
        'music_type',
        'place_name',
        'pref',
        'line',
        'station',
        'place_url',
        'place_address',
        'concert_img',
        'concert_introduction',
        'movie_id',
    ];
    // フリーワード検索をさせるカラムを設定
    private const WORD_SEARCH_ARRAY = [
        'band_name',
        'place_name',
    ];
    // トップページに表示するライブ数
    private const NUMBER_OF_CONCERTS_ON_TOP = 10;
    // マイページのページネーション
    private const NUMBER_OF_PAGINATION_ON_MYPAGE = 5;
    // 検索ページのページネーション
    private const NUMBER_OF_PAGINATION_ON_SEARCH = 5;

    /**
     * コンストラクタ
     * @param Concert $concert
     */
    public function __construct(Concert $concert)
    {
        $this->model = $concert;
    }

    /**
     * 新着10件を取得
     * @return mixed
     */
    public function getAll()
    {
        return $this->model->orderBy('created_at', 'desc')->take(self::NUMBER_OF_CONCERTS_ON_TOP)->get();
    }

    /**
     * ユーザIDをキーに取得
     * @param $userId
     * @return mixed
     */
    public function getByUserId($userId)
    {
        return $this->model->where('user_id', $userId)->orderBy('created_at', 'desc')->paginate(self::NUMBER_OF_PAGINATION_ON_MYPAGE);
    }

    /**
     * 絞り込み検索結果を取得
     * @param $conditions
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getByCondition($conditions)
    {
        $conditions = $this->formatCondition($conditions);
        $query = $this->model->query();
        foreach ($conditions as $key => $val) {
            if (empty($val)) {
                continue;
            }

            if (in_array($key, self::WORD_SEARCH_ARRAY)) {
                $query->where("detail_info->$key", 'like', "%$val%");
            } elseif ($key == 'stations') {
                $query->whereIn("detail_info->station", $conditions[$key]);
            } else {
                $query->where("detail_info->$key", '=', $val);
            }
        }
        return $query->orderBy('detail_info->concert_date', 'desc')->paginate(self::NUMBER_OF_PAGINATION_ON_SEARCH);
    }

    /**
     * エリア検索用に条件の配列を整形して返す
     * @param $conditions
     * @return array
     */
    private function formatCondition($conditions = array()): array
    {
        //pref,line,stationの存在確認
        $existPref = array_key_exists('pref', $conditions);
        $existLine = array_key_exists('line', $conditions);
        $existStation = array_key_exists('station', $conditions);

        if ($existPref && !$existStation && !$existLine) { //都道府県のみ指定した場合
            $format_conditions = $conditions;
        } else if ($existLine && !$existStation) { //路線まで指定した場合
            //都道府県と路線を検索条件から外す
            $format_conditions = $conditions;
            unset($format_conditions['pref']);
            unset($format_conditions['line']);

            //路線上にある全ての駅コードを取得して格納
            $stations = \Helper::getStationsByLine($conditions['line']);
            foreach ($stations as $station) {
                $stationCodes[] = (int)$station->station_cd;
            }
            $format_conditions['stations'] = $stationCodes ?? array();
        } else { //駅まで指定した場合
            //prefとlineを検索条件から外す
            unset($conditions['pref']);
            unset($conditions['line']);
            $format_conditions = $conditions;
        }

        return $format_conditions;
    }

    /**
     * コンサートテーブルIDをキーに取得
     * @param $concertId
     * @return mixed
     */
    public function findByConcertId($concertId)
    {
        return $this->model->find($concertId);
    }

    /**
     * 配列情報を元に登録
     * @param $concertData (array)
     * @return mixed
     */
    public function createConcert($concertData)
    {
        return $this->model->create($concertData);
    }

    /**
     * idで検索して削除
     * @param $id
     * @return mixed
     */
    public function deleteById($id)
    {
        return $this->model->find($id)->delete();
    }

}