@extends('admin.layouts.app')
@section('title', 'Редактирование меню')

@section('content')
  <div class="container-fluid pt-5 px-4" id="headerApp">
    <div class="row">
      <div class="col-12">
        <h2>Настроки меню</h2>
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
          <form action="{{ route('admin.setting.menu.update', $setting->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="button" @click="save()">Обновить</button>
              </div>
            </div>
            <div class="row mt-3 ">
              <div class="col-12">
                <div class="row">
                  <div class="col">
                    <h3 class="d-flex">Категории в меню</h3>
                  </div>
                  <div class="col justify-content-end d-flex">
                    <button class="btn btn-dark rounded-0" type="button" @click="addCategory()" >Добавить категорию</button>
                  </div>
                </div>
              </div>
              <div class="col-12" v-for="(category, index) in categories">
                <div class="row">
                  <div class="col-md-6 mt-2">
                    <label for="categories[]">Категория</label>
                    <select name="categories[]" v-model="category.id" id="category-1" class="form-control rounded-0 category">
                      @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-6 mt-md-4 pt-md-2">
                    <div class="row">
                      <div class="col-12">
                        <button class="btn btn-dark rounded-0" type="button" @click="addItemInCategory(category)">Добавить ссылку</button>
                      </div>
                      <div class="col-12">
                        <div class="row" v-for="item in category.items">
                          <div class="col-md-12 mt-2">
                            <label for="photos[]">Фотография</label>
                            <input name="photos[]" type="file" @change="handleFileChange($event, item)" id="" class="form-control-file rounded-0" accept="image/webp, image/jpeg, image/png">
                          </div>
                          <div class="col-12 mt-2">
                            <label for="names[]">Наименование (Текст)</label>
                            <input for="names[]" class="form-control rounded-0" type="text" v-model="item.name">
                          </div>
                          <div class="col-12 mt-2">
                            <label for=links[]">Ссылка</label>
                            <input for="links[]" type="text" class="form-control rounded-0" v-model="item.link">
                          </div>
                        </div>
                      </div>
                    </div>
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
  <script !src="">
    // $('.category').select2({
    //   width: '100%',
    //   placeholder: "Категория",
    //   ajax: {
    //     type: "POST",
    //     dataType: 'json',
    //     url: function (params) {
    //       return '{{ route('api.category', '') }}' + '/' + params.term;
    //     },
    //     processResults: function (data) {
    //       return {
    //         results: data.items.map((e) => {
    //           return {
    //             text: e.name,
    //             id: e.id
    //           };
    //         })
    //       };
    //     }
    //   }
    // });

    const app = new Vue({
        el: '#headerApp',
        data: {
          categories: [],
        },
        mounted () {
          this.categories = {!! json_encode($setting->meta->categories) !!}
          console.log(this.categories)
        },
        methods: {
          addCategory () {
            let obj = {
              id: null,
              items: []
            }
            this.categories.push(obj)
          },
          addItemInCategory (category) {
            let obj = {
              name: '',
              photo: '',
              link: ''
            }
            category.items.push(obj)
          },
          handleFileChange(evt, item) {
            console.log(evt);
            item.photo = evt.target.files[0]
          },
          save() {
            let formData = {}
            axios.put("{{ route('admin.setting.menu.update', $setting->id) }}",{categories: this.categories})
          }
        }
      })
  </script>
@endsection
