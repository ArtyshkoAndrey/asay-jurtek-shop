@extends('admin.layouts.app')
@section('title', 'Редактирование заказа ' . $order->user->name)

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Заказ</h2>
      </div>
    </div>
    @include('admin.layouts.menu_store')
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row">
            <div class="col-auto">
              <a href="{{ url()->previous() }}" class="h4 d-flex align-content-center"><i class="fal fa-long-arrow-left mr-2"></i> Назад</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.store.order.update', $order->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row justify-content-between">
              <div class="col-auto">
                <h3>Заказ № {{ $order->no }}</h3>
              </div>
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Обновить</button>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-lg-3 col-md-6">
                <div class="row">
                  <div class="col-12">
                    <label for="created_at">Дата заказа</label>
                  </div>
                  <div class="col-12">
                    <input type="datetime-local" name="created_at" id="created_at" class="form-control w-auto {{ $errors->has('created_at') ? ' is-invalid' : '' }}"" value="{{ old('created_at', $order->created_at->format('Y-m-d\TH:i')) }}" required>
                    <span id="created_at-error" class="error invalid-feedback">{{ $errors->first('created_at') }}</span>
                  </div>
                </div>

                <div class="row mt-2">
                  <div class="col-12">
                    <label for="ship_status">Стутас заказа</label>
                  </div>
                  <div class="col-12">
                    @if(old('ship_status', $order->ship_status) === \App\Models\Order::SHIP_STATUS_CANCEL)
                      <select name="ship_status" id="ship_status" class="form-control w-auto {{ $errors->has('ship_status') ? ' is-invalid' : '' }}" required readonly>
                        <option value="{{ old('ship_status', $order->ship_status) }}">{{ \App\Models\Order::$shipStatusMap[$order->ship_status] }}</option>
                      </select>
                    @else
                      <select name="ship_status" id="ship_status" class="form-control w-auto {{ $errors->has('ship_status') ? ' is-invalid' : '' }}" required>
                        @foreach(\App\Models\Order::SHIP_STATUS_MAP as $ship)
                          <option value="{{ $ship }}" {{ old('ship_status', $order->ship_status) === $ship ? 'selected' : '' }}>{{ \App\Models\Order::$shipStatusMap[$ship] }}</option>
                        @endforeach
                      </select>
                    @endif
                      <span id="ship_status-error" class="error invalid-feedback">{{ $errors->first('ship_status') }}</span>
                  </div>
                </div>

                <div class="row mt-2">
                  <div class="col-12">
                    <label for="user">Клиент</label>
                    <select name="user" id="user" class="form-control w-auto {{ $errors->has('user') ? ' is-invalid' : '' }}" required>
                      @foreach(\App\Models\User::all() as $user)
                        <option value="{{ old('user', $order->user->id) }}" {{ old('user', $order->user->id) === $user->id ? 'selected' : '' }}>{{ $user->getIOName() }}</option>
                      @endforeach
                    </select>
                    <span id="user-error" class="error invalid-feedback">{{ $errors->first('user') }}</span>
                  </div>
                </div>

                <div class="row mt-2">
                  <div class="col-12">
                    <label for="express_no">Трек номер</label>
                    <input type="text" name="express_no" id="express_no" class="form-control {{ $errors->has('express_no') ? ' is-invalid' : '' }}" value="{{ old('express_no', $order->ship_data ? $order->ship_data['express_no'] : null) }}">
                    <span id="express_no-error" class="error invalid-feedback">{{ $errors->first('express_no') }}</span>
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-md-6">
                <div class="row">
                  <div class="col-12">
                    <label for="address">Платежный адрес</label>
                  </div>
                  <div class="col-12">
                    <p id="address" class="text-muted">{{ $order->address['address'] }}</p>
                  </div>
                </div>

                <div class="row mt-2">
                  <div class="col-12">
                    <label for="email">Email</label>
                  </div>
                  <div class="col-12">
                    <p id="email" class="text-red">{{ $order->user->email }}</p>
                  </div>
                </div>

                <div class="row mt-2">
                  <div class="col-12">
                    <label for="phone">Телефон</label>
                  </div>
                  <div class="col-12">
                    <p id="phone" class="text-red">{{ $order->address['contact_phone']}}</p>
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-md-6">
                <div class="row">
                  <div class="col-12">
                    <label for="address">Доставка</label>
                  </div>
                  <div class="col-12">
                    <p id="address" class="text-muted">{{ $order->address['address'] }}</p>
                  </div>
                </div>

                <div class="row">
                  <div class="col-12">
                    <label for="express_company">Способ доставки</label>
                  </div>
                  <div class="col-12">
                    <p id="express_company" class="text-muted">{{ $order->expressCompany->name }}</p>
                  </div>
                </div>

                <div class="row">
                  <div class="col-12">
                    <label for="total_amount">Сумма доставки</label>
                  </div>
                  <div class="col-12">
                    <p id="total_amount" class="text-muted">{{ $order->cost($order->ship_price) }} тг.</p>
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-md-6">
                <div class="row">
                  <div class="col-12">
                    <label for="payment_method">Детали оплаты</label>
                  </div>
                  <div class="col-12">
                    <p id="payment_method" class="text-muted">{{ \App\Models\Order::$paymentMethodsMap[$order->payment_method] }}</p>
                  </div>
                </div>

                <div class="row">
                  <div class="col-12">
                    <label for="total_amount">Сумма без доставки</label>
                  </div>
                  <div class="col-12">
                    <p id="total_amount" class="text-muted">{{ $order->cost($order->total_amount) }} тг.</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-12"><h5 class="font-weight-bold">Позиции заказа</h5></div>
              <div class="col-12 px-md-4 px-0 mt-3">
                <table class="table text-nowrap table-responsive">
                  <thead align="center">
                    <tr>
                      <th class="border-top-0"></th>
                      <th class="border-top-0">Товар</th>
                      <th class="border-top-0">Цена</th>
                      <th class="border-top-0">Итого</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($order->items as $item)
                    <tr align="center">
                      <td style="width:10%; vertical-align: middle;"><img src="{{  $item->product->placeholder() }}" height="100px" alt=""></td>
                      <td style="width:20%; vertical-align: middle;" class="text-wrap font-weight-bolder">{{ $item->product->title }}</td>
                      <td style="width:20%; vertical-align: middle;">{{ $order->cost($item->price) }} тг.</td>
                      <td style="width:20%; vertical-align: middle;">{{ $order->cost($item->price) }} тг.</td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row mt-4 justify-content-lg-between px-md-4 px-0">
              <div class="col-12 col-md-auto h5">
                <span class="font-weight-bold">Доставка:</span> {{ $order->expressCompany->name }} - {{ $order->cost($order->ship_price) }} тг.
              </div>
              <div class="col-12 col-md-auto h5">
                <span class="font-weight-bold">Сумма заказа:</span> {{ $order->cost($order->total_amount + $order->ship_price) }} тг.
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')

@endsection
