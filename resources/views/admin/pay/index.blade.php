@extends('admin.layouts.app')
@section('title', 'Магазин - Оплата')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12 col-md-auto">
        <h2>Оплата</h2>
      </div>
    </div>
    @include('admin.layouts.menu_store')
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-auto ml-auto mt-2 mt-md-0">
              <p class="mb-0">Всего {{ $pays->count() }} систем оплат</p>
            </div>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table text-nowrap">
            <thead>
            <tr>
              <th>Название</th>
              <th>URL</th>
              <th>Режим</th>
              <th>Изменялось</th>
            </tr>
            </thead>
            <tbody>
            @forelse($pays as $p)
              <tr class="align-items-center">
                <td style="vertical-align: middle;"><a href="{{ route('admin.store.pay.edit', $p->id) }}" class="text-red">{{$p->name}}</a></td>
                <td style="vertical-align: middle;">{{$p->url}}</td>
                <td style="vertical-align: middle;">{{ $p->pg_testing_mode ? 'Тестовый' : 'Публичный' }}</td>
                <td style="vertical-align: middle;">{{ $p->updated_at->format('d.m.Y') }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center">Нет оплат</td>
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
  </script>
@endsection
