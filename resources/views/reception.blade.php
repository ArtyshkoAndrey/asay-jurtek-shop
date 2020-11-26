@extends('layouts.app')
@section('title', 'Приём вещей')

@section('style')
  <style>
    #reception {
      background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("images/reception.jpg");
      background-size: cover;
    }
    .wrapper {
      padding: 200px 0;
    }
  </style>
@endsection

@section('content')

  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-12 text-white" id="reception">
        <div class="wrapper text-center w-100">
          <h1>Как сдать вещи в наш магазин?</h1>
          <p>Мы принимаем новую и бывшую в употреблении качественную одежду и аксессуары в хорошем состоянии, <br> не требующую ремонта и отвечающую санитарным нормам.</p>
        </div>
      </div>
    </div>
    <div class="row mt-5 mx-2 mx-md-0">
      <div class="col-md-6 mt-5 px-4">
        <div class="row">
          <div class="col-3">
            <div class="row">
              <div class="col-auto">
                <span class="btn-orange rounded-circle m-0 p-0 d-block text-center" style="width: 25px;height: 25px">1</span>
              </div>
              <div class="col pl-0">
                <img src="{{ asset('images/reception-photo.svg') }}" alt="photo">
              </div>
            </div>
          </div>
          <div class="col">
            <h4>Вышлите нам фотографии</h4>
            <p>Сфотографируйте ваши вещи и отправьте нам на Whats app или в Instagram</p>
            <div class="row">
              <div class="col-md-6">
                <a href="https://wa.me/+77714661465" class="btn btn-orange d-block">Написать в Whats app <i class="fab fa-whatsapp mx-2"></i></a>
              </div>
              <div class="col-md-6 mt-2 mt-md-0">
                <a href="https://www.instagram.com/asayjurek/" class="btn btn-orange d-block w-auto">Написать в Intstagram <i class="fab fa-instagram mx-2"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 mt-5 px-4">
        <div class="row">
          <div class="col-3">
            <div class="row">
              <div class="col-auto">
                <span class="btn-orange rounded-circle m-0 p-0 d-block text-center" style="width: 25px;height: 25px">2</span>
              </div>
              <div class="col pl-0">
                <img src="{{ asset('images/reception-search.svg') }}" alt="photo">
              </div>
            </div>
          </div>
          <div class="col">
            <h4>Мы отбираем вещи</h4>
            <p>Сфотографируйте ваши вещи и отправьте нам на Whats app или в Instagram</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 mt-5 px-4">
        <div class="row">
          <div class="col-3">
            <div class="row">
              <div class="col-auto">
                <span class="btn-orange rounded-circle m-0 p-0 d-block text-center" style="width: 25px;height: 25px">3</span>
              </div>
              <div class="col pl-0">
                <img src="{{ asset('images/reception-closhes.svg') }}" alt="photo">
              </div>
            </div>
          </div>
          <div class="col">
            <h4>Приём вещей</h4>
            <p>После отбора фотографий, вам нужно приехать в наш магазин, подписать договор и сдать вещи. При себе обязательно иметь удостоверение личности или паспорт.</p>
            <div class="row">
              <div class="col-md-auto">
                <a href="{{ asset('files/ДОГОВОР_2020.pdf') }}" download class="btn btn-orange d-block">Ознакомиться с договором <i class="fas fa-file-pdf mx-2"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 mt-5 px-4">
        <div class="row">
          <div class="col-3">
            <div class="row">
              <div class="col-auto">
                <span class="btn-orange rounded-circle m-0 p-0 d-block text-center" style="width: 25px;height: 25px">4</span>
              </div>
              <div class="col pl-0">
                <img src="{{ asset('images/reception-cost.svg') }}" alt="photo">
              </div>
            </div>
          </div>
          <div class="col">
            <h4>Оценка стоимости</h4>
            <p>Наши специалисты-товароведы  помогут назначить наиболее подходящую стоимость вещи, учитывя все факторы. Цена реализации товара включает стоимость товара с учётом комиссионного вознаграждения(от 30% - 50%)</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 mt-5 px-4">
        <div class="row">
          <div class="col-3">
            <div class="row">
              <div class="col-auto">
                <span class="btn-orange rounded-circle m-0 p-0 d-block text-center" style="width: 25px;height: 25px">5</span>
              </div>
              <div class="col pl-0">
                <img src="{{ asset('images/reception-cost.svg') }}" alt="photo">
              </div>
            </div>
          </div>
          <div class="col">
            <h4>Реализация и оплата</h4>
            <p>Мы выплачиваем вам деньги после реализации товара. Для получения своих денег, вам также необходимо иметь при себе удостоверение личности или пасспорт</p>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('js')
@endsection
