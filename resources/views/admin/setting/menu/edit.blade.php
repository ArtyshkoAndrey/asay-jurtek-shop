@extends('admin.layouts.app')
@section('title', 'Настройки - Категории в меню')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12 col-md-auto">
        <h2>Ссылки в категории {{ $category->name }}</h2>
      </div>
      <div class="col-12 col-md-auto">
        <a href="{{ route('admin.setting.link-menu.create', ['category_id' => $category->id]) }}" class="btn btn-dark rounded-0 border-0">Добавить новую ссылку</a>
      </div>
    </div>
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row">
            <div class="col-auto">
              <p class="active">
                Все ({{ $links->count() }})
              </p>
            </div>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table text-nowrap">
            <thead>
              <tr>
                <th>Наименование</th>
                <th>Ссылка</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            @forelse($links as $link)
              <tr class="align-items-center">
                <td style="vertical-align: middle;">
                  <a href="{{ route('admin.setting.link-menu.edit', $link->id) }}" class="text-red">
                    {{ $link->name }}
                  </a>
                </td>
                <td style="vertical-align: middle;">
                  {{ $link->link }}
                </td>
                <td style="vertical-align: middle;">
                  <form action="{{ route('admin.setting.link-menu.destroy', $link->id) }}" method="post" id="form-link-{{ $link->id }}">
                    @csrf
                    @method('delete')
                    <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" onclick="deleteLink({{ $link->id }})" type="button"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="text-center">Нет ссылок в категории</td>
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
    function deleteLink(id) {
      swal({
        title: "Вы уверены?",
        text: "Если вы удалите ссылку, то вернуть данные будет невозможным!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
        .then((willDelete) => {
          if (willDelete) {
            $('#form-link-' + id).submit();
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
