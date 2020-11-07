@extends('admin.layouts.app')
@section('title', 'Редактирование категории атрибутов')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Категории атрибутов</h2>
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
          <form action="{{ route('admin.production.skus-category.update', $sc->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Обновить</button>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-4">
                <label for="name">Наименование</label>
                <input type="text" name="name" id="name" class="w-100 px-2 form-control rounded-0 {{ $errors->has('name') ? 'is-invalid' : null }}" value="{{ old('name', $sc->name) }}" required>
                <span id="name-error" class="error invalid-feedback">{{ $errors->first('name') }}</span>
              </div>
            </div>
          </form>
          <hr>
          <div class="row align-items-center">
            <div class="col-12 col-md-auto">
              <a href="{{ route('admin.production.attr.create') }}" class="btn btn-dark rounded-0 border-0">Добавить новый атрибут</a>
            </div>
            <div class="col-auto ml-auto mt-2 mt-md-0">
              <p class="mb-0">Всего {{ count($sc->skuses) }} атрибутов</p>
            </div>
          </div>

          <div class="row table-responsive mt-3">
            <table class="table text-nowrap">
              <thead>
              <tr>
                <th style="">Название</th>
                <th>Опубликовано</th>
                <th></th>
              </tr>
              </thead>
              <tbody>
              @forelse($sc->skuses()->orderBy('weight', 'ASC')->get() as $sku)
                <tr class="align-items-center">
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
  </div>
@endsection

@section('js')
  <script>
    $(document).ready(() => {
    })
  </script>
@endsection
