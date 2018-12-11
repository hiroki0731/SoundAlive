<?php

namespace App\Http\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * コンサート情報取得のインターフェイス
 *
 * ServiceとModelにimplementさせる
 * Interface ConcertInterface
 */
interface ConcertInterface
{
    /**
     * 新着ライブを取得して返す
     *
     * @return Collection|null
     */
    public function getNew(): ?Collection;

    /**
     * 管理ユーザidからライブを取得
     *
     * @param int $userId
     * @return LengthAwarePaginator|null
     */
    public function getByUserId(int $userId): ?LengthAwarePaginator;

    /**
     * 絞り込み検索結果を取得
     * @param  $conditions
     * @return LengthAwarePaginator|null
     */
    public function getByCondition($conditions): ?LengthAwarePaginator;

    /**
     * コンサートテーブルIDからライブを取得
     * @param int $concertId
     * @return Model|null
     */
    public function findByConcertId(int $concertId): ?Model;

    /**
     * 配列情報を元に登録
     * @param array $concertData
     * @return Model
     */
    public function createConcert(array $concertData): Model;

    /**
     * idで検索して削除
     * @param int $id
     * @return Model
     */
    public function deleteById(int $id): Model;
}