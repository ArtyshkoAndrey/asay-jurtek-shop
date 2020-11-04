<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
  /**
   * @var CartService $cartService
   */
  protected $cartService;

  /**
   * OrderController constructor.
   * @param CartService $cartService
   */
  public function __construct(CartService $cartService)
  {
    parent::__construct($cartService);
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
   * @param  \Illuminate\Http\Request  $request
   * @return Response
   */
  public function store(Request $request)
  {
      //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show(int $id)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit(int $id)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request, int $id)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy(int $id)
  {
      //
  }
}
