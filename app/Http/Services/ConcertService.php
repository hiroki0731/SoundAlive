<?php

namespace App\Http\Services;

use App\Http\Models\Concert;
/**
 * Concertモデルのビジネスロジッククラス
 * @package App\Http\Service
 */
class ConcertService
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

    /**
     * ConcertモデルのDI
     * @param Concert $concert
     */
    public function __construct(Concert $concert)
    {
        $this->model = $concert;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function getByUserId($userId)
    {
        return $this->model->where('user_id', $userId)->get();
    }

    /**
     * @param $concertData(array)
     * @return mixed
     */
    public function createConcert($concertData)
    {
        return $this->model->create($concertData);
    }
}