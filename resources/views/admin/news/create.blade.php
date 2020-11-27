@extends('admin.layouts.app')
@section('title', 'Создание новости')

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
        <h2>Создание новости</h2>
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
          <form action="{{ route('admin.news.store') }}" method="post">
            @csrf
            <input type="hidden" name="image" value="{{ old('image', null) }}">
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Создать</button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="title">Заголовок</label>
                <input type="text" class="form-control rounded-0 {{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" id="title" value="{{ old('title') }}" required>
                <span id="title-error" class="error invalid-feedback">{{ $errors->first('title') }}</span>
              </div>

              <div class="col-md-6">
                <label for="description">Краткое описание</label>
                <textarea name="description" id="description" class="form-control rounded-0 {{ $errors->has('description') ? ' is-invalid' : '' }}" cols="10" rows="2">{{ old('description') }}</textarea>
                <span id="description-error" class="error invalid-feedback">{{ $errors->first('description') }}</span>
              </div>

              <div class="col-md-12">
                <label for="content">Контент</label>
                <textarea name="content" id="content" class="form-control rounded-0 {{ $errors->has('content') ? ' is-invalid' : '' }}">{{ old('content') }}</textarea>
                <span id="content-error" class="error invalid-feedback">{{ $errors->first('content') }}</span>
              </div>

            </div>
          </form>
          <div class="row mt-3 justify-content-center">
            <div class="col-md-8">
              <label for="upload-widget">Фотография</label>
              <form id="upload-widget" method="post" action="{{route('admin.news.photoCreate')}}" class="dropzone"></form>
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
      selector: '#content',
      height: 500,
      paste_text_sticky: true,
      paste_text_sticky_default: true,
      relative_urls : false,
      remove_script_host : false,
      convert_urls : true,
      setup: function (editor) {
        editor.on('init change', function () {
          editor.save();
        });
      },
      plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste imagetools",
        "paste"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
      content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        '//www.tinymce.com/css/codepen.min.css'
      ],
      image_title: true,
      automatic_uploads: true,
      images_upload_url: '{{ route('admin.news.upload.tiny.image') }}',
      file_picker_types: 'image',
      file_picker_callback: function(cb, value, meta) {
        let input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.onchange = function() {
          let file = this.files[0];
          let reader = new FileReader();
          reader.readAsDataURL(file);
          reader.onload = function () {
            let id = 'blobid' + (new Date()).getTime();
            let blobCache =  tinymce.activeEditor.editorUpload.blobCache;
            let base64 = reader.result.split(',')[1];
            let blobInfo = blobCache.create(id, file, base64);
            blobCache.add(blobInfo);
            cb(blobInfo.blobUri(), { title: file.name });
          };
        };
        input.click();
      }
    });
    Dropzone.autoDiscover = false;
    Dropzone.autoDiscover = false;
    let fileList = {};
    const uploader = new Dropzone('#upload-widget', {
      maxFiles: 1,
      init: function() {
        // Hack: Add the dropzone class to the element
        $(this.element).addClass("dropzone");
        this.on("success", function (file, serverFileName) {
          fileList = {"serverFileName": file.upload.filename, "fileName": file.name};
          serverFileName = file.upload.filename;
          $('input[name="image"]').val(serverFileName)
        });
        this.on("removedfile", function(file) {
          let rmvFile = fileList.serverFileName;
          $('input[name="image"]').val(null)
          if (rmvFile){
            console.log(rmvFile)
            axios.post("{{route('admin.news.photoDelete')}}", {
              name: rmvFile
            })
              .then(response => {
                console.log(response)
              })
          }
        });
      },
      paramName: 'file',
      dictDefaultMessage: 'Перетащите фотографию или кликните по полю',
      headers: {
        'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
      },
      acceptedFiles: 'image/*',
      url: "{{route('admin.news.photoCreate')}}",
      renameFile: function (file) {
        return new Date().getTime() + '_' + file.name;
      },
      addRemoveLinks: true,
    });
    @if(old('image'))
      fileList = {"serverFileName": '{{ old('image') }}', "fileName": '{{ old('image') }}'};
      let mockFile = { name: '{{ old('image') }}', size: 0 };
      uploader.emit("addedfile", mockFile);
      uploader.emit("thumbnail", mockFile, '{{ asset('storage/news') . '/' . old('image') }}');
      uploader.emit("complete", mockFile);
      uploader.files.push(mockFile)
    @endif
  </script>
@endsection
