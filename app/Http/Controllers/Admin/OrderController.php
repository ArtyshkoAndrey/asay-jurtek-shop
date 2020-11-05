<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

/**
 * Class OrderController
 * Class for Orders
 * @package App\Http\Controllers\Admin
 */
class OrderController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return Factory|View
   */
  public function index(Request $request): View
  {

    $type = $request->input('type', '');
    $time = $request->input('time', 'all');
    $search = $request->input('search', null);

    $orders = Order::query()->with('user');

    if ($search)
      $orders = $orders->orWhereHas('user', function($q) use ($search) {
          $q->where(function($q) use ($search) {
            $q->where('name', 'LIKE', '%' . $search . '%');
          });
        })
        ->orWhere('no', 'LIKE', '%'.$search.'%')
        ->orWhere('created_at', 'LIKE', '%'.$search.'%')
        ->orWhere('ship_data', 'LIKE', '%'.$search.'%');

    switch ($type) {
      case Order::SHIP_STATUS_RECEIVED:
        $orders =$orders->where('ship_status', Order::SHIP_STATUS_RECEIVED);
        break;
      case Order::SHIP_STATUS_PENDING:
        $orders =$orders->where('ship_status', Order::SHIP_STATUS_PENDING);
        break;
      case Order::SHIP_STATUS_DELIVERED:
        $orders =$orders->where('ship_status', Order::SHIP_STATUS_DELIVERED);
        break;
      case Order::SHIP_STATUS_PAID:
        $orders =$orders->where('ship_status', Order::SHIP_STATUS_PAID);
        break;
      case Order::SHIP_STATUS_CANCEL:
        $orders =$orders->where('ship_status', Order::SHIP_STATUS_CANCEL);
        break;
      default:
    }

    switch ($time) {
      case 'year':
        $orders =$orders->where('created_at', '<', Carbon::now())->where('created_at', '>', Carbon::now()->subYear(1));
        break;
      case 'month':
        $orders =$orders->where('created_at', '<', Carbon::now())->where('created_at', '>',  Carbon::now()->subMonth(1));
        break;
      case 'week':
        $orders =$orders->where('created_at', '<', Carbon::now())->where('created_at', '>',  Carbon::now()->subWeek(1));
        break;
      default:
    }

    $orders = $orders->orderByDesc('created_at')->with('items.product');
    $orders = $orders->paginate(20);
    $filters = [
      'type'  => $type,
      'time'  => $time,
      'search'=> $search
    ];

    return view('admin.order.index', compact('orders', 'type', 'filters'));
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
    $order = Order::find($id);
    return view('admin.order.edit', compact('order'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param int $id
   * @return RedirectResponse
   * @throws Exception
   */
  public function update(Request $request, int $id): RedirectResponse
  {
    $request->validate([
      'created_at' => 'required|date',
      'ship_status' => 'required',
      'user' => 'required|exists:users,id',
      'express_no' => 'nullable'
    ]);
    $order = Order::find($id);
    $order->created_at = Carbon::parse($request->created_at);
    $order->ship_status = $request->ship_status;
    $order->ship_data = ['express_no' => $request->express_no];
    $order->user()->associate($request->user);
    $order->save();
    return redirect()->route('admin.store.order.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function destroy(int $id): RedirectResponse
  {
    $order = Order::find($id);
    $order->delete();
    return redirect()->route('admin.store.order.index');
  }

  /**
   * Delete mani orders
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function collectionsDestroy(Request $request): JsonResponse
  {
    $request->validate([
      'id' => 'required'
    ]);
    Order::destroy($request->id);
    return response()->json(['status' => 'success']);
  }
}
