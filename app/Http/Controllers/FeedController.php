<?php

namespace App\Http\Controllers;

use App\Repositories\FeedRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    /** @var FeedRepository $feedRepository */
    private FeedRepository $feedRepository;

    public function __construct(FeedRepository $feedRepo)
    {
        $this->feedRepository = $feedRepo;
    }

    public function index(Request $request): Factory|View|Application
    {
        $feeds = $this->feedRepository->all();

        return view('feeds.index', compact('feeds'));
    }
}
