@extends('admin.layouts.app')
@section('title', 'Магазин - Товары')

@section('css')
  <link href="https://cdn.jsdelivr.net/npm/froala-editor@3.0.6/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.css">
  <style>
    .dz-image > img {
      width: 100%;
      height: auto;
    }
    .dropzone {
      background: white;
      border-radius: 5px;
      border: 2px dashed rgb(0, 135, 247);
      border-image: none;
      max-width: 100%;
      margin-left: auto;
      margin-right: auto;
    }
  </style>
@endsection

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Товары</h2>
      </div>
    </div>
    @include('admin.layouts.menu_production')
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
          <form action="{{ route('admin.production.products.update', $product->id) }}" id="form" method="post">
            @csrf
            @method('PUT')
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Обновить</button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
                <label for="title">Наименование</label>
                <input type="text" class="form-control rounded-0 {{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" id="title" value="{{ old('title', $product->title) }}" required>
                <span id="title-error" class="error invalid-feedback">{{ $errors->first('title') }}</span>
              </div>
              <div class="col-12 ml-md-4 ml-2">
{{--                <p class="font-smaller">Ссылка: <a href="{{ route('products.show', $product->id) }}" target="_blank" class="text-red" style="text-decoration: underline">{{ route('products.show', $product->id) }}</a></p>--}}
              </div>

              <div class="col-md-8">
                <div class="row">
                  <div class="col-12">
                    <label for="description">Описание</label>
                    <textarea name="description" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" cols="30" rows="10" required>{{ old('description', $product->description) }}</textarea>
                    <span id="description-error" class="error invalid-feedback">{{ $errors->first('description') }}</span>
                  </div>
                  <div class="col-12 col-md-6 mt-2">
                    <label for="category">Категории</label>
                    <select name="category[]" class="form-control rounded-0 {{ $errors->has('category') ? ' is-invalid' : '' }}" multiple id="category">
                      @foreach($product->categories as $category)
                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                      @endforeach
                    </select>
                    <span id="category-error" class="error invalid-feedback">{{ $errors->first('category') }}</span>
                  </div>
                  <div class="col-md-6 mt-2">
                    <label for="price">Цена</label>
                    <input type="number" min="0" name="price" class="form-control rounded-0 {{ $errors->has('price') ? ' is-invalid' : '' }}" id="price" value="{{ old('price', $product->price) }}" required>
                    <span id="price-error" class="error invalid-feedback">{{ $errors->first('price') }}</span>
                  </div>
                  <div class="col-md-6 mt-2">
                    <label for="price_sale">Цена со скидкой</label>
                    <input type="number" min="0" name="price_sale" class="form-control rounded-0 {{ $errors->has('price_sale') ? ' is-invalid' : '' }}" id="price_sale" value="{{ old('price_sale', $product->price_sale) }}">
                    <span id="price_sale-error" class="error invalid-feedback">{{ $errors->first('price_sale') }}</span>
                  </div>

                  <div class="col-md-6 mt-2">
                    <label for="sex">Пол</label>
                    <select name="sex" id="sex" class="form-control rounded-0 {{ $errors->has('sex') ? ' is-invalid' : '' }}" required>
                      @foreach(\App\Models\Product::SEX_ATTR_MAP as $sex)
                        <option value="{{ $sex }}" {{ old('sex', $product->sex) === $sex ? 'selected' : null }}>{{ \App\Models\Product::$sexAttrMap[$sex] }}</option>
                      @endforeach
                    </select>
                    <span id="sex-error" class="error invalid-feedback">{{ $errors->first('sex') }}</span>
                  </div>

                  <div class="col-md-6 mt-2">
                    <label for="stock">Статус</label>
                    <input type="text" name="status" class="form-control rounded-0 {{ $errors->has('status') ? ' is-invalid' : '' }}" id="status" value="{{ old('status', $product->status) }}" required>
                    <span id="status-error" class="error invalid-feedback">{{ $errors->first('status') }}</span>
                  </div>

                  <div class="col-md-6 mt-2">
                    <label for="weight">Вес товара (кг)</label>
                    <input type="number" min="0" name="weight" step="0.01" class="form-control rounded-0" id="weight" value="{{ old('weight', $product->weight) }}" required>
                  </div>

                  {{-- Meta --}}

                  <div class="col-md-6 mt-2">
                    <label for="meta-description">Meta Description</label>
                  <input type="text" name="meta[description]" class="form-control rounded-0" id="meta-description" value="{{ isset($product->meta->description) ? $product->meta->description : '' }}">
                  </div>

                  <div class="col-md-6 mt-2">
                    <label for="meta-keywords">Meta Keywords</label>
                    <input type="text" name="meta[keywords]" class="form-control rounded-0" id="meta-keywords" value="{{ isset($product->meta->keywords) ? $product->meta->keywords : '' }}">
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-11 offset-md-1 mt-4">
                    <input type="hidden" name="on_new" id="new" value="0">
                    <input type="hidden" name="on_sale" id="sale" value="0">

                    <label>
                      <input type="checkbox" name="on_new" id="new" {{ $product->on_new ? 'checked' : null }} value="1">
                      NEW
                    </label>

                    <label class="ml-3">
                      <input type="checkbox" name="on_sale" id="sale" {{ $product->on_sale ? 'checked' : null }} value="1">
                      SALE
                    </label>

                  </div>
                  <div class="col-md-11 offset-md-1 mt-4">
                    <h4 class="font-weight-bold">Атрибуты</h4>
                    <div class="row">
                      <div class="col-12">
                        <div class="row">

                          <div class="accordion col-12" id="sc">
                            @foreach(App\Models\SkusCategory::all() as $sc)
                              <div class="card">
                                <div class="card-header" id="heading-{{ $sc->id }}">
                                  <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse-{{$sc->id}}" aria-expanded="true" aria-controls="collapse-{{$sc->id}}">
                                      {{ $sc->name }}
                                    </button>
                                  </h5>
                                </div>
                                <div id="collapse-{{$sc->id}}" class="collapse" aria-labelledby="heading-{{ $sc->id }}" data-parent="#sc">
                                  <div class="card-body">
                                    <div class="row">
                                      @foreach($sc->skuses as $sku)
                                        <div class="col-12">
                                          <div class="row mt-2">
                                            <label class="col-12">
                                              <input type="radio" value="{{ $sku->id }}" name="skus" id="skus" {{ $product->skus->id === $sku->id ? 'checked' : null }}>
                                              {{ $sku->title }}
                                            </label>
                                          </div>
                                        </div>
                                      @endforeach
                                    </div>
                                  </div>
                                </div>
                              </div>
                            @endforeach
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="row mt-3">
            <div class="col-md-8">
              <form id="upload-widget" method="post" action="{{route('admin.production.products.photo', $product->id)}}" class="dropzone"></form>
            </div>
          </div>
          <div class="row mt-3 justify-content-end">
            <div class="col-auto">
              <button class="btn btn-dark rounded-0 border-0 px-3 py-2" onclick="$('#form').submit()" type="submit">Обновить</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script src='https://cdn.tiny.cloud/1/z826n1n5ayf774zeqdphsta5v2rflavdm2kvy7xtmczyokv3/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.js"></script>
  <script>
    tinymce.init({
      selector: 'textarea',
      plugins : "paste",
      paste_text_sticky: true,
      paste_text_sticky_default: true
    });

    $('#category').select2({
      width: '100%',
      ajax: {
        type: "POST",
        dataType: 'json',
        url: function (params) {
          return '{{ route('api.category', '') }}' + '/' + params.term;
        },
        processResults: function (data) {
          return {
            results: data.items.map((e) => {
              return {
                text: e.name,
                id: e.id
              };
            })
          };
        }
      }
    });


    Dropzone.autoDiscover = false;
    var i =0;
    var fileList = new Array;
    const uploader = new Dropzone('#upload-widget', {
      init: function() {

        // Hack: Add the dropzone class to the element
        $(this.element).addClass("dropzone");

        this.on("success", function (file, serverFileName) {
          fileList[i] = {"serverFileName": serverFileName, "fileName": file.name, "fileId": i};
          i++;
        });
        this.on("removedfile", function(file) {
          var rmvFile = "";
          for(let f=0;f<fileList.length;f++){

            if(fileList[f].fileName == file.name)
            {
              rmvFile = fileList[f].serverFileName;
            }

          }

          if (rmvFile){
            console.log(rmvFile)
            axios.post("{{route('admin.production.products.photoDelete', $product->id)}}", {
              name: rmvFile
            })
            .then(response => {
              console.log(response)
            })
          }
        });
      },
      paramName: 'file',
      maxFiles: 3,
      dictDefaultMessage: 'Drag an image here to upload, or click to select one',
      headers: {
        'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
      },
      acceptedFiles: 'image/*',
      url: "{{route('admin.production.products.photo', $product->id)}}",
      renameFile: function (file) {
        return new Date().getTime() + '_' + file.name;
      },
      addRemoveLinks: true,
    });



    $(document).ready(function() {
      $('.select2-selection').css('border-radius','0px')
      $('.fr-toolbar').css('border-radius','0px')
      $('.second-toolbar').css('border-radius','0px')
      <?php $i = 0;?>
      @foreach($product->photos as $photo)
        var mockFile = { name: '{{ $photo->name }}', size: 0 };
        uploader.emit("addedfile", mockFile);
        uploader.emit("thumbnail", mockFile, '{{ asset('storage/items/') . '/' . $photo->name }}');
        uploader.emit("complete", mockFile);
        uploader.files.push(mockFile)
        fileList.push({"serverFileName": '{{ $photo->name }}', "fileName":'{{ $photo->name }}', "fileId": {{ $i }}});
        <?php $i++?>
      @endforeach
    });

  </script>
@endsection
