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
      'place_station',
      'place_url',
      'place_address',
      'concert_img',
      'concert_introduction',
    ];

    private const NUMBER_OF_CONCERTS_ON_TOP = 10;
    private const NUMBER_OF_PAGINATION_ON_MYPAGE = 2;

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
     * @param $concertData(array)
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