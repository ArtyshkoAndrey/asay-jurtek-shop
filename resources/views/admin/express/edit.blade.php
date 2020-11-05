@extends('admin.layouts.app')
@section('title', 'Редактирование компании доставки')

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
          <form action="{{ route('admin.store.express.update', $express->id) }}" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" value="{{ $express->enabled }}" name="enabled">
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Обновить</button>
              </div>
            </div>
            <div class="row mt-3 align-items-end">
              <div class="col-md-3">
                <label for="name">Наименование</label>
                <input type="text" name="name" id="name" class="w-100 px-2 form-control rounded-0 {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $express->name }}" required>
                <span id="name-error" class="error invalid-feedback">{{ $errors->first('name') }}</span>
              </div>
              <div class="col-md-2">
                <label for="min_cost">Минимальная стоимость</label>
                <input type="number" min="0" name="min_cost" id="min_cost" class="w-100 px-2 form-control rounded-0 {{ $errors->has('min_cost') ? ' is-invalid' : '' }}" value="{{ $express->min_cost }}" required>
                <span id="name-error" class="error invalid-feedback">{{ $errors->first('min_cost') }}</span>
              </div>
              <div class="col-md-2">
                <label for="cost_type">Тип стоимости</label>
                <select name="cost_type" id="cost_type" class="form-control rounded-0 {{ $errors->has('cost_type') ? ' is-invalid' : '' }}">
                  <option value="Настраиваемая" {{ $express->cost_type == 'Настраиваемая' ? 'selected' : null }}>Настраиваемая</option>
                  <option value="0 тг." {{ $express->cost_type == '0 тг.' ? 'selected' : null }}>0 тг.</option>
                </select>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('cost_type') }}</span>
              </div>
              <div class="col-auto d-flex">
                <div class="custom-control align-items-center mb-2 custom-switch">
                  <input type="checkbox" name="enabled_cash" {{ $express->enabled_cash ? 'checked' : '' }} class="custom-control-input" id="customSwitch">
                  <label class="custom-control-label" for="customSwitch">Наличные</label>
                </div>
              </div>
              <div class="col-md-3 align-items-end d-flex">
                <a href="{{ route('admin.store.express-zone.create') }}" class="btn bg-dark rounded-0">Создать зону</a>
              </div>
            </div>
            <hr>
            <div class="row table-responsive">
              @if(count($express->zones) > 0 && $express->zones[0]->step_cost_array === null)
                <table class="table text-nowrap">
                  <thead>
                    <tr>
                      <th>Название зоны</th>
                      <th>Цена за 0.5 кг.</th>
                      <th>Цена каждый шаг в кг.</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($express->zones as $zone)
                      <tr class="align-items-center">
                        <td>{{ $zone->name }}</td>
                        <td>{{ $express->cost($zone->cost) }} тг.</td>
                        <td>{{ $express->cost($zone->cost_step) }} тг. / {{ $zone->step }} кг.</td>
                        <td><a href="{{ route('admin.store.express-zone.edit', $zone->id) }}" class="btn btn-warning border-0 rounded-0">Редактировать</a></td>
                        <td>
  {{--                        <form action="{{ route('admin.store.express-zone.destroy', $zone->id) }}" method="post">--}}
  {{--                          @csrf--}}
  {{--                          @method('delete')--}}
                            <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" type="button" onclick="deletedZone({{ $zone->id }})"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
  {{--                        </form>--}}
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              @else
                <table class="table text-nowrap">
                  <thead>
                  <tr>
                    <th>Название зоны</th>
                    <th>Цена певого шага</th>
                    <th></th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($express->zones as $zone)
                    <tr class="align-items-center">
                      <td>{{ $zone->name }}</td>
                      <td>{{ $express->cost(count($zone->step_cost_array) > 0 ? $zone->step_cost_array[0]['cost'] : 0) }} тг.</td>
                      <td><a href="{{ route('admin.store.express-zone.edit', $zone->id) }}" class="btn btn-warning border-0 rounded-0">Редактировать</a></td>
                      <td>
                        {{--                        <form action="{{ route('admin.store.express-zone.destroy', $zone->id) }}" method="post">--}}
                        {{--                          @csrf--}}
                        {{--                          @method('delete')--}}
                        <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" type="button" onclick="deletedZone({{ $zone->id }})"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                        {{--                        </form>--}}
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              @endif
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script !src="">
    function deletedZone(id) {
      let form = document.createElement('form');
      form.action = '{{ route('admin.store.express-zone.destroy', '') }}/' + id;
      form.method = 'POST';
      $(form).append('<input type="hidden" name="_token" value="'+ $('meta[name="csrf-token"]').attr('content') +'">')
      $(form).append('<input type="hidden" name="_method" value="delete">')
// перед отправкой формы, её нужно вставить в документ
      document.body.append(form);

      form.submit();
    }
  </script>
@endsection
