<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Notifications\RegisterPassword;
use App\Services\CartService;
use App\Services\OrderService;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Paybox\Pay\Facade as Paybox;
use App\Models\Pay;

/**
 * Class OrderController.
 * Класс для работы с заказами. Создание, Корзина...
 *
 * @package App\Http\Controllers
 */
class OrderController extends Controller
{

  protected $orderService;

  public function __construct(CartService $cartService, OrderService $orderService)
  {
    parent::__construct($cartService);
    $this->orderService = $orderService;
  }

  /**
   * Display page Cart
   *
   * @return Application|Factory|View
   */
  public function index(): view
  {
    return view('order.index');
  }

  /**
   * Display page Orders
   *
   * @return Application|Factory|View
   */
  public function orders(): view
  {
    $orders = auth()->user()->orders()->orderBy('id', 'desc')->get();
    return view('order.orders', compact('orders'));
  }


  /**
   * Page where create order and pay.
   *
   * @return View
   */
  public function create(): view
  {
    return view('order.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function store(Request $request)
  {
    $request->validate([
      'address' => 'required|string',
      'firstname' => 'required|string',
      'lastname' => 'required|string',
      'city' => 'required|exists:App\Models\City,id',
      'country' => 'required|exists:App\Models\Country,id',
      'phone' => 'required|string',
      'email' => 'required|email:rfc,dns',
      'company' => 'required|exists:App\Models\ExpressCompany,id',
      'method_pay' => 'required|string',
      'cost_transfer' => 'required|integer',
      'cost' => 'required|integer',
      'items_id' => 'required|array',
      'items_id.*' => 'exists:App\Models\Product,id',
    ]);

    $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
    $password = substr($random, 0, 10);

    $user = User::firstOrNew(['email' =>  $request->email]);
    $user->contact_phone = $request->phone;
    $user->first_name = $request->firstname;
    $user->second_name = $request->lastname;
    $user->street = $request->address;
    if (!$user->created_at) {
      $user->password = Hash::make($password);
      $user->save();
      $user->notify(new RegisterPassword($user->email, $password));
    } else
      $user->save();

    $items = Product::findMany($request->items_id);

    $order = $this->orderService->store($user,
      $request->address,
      $request->city,
      $request->country,
      $items,
      $request->method_pay,
      $request->company,
      $request->cost_transfer,
      $request->cost
    );
//    TODO: Данные с бд, в заказе не сохраняется номер телефона
    $paybox = new Paybox();
    $pay = Pay::first();
    $paybox->merchant->id = $pay->pg_merchant_id;
    $paybox->merchant->secretKey = $pay->code;
    $paybox->order->id = $order->id;
    $paybox->order->description = $pay->description;
    $paybox->order->amount = $request->cost + $request->cost_transfer;
    $paybox->config->isTestingMode = (bool) $pay->pg_testing_mode;
    $paybox->customer->userEmail = $user->email;
    $paybox->customer->id = $user->id;
    $paybox->config->successUrlMethod = 'GET';
    $paybox->config->successUrl = route('index');
    dd($paybox->redirectUrl);
    if ($paybox->init())
      return response()->json(['link' => $paybox->redirectUrl], 200);
    else
      return response()->json(['error' => 'Ошибка'], 404);
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
   * @return void
   */
  public function edit(int $id)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param int $id
   * @return void
   */
  public function update(Request $request, int $id)
  {
      //
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
