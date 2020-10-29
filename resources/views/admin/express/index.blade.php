@extends('admin.layouts.app')
@section('title', 'Магазин - Товары')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12 col-md-auto">
        <h2>Доставка</h2>
      </div>
      <div class="col-12 col-md-auto">
        <a href="{{ route('admin.store.express.create') }}" class="btn btn-dark rounded-0 border-0">Добавить новый</a>
      </div>
    </div>
    @include('admin.layouts.menu_store')
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-auto ml-auto mt-2 mt-md-0">
              <p class="mb-0">Всего {{ $expresses->count() }} службы доставки</p>
            </div>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table text-nowrap">
            <thead>
            <tr>
              <th>Название доставки</th>
              <th>Стоимость</th>
              <th>Включить</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($expresses as $express)
              <tr class="align-items-center">
                <td style="vertical-align: middle;"><a href="{{ route('admin.store.express.edit', $express->id) }}" class="text-red">{{$express->name}}</a></td>
                <td style="vertical-align: middle;">{{$express->cost_type}}</td>
                <td style="vertical-align: middle;">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch{{$express->id}}" {{$express->enabled ? 'checked' : null}}>
                    <label class="custom-control-label" for="customSwitch{{$express->id}}"></label>
                  </div>
                  <form action="{{ route('admin.store.express.enabled', $express->id) }}" id="form{{$express->id}}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="number" style="display: none" name="enabled" id="checking{{$express->id}}">
                  </form>
                </td>
                <td style="vertical-align: middle;">
                  <form action="{{ route('admin.store.express.destroy', $express->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button class="bg-transparent border-0 rounded-0" style="{{ $express->id == 3 ? 'color: #898989' : 'color: #F33C3C' }}" type="submit" {{ $express->id == 3 ? 'disabled' : null }}><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                  </form></td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center">Нет заказов</td>
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
    $('.custom-control-label').click(function(evt) {
      // evt.preventDefault();
      let ch = !$('#' + $(this).attr('for')).prop("checked");
      let id = $(this).attr('for').replace(/\D+/g,"");
      $('#checking' + id).val(ch ? 1 : 0)
      console.log($('.form' + id));
      $('#form' + id).submit();
    })
  </script>
@endsection
