@php
    $companySettings = \App\Models\HomepageSetting::get('company_settings', []);
    $companyName = $companySettings['name'] ?? 'eCommerce';
    $companyLogo = $companySettings['logo'] ?? null;
    $maxDiscountPercent = \App\Models\Product::where('discount_type', 'percent')->where('discount_value', '>', 0)->frontendActive()->max('discount_value') ?? 0;
    $maxDiscountPercent = round($maxDiscountPercent);
@endphp

<!-- TOP BAR -->
<div class="top-bar">
    <div class="container">
        <div class="d-flex justify-content-between">
            <div>
                🇧🇩 সারাদেশে ডেলিভারি
                <strong>Cash on Delivery Available</strong>
            </div>
            <div class="d-none d-md-block">
                Hotline: 01XXXXXXXXX
            </div>
        </div>
    </div>
</div>

<!-- HEADER -->
<header class="main-header">
    <div class="container">
        <div class="row align-items-center g-3">
            <div class="col-6 col-lg-2">
                <a href="{{ route('home') }}" class="brand" style="text-decoration:none;">
                    @if($companyLogo)
                        <img src="{{ asset('storage/' . $companyLogo) }}" alt="{{ $companyName }}" style="max-height: 55px; border-radius: 6px;">
                    @else
                        RONG<span>DHONU</span>
                        <small>FASHION & LIFESTYLE</small>
                    @endif
                </a>
            </div>

            <!-- DESKTOP MENU -->
            <div class="col-lg-5 d-none d-lg-block">
                <ul class="navbar-nav flex-row justify-content-center gap-4 fw-semibold" style="font-size: 15px; margin: 0; padding: 0;">
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('shop') ? 'active' : '' }}" href="{{ route('shop') }}">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger {{ request()->routeIs('flash-sale') ? 'active' : '' }}" href="{{ route('flash-sale') }}">🔥 Sale</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('blogs.*') ? 'active' : '' }}" href="{{ route('blogs.index') }}">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
            </div>

            <!-- SEARCH -->
            <div class="col-lg-3 d-none d-lg-block">
                <form action="{{ route('home') }}" method="GET" class="search-wrapper m-0">
                    <input type="text" name="search" placeholder="Search..." value="{{ request()->query('search') }}" class="search-input-field" autocomplete="off" style="padding-left:15px;">
                    <button type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    <div class="search-results-dropdown d-none position-absolute w-100 bg-white border rounded shadow mt-1 p-2" style="z-index: 1050; top: 100%; left: 0; max-height: 350px; overflow-y: auto;"></div>
                </form>
            </div>
            <!-- ICONS & MOBILE TOGGLE -->
            <div class="col-6 col-lg-2">
                <div class="d-flex justify-content-end gap-2 align-items-center">
                    
                    @if (auth()->guard('admin')->check())
                        <div class="dropdown">
                            <a class="head-icon dropdown-toggle no-arrow" href="#" data-bs-toggle="dropdown" style="text-decoration:none;">
                                <img src="https://placehold.co/26x26/ff5521/fff?text={{ strtoupper(substr(auth()->guard('admin')->user()->email, 0, 1)) }}" class="rounded-circle" style="width: 26px; height: 26px; object-fit: cover;">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end mt-2">
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li>
                                    <form method="POST" action="{{ route('admin.logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @elseif(auth()->guard('web')->check())
                        <div class="dropdown">
                            <a class="head-icon dropdown-toggle no-arrow" href="#" data-bs-toggle="dropdown" style="text-decoration:none;">
                                <img src="https://placehold.co/26x26/ff5521/fff?text={{ strtoupper(substr(auth()->user()->name, 0, 1)) }}" class="rounded-circle" style="width: 26px; height: 26px; object-fit: cover;">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end mt-2">
                                <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">Dashboard</a></li>
                                <li>
                                    <form method="POST" action="{{ route('user.logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a class="head-icon" href="{{ route('user.login') }}" style="text-decoration:none;">
                            <i class="bi bi-person"></i>
                        </a>
                    @endif

                    
                    <div class="dropdown">
                        <a class="head-icon dropdown-toggle no-arrow" href="#" data-bs-toggle="dropdown" id="cartDropdownDesktop" style="text-decoration:none;">
                            <i class="bi bi-bag"></i>
                            <span class="counter badge-num cart-count-badge">0</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-3 cart-dropdown-menu" aria-labelledby="cartDropdownDesktop" style="width: 320px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); border: 1px solid rgba(0,0,0,0.08);">
                            <!-- Dynamically rendered cart items -->
                        </ul>
                    </div>
                    
                    <!-- MOBILE MENU TOGGLER -->
                    <button class="navbar-toggler d-lg-none border-0 bg-transparent ms-1 p-0" type="button" data-bs-toggle="collapse" data-bs-target="#mobileMenu">
                        <i class="bi bi-list fs-2 text-dark"></i>
                    </button>
                </div>
            </div>

            <!-- MOBILE SEARCH -->
            <div class="col-12 d-lg-none">
                <form action="{{ route('home') }}" method="GET" class="search-wrapper">
                    <input type="text" name="search" placeholder="Search products..." value="{{ request()->query('search') }}" class="search-input-field" autocomplete="off">
                    <button type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    <div class="search-results-dropdown d-none position-absolute w-100 bg-white border rounded shadow mt-1 p-2" style="z-index: 1050; top: 100%; left: 0; max-height: 350px; overflow-y: auto;"></div>
                </form>
            </div>
        </div>

        <!-- MOBILE MENU COLLAPSE -->
        <div class="collapse d-lg-none" id="mobileMenu">
            <ul class="navbar-nav pb-3 pt-2">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('shop') ? 'active' : '' }}" href="{{ route('shop') }}">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger {{ request()->routeIs('flash-sale') ? 'active' : '' }}" href="{{ route('flash-sale') }}">🔥 Sale ({{ $maxDiscountPercent }}% OFF)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('blogs.*') ? 'active' : '' }}" href="{{ route('blogs.index') }}">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</header>

<style>
    .main-header { padding: 15px 0; }

<style>
    .search-results-dropdown { border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); border: 1px solid rgba(0, 0, 0, 0.08); }
    .search-item-link:hover { background-color: #f8f9fa; }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInputs = document.querySelectorAll('.search-input-field');
        searchInputs.forEach(input => {
            const form = input.closest('form');
            const dropdown = form.querySelector('.search-results-dropdown');
            let debounceTimer;

            input.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                const query = input.value.trim();

                if (query.length < 2) {
                    dropdown.innerHTML = '';
                    dropdown.classList.add('d-none');
                    return;
                }

                debounceTimer = setTimeout(() => {
                    fetch(`/products/search-api?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(products => {
                            dropdown.innerHTML = '';

                            if (products.length === 0) {
                                dropdown.innerHTML = '<div class="text-muted text-center py-3 small">No products found</div>';
                                dropdown.classList.remove('d-none');
                                return;
                            }

                            products.forEach(product => {
                                const itemHtml = `
                                    <a href="${product.url}" class="d-flex align-items-center gap-3 p-2 mb-1 text-decoration-none text-dark rounded search-item-link">
                                        <img src="${product.image}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;" alt="">
                                        <div class="flex-grow-1 min-w-0">
                                            <div class="fw-semibold text-truncate small">${product.name}</div>
                                            <div class="text-danger small">৳${product.price}</div>
                                        </div>
                                    </a>
                                `;
                                dropdown.insertAdjacentHTML('beforeend', itemHtml);
                            });
                            dropdown.classList.remove('d-none');
                        })
                        .catch(err => console.error('Error fetching live search results:', err));
                }, 300);
            });

            document.addEventListener('click', function(e) {
                if (!form.contains(e.target)) {
                    dropdown.classList.add('d-none');
                }
            });

            input.addEventListener('focus', function() {
                if (dropdown.children.length > 0) {
                    dropdown.classList.remove('d-none');
                }
            });
        });
    });
</script>
