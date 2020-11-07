@extends('admin.layouts.app')
@section('title', 'Магазин - Категории атрибутов')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12 col-md-auto">
        <h2>Категории атрибутов</h2>
      </div>
      <div class="col-12 col-md-auto">
        <a href="{{ route('admin.production.skus-category.create') }}" class="btn btn-dark rounded-0 border-0">Добавить новый</a>
      </div>
    </div>
    @include('admin.layouts.menu_production')
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row">
            <div class="col-auto">
              <p class="active">Все ({{count($scs)}})</p>
            </div>
            <div class="col-auto ml-auto">{{ $scs->links('vendor.pagination.bootstrap-4') }}</div>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table text-nowrap">
            <thead>
            <tr>
              <th style="">Название</th>
              <th>Опубликовано</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($scs as $sc)
              <tr class="align-items-center">
                <td style="vertical-align: middle;">
                  <a href="{{ route('admin.production.skus-category.edit', $sc->id) }}" class="text-red">
                    {{ $sc->name }}
                  </a>
                </td>
                <td style="vertical-align: middle;">
                  {{ $sc->created_at ? $sc->created_at->format('d.m.Y') : null }}
                </td>
                <td style="vertical-align: middle;">
                  <form action="{{ route('admin.production.skus-category.destroy', $sc->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" type="submit"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center">Нет категорий атрибутов</td>
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
    $(document).ready(() => {
    })
  </script>
@endsection
