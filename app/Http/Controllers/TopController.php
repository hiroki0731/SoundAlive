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

    public function index()
    {
        $concerts = $this->concertService->getAll();
        return view('/top')->with('concerts', $concerts);
    }
}
