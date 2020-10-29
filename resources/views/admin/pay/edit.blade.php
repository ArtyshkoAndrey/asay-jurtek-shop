@extends('admin.layouts.app')
@section('title', 'Редактирование оплаты')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Оплата</h2>
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
          <form action="{{ route('admin.store.pay.update', $p->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Обновить</button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="row mt-3">
                  <div class="col-12">
                    <label for="name">Наименование</label>
                    <input type="text" name="name" id="name" class="w-100 px-2 form-control rounded-0 {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') ? old('name') : $p->name }}" required>
                    <span id="name-error" class="error invalid-feedback">{{ $errors->first('name') }}</span>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-12">
                    <label for="pg_merchant_id">Merchant id</label>
                    <input type="number" name="pg_merchant_id" id="pg_merchant_id" class="w-100 px-2 form-control rounded-0 {{ $errors->has('pg_merchant_id') ? ' is-invalid' : '' }}" value="{{ old('pg_merchant_id') ? old('pg_merchant_id') : $p->pg_merchant_id }}" required>
                    <span id="pg_merchant_id-error" class="error invalid-feedback">{{ $errors->first('pg_merchant_id') }}</span>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-12">
                    <label for="code">Code</label>
                    <input type="text" name="code" id="code" class="w-100 px-2 form-control rounded-0 {{ $errors->has('code') ? ' is-invalid' : '' }}" value="{{ old('code') ? old('code') : $p->code }}" required>
                    <span id="code-error" class="error invalid-feedback">{{ $errors->first('code') }}</span>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-12">
                    <label for="url">URL</label>
                    <input type="text" name="url" id="url" class="w-100 px-2 form-control rounded-0 {{ $errors->has('url') ? ' is-invalid' : '' }}" value="{{ old('url') ? old('url') : $p->url }}" required>
                    <span id="url-error" class="error invalid-feedback">{{ $errors->first('url') }}</span>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-12">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" name="pg_testing_mode" id="pg_testing_mode" {{ $p->pg_testing_mode ? 'checked' : null }}>
                      <label class="custom-control-label" for="pg_testing_mode">Тест режим</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 mt-3">
                <label for="pg_description">Описание</label>
                <textarea class="form-control rounded-0" name="pg_description" id="pg_description" cols="30" rows="10">{{ old('pg_description') ? old('pg_description') : $p->pg_description }}</textarea>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script !src="">
  </script>
@endsection
