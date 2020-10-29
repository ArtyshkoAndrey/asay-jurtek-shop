@extends('admin.layouts.app')
@section('title', 'Создание зоны доставки')

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

          <div data-toggle="buttons" class="btn-group btn-group-toggle ml-2">
            <label class="btn btn-white border-0 rounded-0 p-3">
              <input type="radio" value="array_step" name="method" id="method_1" v-model="methodCost" @click="()=>{ methodCost = 'array_step' }" autocomplete="off">
              Массив весов
            </label>
            <label class="btn btn-white border-0 rounded-0 p-3">
              <input type="radio" value="step_and_cost" name="method" v-model="methodCost" id="method_2" autocomplete="off" @click="()=>{ methodCost = 'step_and_cost' }">
              Шаги
            </label>
          </div>

          <form action="{{ route('admin.store.express-zone.store') }}" method="post" v-if="methodCost === 'array_step'">
            @csrf
            <input type="hidden" name="method_cost" value="array_step">
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Создать</button>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md">
                <label for="name">Наименование</label>
                <input type="text" name="name" id="name" class="form-control rounded-0 {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" required>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('name') }}</span>
              </div>
              <div class="col-md">
                <label for="company_id">Компания</label>
                <select name="company_id" class="form-control rounded-0 {{ $errors->has('company_id') ? ' is-invalid' : '' }}" id="company_id">
                  @foreach(App\Models\ExpressCompany::where('cost_type', 'Настраиваемая')->get() as $company)
                    <option value="{{$company->id}}" {{old('company_id') == $company->id ? 'selected' : null}}>{{$company->name}}</option>
                  @endforeach
                </select>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('company_id') }}</span>
              </div>
            </div>
            <div class="row align-items-end mt-2" v-for="index in step_counter">
              <div class="col-md">
                <label :for="'weight_to['+index+']'">Вес от:</label>
                <input type="number" min="0" step="0.1" :name="'weight_to['+index+']'" :id="'weight_to_'+index" class="form-control rounded-0" v-model="step_cost_array[index - 1].weight_to" required>
              </div>
              <div class="col-md">
                <label :for="'weight_from['+index+']'">Вес до:</label>
                <input type="number" min="0" step="0.1" :name="'weight_from['+index+']'" :id="'weight_from_'+index" class="form-control rounded-0" v-model="step_cost_array[index - 1].weight_from" required>
              </div>
              <div class="col-md">
                <label :for="'cost['+index+']'">Цена за промежуток:</label>
                <input type="number" min="0" :name="'cost['+index+']'" :id="'cost_'+index" class="form-control rounded-0" v-model="step_cost_array[index - 1].cost" required>
              </div>
              <div class="col-md-auto mt-2 mt-sm-0">
                <button type="button" @click="incStep(index - 1)" class="btn btn-danger rounded-0 w-100">Удаить</button>
              </div>
              <hr class="w-100">
            </div>
            <div class="row justify-content-end mt-2">
              <div class="col-md-1">
                <button type="button" @click="step_counter++" class="btn btn-dark rounded-0 w-100">Добавить</button>
              </div>
            </div>
          </form>

          <form action="{{ route('admin.store.express-zone.store') }}" method="post" v-if="methodCost === 'step_and_cost'">
            @csrf
            <input type="hidden" name="method_cost" value="step_and_cost">
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Создать</button>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md">
                <label for="name">Наименование</label>
                <input type="text" name="name" id="name" class="form-control rounded-0 {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" required>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('name') }}</span>
              </div>
              <div class="col-md">
                <label for="cost">Стоимость</label>
                <input type="number" name="cost" id="cost" class="form-control rounded-0 {{ $errors->has('cost') ? ' is-invalid' : '' }}" value="{{ old('cost')[1] }}" required>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('cost') }}</span>
              </div>
              <div class="col-md">
                <label for="step">Шаг</label>
                <input type="number" name="step" id="step" class="form-control rounded-0 {{ $errors->has('step') ? ' is-invalid' : '' }}" step="0.01" value="{{ old('step') }}" required>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('step') }}</span>
              </div>
              <div class="col-md">
                <label for="cost_step">Стоимость шага</label>
                <input type="number" name="cost_step" id="cost_step" class="form-control rounded-0 {{ $errors->has('cost_step') ? ' is-invalid' : '' }}" value="{{ old('cost_step') }}" required>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('cost_step') }}</span>
              </div>
              <div class="col-md">
                <label for="company_id">Компания</label>
                <select name="company_id" class="form-control rounded-0 {{ $errors->has('company_id') ? ' is-invalid' : '' }}" id="company_id">
                  @foreach(App\Models\ExpressCompany::where('cost_type', 'Настраиваемая')->get() as $company)
                    <option value="{{$company->id}}" {{old('company_id') == $company->id ? 'selected' : null}}>{{$company->name}}</option>
                  @endforeach
                </select>
                <span id="cost-error" class="error invalid-feedback">{{ $errors->first('company_id') }}</span>
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

    let step_cost_array = [];

    @if(old('cost') && old('method_cost') === 'array_step')
      @for($i = 1; $i <= count(old('cost')); $i++)
        step_cost_array[{{ $i - 1 }}] = {
          cost: {{old('cost')[$i] }},
          weight_to: {{old('weight_to')[$i] }},
          weight_from: {{old('weight_from')[$i] }}
        }
      @endfor
    @endif

    const app = new Vue({
      el: '#vue-app',
      data: {
        methodCost: 'array_step',
        step_counter: step_cost_array.length > 0 ? step_cost_array : [],
        step_cost_array: step_cost_array
      },
      create () {
        // if (this.step_counter > 0 && this.step_cost_array.length !== this.step_counter) {
        //
        // }
      },
      methods: {
        incStep (index) {
          this.step_cost_array.splice(index, 1);
          this.step_counter--
        }
      },
      watch: {
        step_counter: function (newVal, oldVal) {
          let costs =  this.step_cost_array.length > 0 ? this.step_cost_array.slice() : []
          if (newVal > oldVal) {
            costs.push({
              weight_to: null,
              wight_from: null,
              cost: null
            })
          }
          this.step_cost_array = costs.slice()
        }
      }
    })
  </script>
@endsection
