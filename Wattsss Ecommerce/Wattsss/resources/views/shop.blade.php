<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="{{ asset('Watts.png') }}">
  <!-- Bootstrap CSS -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('css/tiny-slider.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <title>Wattsss</title>
</head>

<body>

  <!-- Start Header/Navigation -->
  <nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" aria-label="Watts navigation bar">
    <div class="container">
      <a class="navbar-brand" href="{{ url('dashboard') }}">Wattsss<span>.</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsWatts" aria-controls="navbarsWatts" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsWatts">
        <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link" href="{{ url('dashboard') }}">Home</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="{{ url('shop') }}">Shop</a>
          </li>
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
            <a class="nav-link" href="#">Manage Products</a>
          </li>
          @endif
        </ul>

        <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
          <li><a class="nav-link" href="{{ url('cart') }}"><img src="{{ asset('images/cart.svg') }}"></a></li>
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

  <div class="hero">
    <div class="container">
      <div class="row justify-content-between">
        <div class="col-lg-5">
          <div class="intro-excerpt">
            <h1>Shop</h1>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="untree_co-section product-section before-footer-section">
    <div class="container">
      <div class="col-lg-7">
        <form method="GET" action="{{ route('shop') }}">
          <div class="input-group mb-3">
            <select class="form-select" name="category_id" onchange="this.form.submit()">
              <option value="">All Categories</option>
              @foreach($categories as $category)
              <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
              </option>
              @endforeach
            </select>
            <select class="form-select" name="sort" onchange="this.form.submit()">
              <option value="" disabled selected>Sort By</option>
              <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
              <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
            </select>
          </div>
        </form>
      </div>
      <div class="row">
        @foreach($products as $product)
        <div class="col-12 col-md-4 col-lg-3 mb-4">
          <div class="product-card">
            <a class="product-item" href="#">
              <img src="{{ asset($product->image) }}" class="img-fluid product-thumbnail">
              <h3 class="product-title">{{ $product->name }}</h3>
              <div class="product-price">
                <strong>₱{{ number_format($product->price, 2) }}</strong>
              </div>
              <span class="icon-cross" data-product-id="{{ $product->id }}">
                <img src="{{ asset('images/cross.svg') }}" class="img-fluid">
              </span>
            </a>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>

  <!-- Toast Notification -->
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="toastNotification" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          Product added to cart successfully!
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>

  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/tiny-slider.js') }}"></script>
  <script src="{{ asset('js/custom.js') }}"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const crossIcons = document.querySelectorAll('.icon-cross');

        crossIcons.forEach(icon => {
            icon.addEventListener('click', function(event) {
                event.preventDefault();

                const productId = this.getAttribute('data-product-id');

                fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ product_id: productId })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showToast('Product added to cart successfully!');
                    } else {
                        showToast(data.message, true);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('An error occurred while adding the product to the cart', true);
                });
            });
        });
    });

    function showToast(message, isError = false) {
        const toastElement = document.getElementById('toastNotification');
        const toastBody = toastElement.querySelector('.toast-body');
        toastBody.textContent = message;

        if (isError) {
            toastElement.classList.remove('bg-success');
            toastElement.classList.add('bg-danger');
        } else {
            toastElement.classList.remove('bg-danger');
            toastElement.classList.add('bg-success');
        }

        const toast = new bootstrap.Toast(toastElement);
        toast.show();
    }
</script>


</body>
</html>
