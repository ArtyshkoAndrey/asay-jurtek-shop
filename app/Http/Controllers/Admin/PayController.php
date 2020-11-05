<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pay;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Class PayController
 * Class for work Pay Setting
 * @package App\Http\Controllers\Admin
 */
class PayController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Factory|View
   */
  public function index(): View
  {
    $pays = Pay::all();
    return view('admin.pay.index', compact('pays'));
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
   * @return void
   */
  public function store(Request $request)
  {
    //
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
   * @return Factory|View
   */
  public function edit(int $id): View
  {
    $p = Pay::find($id);
    return view('admin.pay.edit', compact('p'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param int $id
   * @return RedirectResponse
   */
  public function update(Request $request, int $id): RedirectResponse
  {
    $request->validate([
      'pg_merchant_id' => 'required',
      'pg_description' => 'required',
      'url' => 'required',
      'code' => 'required',
      'name' => 'required',
    ]);
    $p = Pay::find($id);
    $request['pg_testing_mode'] = isset($request->pg_testing_mode);
    $p->update($request->all());
    $p->save();
    return redirect()->route('admin.store.pay.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return void
   */
  public function destroy(int $id)
  {
    //
  }
}
