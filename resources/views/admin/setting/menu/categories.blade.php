@extends('admin.layouts.app')
@section('title', 'Настройки - Категории в меню')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12 col-md-auto">
        <h2>Категории в меню</h2>
      </div>
       <div class="col-12 col-md-auto">
        <a href="{{ route('admin.setting.menu-categories.create') }}" class="btn btn-dark rounded-0 border-0">Добавить новую</a>
      </div>
    </div>
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row">
            <div class="col-auto">
              <p class="active">
                Все ({{ $menu_categories->count() }})
              </p>
            </div>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table text-nowrap">
            <thead>
              <tr>
                <th>Наименование</th>
                <th>Ссылок</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            @forelse($menu_categories as $category)
              <tr class="align-items-center">
                <td style="vertical-align: middle;">
                  <a href="{{ route('admin.setting.menu-categories.edit', $category->id) }}" class="text-red">
                    {{ $category->name }}
                  </a>
                </td>
                <td style="vertical-align: middle;">
                  {{ $category->linksFilter()->count() }}
                </td>
                <td style="vertical-align: middle;">
                  <form action="{{ route('admin.setting.menu-categories.destroy', $category->id) }}" method="post" id="form-category-{{ $category->id }}">
                    @csrf
                    @method('delete')
                    <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" onclick="deleteCategory({{ $category->id }})" type="button"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="text-center">Нет категорий в меню</td>
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
    function deleteCategory(id) {
      swal({
        title: "Вы уверены?",
        text: "Если вы удалите категорию из меню, то удаляться все её дополнительные ссылки",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
        .then((willDelete) => {
          if (willDelete) {
            $('#form-category-' + id).submit();
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
