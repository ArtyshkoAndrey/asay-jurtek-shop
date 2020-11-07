@extends('admin.layouts.app')
@section('title', 'Магазин - Товары')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12 col-md-auto">
        <h2>Товары</h2>
      </div>
      <div class="col-12 col-md-auto">
        <a href="{{ route('admin.production.products.create') }}" class="btn btn-dark rounded-0 border-0">Добавить новый</a>
      </div>
    </div>
    @include('admin.layouts.menu_production')
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row">
            <div class="col-auto">
              <a href="{{ route('admin.production.products.index', ['type' => 'all']) }}" class="{{ ($filters['type'] === null || $filters['type'] === 'all') ? 'active' : ''}}">Все ({{App\Models\Product::withTrashed()->count()}})</a>
            </div>
            <div class="col-auto">
              <a href="{{ route('admin.production.products.index', ['type' => 'publish']) }}" class="{{ $filters['type'] === 'publish' ? 'active' : ''}}">
                Опубликованные ({{App\Models\Product::count()}})
              </a>
            </div>
            <div class="col-auto"><a href="{{ route('admin.production.products.index', ['type' => 'delete']) }}" class="{{ $filters['type'] === 'delete' ? 'active' : ''}}">
                Удаленные ({{App\Models\Product::onlyTrashed()->count()}})
              </a>
            </div>
            <div class="col-auto ml-auto">{{ $products->appends($filters)->links('vendor.pagination.bootstrap-4') }}</div>
          </div>
          <div class="row align-items-center">
            <div class="col-md-auto col-12 mt-2 mt-md-0">
              <div class="form-inline">
                <select name="action" class="form-control rounded-0">
                  <option value="delete">Удалить</option>
                  <option value="edit">Редактировать</option>
                  <option value="restore">Востановить</option>
                </select>
                <button class="btn btn-dark border-0 rounded-0 ml-md-2 ml-0 mt-2 mt-md-0" id="action">Применить</button>
              </div>
            </div>
            <div class="col-md-auto col-12 mt-2 mt-md-0">
              <form action="{{ route('admin.production.products.index') }}" name="form-search" method="get">
                <div class="form-inline">
                  <input type="hidden" name="type" value="{{$filters['type']}}">
                  <input type="text" name="search" class="form-control rounded-0" placeholder="Поиск" value="{{ $filters['search'] }}">
                  <button class="btn btn-dark border-0 rounded-0 ml-md-2 ml-0 mt-2 mt-md-0" type="submit">Найти</button>
                </div>
              </form>
            </div>
            <div class="col-auto ml-auto mt-2 mt-md-0">
              <p class="mb-0">Всего {{ \App\Models\Product::withTrashed()->count() }} товаров</p>
            </div>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table text-nowrap">
            <thead>
              <tr>
                <th>
                  <label>
                    <input type="checkbox" name="check_all">
                  </label>
                </th>
                <th style="text-align: center;" class=""><i class="fa fa-camera"></i></th>
                <th style="">Название</th>
                <th>Цена</th>
                <th>Категории</th>
                <th>Опубликовано</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            @forelse($products as $product)
              <tr class="align-items-center">
                <td style="vertical-align: middle;"><input type="checkbox" meta-product-id="{{ $product->id }}" class="check-to-product"></td>
                <td style="vertical-align: middle;">
                  <img src="{{ $product->placeholder() }}" alt="{{ $product->title }}" style="height: 100px; width: auto">
                </td>
                <td style="vertical-align: middle;" class="text-wrap w-25">
                  <a href="{{ route('admin.production.products.edit', $product->id) }}" class="text-red">{{ $product->title }}</a>
                </td>
                <td style="vertical-align: middle;">
                  {{ $product->cost() }} тг.
                </td>
                <td style="vertical-align: middle;" class="text-wrap">
                  @foreach($product->categories as $index => $cat)
                    {{ $product->categories->count() == $index + 1 ? $cat->name : $cat->name . ', ' }}
                  @endforeach
                </td>
                <td style="vertical-align: middle;">
                  {{ $product->created_at->format('d.m.Y') }}
                </td>
                <td style="vertical-align: middle;">
                  <form action="{{ route('admin.production.products.destroy', $product->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" type="submit"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center">Нет продуктов</td>
              </tr>
            @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    let filters = {!! json_encode($filters) !!};
    $(document).ready(() => {
      $('input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal',
      });
      $('input[name="search"]').val(filters.search);
      $('input[name="check_all"]').on('ifChanged', function(event) {
        event.target.checked ? $('.check-to-product').iCheck('check') : $('.check-to-product').iCheck('uncheck')
      });

      $('#action').click(() => {
        let ids = []
        $('.check-to-product').each(function (el) {
          this.checked ? ids.push(Number($(this).attr('meta-product-id'))) : null
        })
        if ($('select[name="action"]').val() === 'delete' && ids.length > 0) {
          window.axios.delete('{{ route('admin.production.products.collectionsDestroy') }}', {data: {id: ids}})
            .then(response => {
              if (response.data.status === 'success') {
                document.location.reload()
                console.log(response.data)
              }
            })
            .catch(e => {
              console.log(e)
            })
        } else if ($('select[name="action"]').val() === 'edit' && ids.length === 1) {
          window.location.replace('{{ route('admin.production.products.index') }}' + '/' + ids.pop() + '/edit');
        } else if ($('select[name="action"]').val() === 'restore' && ids.length > 0) {
          window.axios.post('{{ route('admin.production.products.collectionsRestore') }}', {data: {id: ids}})
            .then(response => {
              if (response.data.status === 'success') {
                document.location.reload()
                console.log(response.data)
              }
            })
            .catch(e => {
              console.log(e)
            })
        } else {
          alert('Ни одна запись не выбрана, или выбранно более одной для редактирования')
        }
      })

    })
  </script>
@endsection
