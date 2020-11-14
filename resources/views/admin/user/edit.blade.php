@extends('admin.layouts.app')
@section('title', 'Редактирование пользователя')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Пользователь {{ $user->getFSName() }}</h2>
      </div>
    </div>
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
          <form action="{{ route('admin.users.update', $user->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Обновить</button>
              </div>
            </div>
            <div class="row mt-3 justify-content-center align-items-center">
              <div class="col-md-3 col-8">
                <img src="{{ $user->getPhoto() }}" alt="{{ $user->first_name }}" class="img-fluid w-100">
              </div>
              <div class="col-md col-12">
                <div class="row flex-column">

                  <div class="col-md-6">
                    <label for="first_name">Имя</label>
                    <input type="text" name="first_name" id="first_name" class="w-100 px-2 form-control rounded-0 {{ $errors->has('first_name') ? 'is-invalid' : null }}" value="{{ old('first_name', $user->first_name) }}" required>
                    <span id="first_name-error" class="error invalid-feedback">{{ $errors->first('first_name') }}</span>
                  </div>

                  <div class="col-md-6 mt-2">
                    <label for="second_name">Фамилия</label>
                    <input type="text" name="second_name" id="second_name" class="w-100 px-2 form-control rounded-0 {{ $errors->has('second_name') ? 'is-invalid' : null }}" value="{{ old('second_name', $user->second_name) }}" required>
                    <span id="second_name-error" class="error invalid-feedback">{{ $errors->first('second_name') }}</span>
                  </div>

                  <div class="col-md-6 mt-2">
                    <label for="patronymic">Отчество</label>
                    <input type="text" name="patronymic" id="patronymic" class="w-100 px-2 form-control rounded-0 {{ $errors->has('patronymic') ? 'is-invalid' : null }}" value="{{ old('patronymic', $user->patronymic) }}" required>
                    <span id="patronymic-error" class="error invalid-feedback">{{ $errors->first('patronymic') }}</span>
                  </div>

                  <div class="col-md-12 mt-2">
                    <p><span class="font-weight-bolder">Роль</span> {{ $user->is_admin ? 'Администратор' : 'Покупатель' }}</p>
                  </div>

                </div>
              </div>
            </div>
            <div class="row">

              <div class="col-md mt-4">
                <h3>Информация</h3>
                <div class="row">
                  <div class="col-md-12">
                    <p><span class="font-weight-bolder">Email:</span> {{ $user->email}}</p>
                  </div>
                  <div class="col-md-12">
                    <p><span class="font-weight-bolder">Страна:</span> {{ $user->country ? $user->country->name : '' }}</p>
                  </div>
                  <div class="col-md-12">
                    <p><span class="font-weight-bolder">Город:</span> {{ $user->city ? $user->city->name : '' }}</p>
                  </div>
                  <div class="col-md-12">
                    <p><span class="font-weight-bolder">Адресс:</span> {{ $user->street }}</p>
                  </div>
                  <div class="col-md-12">
                    <p><span class="font-weight-bolder">Контактный телефон:</span> {{ $user->contact_phone }}</p>
                  </div>
                </div>
              </div>

              <div class="col-md mt-4">
                <h3>Заказы</h3>
                <div class="row">
                  <div class="col-md-12">
                    <p><span class="font-weight-bolder">Последни заказ:</span> {{ $user->orders->count() > 0 ? $user->orders()->orderBy('created_at', 'desc')->first()->created_at->format('d.m.Y') : 'Нет заказов'}}</p>
                  </div>
                  <div class="col-md-12">
                    <p><span class="font-weight-bolder">Кол-во заказов:</span> {{ $user->orders->count() }}</p>
                  </div>
                  <div class="col-md-12">
                    <p><span class="font-weight-bolder">Кол-во оплаченых заказов:</span> {{ $user->orders()->where('ship_status', '!=', ['cancel', 'paid'])->count() }}</p>
                  </div>
                  <div class="col-md-12">
                    <p><span class="font-weight-bolder">Общая стоимость покупок:</span> {{ App\Helpers::cost($user->orders()->where('ship_status', '!=', ['cancel', 'paid'])->sum('total_amount')) }} тг.</p>
                  </div>
                </div>
              </div>

            </div>
            @if($user->id === auth()->user()->id)
              <div class="row mt-4">
                <div class="col-12">
                  <h3>Изменить пароль</h3>
                </div>
                <div class="col-md-6">
                  <label for="password">Пароль</label>
                  <input type="password" name="password" id="password" class="w-100 px-2 form-control rounded-0 {{ $errors->has('password') ? 'is-invalid' : null }}" value="{{ old('password') }}">
                  <span id="password-error" class="error invalid-feedback">{{ $errors->first('password') }}</span>
                </div>
                <div class="col-md-6">
                  <label for="password">Повторите пароль</label>
                  <input type="password" name="password_confirmation" id="password_confirmation" class="w-100 px-2 form-control rounded-0 {{ $errors->has('password_confirmation') ? 'is-invalid' : null }}" value="{{ old('password_confirmation') }}">
                  <span id="password_confirmation-error" class="error invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
                </div>
              </div>
            @endif
          </form>
          <div class="row mt-4">
            <h3>Заказы</h3>
            <table class="table text-nowrap">
              <thead>
              <tr>
                <th>Номер заказа</th>
                <th>Клиент</th>
                <th>Дата</th>
                <th>Статус</th>
                <th>Итого</th>
                <th></th>
              </tr>
              </thead>
              <tbody>
              @forelse($user->orders as $order)
              <tr class="align-items-center">
                <td style="vertical-align: middle;"><a href="{{ route('admin.store.order.edit', $order->id) }}" class="text-red">№ {{ $order->no }}</a></td>
                <td style="vertical-align: middle;">{{ $order->user->getFSName() }}</td>
                <td style="vertical-align: middle;">{{ $order->created_at->format('d.m.Y') }}</td>
                <td style="vertical-align: middle;">{{ \App\Models\Order::$shipStatusMap[$order->ship_status] }}</td>
                <td style="vertical-align: middle;"><span class="font-weight-bold h5">{{ $order->cost($order->total_amount + $order->ship_price) }} тг.</span></td>
                <td style="vertical-align: middle;">
                  <form action="{{ route('admin.store.order.destroy', $order->id) }}" method="post" >
                    @csrf
                    @method('delete')
                    <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" type="submit"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                  </form>
                </td>
              </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center">Нет заказов</td>
                </tr>
              @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script !src="">
  </script>
@endsection
