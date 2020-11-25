<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Factory|View
   */
  public function index()
  {
    $categories = Category::select('*')->whereNotIn('id',function($query) {

      $query->select('child_category_id')->from('categories_categories');

    })->get();
    return view('admin.category.index', compact('categories'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return void
   */
  public function create()
  {
      //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return RedirectResponse
   */
  public function store(Request $request)
  {
//      dd($request);
    $request->validate([
      'name' => 'required|string',
      'description' => 'string'
    ]);
    $ct = new Category();
    $ct->name = $request->name;
    $ct->description = $request->description;
    $ct->save();
    $ct->parents()->sync($request->categories);
    return redirect()->route('admin.production.category.index')->withSuccess(['Категоия - ' . $request->name . ' - создана']);
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
   * @return Application|Factory|\Illuminate\Contracts\View\View|Response
   */
  public function edit(int $id)
  {
    $category = Category::find($id);
    $categories = Category::select('*')->whereNotIn('id',function($query) {
      $query->select('child_category_id')->from('categories_categories');
    })->get();
    return view('admin.category.edit', compact('category', 'categories'));
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
    $request->validate([
      'name' => 'required|string',
      'description' => 'string'
    ]);
    $ct = Category::find($id);
    $ct->name = $request->name;
    $ct->description = $request->description;
    $ct->parents()->sync($request->categories);
    $ct->save();
    return redirect()->route('admin.production.category.index')->withSuccess(['Категоия - ' . $request->name . ' - изменена']);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function destroy(int $id)
  {
    $category = Category::find($id);
    $name = $category->name;
    $category->delete();
    return redirect()->route('admin.production.category.index')->withSuccess(['Категоия - ' . $name . ' - удалена']);
  }
}
