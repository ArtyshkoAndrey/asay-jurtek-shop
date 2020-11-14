@extends('admin.layouts.app')
@section('title', 'Пользователи - Список пользователей')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12 col-md-auto">
        <h2>Список пользователей</h2>
      </div>
      {{-- <div class="col-12 col-md-auto">
        <a href="{{ route('admin.users.create') }}" class="btn btn-dark rounded-0 border-0">Добавить нового</a>
      </div> --}}
    </div>
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row">
            <div class="col-auto">
              <a href="{{ route('admin.users.index', ['type' => 'all']) }}" class="{{ $type === 'all' ? 'active' : ''}}">
                Все ({{ App\Models\User::count() }})
              </a>
            </div>
            <div class="col-auto">
              <a href="{{ route('admin.users.index', ['type' => 'admin']) }}" class="{{ $type === 'admin' ? 'active' : ''}}">
                Администраторов ({{App\Models\User::where('is_admin', true)->count()}})
              </a>
            </div>
            <div class="col-auto ml-auto">{{ $users->links('vendor.pagination.bootstrap-4') }}</div>
          </div>
          <div class="row">
            <div class="col-md-auto col-12 mt-2 mt-md-0">
              <form action="{{ route('admin.users.index') }}" name="form-search" method="get">
                <div class="form-inline">
                  <input type="hidden" name="type" value="{{ $type }}">
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
              <th>Имя</th>
              <th>Страна</th>
              <th>Заказов</th>
              <th>Затраты</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
              <tr class="align-items-center">
                <td style="vertical-align: middle;">
                  <a href="{{ route('admin.users.edit', $user->id) }}" class="text-red">
                    {{ $user->getFSName() }}
                  </a>
                </td>
                <td style="vertical-align: middle;">
                  {{ $user->country->name }}
                </td>
                <td style="vertical-align: middle;">
                  {{ $user->orders->count() }} шт.
                </td>
                <td style="vertical-align: middle;">
                  {{ App\Helpers::cost($user->orders->sum('total_amount')) }} тг.
                </td>
                <td style="vertical-align: middle;">
                  <form action="{{ route('admin.users.destroy', $user->id) }}" method="post" id="form-user-{{ $user->id }}">
                    @csrf
                    @method('delete')
                    <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" onclick="deleteUser({{ $user->id }})" type="button"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center">Нет пользователей</td>
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
  function deleteUser(id) {
    swal({
      title: "Вы уверены?",
      text: "Если вы удалите пользователя, то обратно востановить не смлжете",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $('#form-user-' + id).submit();
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
