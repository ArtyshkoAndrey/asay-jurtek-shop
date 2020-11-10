@extends('admin.layouts.app')
@section('title', 'Магазин - Категории')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12 col-md-auto">
        <h2>Категории</h2>
      </div>
    </div>
    @include('admin.layouts.menu_production')
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <form action="{{ route('admin.production.category.update', $category->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="name">Название категории</label>
                  <input type="text" class="form-control rounded-0" id="name" name="name" placeholder="Название категории" value="{{ old('name') ? old('name') : $category->name }}">
                </div>
                <div class="form-group">
                  <label for="categories" class="col-12">Родительская категория</label>
                  <select name="categories[]" multiple id="categories" class="form-control rounded-0 js-example-basic-multiple">
                    <option value="">Без родителя</option>
                    @foreach(App\Models\Category::where('id', '!=' , $category->id)->get() as $cat)
                      <option value="{{ $cat->id }}"
                      @foreach($category->parents as $pr)
                       {{ $pr->id === $cat->id ? 'selected' : null }}
                      @endforeach
                      >{{ $cat->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="custom-control mb-2 custom-switch">
                  <input type="checkbox" name="to_index" value="true" {{ $category->to_index == true ? 'checked' : '' }} class="custom-control-input" id="customSwitch">
                  <label class="custom-control-label" for="customSwitch">На главной странице</label>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn bg-dark rounded-0 border-0">Изменить</button>
                </div>
              </form>
            </div>
            <div class="col-md-6 category">
              <ul>
                @foreach($categories as $categoryList)
                  <li><a href="{{ route('admin.production.category.edit', $categoryList->id) }}" class="text-red">{{ $categoryList->name }}
                      @if($categoryList->to_index)
                        <i style="font-size: 1.5rem" class="fal fa-home-lg-alt ml-2 text-success"></i>
                      @endif
                    </a>

                    <form action="{{ route('admin.production.category.destroy', $categoryList->id) }}" method="post">
                      @csrf
                      @method('delete')
                      <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" type="submit"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                    </form>
                  </li>
                  @if($categoryList->child()->count() > 0)
                    <ul>
                      @include('admin.layouts.categoryList', ['cat' => $categoryList->child()->get(), 'deleted' => true])
                    </ul>
                  @endif
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    $('.js-example-basic-multiple').select2({
      width: 'resolve'
    });
  </script>
@endsection