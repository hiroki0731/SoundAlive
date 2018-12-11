<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Helper;
use App\Http\Services\ConcertService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SearchController extends Controller
{
    private $concertService;

    public function __construct(ConcertService $concertService)
    {
        $this->concertService = $concertService;
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
            if (empty($val) || $key === "page") {
                continue;
            } else {
                $conditions[$key] = $val;
            }
        }

        $concerts = $this->concertService->getByCondition($conditions ?? array());
        $conditions = $this->replaceConditionName($conditions ?? array());

        return view('/search' , compact('concerts', 'conditions'));
    }

    /**
     * 検索条件の中身を文字列に変換する
     * @param $conditions
     * @return array
     */
    private function replaceConditionName($conditions = array()): array
    {
        $const = Config::get('const.conditions') ?? array();

        foreach ($conditions as $key => $val) {
            if($key == "pref"){
                $val = Helper::getPrefName($val);
            }else if($key == "line"){
                $val = Helper::getLineName($val);
            }else if($key == "station"){
                $val = Helper::getStationName($val);
            }
            if(key_exists($key, $const)){
                $replacedConditions[$const[$key]] = $val;
            }
        }
        return $replacedConditions ?? array();
    }

}
