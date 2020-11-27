<?php

namespace App\Http\Controllers;

use App\Models\News;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NewsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return View
   */
  public function index(Request $request): View
  {
    $filter = [
      'order' => 'sort-new'
    ];
//    if ($filter['order'] = $request->input('order', null)) {
//      $newses = News::where('title', 'like', '%'.$search.'%')->paginate(10);
//    } else {
      $newses = News::paginate(10);
//    }
    return view('news.index', compact('newses', 'filter'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return View
   */
  public function create(): View
  {

  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return Response
   */
  public function store(Request $request)
  {

  }

  /**
   * Display the specified resource.
   *
   * @param News $news
   * @return Application|Factory|View
   */
  public function show(News $news): View
  {
    return view('news.show', compact('news'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param News $news
   * @return View
   */
  public function edit(News $news): View
  {

  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param News $news
   * @return Response
   */
  public function update(Request $request, News $news)
  {

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param News $news
   * @return RedirectResponse
   * @throws Exception
   */
  public function destroy(News $news)
  {

  }
}
