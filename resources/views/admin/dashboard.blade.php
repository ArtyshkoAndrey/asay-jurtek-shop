@extends('admin.layouts.app')
@section('title', 'Панель администратора')

@section('content')
  <div class="container-fluid px-4">
    <div class="row">
      <div class="col-lg-4 col-md-6 col-12 mt-5">
        <div class="card h-100 border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
          <div class="card-header">
            Работа сайта
          </div>
          <div class="card-body">
            <form action="{{ route('admin.root.status') }}" method="post">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="col-auto d-flex justify-content-center align-items-center">
                  <div class="custom-control w-100 px-5 custom-switch">
                    <input type="checkbox" name="status" class="custom-control-input" id="status" {{ App\Models\Setting::getStatusSite() ? 'checked' : null }}>
                    <label class="custom-control-label" for="status">Включить сайт</label>
                  </div>
                </div>
                <div class="col-auto">
                  <input type="submit" value="Сохранить" class="btn d-block w-100 btn-dark rounded-0">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection
