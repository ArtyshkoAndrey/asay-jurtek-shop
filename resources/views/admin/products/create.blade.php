@extends('admin.layouts.app')
@section('title', 'Магазин - Товары')

@section('css')
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
          <form action="{{ route('admin.production.products.store') }}" method="post">
            @csrf
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Создать</button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
                <label for="title">Наименование</label>
                <input type="text" class="form-control rounded-0 {{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" id="title" value="{{ old('title') }}" required>
                <span id="title-error" class="error invalid-feedback">{{ $errors->first('title') }}</span>
              </div>
              <div class="col-12">

              </div>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-12">
                    <label for="description">Описание</label>
                    <textarea name="description" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
                    <span id="description-error" class="error invalid-feedback">{{ $errors->first('description') }}</span>
                  </div>
                  <div class="col-12 mt-2">
                    <label for="history">История вещи</label>
                    <textarea name="history" class="form-control {{ $errors->has('history') ? ' is-invalid' : '' }}" id="history" cols="30" rows="10">{{ old('history') }}</textarea>
                    <span id="history-error" class="error invalid-feedback">{{ $errors->first('history') }}</span>
                  </div>
                  <div class="col-12 col-md-6 mt-2">
                    <label for="category">Категории</label>
                    <select name="category[]" class="form-control rounded-0 {{ $errors->has('category') ? ' is-invalid' : '' }}" multiple id="category" required>
                      @if (old('category'))
                        @foreach(old('category') as $id)
                          <option value="{{ $id }}" selected>{{ App\Models\Category::find($id)->name }}</option>
                        @endforeach
                      @endif
                    </select>
                    <span id="category-error" class="error invalid-feedback">{{ $errors->first('category') }}</span>
                  </div>
                  <div class="col-md-6 mt-2">
                    <label for="price">Цена</label>
                    <input type="number" min="0" name="price" class="form-control rounded-0 {{ $errors->has('price') ? ' is-invalid' : '' }}" id="price" required value="{{ old('price') }}">
                    <span id="price-error" class="error invalid-feedback">{{ $errors->first('price') }}</span>
                  </div>
                  <div class="col-md-6 mt-2">
                    <label for="price_sale">Цена со скидкой</label>
                    <input type="number" min="0" name="price_sale" class="form-control rounded-0 {{ $errors->has('price_sale') ? ' is-invalid' : '' }}" id="price_sale" value="{{ old('price_sale') }}">
                    <span id="price_sale-error" class="error invalid-feedback">{{ $errors->first('price_sale') }}</span>
                  </div>

                  <div class="col-md-6 mt-2">
                    <label for="sex">Пол</label>
                    <select name="sex" id="sex" class="form-control rounded-0 {{ $errors->has('sex') ? ' is-invalid' : '' }}" required>
                      @foreach(\App\Models\Product::SEX_ATTR_MAP as $sex)
                        <option value="{{ $sex }}" {{ old('sex') === $sex ? 'selected' : null }}>{{ \App\Models\Product::$sexAttrMap[$sex] }}</option>
                      @endforeach
                    </select>
                    <span id="sex-error" class="error invalid-feedback">{{ $errors->first('sex') }}</span>
                  </div>



                  <div class="col-md-6 mt-2">
                    <label for="status">Статус</label>
                    <input type="text" name="status" class="form-control rounded-0 {{ $errors->has('status') ? ' is-invalid' : '' }}" id="status" value="{{ old('status') }}">
                    <span id="status-error" class="error invalid-feedback">{{ $errors->first('status') }}</span>
                  </div>

                  <div class="col-md-6 mt-2">
                    <label for="weight">Вес товара (кг)</label>
                    <input type="number" min="0" name="weight" step="0.01" class="form-control rounded-0 {{ $errors->has('weight') ? ' is-invalid' : '' }}" id="weight" value="{{ old('weight') }}">
                    <span id="weight-error" class="error invalid-feedback">{{ $errors->first('weight') }}</span>
                  </div>

                  {{-- Meta --}}

                  <div class="col-md-6 mt-2">
                    <label for="meta-description">Meta Description</label>
                    <input type="text" name="meta[description]" class="form-control rounded-0 {{ $errors->has('meta') ? ' is-invalid' : '' }}" id="meta-description" value="{{ old('meta')["description"] }}">
                    <span id="meta1-error" class="error invalid-feedback">{{ $errors->first('meta') }}</span>
                  </div>

                  <div class="col-md-6 mt-2">
                    <label for="meta-keywords">Meta Keywords</label>
                    <input type="text" name="meta[keywords]" class="form-control rounded-0 {{ $errors->has('meta') ? ' is-invalid' : '' }}" id="meta-keywords" value="{{ old('meta')["keywords"] }}">
                    <span id="meta2-error" class="error invalid-feedback">{{ $errors->first('meta') }}</span>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-11 offset-md-1 mt-4">

                    <input type="hidden" name="on_new" id="new" value="0">
                    <input type="hidden" name="on_sale" id="sale" value="0">

                    <label>
                      <input type="checkbox" name="on_new" id="new" value="1" {{ old('on_new') ? 'checked' : null }}>
                      NEW
                    </label>

                    <label class="ml-3">
                      <input type="checkbox" name="on_sale" id="sale" value="1" {{ old('on_sale') ? 'checked' : null }}>
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
                                          <input type="radio" value="{{ $sku->id }}" name="skus" id="skus" {{ $sku->id == old('skus') ? 'checked' : null }}>
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
                      <input type="hidden" name="photo[0]" value="{{ old('photo') ? old('photo')[0] : null }}">
                      <input type="hidden" name="photo[1]" value="{{ old('photo') ? old('photo')[1] : null }}">
                      <input type="hidden" name="photo[2]" value="{{ old('photo') ? old('photo')[2] : null }}">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="row mt-3">
            <div class="col-md-8">
              <form id="upload-widget" method="post" action="{{route('admin.production.products.photoCreate')}}" class="dropzone"></form>
            </div>
            <div class="col-12">
              <p class="small">Рекомендуем использовать раличные наименования файлов перед отправкой</p>
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
    // let editor = new FroalaEditor('textarea')
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
          fileList[i] = {"serverFileName": file.upload.filename, "fileName": file.name, "fileId": i};
          console.log(serverFileName)
          if ($('input[name="photo['+ i +']"]').val() === '') {
            $('input[name="photo[' + i + ']"]').val(serverFileName)
          } else {
            if (i === 2) {
              $('input[name="photo[1]"]').val() === '' ? $('input[name="photo[1]"]').val(serverFileName) : $('input[name="photo[0]"]').val() === '' ? $('input[name="photo[0]"]').val(serverFileName) : console.error('Error', i)
            } else if (i === 1) {
              $('input[name="photo[2]"]').val() === '' ? $('input[name="photo[2]"]').val(serverFileName) : $('input[name="photo[0]"]').val() === '' ? $('input[name="photo[0]"]').val(serverFileName) : console.error('Error', i)
            } else if (i === 0) {
              $('input[name="photo[1]"]').val() === '' ? $('input[name="photo[1]"]').val(serverFileName) : $('input[name="photo[2]"]').val() === '' ? $('input[name="photo[2]"]').val(serverFileName) : console.error('Error', i)
            }

          }

          i++;
        });
        this.on("removedfile", function(file) {
          var rmvFile = "";
          for(let f=0;f<fileList.length;f++){

            if(fileList[f].fileName === file.name)
            {
              rmvFile = fileList[f].serverFileName;
              fileList.splice(f, 1);
              i = fileList.length;
              $('input[value="'+ rmvFile +'"]').val(null)
              break;
            }

          }
          console.log(fileList)

          if (rmvFile){
            console.log(rmvFile)
            axios.post("{{route('admin.production.products.photoDeleteCreate')}}", {
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
      url: "{{route('admin.production.products.photoCreate')}}",
      renameFile: function (file) {
        let newName = new Date().getTime() + '_' + file.name;
        return newName;
      },
      addRemoveLinks: true,
    });



    $(document).ready(function() {
      $('.select2-selection').css('border-radius', '0px')
      $('.fr-toolbar').css('border-radius', '0px')
      $('.second-toolbar').css('border-radius', '0px')
      <?php $i = 0;?>
      let mockFile;

      @foreach(old('photo', []) as $photo)
        @if ($photo != null)
          mockFile = {name: '{{ $photo }}', size: 0};
          uploader.emit("addedfile", mockFile);
          uploader.emit("thumbnail", mockFile, '{{ asset('storage/items/') . '/' . $photo }}');
          uploader.emit("complete", mockFile);
          uploader.files.push(mockFile)
          fileList.push({"serverFileName": '{{ $photo }}', "fileName": '{{ $photo }}', "fileId": {{ $i }}});
          <?php $i++?>
        @endif
      @endforeach
    })
  </script>
  {{-- <script>
    $('#title').val('Test')
    $('#description').val('Test')
    $('#category').val(23)
    $('#price').val(100)
    $('#stock').val(10)
    $('#weight').val(1)
    $('#meta-description').val('Meta Desc')
    $('#meta-keywords').val('Meta Key')
  </script> --}}
@endsection
