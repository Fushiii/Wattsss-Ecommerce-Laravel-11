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
          <li class="nav-item">
            <a class="nav-link" href="{{ url('shop') }}">Shop</a>
          </li>
          @if(Auth::user()->role == 'customer')
          <li class="nav-item">
            <a class="nav-link" href="{{ route ('applySeller') }}">Become a Seller</a>
          </li>
          @elseif(Auth::user()->role == 'admin')
          <li class="nav-item">
            <a class="nav-link" href="{{ route ('application') }}">Seller Request</a>
          </li>
          @elseif(Auth::user()->role == 'seller')
          <li class="nav-item active">
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
            <h1>Manage Products</h1>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- List of Products -->
    <h2>My Products</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>${{ $product->price }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('images/' . $product->image) }}" alt="" width="50">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-primary btn-edit" data-id="{{ $product->id }}">Edit</button>
                        <form action="{{ route('manage.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Add/Edit Product Form -->
    <h2 id="form-title">Add New Product</h2>
    <form id="product-form" action="{{ route('manage.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="product-id" name="product_id">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Save Product</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('product-form');
            const formTitle = document.getElementById('form-title');
            const productId = document.getElementById('product-id');
            const name = document.getElementById('name');
            const price = document.getElementById('price');
            const image = document.getElementById('image');
            const category_id = document.getElementById('category_id');

            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    fetch(`/seller/products/${id}/edit`)
                        .then(response => response.json())
                        .then(data => {
                            form.action = `/seller/products/${id}`;
                            form.method = 'POST';
                            form.innerHTML += '<input type="hidden" name="_method" value="PUT">';
                            formTitle.innerText = 'Edit Product';
                            productId.value = data.id;
                            name.value = data.name;
                            description.value = data.description;
                            price.value = data.price;
                            image.value = null; // Reset image input
                        });
                });
            });
        });
    </script>

  <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('js/tiny-slider.js')}}"></script>
  <script src="{{asset('js/custom.js')}}"></script>
</body>

</html>