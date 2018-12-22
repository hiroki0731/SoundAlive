<?php
declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Contracts\ConcertInterface;
use App\Http\Models\Concert;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    const LOCAL_STORAGE_PATH = '/images';
    const S3_STORAGE_PATH = '/';

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
     *
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
        } else {
            if ($existLine && !$existStation) { //路線まで指定した場合
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

    /**
     * 共通登録処理
     * @param $request
     * @param null $concertImg (更新処理の時のみ)
     * @return string
     * @throws Exception
     */
    public function storeProcess($request, $concertImg = null)
    {
        //インプット情報からコンサートテーブルのカラムに対応する値のみを抽出
        foreach ($request->except('_token') as $key => $val) {
            if (in_array($key, self::CONCERT_TABLE_COLUMNS)) {
                // Youtubeリンクの整形
                if ($key == "movie_id" && !empty($val)) {
                    $val = $this->extractMovieId($val);
                }
                $inputData[$key] = $val;
            }
        }

        //アップロードされた画像を保存してパスを格納（編集時はnullのことがある）
        if (empty($request->file('concert_img'))) {
            $inputData['concert_img'] = $concertImg;
        } else {
            $img = $request->file('concert_img');

            //S3とローカルの両方に画像を保存する
            $filePath = Storage::putFile(self::S3_STORAGE_PATH, $img, 'public');
            Storage::disk('public')->putFile(self::LOCAL_STORAGE_PATH, $img);

            //S3のパスをDBに保存
            $inputData['concert_img'] = Storage::url($filePath);
        }

        //抽出した値をjsonにパース
        $detail_info = json_encode($inputData ?? []);

        if (json_last_error() != JSON_ERROR_NONE) {
            logs()->error('-------------------------------------¥n');
            logs()->error('json_encodeでエラー。エラーコード：' . json_last_error() . '¥n');
            logs()->error('- - - - - - - - - - - - - - - - - - -¥n');
            logs()->error('エラー発生時のインプット：' . print_r($request->except('_token'), true) . '¥n');
            logs()->error('-------------------------------------¥n');
            // TODO: Exception吐きすてて終了ってのをどうにかする
            throw new Exception('ライブ情報JSONのパースに失敗しました');
        }

        return $detail_info;
    }

    /**
     * Youtubeリンクから動画idを抽出して返却する
     * @param $paramUrl
     * @return string
     */
    private function extractMovieId($paramUrl): string
    {
        if (preg_match('#https?://www.youtube.com/watch\?v=([^\&]*\&?)#', $paramUrl, $matches)) {
            if (!empty($matches[1])) {
                $movieId = rtrim($matches[1], '&');
            }
        }
        return $movieId ?? '';
    }
}