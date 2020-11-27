@extends('admin.layouts.app')
@section('title', 'Новости')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12 col-md-auto">
        <h2>Список новостей</h2>
      </div>
       <div class="col-12 col-md-auto">
        <a href="{{ route('admin.news.create') }}" class="btn btn-dark rounded-0 border-0">Добавить новую</a>
      </div>
    </div>
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row">
            <div class="col-auto">
              <p>
                Всего ({{ App\Models\News::count() }})
              </p>
            </div>
            <div class="col-auto ml-auto">{{ $newses->links('vendor.pagination.bootstrap-4') }}</div>
          </div>
          <div class="row">
            <div class="col-md-auto col-12 mt-2 mt-md-0">
              <form action="{{ route('admin.news.index') }}" name="form-search" method="get">
                <div class="form-inline">
                  <input type="text" name="search" class="form-control rounded-0" placeholder="Поиск" value="{{ $search }}">
                  <button class="btn btn-dark border-0 rounded-0 ml-md-2 ml-0 mt-2 mt-md-0" type="submit">Найти</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table text-nowrap">
            <thead>
            <tr>
              <th>Фотография</th>
              <th>Заголовок</th>
              <th>Создано</th>
              <th>Обновлено</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($newses as $news)
              <tr class="align-items-center">
                <td style="vertical-align: middle;">
                  <img src="{{ asset('storage/news/'.$news->image) }}" style="max-height: 100px ;" class="img-fluid" alt="{{ $news->title }}">
                </td>
                <td style="vertical-align: middle;">
                  <a href="{{ route('admin.news.edit', $news->id) }}" class="text-red">
                    {{ $news->title }}
                  </a>
                </td>
                <td style="vertical-align: middle;">
                  {{ $news->created_at->format('d.m.Y') }}
                </td>
                <td style="vertical-align: middle;">
                  {{ $news->updated_at->format('d.m.Y') }}
                </td>
                <td style="vertical-align: middle;">
                  <form action="{{ route('admin.news.destroy', $news->id) }}" method="post" id="form-news-{{ $news->id }}">
                    @csrf
                    @method('delete')
                    <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" onclick="deleteNews({{ $news->id }})" type="button"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center">Нет новостей</td>
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
    function deleteNews(id) {
      swal({
        title: "Вы уверены?",
        text: "Если вы удалите новость, то обратно востановить не сможете",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
        .then((willDelete) => {
          if (willDelete) {
            $('#form-news-' + id).submit();
          } else {

          }
        });
    }
  </script>
  <script>
    $(document).ready(() => {
    })
  </script>
@endsection
