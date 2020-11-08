@extends('admin.layouts.app')
@section('title', 'Редактирование изображения первого сектора')

@section('css')
  <style>
    .input-file-container {
      position: relative;
      width: 225px;
    }
    .js .input-file-trigger {
      display: block;
      padding: 5px 45px;
      background: #343a40;
      color: #fff;
      font-size: 1em;
      transition: all .4s;
      cursor: pointer;
    }
    .js .input-file {
      position: absolute;
      top: 0; left: 0;
      width: 225px;
      opacity: 0;
      padding: 14px 0;
      cursor: pointer;
    }
    .js .input-file:hover + .input-file-trigger,
    .js .input-file:focus + .input-file-trigger,
    .js .input-file-trigger:hover,
    .js .input-file-trigger:focus {
      background: #34495E;
      color: red;
    }

    .file-return {
      margin: 0;
    }
    .file-return:not(:empty) {
      margin: 1em 0;
    }
    .js .file-return {
      font-style: italic;
      font-size: .9em;
      font-weight: bold;
    }
    .js .file-return:not(:empty):before {
      content: "Картинка: ";
      font-style: normal;
      font-weight: normal;
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

    @media screen and (max-width: 992px) {
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
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Первый сектор</h2>
      </div>
    </div>
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row">
            <div class="col-auto">
              <a href="{{ url()->previous() }}" class="h4 d-flex align-content-center"><i class="fal fa-long-arrow-left mr-2"></i> Назад</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.setting.first-sector.update') }}" method="post" enctype="multipart/form-data">
            <div class="row">
              @csrf
              @method('PUT')
              <div class="col-12 d-flex justify-content-end">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Обновить</button>
              </div>

              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6">
                    <label for="text_btn">Текст на кнопке</label>
                    <input type="text" name="text_btn" id="text_btn" class="form-control rounded-0 {{ $errors->has('text_btn') ? ' is-invalid' : '' }}" value="{{ old('text_btn', $header->text_btn) }}" required>
                    <span id="text_btn-error" class="error invalid-feedback">{{ $errors->first('text_btn') }}</span>
                  </div>

                  <div class="col-md-6">
                    <label for="link_btn">Ссылка на кнопке</label>
                    <input type="text" name="link_btn" id="link_btn" class="form-control rounded-0 {{ $errors->has('link_btn') ? ' is-invalid' : '' }}" value="{{ old('link_btn', $header->link_btn) }}" required>
                    <span id="link_btn-error" class="error invalid-feedback">{{ $errors->first('link_btn') }}</span>
                  </div>

                  <div class="col-md-6">
                    <label for="text">Заголовок</label>
                    <input type="text" name="text" id="text" class="form-control rounded-0 {{ $errors->has('text') ? ' is-invalid' : '' }}" value="{{ old('text', $header->text) }}" required>
                    <span id="text-error" class="error invalid-feedback">{{ $errors->first('text') }}</span>
                  </div>

                  <div class="col-md-6">
                    <label for="description">Подзаголовок</label>
                    <input type="text" name="description" id="description" class="form-control rounded-0 {{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description', $header->description) }}" required>
                    <span id="description-error" class="error invalid-feedback">{{ $errors->first('description') }}</span>
                  </div>

                  <div class="col-md-6">
                    <label for="width">Ширина картинки в секторе</label>
                    <input type="number" name="width" id="width" max="100" min="0" class="form-control rounded-0 {{ $errors->has('width') ? ' is-invalid' : '' }}" value="{{ old('width', $header->width) }}" required>
                    <span id="width-error" class="error invalid-feedback">{{ $errors->first('width') }}</span>
                  </div>

                  <div class="col-md-6">
                    <label for="color_gradient">Цвет градиента</label>
                    <input type="color" class="form-control rounded-0 {{ $errors->has('color_gradient') ? ' is-invalid' : '' }}" name="color_gradient" value="{{ old('color_gradient', $header->color_gradient) }}" id="color_gradient">
                    <span id="color_gradient-error" class="error invalid-feedback">{{ $errors->first('color_gradient') }}</span>
                  </div>

                  <div class="col-md-6">
                    <label for="image">Картинка в секторе</label>
                    <div class="input-file-container">
                      <input class="input-file" id="image" name="image" type="file">
                      <label tabindex="0" for="image" class="input-file-trigger">Выбрть картинку</label>
                    </div>
                    <span class="file-return"></span>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="row">

                  <div class="col-md-12">
                    <p class="font-weight-bolder mb-0">Направление градиента</p>
                    <div class="custom-control custom-radio">
                      <input type="radio" value="right-to-left" class="custom-control-input {{ $errors->has('gradient_position') ? ' is-invalid' : '' }}" {{ $header->gradient_position === 'right-to-left' ? 'checked' : null }} id="gradient-to-left" name="gradient_position" required>
                      <label class="custom-control-label" for="gradient-to-left">С право на лево</label>
                    </div>
                    <div class="custom-control custom-radio mb-3">
                      <input type="radio" value="left-to-right" class="custom-control-input {{ $errors->has('gradient_position') ? ' is-invalid' : '' }}" {{ $header->gradient_position === 'left-to-right' ? 'checked' : null }} id="gradient-to-right" name="gradient_position" required>
                      <label class="custom-control-label" for="gradient-to-right">С лево на право</label>
                      <div class="invalid-feedback">{{ $errors->first('gradient_position') }}</div>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <p class="font-weight-bolder mb-0">Расположение картинки</p>
                    <div class="custom-control custom-radio">
                      <input type="radio" value="left" class="custom-control-input {{ $errors->has('position') ? ' is-invalid' : '' }}" {{ $header->position === 'left' ? 'checked' : null }} id="position-to-left" name="position" required>
                      <label class="custom-control-label" for="position-to-left">С лево</label>
                    </div>
                    <div class="custom-control custom-radio mb-3">
                      <input type="radio" value="right" class="custom-control-input {{ $errors->has('position') ? ' is-invalid' : '' }}" {{ $header->position === 'right' ? 'checked' : null }} id="position-to-right" name="position" required>
                      <label class="custom-control-label" for="position-to-right">В право</label>
                      <div class="invalid-feedback">{{ $errors->first('position') }}</div>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <p class="font-weight-bolder mb-0">Наличие градиента</p>
                    <div class="custom-control custom-radio">
                      <input type="radio" value="0" class="custom-control-input {{ $errors->has('gradient') ? ' is-invalid' : '' }}" {{ $header->gradient === false ? 'checked' : null }} id="gradient-to-false" name="gradient" required>
                      <label class="custom-control-label" for="gradient-to-false">Без градиента</label>
                    </div>
                    <div class="custom-control custom-radio mb-3">
                      <input type="radio" value="1" class="custom-control-input {{ $errors->has('gradient') ? ' is-invalid' : '' }}" {{ $header->gradient === true ? 'checked' : null }} id="gradient-to-true" name="gradient" required>
                      <label class="custom-control-label" for="gradient-to-true">С градиентом</label>
                      <div class="invalid-feedback">{{ $errors->first('gradient') }}</div>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <p class="font-weight-bolder mb-0">Центровать текст</p>
                    <div class="custom-control custom-radio">
                      <input type="radio" value="0" class="custom-control-input {{ $errors->has('text_center') ? ' is-invalid' : '' }}" {{ $header->text_center === false ? 'checked' : null }} id="text_center-false" name="text_center" required>
                      <label class="custom-control-label" for="text_center-false">Не центровать</label>
                    </div>
                    <div class="custom-control custom-radio mb-3">
                      <input type="radio" value="1" class="custom-control-input {{ $errors->has('text_center') ? ' is-invalid' : '' }}" {{ $header->text_center === true ? 'checked' : null }} id="text_center-true" name="text_center" required>
                      <label class="custom-control-label" for="text_center-true">Центровать</label>
                      <div class="invalid-feedback">{{ $errors->first('text_center') }}</div>
                    </div>
                  </div>

                </div>
              </div>
              <div class="col-12 mt-3">
                <h3>Сейчас</h3>
              </div>
              <div class="col-12 d-flex align-items-center" id="first-big-header">
                <div class="row w-100 m-0 {{$header->text_center ? 'justify-content-center' : ($header->position === 'left' ? 'justify-content-end' : 'justify-content-start')}}">
                  <div class="col-lg-6 text-center text-white">
                    <h1 class="font-weight-bolder">{{ $header->text }}</h1>
                    <p>{{ $header->description }}</p>
                    <a href="{{ $header->link_btn }}" class="btn btn-transparent btn-text-white rounded-0">{{ $header->text_btn }}</a>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    document.querySelector("html").classList.add('js');

    var fileInput  = document.querySelector( ".input-file" ),
      button     = document.querySelector( ".input-file-trigger" ),
      the_return = document.querySelector(".file-return");

    button.addEventListener( "keydown", function( event ) {
      if ( event.keyCode == 13 || event.keyCode == 32 ) {
        fileInput.focus();
      }
    });
    button.addEventListener( "click", function( event ) {
      fileInput.focus();
      return false;
    });
    fileInput.addEventListener( "change", function( event ) {
      the_return.innerHTML = this.value;
    });
  </script>
@endsection
