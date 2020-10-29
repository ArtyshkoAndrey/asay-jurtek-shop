<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExpressCompany;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ExpressController extends Controller
{
  public function __construct()
  {
//    parent::__construct($cartService);
  }

  /**
   * Display a listing of the resource.
   *
   * @return Factory|View
   */
  public function index()
  {
    $expresses = ExpressCompany::all();
    return view('admin.express.index', compact('expresses'));
  }

  public function enabled(Request $request, $id) {
    $express = ExpressCompany::find($id);
    $express->enabled = $request->enabled;
    $express->save();
    return redirect()->route('admin.store.express.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Factory|View
   */
  public function create()
  {
    return view('admin.express.create');
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
      'name' => 'required|unique:express_companies,name',
      'cost_type' => 'required',
      'min_cost' => 'required|min:0'
    ]);

    $express = new ExpressCompany();
    $request['enabled_cash'] = isset($request->enabled_cash);
    $express = $express->create($request->all());

    return redirect()->route('admin.store.express.edit', $express->id);
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
   * @return Factory|View
   */
  public function edit($id)
  {
    $express = ExpressCompany::find($id);
    return view('admin.express.edit', compact('express'));
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
      'name' => 'required|unique:express_companies,name,' . $id,
      'cost_type' => 'required',
      'min_cost' => 'required|min:0'
    ]);

    $express = ExpressCompany::find($id);
    $request['enabled'] = $express->enabled;
    $request['enabled_cash'] = $request->has('enabled_cash');
//    dd($request->all());
    $express->update($request->all());
    return redirect()->route('admin.store.express.edit', $express->id);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return RedirectResponse
   */
  public function destroy($id)
  {
    $company = ExpressCompany::find($id);
    $company->delete();
    return redirect()->route('admin.store.express.index');
  }
}
