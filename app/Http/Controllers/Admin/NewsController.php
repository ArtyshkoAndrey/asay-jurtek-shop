<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

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
    if ($search = $request->input('search', null)) {
      $newses = News::where('title', 'like', '%'.$search.'%')->paginate(10);
    } else {
      $newses = News::paginate(10);
    }
    return view('admin.news.index', compact('newses', 'search'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return View
   */
  public function create(): View
  {
    return view('admin.news.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'required|string|max:255',
      'content' => 'required|string',
      'image' => 'required|string'
    ]);
    $data = $request->all();
    $news = new News($data);
    $news->save();

    return redirect()->route('admin.news.index')->withSuccess(['Новость успешно создана']);
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return void
   */
  public function show(int $id)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param News $news
   * @return View
   */
  public function edit(News $news): View
  {
    return view('admin.news.edit', compact('news'));
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
    $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'required|string|max:255',
      'content' => 'required|string',
      'image' => 'required|string'
    ]);
    $data = $request->all();
    $news->update($data);
    $news->save();

    return redirect()->route('admin.news.index')->withSuccess(['Новость успешно обновлена']);
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
    try {
      $news->delete();
    } catch (Exception $e) {
      return redirect()->route('admin.news.index')->withErrors(['Новость успешно обновлена']);
    }
    return redirect()->route('admin.news.index')->withSuccess(['Новость успешно удалена']);
  }

  /**
   * Save image in text editor
   *
   * @param  Request $request
   * @return JsonResponse
   */
  public function tinyUploadImage(Request $request): JsonResponse
  {
    $name = $this->cropImage($request->file('file'));
    return response()->json(['location' => asset('storage/news/txt/' . $name)]);
  }

  public function photoDelete(Request $request): string
  {
    $f = News::where('image', $request->name)->first();
    if($f) {
      $f->image = 'no image';
      $f->save();
    }
    File::delete(public_path('storage/news/') . '/' .$request->name);
    return $request->name;
  }

  public function photoCreate(Request $request) {
    $image = $request->file('file');
    $destinationPath = public_path('storage/news/');
    $name = $request->file('file')->getClientOriginalName();
    $img = Image::make($image->getRealPath());
    $img->save($destinationPath.'/'.$name);
    if(isset($request->id)) {
      $st = News::find($request->id);
      $st->image = $name;
      $st->save();
    }
    return $name;
  }

  private function cropImage ($image): string
  {
    $file            = $image->getClientOriginalName();
    $destinationPath = public_path('storage/news/txt');
    $name            = pathinfo($file, PATHINFO_FILENAME). '_' . microtime() . '.webp';
    $img             = Image::make($image->getRealPath())->encode('webp', 75);
    $img->resize(null, 600, function ($constraint) {
      $constraint->aspectRatio();
      $constraint->upsize();
    });
    $img->save($destinationPath.'/'.$name);
    return $name;
  }
}
