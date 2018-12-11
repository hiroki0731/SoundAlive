<?php

namespace App\Http\Models;

use App\Http\Contracts\ConcertInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\LengthAwarePaginator;

class Concert extends Model implements ConcertInterface
{
    //論理削除有効化
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    //jsonカラムを設定
    protected $casts = [
        'json_column' => 'detail_info'
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
     * @inheritdoc
     * @see ConcertInterface
     *
     * @return Collection|null
     */
    public function getNew(): ?Collection
    {
        return $this->orderBy('created_at', 'desc')->take(self::NUMBER_OF_CONCERTS_ON_TOP)->get();
    }

    /**
     * 管理ユーザIDをキーに取得
     * @param int $userId
     * @return LengthAwarePaginator|null
     */
    public function getByUserId(int $userId): ?LengthAwarePaginator
    {
        return $this->where('user_id', $userId)->orderBy('created_at', 'desc')->paginate(self::NUMBER_OF_PAGINATION_ON_MYPAGE);
    }

    /**
     * 絞り込み検索結果を取得
     * @param array $conditions
     * @return LengthAwarePaginator
     */
    public function getByCondition($conditions): ?LengthAwarePaginator
    {
        $query = $this->query();
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
     * コンサートテーブルIDをキーに取得
     * @param int $concertId
     * @return Model|null
     */
    public function findByConcertId(int $concertId): ?Model
    {
        return $this->find($concertId);
    }

    /**
     * 配列情報を元に登録
     * @param $concertData (array)
     * @return Model
     */
    public function createConcert(array $concertData): Model
    {
        return $this->create($concertData);
    }

    /**
     * idで検索して削除
     * @param int $id
     * @return Model
     */
    public function deleteById(int $id): Model
    {
        return $this->find($id)->delete();
    }

    /**
     * 最新順に並び替える
     * @param $query
     * @return mixed
     */
    private function scopeOrderByNewest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
