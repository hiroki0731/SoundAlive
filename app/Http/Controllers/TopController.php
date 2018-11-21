<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\ConcertService;

class TopController extends Controller
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
        return view('/top')->with('concerts', $concerts);
    }

    /**
     * ライブ詳細画面の表示
     * @param $id
     * @return $this
     */
    public function showDetail($id)
    {
        $concert = $this->concertService->findByConcertId($id);
        return view('/detail')->with('concert', $concert);
    }
}
