<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MenuCategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Application|Factory|View|Response
   */
  public function index()
  {
    $menu_categories = Category::where('to_menu', true)->get();
    return view('admin.setting.menu.categories', compact('menu_categories'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Application|Factory|View|Response
   */
  public function create()
  {
    $categories = Category::where('to_menu', false)->get();
    $categoriesAll = Category::select('*')->whereNotIn('id',function($query) {

      $query->select('child_category_id')->from('categories_categories');

    })->get();
    return view('admin.setting.menu.create', compact('categories', 'categoriesAll'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return Response
   */
  public function store(Request $request)
  {
    $category = Category::find($request->category_id);
    $category->to_menu = true;
    $category->save();
    return redirect()->route('admin.setting.menu-categories.index')->withSuccess(['Категория ' . $category->name . ' добавлена в меню']);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return Application|Factory|View|Response
   */
  public function edit(int $id)
  {
    $category = Category::find($id);
    $links = $category->linksFilter()->get();
    return view('admin.setting.menu.edit', compact('links', 'category'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request, $id)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    $category = Category::find($id);
    $category->to_menu = false;
    $category->save();
    $category->linksFilter()->each(function($link) {
      $link->delete();
    });
    return redirect()->route('admin.setting.menu-categories.index')->withSuccess(['Категория ' . $category->name . ' удалена из меню']);
  }
}
