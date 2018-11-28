<?php

namespace App\Http\Services;

use App\Http\Models\Concert;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Cache;

/**
 * Concertモデルのビジネスロジッククラス
 * @package App\Http\Service
 */
class ConcertService extends Model
{
    private $model;

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
    ];

    private const NUMBER_OF_CONCERTS_ON_TOP = 10;
    private const NUMBER_OF_PAGINATION_ON_MYPAGE = 5;

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

    public function getByCondition($conditions)
    {
        $conditions = $this->formatCondition($conditions);
        $query = $this->model->query();
        foreach ($conditions as $key => $val) {
            if (empty($val)) {
                continue;
            }
            if ($key == 'band_name') {
                $query->where("detail_info->$key", 'like', "%$val%");
            } elseif ($key == 'stations') {
                $query->whereIn("detail_info->station", $conditions[$key]);
            } else {
                $query->where("detail_info->$key", '=', $val);
            }
        }
        return $query->get();
    }

    private function formatCondition($conditions)
    {
        // pref,line,stationの存在確認
        $existPref = array_key_exists('pref', $conditions);
        $existLine = array_key_exists('line', $conditions);
        $existStation = array_key_exists('station', $conditions);

        if ($existPref && !$existStation && !$existLine) { //都道府県のみ指定した場合、
            //データ整形処理をしない
            $format_conditions = $conditions;
        } else if ($existLine && !$existStation) { //路線を指定した場合、
            //都道府県と路線を検索条件から外す
            $format_conditions = $conditions;
            unset($format_conditions['pref']);
            unset($format_conditions['line']);

            //路線上にある全ての駅コードを取得して新たな検索キーに格納
            $arrays = \Helper::getStationsByLine($conditions['line']);
            foreach ($arrays as $array) {
                $stations[] = (int)$array->station_cd;
            }
            $format_conditions['stations'] = $stations ?? array();
        } else { //駅指定の場合
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