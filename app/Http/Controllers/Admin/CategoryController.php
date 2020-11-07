<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
//      dd($request);
    $request->validate([
      'name' => 'required|string',
      'to_index' => $request->has('to_index') ? 'accepted' : ''
    ]);
    $ct = new Category();
    $ct->name = $request->name;
    $ct->to_index = $request->has('to_index');
    if($request->has('to_index')) {
      Category::where('to_index', true)->update(['to_index' => false]);
    }
    $ct->save();
    $ct->parents()->sync($request->categories);
    return redirect()->route('admin.production.category.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
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
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string',
      'to_index' => $request->has('to_index') ? 'accepted' : ''
    ]);
    $ct = Category::find($id);
    $ct->name = $request->name;
    $ct->to_index = $request->has('to_index');
    if($request->has('to_index')) {
      Category::where('to_index', true)->update(['to_index' => false]);
    }
    $ct->parents()->sync($request->categories);
    $ct->save();
    return redirect()->route('admin.production.category.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function destroy($id)
  {
    Category::destroy($id);
    return redirect()->route('admin.production.category.index');
  }
}
