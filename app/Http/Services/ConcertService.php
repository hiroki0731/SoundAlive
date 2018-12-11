<?php
declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Contracts\ConcertInterface;
use App\Http\Models\Concert;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Concertモデルのビジネスロジッククラス
 * @package App\Http\Service
 */
class ConcertService implements ConcertInterface
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

    /**
     * コンストラクタ
     * @param Concert $concert
     */
    public function __construct(Concert $concert)
    {
        $this->model = $concert;
    }

    /**
     * @inheritdoc
     * @see ConcertInterface
     *
     * @return Collection|null
     */
    public function getNew(): ?Collection
    {
        return $this->model->getNew();
    }

    /**
     * 管理ユーザIDをキーに取得
     * @param int $userId
     * @return LengthAwarePaginator|null
     */
    public function getByUserId(int $userId): ?LengthAwarePaginator
    {
        return $this->model->getByUserId($userId);
    }

    /**
     * 絞り込み検索結果を取得
     * @param array $conditions
     * @return LengthAwarePaginator
     */
    public function getByCondition($conditions): ?LengthAwarePaginator
    {
        //絞り込み条件の整形
        $conditions = $this->formatCondition($conditions);

        return $this->model->getByCondition($conditions);
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
     * @param int $concertId
     * @return Model|null
     */
    public function findByConcertId(int $concertId): ?Model
    {
        return $this->model->findByConcertId($concertId);
    }

    /**
     * 配列情報を元に登録
     * @param $concertData (array)
     * @return Model
     */
    public function createConcert(array $concertData): Model
    {
        return $this->model->createConcert($concertData);
    }

    /**
     * idで検索して削除
     * @param int $id
     * @return Model
     */
    public function deleteById(int $id): Model
    {
        return $this->model->deleteById($id);
    }

}