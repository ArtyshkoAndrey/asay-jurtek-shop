@extends('admin.layouts.app')
@section('title', 'Создание компании доставки')

@section('content')
  {{--  {{ dd($errors) }}--}}
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Компания доставки</h2>
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
          <form action="{{ route('admin.store.express.store') }}" method="post">
            @csrf
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Создать</button>
              </div>
            </div>
            <div class="row mt-3 align-items-end">
              <div class="col-md-4">
                <label for="name">Наименование</label>
                <input type="text" name="name" id="name" class="w-100 px-2 form-control rounded-0 {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" required>
                <span id="name-error" class="error invalid-feedback">{{ $errors->first('name') }}</span>
              </div>
              <div class="col-md-4">
                <label for="description">Описание</label>
                <input type="text" name="description" id="description" class="w-100 px-2 form-control rounded-0 {{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}" required>
                <span id="description-error" class="error invalid-feedback">{{ $errors->first('description') }}</span>
              </div>
              <div class="col-md-2">
                <label for="min_cost">Минимальная стоимость</label>
                <input type="number" min="0" name="min_cost" id="min_cost" class="w-100 px-2 form-control rounded-0 {{ $errors->has('min_cost') ? ' is-invalid' : '' }}" value="{{ old('min_cost') }}" required>
                <span id="name-error" class="error invalid-feedback">{{ $errors->first('min_cost') }}</span>
              </div>
              <div class="col-md-2">
                <label for="cost_type">Тип стоимости</label>
                <select name="cost_type" id="cost_type" class="form-control rounded-0 {{ $errors->has('cost_type') ? ' is-invalid' : '' }}">
                  <option value="Настраиваемая" {{ old('cost_type') == 'Настраиваемая' ? 'selected' : null }}>Настраиваемая</option>
                  <option value="0 тг." {{ old('cost_type') == '0 тг.' ? 'selected' : null }}>0 тг.</option>
                </select>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('cost_type') }}</span>
              </div>
              <div class="col-auto d-flex">
                <div class="custom-control align-items-center mb-2 custom-switch">
                  <input type="checkbox" name="enabled_cash" class="custom-control-input" id="customSwitch">
                  <label class="custom-control-label" for="customSwitch">Наличные</label>
                </div>
              </div>
              <div class="col-auto d-flex">
                <div class="custom-control align-items-center mb-2 custom-switch">
                  <input type="checkbox" name="enabled_card" class="custom-control-input" id="customSwitch1">
                  <label class="custom-control-label" for="customSwitch1">Карта</label>
                </div>
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
