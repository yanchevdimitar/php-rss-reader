<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRssRequest;
use App\Http\Requests\UpdateRssRequest;
use App\Repositories\RssRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use \Illuminate\Routing\Redirector;

class RssController extends Controller
{
    /** @var RssRepository $rssRepository */
    private RssRepository $rssRepository;

    public function __construct(RssRepository $rssRepo)
    {
        $this->rssRepository = $rssRepo;
    }

    public function index(Request $request): Factory|View|Application
    {
        $rsses = $this->rssRepository->all();

        return view('rsses.index', compact('rsses'));
    }

    public function create(): Factory|View|Application
    {
        return view('rsses.create');
    }

    public function store(CreateRssRequest $request): Redirector|Application|RedirectResponse
    {
        $input = $request->all();
        $this->rssRepository->create($input);

        return redirect('/rss')->with('success', 'Rss is successfully saved');
    }

    public function edit($id): View|Factory|Redirector|Application|RedirectResponse
    {
        $rss = $this->rssRepository->getById($id);

        if (empty($rss)) {
            Flash::error('Rss not found');

            return redirect(route('rsses.index'));
        }

        return view('rsses.edit', compact('rss'));
    }

    public function update(UpdateRssRequest $request, $id): Redirector|Application|RedirectResponse
    {
        $this->rssRepository->updateById($id, $request->all());
        return redirect(route('rss.index'));
    }

    public function destroy($id): Redirector|Application|RedirectResponse
    {
        $this->rssRepository->deleteById($id);

        return redirect('/rss')->with('success', 'RSS  is successfully deleted');
    }
}
