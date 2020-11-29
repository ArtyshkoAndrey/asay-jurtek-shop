<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Skus;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Models\SkusCategory;

class SkusController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return Factory|View
   */
  public function index(Request $request)
  {
    $type = 'all';
    $search = $request->search;
    $skus = Skus::query();
    if (isset($search)) {
      $skus = $skus->where('title', 'LIKE', '%' . $search . '%')
        ->orWhere('created_at', 'LIKE', '%'.$search.'%');
    } else {
      $search = '';
    }
    $filters = [
      'search' => $search,
      'type' => $type
    ];
    $skus = $skus->paginate(10);
    return view('admin.skus.index', compact('skus', 'filters'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Factory|View
   */
  public function create()
  {
    return view('admin.skus.create');
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
      'title' => 'required|unique:skuses,title',
      'skus_category_id' => 'required|exists:skus_categories,id',
      'weight' => 'required|unique:skuses,weight,null,id,skus_category_id,'.$request->skus_category_id
    ]);

    $sku = new Skus();
    $sku->skus_category()->associate($request->skus_category_id);
    $sku->title = $request->title;
    $sku->weight = $request->weight;
    $sku->save();

//    return redirect()->route('admin.production.attr.index');
    return redirect()->route('admin.production.skus-category.edit', $request->skus_category_id)->withSuccess(['Размер успешно создан']);
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
      $sku = Skus::find($id);
      $skus_categories = SkusCategory::all();
      return view('admin.skus.edit', compact('sku', 'skus_categories'));
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
        'title' => 'required|unique:skuses,title,' . $id,
        'skus_category_id' => 'required|exists:skus_categories,id',
        'weight' => 'required|unique:skuses,weight,'.$id.',id,skus_category_id,'.$request->skus_category_id
      ]);

      $sku = Skus::find($id);
      $sku->skus_category()->associate($request->skus_category_id);
      $sku->update($request->all());
//      dd($request->all());
      $sku->save();

//      return redirect()->route('admin.production.attr.index');
      return redirect()->route('admin.production.skus-category.edit', $sku->skus_category->id)->withSuccess(['Размер успешно обновлён']);
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
      $sc = Skus::find($id);
      $s = $sc->skus_category_id;
      $sc->delete();
      return redirect()->route('admin.production.skus-category.edit', $s)->withSuccess(['Размер успешно удалён']);
    }
}
