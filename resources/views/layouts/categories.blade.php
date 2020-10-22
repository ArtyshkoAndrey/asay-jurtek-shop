@foreach ($cat->categories as $category)
  @include('layouts.categories', ['cat' => $category])
  <li class="breadcrumb-item px-0"><a href="{{ route('products.all', ['category' => $category->id]) }}" class="text-dark">{{ $category->name }}</a></li>
@endforeach
