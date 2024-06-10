<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('Watts.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/tiny-slider.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>Wattss</title>
</head>

<body>

<!-- Start Header/Navigation -->
<nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Watts navigation bar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('dashboard') }}">Wattsss<span>.</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsWatts"
                aria-controls="navbarsWatts" aria-expanded="false" aria-label="Toggle navigation">
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
                        <a class="nav-link" href="#">Become a Seller</a>
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
                <li><a class="nav-link" href="{{ route('cart.view') }}"><img src="{{ asset('images/cart.svg') }}"></a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('images/user.svg') }}" alt="User" style="width: 20px; height: 20px;">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('account.logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
<!-- End Header/Navigation -->

<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Cart</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End Hero Section -->

<div class="untree_co-section before-footer-section">
    <div class="container">
        <div class="row mb-5">
            <form class="col-md-12" method="post" action="{{ route('cart.update') }}">
                @csrf
                <div class="site-blocks-table">
                    <table class="table">
                        <thead>
                        <tr>
                            <th></th> <!-- Checkbox column -->
                            <th class="product-thumbnail">Image</th>
                            <th class="product-name">Product</th>
                            <th class="product-price">Price</th>
                            <th class="product-quantity">Quantity</th>
                            <th class="product-total">Total</th>
                            <th class="product-remove">Remove</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($cartItems as $item)
                            <tr>
                                <td>
                                    <input type="checkbox" class="item-checkbox" data-id="{{ $item->id }}">
                                </td>
                                <td class="product-thumbnail">
                                    <img src="{{ asset($item->image) }}" alt="Image" class="img-fluid">
                                </td>
                                <td class="product-name">
                                    <h2 class="h5 text-black">{{ $item->name }}</h2>
                                </td>
                                <td>₱{{ number_format($item->price, 2) }}</td>
                                <td>
                                    <div class="input-group mb-3 d-flex align-items-center quantity-container"
                                         style="max-width: 120px;">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-black decrease" type="button"
                                                    data-id="{{ $item->id }}">&minus;</button>
                                        </div>
                                        <input type="text" class="form-control text-center quantity-amount"
                                               value="{{ $item->quantity }}" placeholder=""
                                               aria-label="Example text with button addon" aria-describedby="button-addon1"
                                               data-id="{{ $item->id }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-black increase" type="button"
                                                    data-id="{{ $item->id }}">&plus;</button>
                                        </div>
                                    </div>
                                </td>
                                <td>₱<span class="item-total"
                                          data-price="{{ $item->price }}"
                                          data-quantity="{{ $item->quantity }}">{{ number_format($item->price * $item->quantity, 2) }}</span></td>
                                <td>
                                    <form action="{{ route('cart.remove', ['cart_id' => $item->id]) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE') <!-- Use DELETE method -->
                                        <button type="submit" class="btn btn-black btn-sm">X</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No items in the cart.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if(!empty($cartItems))
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-5">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <!-- Cart items table and other form elements -->
                                    <button type="submit" class="btn btn-black btn-sm btn-block">Update Cart</button>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('shop') }}"
                                       class="btn btn-outline-black btn-sm btn-block">Continue Shopping</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row justify-content-end">
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-12 text-right border-bottom mb-5">
                                            <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <span class="text-black">Subtotal</span>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <strong id="subtotal" class="text-black">₱0.00</strong>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-6">
                                            <span class="text-black">Total</span>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <strong id="total" class="text-black">₱0.00</strong>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                        <a href="{{ route('checkout.view') }}" class="btn btn-black btn-lg py-3 btn-block">Proceed To Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/tiny-slider.js') }}"></script>
  <script src="{{asset('js/custom.js')}}"></script>

  <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const itemTotals = document.querySelectorAll('.item-total');
            const subtotalDisplay = document.querySelector('#subtotal');
            const totalDisplay = document.querySelector('#total');
            
            function calculateTotals() {
                let subtotal = 0;

                checkboxes.forEach((checkbox, index) => {
                    if (checkbox.checked) {
                        const itemTotal = parseFloat(itemTotals[index].getAttribute('data-price')) * parseInt(itemTotals[index].getAttribute('data-quantity'));
                        subtotal += itemTotal;
                    }
                });

                subtotalDisplay.textContent = '₱' + subtotal.toFixed(2);
                totalDisplay.textContent = '₱' + subtotal.toFixed(2); // Assuming subtotal equals total in this case
            }

            checkboxes.forEach((checkbox, index) => {
                checkbox.addEventListener('change', function() {
                    calculateTotals();
                });
            });

            calculateTotals(); // Calculate totals on page load
        });
    </script>

</body>
</html>
