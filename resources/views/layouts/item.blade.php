<a href="{{ route('product.show', $item->id) }}" class="item h-100 w-100 d-block text-decoration-none inverse">
  <div class="row m-0">
    <div class="col p-0 scale">
      <img src="{{ $item->placeholder() }}" alt="{{ $item->title }}" class="img-fluid img-scale">
    </div>
  </div>
  <div class="row mt-2 px-2">
    <div class="col">
      <p class="h5 font-weight-normal">{{ $item->title }}</p>
      <p class="h5 font-weight-normal">{{ $item->cost($currency) }} {{ $currency->symbol }}</p>
    </div>
  </div>
  <div class="row px-2 text-dark">
    <div class="col-auto">
      <p>
        <span class="text-muted">Размер:</span>
        <span>{{ $item->skus->title }}</span>
      </p>
    </div>
    <div class="col-auto ml-auto">
      <p>
        <span class="text-muted">Состояние:</span>
        <span>{{ $item->status }}</span>
      </p>
    </div>
  </div>
</a>
