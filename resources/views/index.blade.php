@extends('layouts.app')
@section('title', 'Главная')

@section('style')
  <style>
    .mt-100 {
      margin-top: 100px;
    }
    #first-big-header {
      position: relative;
      @if($header->gradient)
        background: linear-gradient({{ $header->gradient_position === 'right-to-left' ? '270deg' : '90deg' }}, {{ $header->color_gradient }} {{ (100 - $header->width) . '%' }}, rgba(209, 188, 138, 0) 100%);
      @else
          background: linear-gradient(rgba(0,0,0,0.5) 0%,rgba(0,0,0,0.5) 100%);
      @endif
      min-height: 500px;
    }
    #first-big-header::before {
      background:  url({{ asset('storage/header/'.$header->image) }}) no-repeat left top;
      background-size: cover;
      min-height: 500px;
      content: '';

      width: {{ $header->width . '%' }};

      @if($header->position === 'left')
        left: 0;
      @elseif($header->position === 'right')
        right: 0;
      @endif
      z-index: -1;
      position: absolute;
    }

    .promotion {
     min-height: 455px;
    }

    .promotion>div {
      opacity: 0;
      transition: 1s;
      background: rgba(209, 188, 138, 0.5);
    }

    .promotion:hover>div {
      opacity: 1;
    }

    @foreach($secondSections as $section)
      #secondPromotion-{{$section->id}} {
        background: url("{{ asset('storage/header/'.$section->meta->image) }}");
        background-size: cover;
      }
    @endforeach


    @media screen and (max-width: 992px) {
      .promotion>div {
        opacity: 1 !important;
      }
      .promotion {
        min-height: 400px;
      }
      #first-big-header {
        background: linear-gradient(rgba(0,0,0,0.5) 0%,rgba(0,0,0,0.5) 100%), url({{ asset('storage/header/'.$header->image) }}) no-repeat center top;
        background-size: cover;
        width: 100%;
      }
      #first-big-header::before {
        content: none;
      }
    }
  </style>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row m-0">

      <div class="col-12 d-flex align-items-center" id="first-big-header">
        <div class="row w-100 m-0 {{$header->text_center ? 'justify-content-center' : ($header->position === 'left' ? 'justify-content-end' : 'justify-content-start')}}">
          <div class="col-lg-6 text-center text-white">
            <h1 class="font-weight-bolder">{{ $header->text }}</h1>
            <p>{{ $header->description }}</p>
            <a href="{{ $header->link_btn }}" class="btn btn-transparent btn-text-white rounded-0">{{ $header->text_btn }}</a>
          </div>
        </div>
      </div>

      <div class="col-12 mt-100">
        <div class="row">
          @foreach($secondSections as $index => $section)
            <div class="col-lg-4 col-12 p-0 mt-4 {{ $index / 2 == 1 ? '' : 'pr-lg-3' }}">
              <div class="promotion h-100 h-100 d-flex" id="secondPromotion-{{$section->id}}">
                <div class="w-100 h-100 d-flex align-items-center flex-column justify-content-center">
                  <h4 class="font-weight-bolder text-center text-white h3">{{ $section->meta->title }}</h4>
                  <a href="{{ url($section->meta->link) }}" class="btn btn-transparent btn-text-white rounded-0">{{ $section->meta->btn_text }}</a>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

    </div>
  </div>

  <div class="container-fluid mt-100">
    <div class="row m-0">
      <h3>Новые товары</h3>
    </div>
    <div class="row m-0">
      @forelse($items as $item)
        <div class="col-lg-3 mt-4 col-sm-6 col-12 pl-sm-0">
          @include('layouts.item', array('item'=>$item))
        </div>
      @empty
        <div class="col-12 text-center">
          <p class="h3 font-weight-bolder">Новых товаров нет ((</p>
        </div>
      @endforelse
    </div>
  </div>

  <div class="container-fluid mt-100">
    <div class="row m-0">
      <h3>Наш блог</h3>
    </div>
    <div class="row m-0" id="full-width-news">
      @forelse($newses as $news)
{{--        <div class="col-lg-3 mt-4 col-sm-6 col-12 pl-sm-0">--}}
          @include('layouts.news', array('news'=>$news, 'slider' => true))
{{--        </div>--}}
      @empty
        <div class="col-12 text-center">
          <p class="h3 font-weight-bolder">Новостей нет</p>
        </div>
      @endforelse
    </div>
  </div>

  <div class="container-fluid mt-100">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-md-10">
        <div class="row bg-gray align-items-center">
          <div class="col-md col-12 p-0 pl-5 py-5 py-md-0">
            <p class="text-muted mb-0">Адрес</p>
            <p class="h5 font-weight-normal">ул. Валиханова 43</p>

            <p class="text-muted mt-5 mb-0">Телефоны</p>
            <p class="h5 font-weight-normal">+ 7 (777) 777-77-77</p>
            <p class="h5 font-weight-normal">+ 7 (727) 273-51-45</p>

            <p class="text-muted mt-5 mb-0">Режим работы</p>
            <p class="h5 font-weight-normal">Пн - Пт 12:00 - 20:30</p>
            <p class="h5 font-weight-normal">Сб - Вс 10:00 - 18:30</p>
          </div>
          <div class="col-md col-12 p-0"><iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A728fde973e21e0ab8fec78f16f463d583fa52b0cba4e42f210328c73136ad9ba&amp;source=constructor" width="100%" height="500" frameborder="0"></iframe></div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      resizeImgItems();
      window.onresize = () => {
        resizeImgItems();
      }
    }, false);

    function resizeImgItems() {
      let itemsImg = $('.item img');
      itemsImg.height(itemsImg.width())
    }
    $( document ).ready(function() {
      $('#full-width-news').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 2,
        cssEase: 'linear',
        arrows: false,
        responsive: [
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2,
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
            }
          }
        ]
      });
    })
  </script>
@endsection
