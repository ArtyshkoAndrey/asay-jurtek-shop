<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductsImage;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller {
  public function __construct() {
//
  }

  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return Factory|View
   */
  public function index(Request $request)
  {
    $type     = $request->type;
    $search   = $request->search;
    $products = Product::query();

    if (isset($search)) {

      if ($type === 'delete') {
        $products = $products->onlyTrashed()->orWhere('title', 'LIKE', '%'.$search.'%')
          ->onlyTrashed()->orWhere('created_at', 'LIKE', '%'.$search.'%')
          ->onlyTrashed()->orWhere('price', 'LIKE', '%'.$search.'%');
      } else {
        $products = $products->orWhere('title', 'LIKE', '%'.$search.'%')
          ->orWhere('created_at', 'LIKE', '%'.$search.'%')
          ->orWhere('price', 'LIKE', '%'.$search.'%');
      }
    } else {
      $search = '';
    }

    if (isset($type)) {
      switch ($type) {
        case 'publish':
          break;
        case 'all':
          $products = $products->withTrashed();
          break;
        case 'delete':
          $products = $products->onlyTrashed();
          break;
      }
    } else {
      $type = 'publish';
    }

    $products = $products->orderByDesc('created_at');
    $products = $products->paginate(5);
    $filters  = [
      'type'  => $type,
      'search'=> $search
    ];

    return view('admin.products.index', compact('products', 'filters'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Factory|View
   */
  public function create()
  {
    return view('admin.products.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return RedirectResponse
   */
  public function store(Request $request)
  {
    $product              = new Product();
    $product->title       = $request->title;
    $product->description = $request->description;
    $product->price       = $request->price;
    $product->price_sale  = isset($request->price_sale) ? $request->price_sale : null;
    $product->weight      = $request->weight;
    $product->on_new      = isset($request->on_new) ? 1 : 0;
    $product->on_sale     = isset($request->on_sale) ? 1 : 0;
    $product->meta        = $request->meta;
    $product->skus()->associate($request->skus);
    $product->save();
    $product->categories()->sync($request->category);
    $product->brands()->sync($request->brands);


    foreach ($request->photo as $key => $photo) {
      if ($photo !== null && $photo !== '') {
        $ph = ProductsImage::where('name', $photo)->first();
        $ph->product()->associate($product);
        $ph->save();
      }
    }

    return redirect()->route('admin.production.products.index');
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
   * @param int $id
   * @return Factory|View
   */
  public function edit(int $id)
  {
    $product = Product::withTrashed()->find($id);
    return view('admin.products.edit', compact('product'));
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
    $product              = Product::withTrashed()->find($id);
    $product->title       = $request->title;
    $product->description = $request->description;
    $product->price       = $request->price;
    $product->price_sale  = $request->price_sale;
    $product->weight      = $request->weight;
    $product->on_new      = isset($request->on_new) ? 1 : 0;
    $product->on_sale     = isset($request->on_sale) ? 1 : 0;
    $product->meta        = $request->meta;
    $product->brands()->sync($request->brands);
    $product->categories()->sync($request->category);
    $product->skus()->associate($request->skus);
    $product->save();

    return redirect()->route('admin.production.products.edit', $id);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function destroy(int $id) {
    $pr = Product::withTrashed()->find($id);
    if ($pr->trashed()) {
      $pr->forceDelete();
    } else {
      $pr->delete();
    }
    return redirect()->back();
  }

  public function collectionsDestroy(Request $request) {
    Product::destroy($request->id);
    return ['status' => 'success'];
  }

  public function collectionsRestore(Request $request) {
    foreach($request['data']['id'] as $id) {
      Product::withTrashed()->find($id)->restore();
    }
    return ['status' => 'success'];
  }

  public function photo(Request $request, $id) {
    // read image from temporary file

    $name = $this->cropImage($request->file('file'));
    $ph              = new ProductsImage();
    $ph['name']      = $name;
    $pr              = Product::withTrashed()->find($id);
    $ph->product()->associate($pr);
    $ph->save();
    echo $name;
  }
  public function photoDelete(Request $request, $id) {
    // read image from temporary file
    echo $request->name;
    File::delete(public_path('storage/items/') . '/' .$request->name);
    $ph = ProductsImage::where('name', $request->name)->first();
    $ph->delete();
  }

  public function photoCreate(Request $request) {
    // read image from temporary file
    $name = $this->cropImage($request->file('file'));
    $ph              = new ProductsImage();
    $ph['name']      = $name;
    $ph->save();
    echo $name;
  }

  public function photoDeleteCreate(Request $request) {
    // read image from temporary file
    echo $request->name;
    File::delete(public_path('storage/items/') . '/' .$request->name);
    $ph = ProductsImage::where('name', $request->name)->first();
    $ph->delete();
  }

  private function cropImage ($image) {
    $file = $image->getClientOriginalName();
    $destinationPath = public_path('storage/items/');
    $name            = pathinfo($file, PATHINFO_FILENAME) . '.webp';
    $img             = Image::make($image->getRealPath())->encode('webp', 75);
    $img->resize(600, null, function ($constraint) {
      $constraint->aspectRatio();
      $constraint->upsize();
    });
    $img->save($destinationPath.'/'.$name);
    return $name;
  }
}
