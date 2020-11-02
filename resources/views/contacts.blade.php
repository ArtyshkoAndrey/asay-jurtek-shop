@extends('layouts.app')
@section('title', 'Адресс и контакты')

@section('style')
  <style>
  </style>
@endsection

@section('content')

  <div class="container-fluid mt-5">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="row bg-gray align-items-center">
          <div class="col-md col-12 pl-5 py-5 py-md-0">
            <p class="text-muted mb-0">Адрес</p>
            <p class="h3 font-weight-normal">ул. Валиханова 43</p>

            <p class="text-muted mt-5 mb-0">Телефоны</p>
            <p class="h3 font-weight-normal">+ 7 (777) 777-77-77</p>

            <p class="text-muted mt-5 mb-0">Режим работы</p>
            <p class="h3 font-weight-normal">Пн - Пт 12:00 - 20:30</p>
            <p class="h3 font-weight-normal">Сб - Вс 10:00 - 18:30</p>
          </div>
          <div class="col-md col-12"><iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A728fde973e21e0ab8fec78f16f463d583fa52b0cba4e42f210328c73136ad9ba&amp;source=constructor" width="100%" height="500" frameborder="0"></iframe></div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('js')
@endsection
