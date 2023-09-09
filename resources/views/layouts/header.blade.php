<link rel="stylesheet" href="{{ asset('css/components/header.css') }}">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        {{-- Logo --}}
        <a class="navbar-brand" href="{{ route('home') }}"><img class="nav-logo" src="{{ asset('images/header-logo.png') }}"
                alt="AELOGO"></a>
        {{-- dropdown --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <form class="d-flex mx-auto" action="{{ route('search') }}" method="GET">
                <div class="search-container">
                    <div class="search-box">
                        <select name="category" aria-label="Select Category">
                            <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>All</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <input name="query" class="form-control me-2" type="search" placeholder="Search"
                            aria-label="Search" value="{{ request('query') }}">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </div>
                </div>
            </form>


            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('product.index') }}">Products</a>
                </li>
                @if (Auth::check())
                    @can('manage')
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('category.index') }}">Categories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page"
                                href="{{ route('users.index') }}">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('orders.all') }}">All Orders</a>
                        </li>
                    @endcan
                    @cannot('manage')
                        <li class="nav-item">
                            <a class="nav-link"><span class="balance">Balance: {{ Auth::user()->money }}</span></a>
                        </li>
                    @endcannot


                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle header-name" href="#" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.view', Auth::user()->id) }}">Profile</a></li>
                            @cannot('manage')
                                <li><a class="dropdown-item" href="{{ route('orders.index', Auth::user()->id) }}">Order
                                        History</a></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('cart.index') }}">
                                        <i class="fas fa-shopping-cart"></i> Cart
                                        <span class="badge bg-secondary">{{ Cart::getTotalQuantity() }}</span>
                                    </a>
                                </li>
                            @endcannot

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Sign In</a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>
<script src="{{ asset('js/components/header.js') }}"></script>
