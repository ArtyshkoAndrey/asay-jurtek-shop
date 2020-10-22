@foreach ($cat as $category)
  <li><a href="{{ route('admin.production.category.edit', $category->id) }}" class="text-red">{{ $category->name }}
      @if($category->to_index)
        <i style="font-size: 1.5rem" class="fal fa-home-lg-alt ml-2 text-success"></i>
      @endif
    </a>
    @if($deleted)
      <form action="{{ route('admin.production.category.destroy', $category->id) }}" method="post">
        @csrf
        @method('delete')
        <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" type="submit"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
      </form>
    @endif
  </li>
  @if($category->child()->count() > 0)
    <ul>
      @include('admin.layouts.categoryList', ['cat' => $category->child()->get()])
    </ul>
  @endif
@endforeach
