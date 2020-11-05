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

  /**
   * Display a listing of the resource.
   *
   * @return Factory|View
   */
  public function index(): View
  {
    $expresses = ExpressCompany::all();
    return view('admin.express.index', compact('expresses'));
  }

  /**
   * Set status Enabled in Company
   * @param Request $request
   * @param $id
   * @return RedirectResponse
   */
  public function enabled(Request $request, $id): RedirectResponse
  {
    $request->validate([
      'enabled' => 'required|bool'
    ]);
    $data = $request->all();
    $express = ExpressCompany::find($id);
    $express->enabled = $data['enabled'];
    $express->save();
    return redirect()->route('admin.store.express.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Factory|View
   */
  public function create(): View
  {
    return view('admin.express.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return RedirectResponse
   */
  public function store(Request $request): RedirectResponse
  {
    $request->validate([
      'name' => 'required|unique:express_companies,name',
      'description' => 'required|string',
      'cost_type' => 'required',
      'min_cost' => 'required|min:0'
    ]);

    $express = new ExpressCompany();
    $request['enabled_cash'] = isset($request->enabled_cash);
    $request['enabled_card'] = isset($request->enabled_card);
    $express = $express->create($request->all());

    return redirect()->route('admin.store.express.edit', $express->id);
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
    $express = ExpressCompany::find($id);
    return view('admin.express.edit', compact('express'));
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
      'name' => 'required|unique:express_companies,name,' . $id,
      'description' => 'required|string',
      'cost_type' => 'required',
      'min_cost' => 'required|min:0'
    ]);

    $express = ExpressCompany::find($id);
    $request['enabled'] = $express->enabled;
    $request['enabled_cash'] = $request->has('enabled_cash');
    $request['enabled_card'] = $request->has('enabled_card');
    $express->update($request->all());
    return redirect()->route('admin.store.express.edit', $express->id);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function destroy(int $id): RedirectResponse
  {
    $company = ExpressCompany::find($id);
    $company->delete();
    return redirect()->route('admin.store.express.index');
  }
}
