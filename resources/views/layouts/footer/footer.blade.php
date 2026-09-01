@php
    $companySettings = \App\Models\HomepageSetting::get('company_settings', []);
    $companyName = $companySettings['name'] ?? 'eCommerce';
    $companyPhone = $companySettings['phone'] ?? '01XXXXXXXXX';
    $companyEmail = $companySettings['email'] ?? 'support@rongdhonu.com';
    $companyAddress = $companySettings['address'] ?? 'Dhaka, Bangladesh';
@endphp

<!-- FOOTER -->
<footer>
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <a href="{{ route('home') }}" class="brand" style="text-decoration:none;">
                    RONG<span>DHONU</span>
                </a>
                <p class="mt-4">
                    Modern Bangladeshi fashion brand.
                    Premium clothing collection for men,
                    women and kids.
                </p>
                <div class="social mt-4">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-youtube"></i></a>
                    <a href="#"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>

            <div class="col-6 col-lg-2">
                <h5>Shop</h5>
                <ul>
                    <li><a href="{{ route('shop') }}" style="text-decoration:none;">Shop All</a></li>
                    <li><a href="{{ route('home') }}#products-grid" style="text-decoration:none;">Men</a></li>
                    <li><a href="{{ route('home') }}#products-grid" style="text-decoration:none;">Women</a></li>
                    <li><a href="{{ route('flash-sale') }}" style="text-decoration:none;">Sale</a></li>
                    <li><a href="{{ route('shop') }}" style="text-decoration:none;">New Arrival</a></li>
                </ul>
            </div>

            <div class="col-6 col-lg-2">
                <h5>Customer</h5>
                <ul>
                    <li><a href="{{ route('user.dashboard') }}" style="text-decoration:none;">My Account</a></li>
                    <li><a href="#" style="text-decoration:none;">Track Order</a></li>
                    <li><a href="#" style="text-decoration:none;">Exchange Policy</a></li>
                    <li><a href="#" style="text-decoration:none;">Size Guide</a></li>
                    <li><a href="{{ route('contact') }}" style="text-decoration:none;">Contact Us</a></li>
                </ul>
            </div>

            <div class="col-lg-4">
                <h5>Contact</h5>
                <ul>
                    <li><i class="bi bi-geo-alt me-2"></i>{{ $companyAddress }}</li>
                    <li><i class="bi bi-telephone me-2"></i>{{ $companyPhone }}</li>
                    <li><i class="bi bi-envelope me-2"></i>{{ $companyEmail }}</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="d-md-flex justify-content-between">
                <span>© {{ date('Y') }} {{ $companyName }}. All Rights Reserved.</span>
                <span>Privacy Policy | Terms & Conditions</span>
            </div>
        </div>
    </div>
</footer>

<!-- MOBILE BOTTOM MENU -->
<div class="mobile-bottom">
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}" style="text-decoration:none;">
        <i class="bi bi-house"></i>
        Home
    </a>
    <a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') ? 'active' : '' }}" style="text-decoration:none;">
        <i class="bi bi-grid"></i>
        Shop
    </a>
    <a href="#" style="text-decoration:none;">
        <i class="bi bi-heart"></i>
        Wishlist
    </a>
    <a href="/checkout" style="text-decoration:none;">
        <i class="bi bi-bag"></i>
        Cart
    </a>
    <a href="{{ auth()->check() ? route('user.dashboard') : route('user.login') }}" style="text-decoration:none;">
        <i class="bi bi-person"></i>
        Profile
    </a>
</div>
