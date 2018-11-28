<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\ConcertService;

class SearchController extends Controller
{
    private $concertService;

    public function __construct(ConcertService $concertService)
    {
        $this->concertService = $concertService;
    }

    /**
     * トップ画面の表示
     * @return $this
     */
    public function index()
    {
        $concerts = $this->concertService->getAll();
        return view('/search')->with('concerts', $concerts);
    }

    /**
     * ライブを検索して結果をコレクションで返す
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        $inputs = $request->except('_token');
        foreach ($inputs as $key => $val) {
            if (empty($val)) {
                continue;
            } else {
                $conditions[$key] = $val;
            }
        }
        if (empty($conditions)) {
            $concerts = $this->concertService->getAll();
        } else {
            $concerts = $this->concertService->getByCondition($conditions);
        }

        return view('/search')->with('concerts', $concerts)->with('conditions', $conditions ?? array());
    }

}
