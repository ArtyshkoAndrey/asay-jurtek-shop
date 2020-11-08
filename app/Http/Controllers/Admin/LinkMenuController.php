<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\LinkMenu;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class LinkMenuController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return void
   */
  public function index()
  {
//
  }

  /**
   * Show the form for creating a new resource.
   *
   * @param Request $request
   * @return Application|Factory|View|Response
   */
  public function create(Request $request)
  {
    $categories = Category::where('to_menu', true)->get();
    if ($category_id = $request->input('category_id', null)) {
      $category = Category::find($category_id);
    } else {
      $category = $categories->first();
    }
    return view('admin.setting.link-menu.create',compact('category', 'categories'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return Response
   */
  public function store(Request $request)
  {
    $image = $request->file('image');
    $linkMenu = new LinkMenu($request->all());
    $linkMenu->image = $this->cropImage($image);
    $linkMenu->category()->associate($request->category_id);
    $linkMenu->save();
    return redirect()->route('admin.setting.menu-categories.edit', $request->category_id)->withSuccess(['Ссылка с фотографией успешно создана']);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $linkMenu = LinkMenu::find($id);
    $categories = Category::where('to_menu', true)->get();
    return view('admin.setting.link-menu.edit',compact('linkMenu', 'categories'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request, $id)
  {
    $linkMenu = LinkMenu::find($id);
    $image = $request->file('image');
    $name = $linkMenu->image;
    if ($image) {
      File::delete(public_path('storage/link-menu/' . $name));
      $name = $this->cropImage($image);
    }
    $linkMenu->update($request->all());
    $linkMenu->category()->associate($request->category_id);
    $linkMenu->image = $name;
    $linkMenu->save();
    return redirect()->route('admin.setting.menu-categories.edit', $request->category_id)->withSuccess(['Ссылка с фотографией успешно обновлена']);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return void
   */
  public function destroy(int $id)
  {
    $linkMenu = LinkMenu::find($id);
    $category_id = $linkMenu->category->id;
    File::delete(public_path('storage/link-menu/' . $linkMenu->image));
    $linkMenu->delete();
    return redirect()->route('admin.setting.menu-categories.edit', $category_id)->withSuccess(['Ссылка с фотографией успешно удалена']);
  }

  private function cropImage ($image) {
    $file = time().'_' .$image->getClientOriginalName();
    $destinationPath = public_path('storage/link-menu');
    $name            = pathinfo($file, PATHINFO_FILENAME) . '.webp';
    $img             = Image::make($image->getRealPath())->encode('webp', 75);
    $img->fit(600)
        ->save($destinationPath.'/'.$name);
    return $name;
  }
}
