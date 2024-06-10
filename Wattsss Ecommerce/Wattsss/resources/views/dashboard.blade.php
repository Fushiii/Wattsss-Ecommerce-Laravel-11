<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="{{asset('Watts.png')}}">

  <!-- Bootstrap CSS -->
  <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="{{asset('css/tiny-slider.css')}}" rel="stylesheet">
  <link href="{{asset('css/style.css')}}" rel="stylesheet">
  
  <style>
    /* Ensure all popular product images are the same size */
    .popular-product .thumbnail {
        width: 100%; /* Make sure the thumbnail takes the full width of its container */
        height: 100px; /* Set a fixed height */
        overflow: hidden; /* Hide overflow to maintain aspect ratio */
        display: flex; /* Use flexbox to center the image */
        justify-content: center;
        align-items: center;
    }

    .popular-product .thumbnail img {
        height: 100%; /* Scale image to fill the height */
        width: auto; /* Maintain aspect ratio */
    }
	
  </style>

  <title>Wattsss</title>
</head>

<body>
  <!-- Start Header/Navigation -->
  <nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Watts navigation bar">
    <div class="container">
      <a class="navbar-brand" href="{{url('dashboard')}}">Wattsss<span>.</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsWatts" aria-controls="navbarsWatts" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsWatts">
        <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
          <li class="nav-item active">
            <a class="nav-link" href="{{url('dashboard')}}">Home</a>
          </li>
          <li><a class="nav-link" href="{{url('shop')}}">Shop</a></li>
          @if(Auth::user()->role == 'customer')
          <li class="nav-item">
            <a class="nav-link" href="{{ route ('applySeller') }}">Become a Seller</a>
          </li>
          @elseif(Auth::user()->role == 'admin')
          <li class="nav-item">
            <a class="nav-link" href="{{ route ('admin.applications') }}">Seller Request</a>
          </li>
          @elseif(Auth::user()->role == 'seller')
          <li class="nav-item">
            <a class="nav-link" href="{{ route ('manage.view') }}">Manage Products</a>
          </li>
          @endif
        </ul>

        <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
        <li><a class="nav-link" href="{{ route('cart.view') }}"><img src="{{asset('images/cart.svg')}}"></a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="{{ asset('images/user.svg') }}" alt="User" style="width: 20px; height: 20px;">
              {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li>
                <a class="dropdown-item" href="{{ route('account.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  Logout
                </a>
                <form id="logout-form" action="{{ route('account.logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Start Hero Section -->
  <div class="hero">
    <div class="container">
      <div class="row justify-content-between">
        <div class="col-lg-5">
          <div class="intro-excerpt">
            <h1> Your Gateway to <span clsas="d-block">Modern Living!</span></h1>
            <p class="mb-4">Curated appliances for smarter living. Elevate your home with convenience and style.</p>
            <p><a href="{{ url('shop') }}" class="btn btn-secondary me-2">Shop Now</a><a href="#categories" class="btn btn-white-outline">Explore</a></p>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="hero-img-wrap">
            <img src="{{asset('appliances.png')}}" class="img-fluid">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Hero Section -->

  <!-- Start Product Section -->
  <div class="product-section" id="categories">
    <div class="container">
      <div class="row">

        <!-- Start Column 1 -->
        <div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
          <h2 class="mb-4 section-title">Featured Categories</h2>
          <p class="mb-4">Here are the Featured Categories for the month of June</p>
          <p><a href="{{ url('shop') }}" class="btn">Explore</a></p>
        </div>
        <!-- End Column 1 -->

        <!-- Start Column 2 -->
        @if($categories->isEmpty())
        <p>No categories found.</p>
        @else
        @foreach($categories as $category)
        <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
          <a class="product-item" href="cart.html">
            <img src="{{ asset($category->image) }}" class="img-fluid product-thumbnail">
            <strong class="category-title">{{ $category->name }}</strong>
          </a>
        </div>
        @endforeach
        @endif
        <!-- End Column 2 -->

      </div>
    </div>
  </div>
  <!-- End Product Section -->

  <!-- Start Popular Product Section -->
  <div class="popular-product">
    <div class="container">
      <div class="row">
        <h2 class="mb-4 section-title">Popular Products</h2>

        @if($products->isEmpty())
        <p>No products found.</p>
        @else
        @foreach($products as $product)
        <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
          <div class="product-item-sm d-flex">
            <div class="thumbnail">
              <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid">
            </div>
            <div class="pt-3">
              <h3>{{ $product->name }}</h3>
              <p>Price: P{{ $product->price }}</p>
              <p><a href="{{ url('shop') }}">Read More</a></p>
            </div>
          </div>
        </div>
        @endforeach
        @endif

      </div>
    </div>
  </div>
  <!-- End Popular Product Section -->

  <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('js/tiny-slider.js')}}"></script>
  <script src="{{asset('js/custom.js')}}"></script>
</body>

</html>
