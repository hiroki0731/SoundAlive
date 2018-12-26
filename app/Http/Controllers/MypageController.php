<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateConcertValidation;
use App\Http\Requests\UpdateConcertValidation;
use App\Http\Services\ConcertService;
use App\Http\Services\TwitterService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
            $concertArray['detail_info'] = $this->concertService->storeProcess($request);
        } catch (Exception $e) {
            // TODO:エラー処理
            dd($e->getMessage());
        }

        //新規ライブ情報を登録
        $registerdConcert = $this->concertService->createConcert($concertArray);

        //SNS告知
        if (!is_null($request->get('sns'))) {
            $twitterService->tweet($registerdConcert);
        }

        $request->session()->flash('completed', '登録完了');

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
            $concert->detail_info = $this->concertService->storeProcess($request, $detail_info->concert_img);
        } catch (Exception $e) {
            // TODO:エラー処理
            dd($e->getMessage());
        }
        $concert->save();
        return redirect('/mypage');
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
}
