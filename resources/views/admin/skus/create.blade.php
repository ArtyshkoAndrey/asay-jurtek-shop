@extends('admin.layouts.app')
@section('title', 'Создание атрибута')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Атрибуты</h2>
      </div>
    </div>
    @include('admin.layouts.menu_production')
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
          <form action="{{ route('admin.production.attr.store') }}" method="post">
            @csrf
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Создать</button>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-4">
                <label for="name">Наименование</label>
                <input type="text" name="title" id="title" class="w-100 px-2 form-control rounded-0 {{ $errors->has('title') ? 'is-invalid' : null }}" value="{{ old('title', null) }}" required>
                <span id="name-error" class="error invalid-feedback">{{ $errors->first('title') }}</span>
              </div>
              <div class="col-md-4">
                <label for="skus_category_id">Категория</label>
                <select name="skus_category_id" id="skus_category_id"  class="w-100 px-2 form-control rounded-0 {{ $errors->has('skus_category_id') ? 'is-invalid' : null }}" required>
                  @foreach(App\Models\SkusCategory::all() as $sc)
                    <option value="{{ $sc->id }}" {{ old('skus_category_id') === $sc->id ? 'selected' : null }}>{{ $sc->name }}</option>
                  @endforeach
                </select>
                <span id="name-error" class="error invalid-feedback">{{ $errors->first('skus_category_id') }}</span>
              </div>
              <div class="col-md-4">
                <label for="name">Вес (порядок)</label>
                <input type="number" name="weight" id="weight" class="w-100 px-2 form-control rounded-0 {{ $errors->has('weight') ? 'is-invalid' : null }}" value="{{ old('weight', null) }}" required>
                <span id="name-error" class="error invalid-feedback">{{ $errors->first('weight') }}</span>
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
