<div class="left-menu" id="slide-menu">
  <div class="accordion">

    <div class="section">
      <label><span><a href="{{ route('root') }}">Главная</a></span></label>
      <div class="content"></div>
    </div>

    <div class="section">
      <input type="radio" name="accordion-1" id="section-1"/>
      <label for="section-1"><span>Бренды</span><span class="caret fa fa-angle-right"></span></label>
      <div class="content">
        <ul>
          @foreach(App\Models\Brand::orderBy('name', 'ASC')->get() as $brand)
            <li><span><a href="{{ route('products.all', ['brand' => $brand->id]) }}">{{ $brand->name }}</a></span></li>
          @endforeach
        </ul>
      </div>
    </div>

    @foreach(App\Models\Category::all() as $cat)
      @if($cat->parents()->count() === 0)

        <div class="section">
          <input type="radio" name="accordion-1" id="section-cat-{{$cat->id}}"/>
          <label for="section-cat-{{$cat->id}}"><span>{{ $cat->name }}</span><span class="caret fa fa-angle-right"></span></label>
          <div class="content">
            <ul>
              @foreach(App\Models\Category::whereHas('parents', function ($q) use ($cat) { $q->where('category_id', $cat->id); })->orderBy('name', 'ASC')->get() as $cat2)
                @if (count($cat2->child) > 0)

                  <div class="section">
                    <input type="radio" name="accordion-2" id="section-cat2-{{$cat2->id}}"/>
                    <label for="section-cat2-{{$cat2->id}}"><span>{{ $cat2->name }}</span><span class="caret fa fa-angle-right"></span></label>
                    <div class="content">
                      <ul>
                        @foreach(App\Models\Category::whereHas('parents', function ($q) use ($cat2) { $q->where('category_id', $cat2->id); })->orderBy('name', 'ASC')->get() as $cat3)
                          <li><span><a href="{{ route('products.all', ['category' => $cat3->id]) }}">{{ $cat3->name }}</a></span></li>
                        @endforeach
                      </ul>
                    </div>
                  </div>

                @else
                  <li><span><a href="{{ route('products.all', ['category' => $cat2->id]) }}">{{ $cat2->name }}</a></span></li>
                @endif
              @endforeach
            </ul>
          </div>
        </div>

      @endif
    @endforeach

    <div class="section">
      <label><span><a href="{{ route('contact') }}">Контакты</a></span></label>
      <div class="content"></div>
    </div>

    <div class="section">
      <label><span><a href="{{ route('about') }}">О нас</a></span></label>
      <div class="content"></div>
    </div>

    <div class="section">
      <label><span><a class="c-red" href="{{ route('products.allsale') }}">Sale</a></span></label>
      <div class="content"></div>
    </div>
    <div class="section d-md-none">
      <label><span><a href="{{ route('faqs.index') }}">FAQ</a></span></label>
      <div class="content"></div>
    </div>
  </div>
</div>

<!-- Content panel -->
<nav class="navbar navbar-expand">
  <div id="nav-icon3">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
  </div>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav" id="firstNav">
      <li class="nav-item dropdown d-flex" rel="city">
        <a class="nav-link d-flex align-items-center" id="city" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="d-inline-flex">
            <span>{{ $currency->short_name }} ({{ $currency->symbol }}) <i style="font-size: 15px" class="fas fa-fw fa-chevron-down"></i></span>
          </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="city">
          <div class="list-group" id="list-city">
            @foreach(App\Models\Currency::all() as $cr)
              <a href="/currency/change/{{$cr->id}}" class="list-group-item list-group-item-action">
                {{ $cr->name }}
              </a>
            @endforeach
          </div>
        </div>
      </li>
      <li class="nav-item d-none d-lg-block position-absolute" style="display: flex; left: calc( 50vw  - 25px )">
        <a href="{{ route('root') }}"><img src="{{ asset('public/images/logo.png') }}" height="45" alt=""></a>
      </li>
      <li class="nav-item mr-2 d-none ml-auto" style="display: flex;">
        <form action="{{ route('products.search') }}" id="big-search" class="form-inline w-100">
          <div class="form-group mb-0 mr-0">
            <label class="sr-only">Что-то искали?</label>
            <input type="text" name="name" value="{{ isset($name) ? $name : null }}" class="form-control border-0 rounded-0" placeholder="Что-то искали?">
          </div>
          <button type="submit" class="btn btn-primary border-0 ml-0 rounded-0"><i class="far fa-search"></i></button>
        </form>
      </li>
      @guest
      <li class="nav-item mr-0 mr-sm-4 d-none" rel="profile" style="display: flex;">

        <span class="d-flex align-items-center">
          <a class="nav-link p-0 mr-2 border-bottom border-white d-flex align-items-center" href="{{ route('login') }}">Войдите</a>
          или
          <a class="nav-link p-0 ml-2 border-bottom border-white d-flex align-items-center" href="{{ route('register') }}">Зарегистрируйтесь</a>
        </span>
      </li>
      <li class="nav-item dropdown mr-0 mr-sm-4 d-flex ml-auto" rel="profile-mobile">
        <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fal fa-user fa-fw" style="font-size: 1.4em"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" style="right: 0; width: unset!important; height: unset!important;max-width: unset!important; max-height: unset!important; min-width: unset!important; min-height: unset!important;" aria-labelledby="profile">
          <a href="{{ route('login') }}" class="dropdown-item">Войти</a>
          <a href="{{ route('register') }}" class="dropdown-item">Зарегистрироваться</a>
        </div>
      </li>
      @else
      <li class="nav-item dropdown mr-0 mr-sm-4 ml-auto" rel="profile">
        <a class="nav-link p-0 align-items-center" id="nav-profile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img class="img-fluid rounded-circle p-0" src="{{ isset(auth()->user()->avatar) ? asset('storage/avatar/thumbnail/'.auth()->user()->avatar) : asset('public/images/person.png') }}" alt="">
          <span class="d-none d-sm-block ml-2">{{ auth()->user()->name }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile">
          <a href="{{ route('profile.index') }}" class="dropdown-item">Мой профиль</a>
          <a href="{{ route('orders.index') }}" class="dropdown-item">Мои заказы</a>
          <a href="{{ route('products.favorites') }}" class="dropdown-item">Избранное</a>
          <a class="dropdown-item" id="logout" href="#"
             onclick="event.preventDefault();document.getElementById('logout-form').submit();">Выйти</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
          </form>
        </div>
      </li>
      @endguest
      <li class="nav-item dropdown mr-0 mr-sm-4 d-flex" style="position: static;" rel="search-mobile">
        <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fal fa-search fa-fw" style="font-size: 1.4em"></i>
        </a>
          <form action="{{ route('products.search') }}" class="dropdown-menu dropdown-menu-right" style="height: unset!important;max-width: unset!important; max-height: unset!important; min-width: unset!important; min-height: unset!important;" aria-labelledby="profile">
            <div class="form-group">
              <label for="exampleDropdownFormEmail2"></label>
              <input type="text" class="form-control" id="" name="name" value="{{ isset($name) ? $name : null }}" placeholder="Что-то искали?">
            </div>
            <button type="submit" class="btn btn-dark rounded-0 w-100">Найти</button>
          </form>
      </li>
      <li class="nav-item dropdown mr-0 mr-sm-4" rel="cart">
        <a class="nav-link" id="cart" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fal fa-shopping-bag fa-fw" style="font-size: 1.4em"></i>
          <div id="counter">
            <span>@{{ amount }}</span>
          </div>
        </a>
        <header-cart :cartitems="{{ json_encode($cartItems) }}" :currency="{{ $currency }}" :priceamount="{{ $priceAmount }}" inline-template>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="cart" id="cart-dropdown">
            <mini-cart-item v-for="(item, index) in $parent.cartItems" :key="item.id + '-' + index" :item="item" :currency="{{ $currency }}" :id="item.product_sku.id" inline-template>
              <div class="row align-items-center m-0">
                <div class="col-md-3 col-6 h-100">
                  <img :src="item.product_sku.product.photos !== null && item.product_sku.product.photos.length > 0  ? '/public/storage/products/' + item.product_sku.product.photos[0].name : 'https://developers.google.com/maps/documentation/maps-static/images/error-image-generic.png'" alt="t-short" class="img-fluid">
                </div>
                <div class="col-md-5 col-6 h-100">
                  <p class="p-0 m-0">@{{ item.product_sku.product.title }}</p>
                </div>
                <div class="col-md-4 mt-2 mt-md-0 h-100">
                  <div class="row px-3 px-md-0">
                    <span class="col-md-9 col-9 p-0 cart-price">@{{ item.amount }} х @{{ item.product_sku.product.on_sale && item.product_sku.product.price_sale ? $cost(Number(item.product_sku.product.price_sale) * currency.ratio)  : $cost(Number(item.product_sku.product.price) * currency.ratio) }} @{{currency.symbol}}</span>
                    <button class="btn btn-default col-md-3 col-3 p-0" @click="deleteItem"><i class="fal fa-times fa-fw fa-lg text-dark"></i></button>
                  </div>
                </div>
                <div class="col-12" v-if="item.product_sku.product.isPromotion === true">
                  По акции: @{{  item.product_sku.product.namePromotion }}
                </div>
              </div>
            </mini-cart-item>


            <div class="row align-items-center m-0">
              <div class="col-md-6 col-6 h-100">
                <a class="btn btn-dark" href="{{ route('cart.index') }}" role="button">Перейти в корзину</a>
              </div>
              <div class="col-md-6 col-6 h-100"><p class="p-0 cart-price m-0">Итого: @{{ $cost($parent.priceAmount * currency.ratio) }} @{{currency.symbol}}</p></div>
            </div>
          </div>
        </header-cart>
      </li>
    </ul>
  </div>
</nav>

<nav class="navbar navbar-expand p-0" style="position: fixed; margin-top: 50px; background: rgba(0, 0, 0, 0.58)!important; z-index: 99;width: 100vw">
  <div class="collapse navbar-collapse" id="navbarSupportedContent" style="width: 100vw;">
    <ul class="navbar-nav justify-content-center" style="width: 100vw;">

      @foreach(App\Models\Category::all() as $cat)
        @if($cat->parents()->count() === 0)
          <li class="nav-item mr-0 mr-sm-4">
            <a class="nav-link d-flex align-items-center" style="cursor: pointer;" id="top-brands" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{ $cat->name }}
            </a>
            <div class="dropdown-menu border-0 m-0 rounded-0 p-0" style="left: auto; top: 50px; max-height: 300px" aria-labelledby="top-brands">
              <ul class="list-group rounded-0 d-flex p-2" id="top-drop-ul-brands" style="max-height: 300px; overflow-y:scroll; webkit-overflow-scrolling: touch;">
                @foreach(App\Models\Category::whereHas('parents', function ($q) use ($cat) { $q->where('category_id', $cat->id); })->orderBy('name', 'ASC')->get() as $cat2)
                  <li class="list-group-item collapseLink rounded-0 border-0 p-2">
                   @if (count($cat2->child) > 0)

                      <a href="#" class="dropdown-toggle text-dark text-decoration">{{ $cat2->name }}</a>
                      <div class="collapse rounded-0 border-black-fade" id="collapseExample{{$cat2->id}}">
                        @foreach(App\Models\Category::whereHas('parents', function ($q) use ($cat2) { $q->where('category_id', $cat2->id); })->orderBy('name', 'ASC')->get() as $cat3)
                          <a class="dropdown-item text-dark bg-transparent text-decoration p-1" href="{{ route('products.all', ['category' => $cat3->id]) }}"><u>{{ $cat3->name }}</u></a>
                        @endforeach
                      </div>

                    @else
                      <a href="{{ route('products.all', ['category' => $cat2->id]) }}" class="text-dark">{{ $cat2->name }}</a>
                    @endif


                  </li>
                @endforeach
              </ul>
            </div>
          </li>
        @endif
      @endforeach

        <li class="nav-item mr-0 mr-sm-4">
          <a class="nav-link d-flex align-items-center" style="cursor: pointer;" id="top-brands" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Бренды
          </a>
          <div class="dropdown-menu border-0 m-0 rounded-0 p-0" style="left: auto; top: 50px; max-height: 300px" aria-labelledby="top-brands">
            <ul class="list-group rounded-0 d-flex p-2" id="top-drop-ul-brands" style="max-height: 300px; overflow-y:scroll; webkit-overflow-scrolling: touch;">
              @foreach(App\Models\Brand::orderBy('name', 'ASC')->get() as $brand)
                <li class="list-group-item rounded-0 border-0 p-2"><a href="{{ route('products.all', ['brand' => $brand->id]) }}" class="text-dark">{{ $brand->name }}</a></li>
              @endforeach
            </ul>
          </div>
        </li>

      <li class="nav-item mr-0 mr-sm-4">
        <a class="nav-link d-flex align-items-center c-red" href="{{ route('products.allsale') }}">Sale</a>
      </li>
      <li class="nav-item mr-0 mr-sm-4">
        <a class="nav-link d-flex align-items-center" href="{{ route('products.allactions') }}">Акции</a>
      </li>

    </ul>
  </div>
</nav>
