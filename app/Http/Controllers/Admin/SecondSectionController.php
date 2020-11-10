<?php
/*
 * Copyright (c) 2020.
 * The written code is completely free, full copying and modifications for improvement are allowed.
 * I am Fulliton https://github.com/ArtyshkoAndrey giving the right to everyone, without exception, to use this code.
 * Stable and optimized code =)
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class SecondSectionController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return Factory|View
   */
  public function index(Request $request): View
  {
    $settings = Setting::where('key', 'second-section')->get();
    return view('admin.setting.second-section.index', compact('settings'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Factory|View
   */
  public function create(): View
  {

  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return RedirectResponse
   */
  public function store(Request $request): RedirectResponse
  {

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
   * @param int $id
   * @return Factory|View|RedirectResponse
   */
  public function edit(int $id)
  {
    if (($setting = Setting::find($id))->key != 'second-section') {
      return redirect()->route('admin.setting.second-section.index')->withErrors('Данная настройка не подходит');
    }
    return view('admin.setting.second-section.edit', compact('setting'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param int $id
   * @return RedirectResponse
   */
  public function update(Request $request, int $id)
  {
    if (($setting = Setting::find($id))->key != 'second-section') {
      return redirect()->route('admin.setting.second-section.index')->withErrors('Данная настройка не подходит');
    }
    $name = $setting->meta->image;
    if ($image = $request->file('image')) {
      File::delete(public_path('storage/header/' . $name));
      $name = $this->cropImage($image);
    }
    $setting->meta = array(
      'image' => $name,
      'btn_text' => $request->btn_text,
      'link' => $request->link,
      'title' => $request->title,
    );
    $setting->save();
    return redirect()->route('admin.setting.second-section.index')->withSuccess(['Второй сектор обновлён']);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return RedirectResponse
   * @throws Exception
   */
  public function destroy(int $id) {

  }

  private function cropImage ($image) {
    $file = time() . "_" . $image->getClientOriginalName();
    $destinationPath = public_path('storage/header/');
    $name            = pathinfo($file, PATHINFO_FILENAME) . '.webp';
    $img             = Image::make($image->getRealPath())->encode('webp', 75);
    $img->save($destinationPath.'/'.$name);
    return $name;
  }

}
