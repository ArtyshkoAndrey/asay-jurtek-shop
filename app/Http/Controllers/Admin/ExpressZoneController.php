<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExpressZone;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Class ExpressZoneController
 * Class for Zone in Express Company
 * @package App\Http\Controllers\Admin
 */
class ExpressZoneController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return void
   */
  public function index()
  {

  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Factory|View
   */
  public function create(): View
  {
    return view('admin.express-zone.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return RedirectResponse
   */
  public function store(Request $request): RedirectResponse
  {
    $zone = new ExpressZone();
    if($request->method_cost === 'step_and_cost') {
      $request->validate([
        'name' => 'required|unique:express_zones,name',
        'cost' => 'required|numeric|min:0',
        'step' => 'required|numeric|min:0',
        'cost_step' => 'required|numeric|min:0',
        'company_id' => 'required|exists:express_companies,id',
      ]);

      $zone = $zone->create($request->all());
    } else if ($request->method_cost === 'array_step') {
      $request->validate([
        'name' => 'required|unique:express_zones,name',
        'company_id' => 'required|exists:express_companies,id',
        'weight_to' => 'required',
        'weight_from' => 'required',
        'cost' => 'required'
      ]);
      $zone = $this->setZone($request->all(), $zone);
    }

    return redirect()->route('admin.store.express-zone.edit', $zone->id);
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

    $zone = ExpressZone::find($id);
    return view('admin.express-zone.edit', compact('zone'));
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
    $zone = ExpressZone::find($id);
    if ($request->method_cost === 'step_and_cost') {
      $request->validate([
        'name' => 'required|unique:express_zones,name,' . $id,
        'cost' => 'required|numeric|min:0',
        'step' => 'required|numeric|min:0',
        'cost_step' => 'required|numeric|min:0',
        'company_id' => 'required|exists:express_zones'
      ]);
      $zone->update($request->all());
    } else if ($request->method_cost === 'array_step') {
      $request->validate([
        'name' => 'required|unique:express_zones,name,' . $id,
        'company_id' => 'required|exists:express_companies,id',
        'weight_to' => 'required',
        'weight_from' => 'required',
        'cost' => 'required'
      ]);
      $zone = $this->setZone($request->all(), $zone);
    }
    return redirect()->route('admin.store.express-zone.edit', $zone->id);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function destroy(int $id): RedirectResponse
  {
    $zone = ExpressZone::find($id);
    $zone->delete();
    return redirect()->route('admin.store.express.edit', $zone->company->id);
  }

  /**
   * Delete city in zone
   *
   * @param Request $request
   * @param int $id
   * @return JsonResponse
   */
  public function destroyCity(Request $request, int $id): JsonResponse
  {
    $request->validate([
      'city_id' => 'required|exist:App\Models\City,id'
    ]);
    $data = $request->all();
    $zone = ExpressZone::find($id);
    $zone->cities()->detach($data['city_id']);
    return response()->json(['success'=>'ok']);
  }

  /**
   * Helper function to avoid duplicate code
   * @param array $data
   * @param ExpressZone $zone
   * @return ExpressZone
   */
  private function setZone(array $data, ExpressZone $zone) {
    $zone->name = $data['name'];
    $zone->company()->associate($data['company_id']);
    $step_cost_array = array();
    for ($i = 1; $i <= count($data['cost']); $i++) {
      $step_cost_array[$i - 1] = (object) array();
      $step_cost_array[$i - 1]->cost = (double) $data['cost'][$i];
      $step_cost_array[$i - 1]->weight_to = (double) $data['weight_to'][$i];
      $step_cost_array[$i - 1]->weight_from = (double)  $data['weight_from'][$i];
    }
    $zone->step_cost_array = $step_cost_array;
    $zone->save();
    return $zone;
  }

  /**
   * add City in zone by id
   *
   * @param Request $request
   * @param int $id
   * @return JsonResponse
   */
  public function setCity(Request $request, int $id): JsonResponse
  {
    $zone = ExpressZone::find($id);
    $request->validate([
      'city_id' => 'required|unique:city_expresses,city_id,'.$request->city_id.',id,express_company_id,'.$zone->company->id
    ]);
    $zone->cities()->attach($request->city_id, ['express_company_id' => $zone->company->id]);
    return response()->json(['success' => 'ok']);
  }
}
