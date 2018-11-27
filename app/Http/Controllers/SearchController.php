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

}
