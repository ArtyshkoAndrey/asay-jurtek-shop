@extends('layouts.app')
@section('title', 'Адресс и контакты')

@section('style')
  <style>
  </style>
@endsection

@section('content')

  <div class="container-fluid mt-2" id="filtered">
    <div class="row justify-content-end">
      <div class="col-auto dropdown">
        <a href="#" class="text-dark dropdown-toggle text-decoration-none" role="button" id="dropdownOrderLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          @if($filter['order'] === 'sort-old')
            <i class="fas fa-sort-amount-down"></i> С начало старые
          @elseif($filter['order'] === 'sort-new')
            <i class="fas fa-sort-amount-up"></i> Сначало новые
          @elseif($filter['order'] === 'sort-expensive')
            <i class="fas fa-sort-amount-up"></i> С начало дорогие
          @elseif($filter['order'] === 'sort-cheap')
            <i class="fas fa-sort-amount-down"></i> С начало дешёвые
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-shadow rounded-0 border-0 py-3 px-4" aria-labelledby="dropdownOrderLink">
          <a href="#" role="button" onclick="orderSort('sort-old')" class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-old' ? 'active' : '' }}"><i class="fas fa-sort-amount-down"></i> С начало старые</a>
          <a href="#" role="button" onclick="orderSort('sort-new')" class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-new' ? 'active' : '' }}"><i class="fas fa-sort-amount-up"></i> С начало новые</a>
          <a href="#" role="button" onclick="orderSort('sort-expensive')" class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-expensive' ? 'active' : '' }}"><i class="fas fa-sort-amount-up"></i> С начало дорогие</a>
          <a href="#" role="button" onclick="orderSort('sort-cheap')" class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-cheap' ? 'active' : '' }}"><i class="fas fa-sort-amount-down"></i> С начало дешёвые</a>
        </div>
      </div>
    </div>
    <div class="row">
      <a href="{{ route('product.all') }}" class="link-category col-md-auto col-12 {{ $filter['p'] === 0 ? 'active' : null }} ">Все товары</a>
      @foreach(App\Models\Category::all() as $cat)
        @if($cat->parents()->count() === 0)
          <a href="{{ route('product.all', ['p'=> $cat->id]) }}" class="link-category col-md-auto col-12 {{ $filter['p'] === $cat->id ? 'active' : null }}">{{ $cat->name }}</a>
        @endif
      @endforeach
      <div class="col-12">
        <hr>
      </div>
    </div>
    <form action="{{ route('product.all') }}" method="get" id="product-all">
      <input type="hidden" value="{{ $filter['p'] }}" name="p">
      <input type="hidden" value="{{ $filter['order'] }}" name="order" id="order">
      <div class="row align-items-center">
        <div class="col-auto dropdown h-100">
          <a href="#" class="text-dark dropdown-toggle border-hover text-decoration-none {{ count($filter['sex']) > 0 ? 'font-weight-bolder' : null }}" role="button" id="dropdownSexLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Пол
          </a>
          <div class="dropdown-menu dropdown-shadow rounded-0 border-0 py-3 px-4" aria-labelledby="dropdownSexLink">
            @foreach(\App\Models\Product::SEX_ATTR_MAP as $attr)
              <div class="checkbox">
                <input type="checkbox" class="form-check-input" id="sex-{{$attr}}" name="sex[]" value="{{ $attr }}" {{ in_array($attr, $filter['sex']) ? 'checked' : null }}>
                <label class="form-check-label" for="sex-{{$attr}}">{{ \App\Models\Product::$sexAttrMap[$attr] }}</label>
              </div>

            @endforeach
          </div>
        </div>

        <div class="col-auto dropdown h-100">
          <a href="#" class="text-dark dropdown-toggle border-hover text-decoration-none {{ count($filter['category']) > 0 ? 'font-weight-bolder' : null }}" role="button" id="dropdownCategoryLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Категория
          </a>
          <div class="dropdown-menu dropdown-shadow rounded-0 border-0 py-3 px-4 overflow-auto" style="max-height: 300px; width: 250px" aria-labelledby="dropdownCategoryLink">
            @foreach(\App\Models\Category::all() as $category)
              <div class="checkbox">
                <input type="checkbox" class="form-check-input" id="category-{{$category->id}}" name="category[]" value="{{ $category->id }}" {{ in_array($category->id, $filter['category']) ? 'checked' : null }}>
                <label class="form-check-label" for="category-{{$category->id}}">{{ $category->name }}</label>
              </div>

            @endforeach
          </div>
        </div>

        <div class="col-auto dropdown h-100">
          <a href="#" class="text-dark dropdown-toggle border-hover text-decoration-none {{ count($filter['size']) > 0 ? 'font-weight-bolder' : null }}" role="button" id="dropdownSizeLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Размер
          </a>
          <div class="dropdown-menu dropdown-shadow rounded-0 border-0 py-3 px-4" aria-labelledby="dropdownSizeLink">
            @foreach(\App\Models\Skus::all() as $skus)
              <div class="checkbox">
                <input type="checkbox" class="form-check-input" id="skus-{{$skus->id}}" name="skus[]" value="{{ $skus->id }}" {{ in_array($skus->id, $filter['size']) ? 'checked' : null }}>
                <label class="form-check-label" for="skus-{{$skus->id}}">{{ $skus->title }}</label>
              </div>

            @endforeach
          </div>
        </div>
        <div class="col-md-auto">
          <button type="submit" class="btn btn-orange w-100 mt-2 mt-md-0">Применить</button>
  {{--        TODO: ОСтавляем кнопку, тут вью со списками что бы был реактивен, товары подгружать по api--}}
        </div>

        <div class="col-12">
          <hr>
        </div>
      </div>
    </form>
    <div class="row">
      @foreach($filter['sex'] as $value)
        <div class="col-auto bg-gray px-2 py-1 m-1">
          <span class="font-weight-light">{{ \App\Models\Product::$sexAttrMap[$value] }}</span>
          <button class="color-orange btn border-none" onclick="uncheckProps($('#sex-{{$value}}'))"><i class="fal fa-times"></i></button>
        </div>
      @endforeach

      @foreach($filter['category'] as $value)
        <div class="col-auto bg-gray px-2 py-1 m-1">
          <span class="font-weight-light">{{ \App\Models\Category::find($value)->name }}</span>
          <button class="color-orange btn border-none" onclick="uncheckProps($('#category-{{$value}}'))"><i class="fal fa-times"></i></button>
        </div>
      @endforeach

        @foreach($filter['size'] as $value)
          <div class="col-auto bg-gray px-2 py-1 m-1">
            <span class="font-weight-light">{{ \App\Models\Skus::find($value)->title }}</span>
            <button class="color-orange btn border-none" onclick="uncheckProps($('#skus-{{$value}}'))"><i class="fal fa-times"></i></button>
          </div>
        @endforeach
    </div>
  </div>

      </div>
    </div>
  </div>

@endsection

@section('js')
  <script>
    $("#filtered .dropdown-menu").on('click', function (event) {
      event.stopPropagation();
    });
  </script>
@endsection
