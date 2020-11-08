@extends('admin.layouts.app')
@section('title', 'Создание ссылки для категории ' . $category->name)

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
  </style>
@endsection

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Ссылка для категории</h2>
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
          <form action="{{ route('admin.setting.link-menu.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Создать</button>
              </div>
            </div>
            <div class="row mt-3 align-items-end">
              <div class="col-md-3">
                <label for="name">Наименование</label>
                <input type="text" name="name" id="name" class="w-100 px-2 form-control rounded-0 {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" required>
                <span id="name-error" class="error invalid-feedback">{{ $errors->first('name') }}</span>
              </div>
              <div class="col-md-3">
                <label for="link">Ссылка</label>
                <input type="text" name="link" id="link" class="w-100 px-2 form-control rounded-0 {{ $errors->has('link') ? ' is-invalid' : '' }}" value="{{ old('link') }}" required>
                <span id="link-error" class="error invalid-feedback">{{ $errors->first('link') }}</span>
              </div>

              <div class="col-md-3">
                <label for="category_id">Категория</label>
                <select name="category_id" id="category" class="w-100 px-2 form-control rounded-0 {{ $errors->has('category_id') ? ' is-invalid' : '' }}">
                  @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $category->id) === $cat->id ? 'selected' : null }}>{{ $cat->name }}</option>
                  @endforeach
                </select>
                <span id="category_id-error" class="error invalid-feedback">{{ $errors->first('category_id') }}</span>
              </div>
              <div class="col-md-3">
                <div class="input-file-container">
                  <input class="input-file" id="my-file" name="image" type="file">
                  <label tabindex="0" for="my-file" class="input-file-trigger">Выбрть картинку</label>
                </div>
                <span class="file-return"></span>
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
