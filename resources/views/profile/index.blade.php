@extends('layouts.app')
@section('title', 'Личный кабинет')

@section('style')
  <style>
  </style>
@endsection

@section('content')

  <section class="container-fluid py-5" id="profile">
    <div class="card rounded-0 px-0">
      <div class="card-body px-0 py-0 rounded-0">
        <div class="row mx-0">
          <div class="col-md-3 bg-gray m-0 p-0">
            <div class="nav flex-column nav-pills h-100 m-0" role="tablist" aria-orientation="vertical">
              <a class="nav-link active border-0 rounded-0 py-4" href="{{ route('profile.index') }}" aria-selected="true"><i class="fal fa-user pr-1"></i> Мой профиль</a>
              <a class="nav-link border-0 rounded-0 py-4" href="{{ route('order.orders') }}" aria-selected="true"><i class="fal fa-tasks pr-1"></i> Мои заказы</a>
            </div>
          </div>
          <div class="col-md-9 p-4">
            <div class="row">
              <div class="col-12">
                <h3 class="font-weight-bold">Мой профиль</h3>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-3">
                <img src="{{ $user->getPhoto() }}" class="img-fluid w-100 px-4 px-md-0" alt="{{ $user->first_name }}">
                <form action="{{ route('profile.update.photo') }}" method="POST" id="form-photo" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <input type="file" id="photo" name="photo" size="chars" accept="image/jpeg,image/png" style="visibility: hidden">
                  <button type="button" class="btn btn-dark position-absolute" id="add-photo">
                    <i class="fal fa-camera"></i>
                  </button>
                </form>
              </div>
              <div class="col-md-9 pl-md-5 pl-0 px-3 mt-4 mt-md-0">
                <h4 class="font-weight-bold">{{ $user->getFSName() }}</h4>
                  <p class="font-weight-light mb-0">{{ $user->getFullAddress() }}</p>
                  <p class="font-weight-light mb-0">Валюта: {{ $user->currency->name }}</p>
                  <p class="font-weight-light mb-0">{{ $user->contact_phone }}</p>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-4 px-3 px-md-2">
                <div class="row">
                  <div class="col-12">
                    <h4 class="font-weight-bold">Сменить пароль</h4>
                  </div>
                  <div class="col-12">
                    <form action="{{ route('profile.update.password') }}" method="POST">
                      @csrf
                      @method('PUT')
                      <input type="password" name="password" class="form-control mb-4 rounded-0" placeholder="Новый пароль">
                      <input type="password" name="password_confirmation" class="form-control mb-4 rounded-0" placeholder="Повторите пароль">
                      <button type="submit" class="btn btn-dark m-0 rounded-0">Сохранить</button>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-md-8 px-3 px-md-2 mt-4 mt-md-0">
                <div class="row">
                  <div class="col-12">
                    <h4 class="font-weight-bold">Настройки профиля</h4>
                  </div>
                  <div class="col-12">
                    <form action="{{ route('profile.update') }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="row">
                        <div class="col-md-6 col-12">
                          <input type="text" name="first_name" class="form-control mb-4 rounded-0" placeholder="Имя" value="{{ old('first_name', $user->first_name) }}" required>
                          @if ($errors->has('first_name'))
                            <span class="text-danger">{{ $errors->first('first_name') }}</span>
                          @endif
                        </div>

                        <div class="col-md-6 col-12">
                          <input type="text" name="second_name" class="form-control mb-4 rounded-0" placeholder="Фамилия" value="{{ old('second_name', $user->second_name) }}" required>
                          @if ($errors->has('second_name'))
                            <span class="text-danger">{{ $errors->first('second_name') }}</span>
                          @endif
                        </div>

                        <div class="col-md-6 col-12">
                          <input type="text" name="patronymic" class="form-control mb-4 rounded-0" placeholder="Отчество" value="{{ old('patronymic', $user->patronymic) }}">
                          @if ($errors->has('patronymic'))
                            <span class="text-danger">{{ $errors->first('patronymice') }}</span>
                          @endif
                        </div>

                        <div class="col-md-6 col-12">
                          <input type="text" class="form-control mb-4 rounded-0" name="contact_phone" placeholder="Номер телефона" value="{{ old('contact_phone', $user->contact_phone) }}" required>
                          @if ($errors->has('contact_phone'))
                            <span class="text-danger">{{ $errors->first('contact_phone') }}</span>
                          @endif
                        </div>
                        <div class="col-md-6 col-12">
                          <input type="email" class="form-control mb-4 rounded-0" name="email" placeholder="Email" value="{{ old('email', $user->email) }}" required>
                          @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                          @endif
                        </div>
                        <div class="col-md-6 col-12">
                          <select class="form-control mb-4 rounded-0" name="currency" placeholder="Валюта">
                            @foreach($currencies as $currencyProfile)
                              @if($user->currency->id == $currencyProfile->id)
                                <option selected value="{{ $currencyProfile->id }}">{{ $currencyProfile->name }}</option>
                              @else
                                <option  value="{{ $currencyProfile->id }}">{{ $currencyProfile->name }}</option>
                              @endif
                            @endforeach
                          </select>
                          @if ($errors->has('currency'))
                            <span class="text-danger">{{ $errors->first('currency') }}</span>
                          @endif
                        </div>
                        <div class="col-md-6 col-12 mb-4">
                          <select id="country" name="country" class="rounded-0 w-100 h-100 form-control">
                            @if(isset($user->country))
                              <option value="{{ $user->country->id }}" selected>{{ $user->country->name }}</option>
                            @endif
                          </select>
                          @if ($errors->has('country'))
                            <span class="text-danger">{{ $errors->first('country') }}</span>
                          @endif
                        </div>
                        <div class="col-md-6 col-12 mb-4">
                          <select id="city" name="city" class="w-100 h-100 form-control rounded-0">
                            @if($user->city))
                              <option value="{{ $user->city->id }}" selected>{{ $user->city->name }}</option>
                            @endif
                          </select>
                        </div>
                        <div class="col-12">
                          <input type="text" class="form-control mb-0 rounded-0" name="street" placeholder="Улица, индекс" value="{{ old('street', $user->street) }}" required>
                          <small class="form-text text-muted">Пример: ул. Ленина, 111 кв. 666, 143080 (индекс)</small>
                          @if ($errors->has('street'))
                            <span class="text-danger">{{ $errors->first('street') }}</span>
                          @endif
                        </div>
                      </div>
                      <button type="submit" class="btn btn-dark m-0 rounded-0">Сохранить</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection

@section('js')
  <script>
    $(document).ready(function() {
      // $('input[name=contact_phone]').mask("+7 (999) 999-99-99");
      $('#city').select2({
        ajax: {
          type: "POST",
          dataType: 'json',
          url: function (params) {
            return '{{ route('api.city', '') }}' + '/' + params.term;
          },
          processResults: function (data) {
            return {
              results: data.items.map((e) => {
                return {
                  text: e.name,
                  id: e.id
                };
              })
            };
          }
        }
      });
      $('#country').select2({
        ajax: {
          type: "POST",
          dataType: 'json',
          url: function (params) {
            return '{{ route('api.country', '') }}' + '/' + params.term;
          },
          processResults: function (data) {
            return {
              results: data.items.map((e) => {
                return {
                  text: e.name,
                  id: e.id
                };
              })
            };
          }
        }
      });
      $('#add-photo').click(() => {
        $('#photo').click();
      });
      $("#photo").change(() => {
        swal({
          title: "Вы уверены?",
          text: "Данные действия обновят фотографию профиля!",
          icon: "info",
          buttons: {
            success: "Да, обноить!",
            cancle: {
              text: "Нет!",
              value: "cancle",
              className: "btn-danger"
            }
          },
          dangerMode: true,
        })
          .then((answer) => {
            switch (answer) {
              case "success":
                swal("Фотография обновлена!", 'success');
                $('#form-photo').submit()
                break;
              case "cancle":
                swal("Действик отменено", 'info');
                break;
              default:
                swal("Действик отменено", 'info');
            }
          })
      });
    });
  </script>
@endsection
