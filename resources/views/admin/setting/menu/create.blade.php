@extends('admin.layouts.app')
@section('title', 'Создание категории в меню')

@section('css')
@endsection

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Категория в меню</h2>
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
          <div class="row">
            <div class="col-md-6">
              <form action="{{ route('admin.setting.menu-categories.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-end">
                  <div class="col-auto">
                    <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Добавить</button>
                  </div>
                </div>
                <div class="row mt-3 align-items-end">
                  <div class="col">
                    <label for="category_id">Категория</label>
                    <select name="category_id" id="category_id" class="w-100 px-2 form-control rounded-0 {{ $errors->has('category_id') ? ' is-invalid' : '' }}">
                      @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') === $cat->id ? 'selected' : null }}>{{ $cat->name }}</option>
                      @endforeach
                    </select>
                    <span id="category_id-error" class="error invalid-feedback">{{ $errors->first('category_id') }}</span>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-md-6 category">
              <ul>
                @foreach($categoriesAll as $category)
                  <li><a href="{{ route('admin.production.category.edit', $category->id) }}" class="text-red">{{ $category->name }}
                      @if($category->to_index)
                        <i style="font-size: 1.5rem" class="fal fa-home-lg-alt ml-2 text-success"></i>
                      @endif
                    </a>

                    <form action="{{ route('admin.production.category.destroy', $category->id) }}" method="post">
                      @csrf
                      @method('delete')
                      <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" type="submit"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
                    </form>
                  </li>
                  @if($category->child()->count() > 0)
                    <ul>
                      @include('admin.layouts.categoryList', ['cat' => $category->child()->get(), 'deleted' => true])
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

@endsection
