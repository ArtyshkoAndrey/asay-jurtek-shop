@extends('admin.layouts.app')
@section('title', 'Магазин - Атрибуты')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12 col-md-auto">
        <h2>Атрибуты</h2>
      </div>
      <div class="col-12 col-md-auto">
        <a href="{{ route('admin.production.attr.create') }}" class="btn btn-dark rounded-0 border-0">Добавить новый</a>
      </div>
    </div>
    @include('admin.layouts.menu_production')
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row">
            <div class="col-auto">
              <a href="{{ route('admin.production.attr.index') }}" class="{{ ($filters['type'] === null || $filters['type'] === 'all') ? 'active' : ''}}">Все ({{App\Models\Skus::count()}})</a>
            </div>
            <div class="col-auto">
              <a href="{{ route('admin.production.attr.index', ['type' => 'publish']) }}" class="{{ $filters['type'] === 'publish' ? 'active' : ''}}">
                Опубликованные ({{App\Models\Skus::count()}})
              </a>
            </div>
            <div class="col-auto ml-auto">{{ $skus->appends($filters)->render() }}</div>
          </div>
          <div class="row align-items-center">
            <div class="col-md-auto col-12 mt-2 mt-md-0">
              <div class="form-inline">
                <select name="action" class="form-control rounded-0">
                  <option value="delete">Удалить</option>
                  <option value="edit">Редактировать</option>
                </select>
                <button class="btn btn-dark border-0 rounded-0 ml-md-2 ml-0 mt-2 mt-md-0" id="action">Применить</button>
              </div>
            </div>
            <div class="col-md-auto col-12 mt-2 mt-md-0">
              <form action="{{ route('admin.production.attr.index') }}" name="form-search" method="get">
                <div class="form-inline">
                  <input type="hidden" name="type" value="{{$filters['type']}}">
                  <input type="text" name="search" class="form-control rounded-0" placeholder="Поиск" value="{{ $filters['search'] }}">
                  <button class="btn btn-dark border-0 rounded-0 ml-md-2 ml-0 mt-2 mt-md-0" type="submit">Найти</button>
                </div>
              </form>
            </div>
            <div class="col-auto ml-auto mt-2 mt-md-0">
              <p class="mb-0">Всего {{ \App\Models\Skus::count() }} атрибутов</p>
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
                <th style="">Название</th>
                <th>Опубликовано</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            @forelse($skus as $sku)
              <tr class="align-items-center">
                <td style="vertical-align: middle;"><input type="checkbox" meta-sku-id="{{ $sku->id }}" class="check-to-sku"></td>
                <td style="vertical-align: middle;">
                  <a href="{{ route('admin.production.attr.edit', $sku->id) }}" class="text-red">
                    {{ $sku->title }}
                  </a>
                </td>
                <td style="vertical-align: middle;">
                  {{ $sku->created_at ? $sku->created_at->format('d.m.Y') : null }}
                </td>
                <td style="vertical-align: middle;">
                  <form action="{{ route('admin.production.attr.destroy', $sku->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" type="submit"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center">Нет атрибутов</td>
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
        event.target.checked ? $('.check-to-sku').iCheck('check') : $('.check-to-sku').iCheck('uncheck')
      });
      $('#action').click(() => {
        let ids = []
        $('.check-to-sku').each(function (el) {
          this.checked ? ids.push(Number($(this).attr('meta-sku-id'))) : null
        })
        if ($('select[name="action"]').val() === 'delete' && ids.length > 0) {
          window.axios.delete('{{ route('admin.production.attr.collectionsDestroy') }}', {data: {id: ids}})
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
          window.location.replace('{{ route('admin.production.attr.index') }}' + '/' + ids.pop() + '/edit');
        } else {
          alert('Ни одна запись не выбрана, или выбранно более одной для редактирования')
        }
      })
    })
  </script>
@endsection
