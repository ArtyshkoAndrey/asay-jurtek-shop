@extends('admin.layouts.app')
@section('title', 'Настройки - Категории в меню')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12 col-md-auto">
        <h2>Вторые секции</h2>
      </div>
    </div>
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row">
            <div class="col-auto">
              <p class="active">
                Все ({{ $settings->count() }})
              </p>
            </div>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table text-nowrap">
            <thead>
              <tr>
                <th>Заголовок</th>
                <th>Ссылка</th>
              </tr>
            </thead>
            <tbody>
            @forelse($settings as $setting)
              <tr class="align-items-center">
                <td style="vertical-align: middle;">
                  <a href="{{ route('admin.setting.second-section.edit', $setting->id) }}" class="text-red">
                    {{ $setting->meta->title }}
                  </a>
                </td>
                <td style="vertical-align: middle;">
                  {{ $setting->meta->link }}
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="2" class="text-center">Нет секций</td>
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
