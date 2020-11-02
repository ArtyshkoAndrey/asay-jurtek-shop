<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkusCategory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SkusCategoriesController extends Controller {
  public function __construct() {

  }

  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return Factory|View
   */
  public function index(Request $request)
  {
    $scs = SkusCategory::paginate(10);
    return view('admin.skus_categories.index', compact('scs'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Factory|View
   */
  public function create()
  {
    return view('admin.skus_categories.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return RedirectResponse
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|unique:skus_categories,name'
    ]);

    $sc= new SkusCategory();
    $sc->name = $request->name;
    $sc->save();

    return redirect()->route('admin.production.skus-category.edit', $sc->id);
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
   * @return Factory|View
   */
  public function edit($id)
  {
    $sc = SkusCategory::find($id);
    return view('admin.skus_categories.edit', compact('sc'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param  int  $id
   * @return RedirectResponse
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|unique:skus_categories,name,' . $id,
    ]);

    $sc = SkusCategory::find($id);
    $sc->update($request->all());
    $sc->save();

    return redirect()->route('admin.production.skus-category.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return RedirectResponse
   * @throws Exception
   */
  public function destroy($id)
  {
    SkusCategory::destroy($id);
    return redirect()->route('admin.production.skus-category.index');
  }
}
