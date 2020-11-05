@extends('admin.layouts.app')
@section('title', 'Редактирование зоны доставки')

@section('content')
  <div class="container-fluid pt-5 px-4" id="vue-app">
    <div class="row">
      <div class="col-12">
        <h2>Зона доставки</h2>
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

          @if($zone->step_cost_array !== null)

          <form action="{{ route('admin.store.express-zone.update', $zone->id) }}" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" name="method_cost" value="array_step">
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Обновить</button>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md">
                <label for="name">Наименование</label>
                <input type="text" name="name" id="name" class="form-control rounded-0 {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $zone->name }}" required>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('name') }}</span>
              </div>
              <div class="col-md">
                <label for="company_id">Компания</label>
                <select name="company_id" class="form-control rounded-0 {{ $errors->has('company_id') ? ' is-invalid' : '' }}" id="company">
                  @foreach(App\Models\ExpressCompany::get() as $company)
                    <option value="{{$company->id}}" {{$zone->company->id == $company->id ? 'selected' : null}}>{{$company->name}}</option>
                  @endforeach
                </select>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('company_id') }}</span>
              </div>
            </div>

            <div class="row align-items-end mt-2" v-for="index in step_counter">
              <div class="col-md">
                <label :for="'weight_to['+index+']'">Вес от:</label>
                <input type="number" min="0" step="0.1" :name="'weight_to['+index+']'" :id="'weight_to_'+index" class="form-control rounded-0" :value="step_cost_array[index - 1] ? step_cost_array[index - 1].weight_to : ''" required>
              </div>
              <div class="col-md">
                <label :for="'weight_from['+index+']'">Вес до:</label>
                <input type="number" min="0" step="0.1" :name="'weight_from['+index+']'" :id="'weight_from_'+index" class="form-control rounded-0" :value="step_cost_array[index - 1] ? step_cost_array[index - 1].weight_from : ''" required>
              </div>
              <div class="col-md">
                <label :for="'cost['+index+']'">Цена за промежуток:</label>
                <input type="number" min="0" :name="'cost['+index+']'" :id="'cost_'+index" class="form-control rounded-0" :value="step_cost_array[index - 1] ? step_cost_array[index - 1].cost : ''" required>
              </div>
              <div class="col-md-auto mt-2 mt-sm-0">
                <button type="button" @click="step_counter--" class="btn btn-danger rounded-0 w-100">Удаить</button>
              </div>
              <hr class="w-100">
            </div>
            <div class="row justify-content-end mt-2">
              <div class="col-md-1">
                <button type="button" @click="step_counter++" class="btn btn-dark rounded-0 w-100">Добавить</button>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <select name="city" id="city" class="form-control w-100" placeholder="Город"></select>
              </div>
              <div class="col-md-4 mt-2 mt-md-0">
                <button class="btn bg-dark rounded-0 d-block w-100" onclick="addColumn()" type="button">Добавить</button>
              </div>
            </div>
            <hr>
            <div class="row table-responsive">
              <table class="table text-nowrap">
                <thead>
                <tr>
                  <th>Город</th>
                  <th></th>
                </tr>
                </thead>
                <tbody id="tbody">
                @foreach($zone->cities as $city)
                  <tr class="align-items-center" id="city-{{ $city->id }}">
                    <td>
                      {{ $city->name }}
                    </td>
                    <td>
                      <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" onclick="onDelete({{ $city->id }})" type="button"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </form>

          @else

          <form action="{{ route('admin.store.express-zone.update', $zone->id) }}" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" name="method_cost" value="step_and_cost">
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Обновить</button>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md">
                <label for="name">Наименование</label>
                <input type="text" name="name" id="name" class="form-control rounded-0 {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $zone->name }}" required>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('name') }}</span>
              </div>
              <div class="col-md">
                <label for="cost">Стоимость</label>
                <input type="number" name="cost" id="cost" class="form-control rounded-0 {{ $errors->has('cost') ? ' is-invalid' : '' }}" value="{{ $zone->cost }}" required>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('cost') }}</span>
              </div>
              <div class="col-md">
                <label for="step">Шаг</label>
                <input type="number" name="step" id="step" class="form-control rounded-0 {{ $errors->has('step') ? ' is-invalid' : '' }}" step="0.01" value="{{ $zone->step }}" required>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('step') }}</span>
              </div>
              <div class="col-md">
                <label for="cost_step">Стоимость шага</label>
                <input type="number" name="cost_step" id="cost_step" class="form-control rounded-0 {{ $errors->has('cost_step') ? ' is-invalid' : '' }}" value="{{ $zone->cost_step }}" required>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('cost_step') }}</span>
              </div>
              <div class="col-md">
                <label for="company_id">Компания</label>
                <select name="company_id" class="form-control rounded-0 {{ $errors->has('company_id') ? ' is-invalid' : '' }}" id="company">
                  @foreach(App\Models\ExpressCompany::where('cost_type', 'Настраиваемая')->get() as $company)
                    <option value="{{$company->id}}" {{$zone->company->id == $company->id ? 'selected' : null}}>{{$company->name}}</option>
                  @endforeach
                </select>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('company_id') }}</span>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-4">
                <select name="city" id="city" class="form-control w-100" placeholder="Город"></select>
              </div>
              <div class="col-md-4 mt-2 mt-md-0">
                <button class="btn bg-dark rounded-0 d-block w-100" onclick="addColumn()" type="button">Добавить</button>
              </div>
            </div>
            <hr>
            <div class="row table-responsive">
              <table class="table text-nowrap">
                <thead>
                <tr>
                  <th>Город</th>
                  <th></th>
                </tr>
                </thead>
                <tbody id="tbody">
                @foreach($zone->cities as $city)
                  <tr class="align-items-center" id="city-{{ $city->id }}">
                    <td>
                      {{ $city->name }}
                    </td>
                    <td>
                      <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" onclick="onDelete({{ $city->id }})" type="button"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </form>

          @endif

        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    function addColumn() {
      axios.put('{{ route('admin.store.express-zone.set-city', $zone->id) }}',
        {
          city_id: $('#city').val()
        })
        .then((response) => {
          console.log(response)
          if (response.data.success === 'ok') {
            $('#tbody').prepend(
              '<tr class="align-items-center" id="city-' + $('#city').val() + '">\n' +
              '                    <td>\n' +
              '                      ' + $('#city').text() + '\n' +
              '                    </td>\n' +
              '                    <td>\n' +
              '                        <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C"onclick="onDelete(' + $('#city').val() + ')" type="button"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>\n' +
              '                    </td>\n' +
              '                  </tr>'
            )
            $('#city').val('')
            $('#city').text('')
          } else {
            swal(response, '', 'error');
          }
        })
        .catch((error) => {
          console.log(error, 123);
          for (let key in error.response.data.errors) {
            swal(error.response.data.errors[key][0], '', 'error');
          }

        });
    }

    function onDelete(index) {
      console.log(index)
      axios.post('{{ route("admin.store.express-zone.destroyCity", $zone->id) }}',
        {
          city_id: index
        }
        )
        .then((response) => {
          console.log(response)
          if (response.data.success === 'ok') {
            $('#city-'+index).remove()
          }
        })
        .catch((error) => {
          console.log(error, 123);
          for (let key in error.response.data.errors) {
            swal(error.response.data.errors[key][0], '', 'error');
          }

        });
    }

    $(document).ready(() => {
      $('#city').select2({
        placeholder: 'Город',
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
    })

      @if($zone->step_cost_array !== null)

    const app = new Vue({
        el: '#vue-app',
        data: {
          methodCost: '{{ $zone->step_cost_array !== null ? 'array_step' : 'step_and_cost'}}',
          step_counter: {{ count($zone->step_cost_array) }},
          step_cost_array: {!! json_encode($zone->step_cost_array) !!}
        },
        created () {
          console.log({!! json_encode($zone->step_cost_array) !!})

        }
      })

    @else

    @endif
  </script>
@endsection
