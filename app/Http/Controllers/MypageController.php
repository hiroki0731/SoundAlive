<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateConcertValidation;
use App\Http\Requests\UpdateConcertValidation;
use App\Http\Services\ConcertService;
use App\Http\Services\TwitterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Exception;

class MypageController extends Controller
{
    private $concertService;

    /**
     * 認証済みの場合のみ許可
     * @param ConcertService $concertService
     */
    public function __construct(ConcertService $concertService)
    {
        $this->middleware('auth');
        $this->concertService = $concertService;
    }

    /**
     * ライブ検索一覧画面を表示
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $concerts = $this->concertService->getByUserId(Auth::id());
        $userName = Auth::user()->name;

        return view('mypage/mypage', compact('userName', 'concerts'));
    }

    /**
     * 新規ライブ情報の登録
     *
     * @param CreateConcertValidation $request
     * @param TwitterService $twitterService
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createConcert(CreateConcertValidation $request, TwitterService $twitterService)
    {
        $userId = Auth::id();

        //新規ライブ情報の配列を作成
        $concertArray = [];
        $concertArray['user_id'] = $userId;
        try {
            $concertArray['detail_info'] = $this->storeProcess($request);
        } catch (Exception $e) {
            // TODO:エラー処理
            dd($e->getMessage());
        }

        //新規ライブ情報を登録
        $registerdConcert = $this->concertService->createConcert($concertArray);

        //SNS告知
        if ($request->get('sns')) {
            $twitterService->tweet($registerdConcert);
        }

        return redirect('/mypage');
    }

    /**
     * 編集したライブ情報の更新処理
     * @param UpdateConcertValidation $request
     * @param $concertId
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateConcert(UpdateConcertValidation $request, $concertId)
    {
        $concert = $this->concertService->findByConcertId($concertId);
        $detail_info = json_decode($concert->detail_info);

        try {
            $concert->detail_info = $this->storeProcess($request, $detail_info->concert_img);
        } catch (Exception $e) {
            // TODO:エラー処理
            dd($e->getMessage());
        }
        $concert->save();
        return redirect('/mypage');
    }

    /**
     * 共通登録処理
     * @param $request
     * @param null $concertImg(更新処理の時のみ)
     * @return string
     * @throws Exception
     */
    private function storeProcess($request, $concertImg = null)
    {
        //インプット情報からコンサートテーブルのカラムに対応する値のみを抽出
        foreach ($request->except('_token') as $key => $val) {
            if (in_array($key, $this->concertService::CONCERT_TABLE_COLUMNS)) {
                if ($key == "movie_id") {
                    $val = $this->extractMovieId($val);
                }
                $inputData[$key] = $val;
            }
        }

        //アップロードされた画像を保存してパスを格納（編集時はnullのことがある）
        if (empty($request->file('concert_img'))) {
            $inputData['concert_img'] = $concertImg;
        } else {
            $filePath = Storage::putFile('/images', $request->file('concert_img'));
            $inputData['concert_img'] = basename($filePath);
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
     * ライブ情報の編集ページ表示
     * @param $concertId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showUpdate($concertId)
    {
        $concert = $this->concertService->findByConcertId($concertId);

        // ライブ作成者idとユーザidを照合
        if ($concert->user_id != Auth::id()) {
            return redirect('/mypage');
        }
        return view('/detail_update', compact('concert'));
    }

    /**
     * ライブの論理削除
     * @param $concertId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteConcert($concertId)
    {
        $concert = $this->concertService->findByConcertId($concertId);

        // ライブ作成者idとユーザidを照合
        if ($concert->user_id != Auth::id()) {
            return redirect('/mypage');
        }

        $this->concertService->deleteById($concert->id);
        return redirect('/mypage');
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
