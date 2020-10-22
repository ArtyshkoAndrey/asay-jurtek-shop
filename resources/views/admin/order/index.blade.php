@extends('admin.layouts.app')
@section('title', 'Магазин - Товары')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Заказы</h2>
      </div>
    </div>
    @include('admin.layouts.menu_store')
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row">
            <div class="col-auto"><a href="{{ route('admin.store.order.index') }}" class="{{ ($type === null || $type === 'all') ? 'active' : ''}}">Все ({{App\Models\Order::count()}})</a></div>
            <div class="col-auto">
              <a href="{{ route('admin.store.order.index', ['type' => \App\Models\Order::SHIP_STATUS_PENDING]) }}" class="{{ $type === \App\Models\Order::SHIP_STATUS_PENDING ? 'active' : ''}}">
                В обработке ({{App\Models\Order::where('ship_status', \App\Models\Order::SHIP_STATUS_PENDING)->count()}})
              </a>
            </div>
            <div class="col-auto"><a href="{{ route('admin.store.order.index', ['type' => \App\Models\Order::SHIP_STATUS_RECEIVED]) }}" class="{{ $type === \App\Models\Order::SHIP_STATUS_RECEIVED ? 'active' : ''}}">
                Выполненные ({{App\Models\Order::where('ship_status', \App\Models\Order::SHIP_STATUS_RECEIVED)->count()}})
              </a>
            </div>
            <div class="col-auto"><a href="{{ route('admin.store.order.index', ['type' => \App\Models\Order::SHIP_STATUS_PAID]) }}" class="{{ $type === \App\Models\Order::SHIP_STATUS_PAID ? 'active' : ''}}">
                Оплачиваются ({{App\Models\Order::where('ship_status', \App\Models\Order::SHIP_STATUS_PAID)->count()}})
              </a>
            </div>
            <div class="col-auto"><a href="{{ route('admin.store.order.index', ['type' => \App\Models\Order::SHIP_STATUS_DELIVERED]) }}" class="{{ $type === \App\Models\Order::SHIP_STATUS_DELIVERED ? 'active' : ''}}">
                Отправленые ({{App\Models\Order::where('ship_status', \App\Models\Order::SHIP_STATUS_DELIVERED)->count()}})
              </a>
            </div>
            <div class="col-auto"><a href="{{ route('admin.store.order.index', ['type' => \App\Models\Order::SHIP_STATUS_CANCEL]) }}" class="{{ $type === \App\Models\Order::SHIP_STATUS_CANCEL ? 'active' : ''}}">
                Отменённые  ({{App\Models\Order::where('ship_status', \App\Models\Order::SHIP_STATUS_CANCEL)->count()}})
              </a>
            </div>
            <div class="col-auto ml-auto">{{ $orders->appends($filters)->render() }}</div>
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
              <form action="{{ route('admin.store.order.index') }}" name="form-time" method="get">
                <div class="form-inline">
                  <input type="hidden" name="type" value="{{$filters['type']}}">
                  <input type="hidden" name="search" value="{{$filters['search']}}">
                  <select name="time" class="form-control rounded-0">
                    <option value="all" {{ ($filters['time'] == 'all' || $filters['time'] == null) ? 'selected' : '' }}>За всё время</option>
                    <option value="year" {{ $filters['time'] == 'year' ? 'selected' : '' }}>За год</option>
                    <option value="month" {{ $filters['time'] == 'month' ? 'selected' : '' }}>За месяц</option>
                    <option value="week" {{ $filters['time'] == 'week' ? 'selected' : '' }}>За неделю</option>
                  </select>
                </div>
              </form>
            </div>
            <div class="col-md-auto col-12 mt-2 mt-md-0">
              <form action="{{ route('admin.store.order.index') }}" name="form-search" method="get">
                <div class="form-inline">
                  <input type="hidden" name="type" value="{{$filters['type']}}">
                  <input type="hidden" name="time" value="{{$filters['time']}}">
                  <input type="text" name="search" class="form-control rounded-0" placeholder="Поиск" value="{{ $filters['search'] }}">
                  <button class="btn btn-dark border-0 rounded-0 ml-md-2 ml-0 mt-2 mt-md-0" type="submit">Найти</button>
                </div>
              </form>
            </div>
            <div class="col-auto ml-auto mt-2 mt-md-0">
              <p class="mb-0">Всего {{ \App\Models\Order::all()->count() }} заказов</p>
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
              <th>Номер заказа</th>
              <th>Клиент</th>
              <th>Дата</th>
              <th>Статус</th>
              <th>Итого</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($orders as $order)
            <tr class="align-items-center">
              <td style="vertical-align: middle;"><input type="checkbox" meta-order-id="{{ $order->id }}" class="check-to-order"></td>
              <td style="vertical-align: middle;"><a href="{{ route('admin.store.order.edit', $order->id) }}" class="text-red">№ {{ $order->no }}</a></td>
              <td style="vertical-align: middle;">{{ $order->user->name }}</td>
              <td style="vertical-align: middle;">{{ $order->created_at->format('d.m.Y') }}</td>
              <td style="vertical-align: middle;">{{ \App\Models\Order::$shipStatusMap[$order->ship_status] }}</td>
              <td style="vertical-align: middle;">Валюта: тенге <br> <span class="font-weight-bold h5">{{ cost($order->total_amount + $order->ship_price) }} тг.</span></td>
              <td style="vertical-align: middle;">
                <form action="{{ route('admin.store.order.destroy', $order->id) }}" method="post">
                  @csrf
                  @method('delete')
                  <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" type="submit"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
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
    let filters = {!! json_encode($filters) !!};
    $(document).ready(() => {
      $('input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal',
      });
      $('select[name="time"]').val(filters.time);
      $('input[name="search"]').val(filters.search);
      $('select[name="time"]').on('change', function() {
        $('form[name="form-time"]').submit();
      });

      $('input[name="check_all"]').on('ifChanged', function(event) {
        event.target.checked ? $('.check-to-order').iCheck('check') : $('.check-to-order').iCheck('uncheck')
      });

      $('#action').click(() => {
        let ids = []
        $('.check-to-order').each(function (el) {
          this.checked ? ids.push(Number($(this).attr('meta-order-id'))) : null
        })
        if ($('select[name="action"]').val() === 'delete' && ids.length > 0) {
          window.axios.delete('{{ route('admin.store.order.collectionsDestroy') }}', {data: {id: ids}})
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
          window.location.replace('{{ route('admin.store.order.index') }}' + '/' + ids.pop() + '/edit');
        } else {
          alert('Ни одна запись не выбрана, или выбранно более одной для редактирования')
        }
      })

    })
  </script>
@endsection
