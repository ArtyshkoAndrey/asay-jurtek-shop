<a href="{{ route('news.show', $news->id) }}" class="item h-100 w-100 d-block text-decoration-none inverse {{ $slider ? 'mx-3 my-2' : null }}">
  <div class="row m-0">
    <div class="col p-0 {{ !$slider ? 'scale' : null }}">
      <img src="{{ asset('storage/news/' . $news->image) }}" alt="{{ $news->title }}" class="img-fluid {{ !$slider ? 'img-scale' : null }}">
    </div>
  </div>
  <div class="row mt-2 px-2">
    <div class="col">
      <p class="h5 font-weight-normal" style="-webkit-line-clamp: 2; display: -webkit-box; overflow: hidden; height: 3rem; -webkit-box-orient: vertical;">{{ $news->title }}</p>
      <p class="text-muted" style="-webkit-line-clamp: 2; display: -webkit-box; overflow: hidden; height: 3rem; -webkit-box-orient: vertical;">{{ $news->description }}</p>
      <p class="color-orange">Читать дальше...</p>
    </div>
  </div>
</a>

