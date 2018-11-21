<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\ConcertService;
use Mockery\Exception;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreateConcertValidation;

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

        // TODO: ユーザーIDをキーにしてコンサートテーブルの情報を取得してviewに渡す
        $concerts = $this->concertService->getByUserId(Auth::id());

        return view('mypage/mypage')->with('userName', Auth::user()->name)->with('concerts', $concerts);
    }


    /**
     * TODO: Validation
     * 新規ライブ情報の登録
     *
     * @param CreateConcertValidation $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createConcert(CreateConcertValidation $request)
    {
        $userId = Auth::id();

        //新規ライブ情報の配列を作成
        $concertArray = [];
        $concertArray['user_id'] = $userId;

        //インプット情報からコンサートテーブルのカラムに対応する値のみを抽出
        foreach ($request->except('_token') as $key => $val) {
            if (in_array($key, $this->concertService::CONCERT_TABLE_COLUMNS)) {
                $inputData[$key] = $val;
            }
        }

        //アップロードされた画像を保存してパスを格納
        $filePath = Storage::putFile('/images', $request->file('concert_img'));
        $inputData['concert_img'] = basename($filePath);

        //抽出した値をjsonにパースし、新規ライブ情報に追加
        $detail_info = json_encode($inputData ?? []);
        if (json_last_error() === JSON_ERROR_NONE) {
            $concertArray['detail_info'] = $detail_info;
        } else {
            logs()->error('-------------------------------------¥n');
            logs()->error('json_encodeでエラー。エラーコード：' . json_last_error() . '¥n');
            logs()->error('- - - - - - - - - - - - - - - - - - -¥n');
            logs()->error('エラー発生時のインプット：' . print_r($request->except('_token'), true) . '¥n');
            logs()->error('-------------------------------------¥n');

            // TODO: Exception吐きすてて終了ってのをどうにかする
            throw new Exception();
        }

        // TODO:削除
        logs()->debug('input内容：' . print_r($concertArray, true));

        //新規ライブ情報を登録
        $model = $this->concertService->createConcert($concertArray);

        // TODO:失敗時の処理
        if (empty($model)) {
            //登録失敗ページを表示
            return redirect('/mypage');
        } else {
            //登録完了ページを表示
            return redirect('/mypage');
        }
    }

    /**
     * ライブ情報の登録
     */
    public function storeConcert()
    {

    }

    /**
     * ライブ情報の編集ページ表示
     * @param $concertId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateConcert($concertId)
    {
        $concert = $this->concertService->findByConcertId($concertId);

        // ライブ作成者idとユーザidを照合
        if($concert->user_id != Auth::id()){
            return redirect('/mypage');
        }
        return view('/detail_update')->with('concert', $concert);
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
        if($concert->user_id != Auth::id()){
            return redirect('/mypage');
        }

        $this->concertService->deleteById($concert->id);
        return redirect('/mypage');
    }

}
