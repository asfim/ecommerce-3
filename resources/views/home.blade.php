@extends('layouts.app')

@section('content')

<!-- HERO -->
@php
    $heroBg = "url('https://images.unsplash.com/photo-1445205170230-053b83016050?auto=format&fit=crop&w=1800&q=90')";
    if(isset($heroBanners) && count($heroBanners) > 0) {
        $heroBg = "url('" . asset('storage/' . str_replace('\\', '/', $heroBanners[0])) . "')";
    }
    
    $heroBadge = \App\Models\HomepageSetting::get('hero_badge', '✨ NEW COLLECTION ' . date('Y'));
    $heroTitle = \App\Models\HomepageSetting::get('hero_title', "বাংলাদেশের\n<span>রঙে</span><br>\nআপনার Fashion");
    $heroSubtitle = \App\Models\HomepageSetting::get('hero_subtitle', "Premium Panjabi, Saree, Three Piece, T-Shirt,\nShirt এবং নতুন Fashion Collection এখন এক জায়গায়।");
@endphp
<section class="hero" style="background-image: linear-gradient(100deg, rgba(20,33,61,.85) 0%, rgba(111,66,193,.70) 47%, rgba(232,62,140,.25) 100%), {!! $heroBg !!}; background-size: cover; background-position: center;">
    <div class="container">
        <div class="hero-content">
            <span class="hero-badge">
                {{ $heroBadge }}
            </span>
            <h1>
                {!! nl2br($heroTitle) !!}
            </h1>
            <p>
                {!! nl2br(e($heroSubtitle)) !!}
            </p>
            <div class="mt-4">
                <a href="{{ route('shop') }}" class="btn hero-btn hero-btn-primary me-2">
                    SHOP NOW
                </a>
                <a href="#products" class="btn hero-btn hero-btn-light">
                    NEW ARRIVAL
                </a>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="features-area">
    <div class="container">
        <div class="row g-3">
            @php
                $features = \App\Models\HomepageSetting::get('features', [
                    ['icon' => 'bi-truck', 'title' => 'Fast Delivery', 'subtitle' => 'সারাদেশে দ্রুত ডেলিভারি', 'color' => 'icon-orange'],
                    ['icon' => 'bi-cash-stack', 'title' => 'Cash on Delivery', 'subtitle' => 'পণ্য পেয়ে মূল্য পরিশোধ', 'color' => 'icon-purple'],
                    ['icon' => 'bi-arrow-repeat', 'title' => 'Easy Exchange', 'subtitle' => 'সহজ Size Exchange', 'color' => 'icon-pink'],
                    ['icon' => 'bi-shield-check', 'title' => 'Secure Payment', 'subtitle' => 'bKash, Nagad & Card', 'color' => 'icon-green'],
                ]);
            @endphp
            @foreach($features as $feat)
            <div class="col-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon {{ $feat['color'] ?? 'icon-orange' }}">
                        <i class="bi {{ $feat['icon'] ?? 'bi-star' }}"></i>
                    </div>
                    <div>
                        <h6>{{ $feat['title'] ?? '' }}</h6>
                        <p>{{ $feat['subtitle'] ?? '' }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CATEGORIES -->
<section class="section-padding">
    <div class="container">
        <div class="section-head d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-end mb-4">
            <div class="text-center text-md-start mb-3 mb-md-0">
                <span>Shop By Category</span>
                <h2 class="mb-0">আপনার পছন্দের Collection</h2>
            </div>
            <div class="d-flex gap-2 pb-2">
                <button class="btn btn-outline-dark rounded-circle cat-prev" style="width:40px; height:40px; display:flex; align-items:center; justify-content:center;"><i class="bi bi-arrow-left"></i></button>
                <button class="btn btn-outline-dark rounded-circle cat-next" style="width:40px; height:40px; display:flex; align-items:center; justify-content:center;"><i class="bi bi-arrow-right"></i></button>
            </div>
        </div>
        <div class="d-flex overflow-auto gap-4 pb-3 category-slider" style="scroll-snap-type: x mandatory; scrollbar-width: none; -ms-overflow-style: none;">
            @foreach($categories as $cat)
            <div class="flex-shrink-0" style="width: 280px; scroll-snap-align: start;">
                <div class="category-card">
                    @if($cat->image)
                        <img src="{{ asset('storage/' . str_replace('\\', '/', $cat->image)) }}" alt="{{ $cat->name }}">
                    @else
                        <img src="https://images.unsplash.com/photo-1617137968427-85924c800a22?auto=format&fit=crop&w=800&q=80" alt="{{ $cat->name }}">
                    @endif
                    <div class="category-overlay"></div>
                    <div class="category-content">
                        <h3>{{ $cat->name }}</h3>
                        <p>Explore {{ $cat->name }}</p>
                        <a class="category-btn" href="{{ route('category.products', $cat->id) }}" style="text-decoration:none;">
                            SHOP NOW
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <style>
            .category-slider::-webkit-scrollbar,
            .flash-sale-slider::-webkit-scrollbar { 
                display: none; 
            }
            .slider-card-width {
                width: 280px;
            }
            @media (min-width: 992px) {
                .slider-card-width {
                    width: calc(25% - 18px);
                }
            }
            @media (max-width: 991px) and (min-width: 768px) {
                .slider-card-width {
                    width: calc(33.333% - 16px);
                }
            }
            @media (max-width: 767px) {
                .slider-card-width {
                    width: calc(85%);
                }
            }
        </style>
    </div>
</section>

<!-- FLASH SALE -->
<section class="flash-sale">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <small>LIMITED TIME OFFER</small>
                <h2>
                    Flash Sale
                    <span>Up To {{ $maxDiscountPercent > 0 ? $maxDiscountPercent : 50 }}% OFF</span>
                </h2>
                <p>
                    আপনার পছন্দের Fashion Product এখন
                    বিশেষ Discount-এ।
                </p>
                <div class="countdown">
                    <div class="time-box">
                        <strong id="days">02</strong>
                        <span>DAYS</span>
                    </div>
                    <div class="time-box">
                        <strong id="hours">15</strong>
                        <span>HOURS</span>
                    </div>
                    <div class="time-box">
                        <strong id="minutes">30</strong>
                        <span>MINS</span>
                    </div>
                    <div class="time-box">
                        <strong id="seconds">45</strong>
                        <span>SECS</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 text-lg-end mt-4 mt-lg-0 d-flex flex-column align-items-lg-end">
                <a href="{{ route('flash-sale') }}" class="btn hero-btn hero-btn-light">
                    EXPLORE SALE
                </a>
            </div>
        </div>

        <div class="position-relative mt-5">
            <button class="btn btn-light rounded-circle fs-prev position-absolute top-50 start-0 translate-middle-y shadow-sm" style="width:40px; height:40px; display:flex; align-items:center; justify-content:center; z-index:5; left:-20px !important;"><i class="bi bi-arrow-left"></i></button>
            <button class="btn btn-light rounded-circle fs-next position-absolute top-50 end-0 translate-middle-y shadow-sm" style="width:40px; height:40px; display:flex; align-items:center; justify-content:center; z-index:5; right:-20px !important;"><i class="bi bi-arrow-right"></i></button>

            <div class="d-flex overflow-auto gap-4 pb-3 flash-sale-slider" style="scroll-snap-type: x mandatory; scrollbar-width: none; -ms-overflow-style: none;">
            @foreach($discountedProducts as $product)
                @php
                    $displayImage = $product->image;
                    if(empty($displayImage)) {
                        if(!empty($product->variants) && is_array($product->variants)) {
                            foreach($product->variants as $v) {
                                if(!empty($v['image'])) {
                                    $displayImage = $v['image'];
                                    break;
                                }
                            }
                        }
                    }
                    $isNew = $product->created_at && $product->created_at->diffInDays(now()) < 30;
                    $hasDiscount = $product->has_active_discount;
                    $discountedPrice = $product->price;
                    $discountPercent = 0;
                    $badgeText = '';
                    
                    if ($hasDiscount) {
                        if ($product->discount_type === 'percent') {
                            $discountPercent = $product->discount_value;
                            $discountedPrice = $product->price - ($product->price * $product->discount_value) / 100;
                            $badgeText = '-' . round($product->discount_value) . '%';
                        } else {
                            $discountedPrice = $product->price - $product->discount_value;
                            $badgeText = '-৳' . round($product->discount_value);
                            if ($product->price > 0) {
                                $discountPercent = ($product->discount_value / $product->price) * 100;
                            }
                        }
                    } elseif ($product->has_any_discount) {
                        // Discount is in a variant. Find max variant discount for display.
                        $hasDiscount = true;
                        if (is_array($product->variants)) {
                            foreach($product->variants as $v) {
                                if (!empty($v['discount']) && $v['discount'] > 0) {
                                    $vPrice = !empty($v['price']) ? $v['price'] : $product->price;
                                    if (!empty($v['discount_type']) && $v['discount_type'] === 'percent') {
                                        if ($v['discount'] > $discountPercent) {
                                            $discountPercent = $v['discount'];
                                            $discountedPrice = $vPrice - ($vPrice * $v['discount']) / 100;
                                            $badgeText = '-' . round($v['discount']) . '%';
                                        }
                                    } else {
                                        if ($vPrice > 0) {
                                            $vp = ($v['discount'] / $vPrice) * 100;
                                            if ($vp > $discountPercent) {
                                                $discountPercent = $vp;
                                                $discountedPrice = $vPrice - $v['discount'];
                                                $badgeText = '-৳' . round($v['discount']);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                @endphp
                <div class="flex-shrink-0 slider-card-width" style="scroll-snap-align: start;">
                    <div class="product-card flash-glass-card">
                        <div class="product-img">
                            <a href="{{ route('product.details', $product->slug) }}">
                                @if($displayImage)
                                    <img src="{{ asset('storage/' . $displayImage) }}" alt="{{ $product->name }}">
                                @else
                                    <img src="https://images.unsplash.com/photo-1610652492500-ded49ceeb378?auto=format&fit=crop&w=700&q=80" alt="{{ $product->name }}">
                                @endif
                            </a>
                            
                            @if($hasDiscount && !empty($badgeText))
                                <span class="badge-product badge-sale">{{ $badgeText }}</span>
                            @elseif($isNew)
                                <span class="badge-product badge-new">NEW</span>
                            @endif

                            <button class="wishlist">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>
                        <div class="product-info">
                            <div class="product-category">
                                {{ $product->category->name ?? 'Category' }}
                            </div>
                            <a href="{{ route('product.details', $product->slug) }}" class="product-title d-block" style="text-decoration:none;">
                                {{ Str::limit($product->name, 25) }}
                            </a>
                            <div>
                                <span class="rating">★★★★★</span>
                                <span class="review-count">(10)</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <span class="price">৳{{ number_format($discountedPrice) }}</span>
                                    @if($hasDiscount)
                                        <span class="old-price">৳{{ number_format($product->price) }}</span>
                                    @endif
                                </div>
                                <button class="add-cart add-to-cart-btn" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $discountedPrice }}" data-image="{{ $displayImage ? asset('storage/'.$displayImage) : '' }}" data-original-price="{{ $product->price }}">
                                    <i class="bi bi-bag-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
        <style>
            .flash-sale-slider::-webkit-scrollbar { display: none; }
        </style>
    </div>
</section>

<!-- PRODUCTS -->
<section class="section-padding bg-light" id="products">
    <div class="container">
        <div class="section-head text-center">
            <span>Popular Products</span>
            <h2>Best Selling Products</h2>
        </div>
        <div class="row g-4">
            @foreach($bestSellingProducts->take(8) as $product)
                @php
                    $displayImage = $product->image;
                    if(empty($displayImage)) {
                        if(!empty($product->variants) && is_array($product->variants)) {
                            foreach($product->variants as $v) {
                                if(!empty($v['image'])) {
                                    $displayImage = $v['image'];
                                    break;
                                }
                            }
                        }
                    }
                    $isNew = $product->created_at && $product->created_at->diffInDays(now()) < 30;
                    $hasDiscount = $product->has_active_discount;
                    $discountedPrice = $product->price;
                    if ($hasDiscount) {
                        if ($product->discount_type === 'percent') {
                            $discountedPrice = $product->price - ($product->price * $product->discount_value) / 100;
                        } else {
                            $discountedPrice = $product->price - $product->discount_value;
                        }
                    }
                @endphp
                <div class="col-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-img">
                            <a href="{{ route('product.details', $product->slug) }}">
                                @if($displayImage)
                                    <img src="{{ asset('storage/' . $displayImage) }}" alt="{{ $product->name }}">
                                @else
                                    <img src="https://images.unsplash.com/photo-1610652492500-ded49ceeb378?auto=format&fit=crop&w=700&q=80" alt="{{ $product->name }}">
                                @endif
                            </a>
                            
                            @if($hasDiscount && $product->discount_type === 'percent')
                                <span class="badge-product badge-sale">-{{ round($product->discount_value) }}%</span>
                            @elseif($isNew)
                                <span class="badge-product badge-new">NEW</span>
                            @endif

                            <button class="wishlist">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>
                        <div class="product-info">
                            <div class="product-category">
                                {{ $product->category->name ?? 'Category' }}
                            </div>
                            <a href="{{ route('product.details', $product->slug) }}" class="product-title d-block" style="text-decoration:none;">
                                {{ Str::limit($product->name, 25) }}
                            </a>
                            <div>
                                <span class="rating">★★★★★</span>
                                <span class="review-count">(10)</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <span class="price">৳{{ number_format($discountedPrice) }}</span>
                                    @if($hasDiscount)
                                        <span class="old-price">৳{{ number_format($product->price) }}</span>
                                    @endif
                                </div>
                                <button class="add-cart add-to-cart-btn" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $discountedPrice }}" data-image="{{ $displayImage ? asset('storage/'.$displayImage) : '' }}" data-original-price="{{ $product->price }}">
                                    <i class="bi bi-bag-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('shop', ['sort' => 'best_selling']) }}" class="btn hero-btn hero-btn-primary px-5" style="text-decoration:none;">
                VIEW ALL PRODUCTS
            </a>
        </div>
    </div>
</section>

<!-- CATEGORY WISE PRODUCTS -->
@foreach($homeCategories as $index => $category)
    @if($category->products->count() > 0)
        <section class="section-padding {{ $index % 2 == 1 ? 'bg-light' : '' }}">
            <div class="container">
                <div class="section-head text-center">
                    <span>{{ $category->name }} Collection</span>
                    <h2>Top {{ $category->name }}</h2>
                </div>
                <div class="row g-4" id="category-products-{{ $category->id }}">
                    @foreach($category->products->take(4) as $product)
                        @include('frontend.partials.product_card', ['product' => $product])
                    @endforeach
                </div>
                @if($category->products_count > 4)
                    <div class="text-center mt-5" id="load-more-container-{{ $category->id }}">
                        <button class="btn hero-btn hero-btn-primary px-5 load-more-category-btn" data-category="{{ $category->id }}" data-page="2">
                            Load More
                        </button>
                    </div>
                @endif
            </div>
        </section>
    @endif
@endforeach



<!-- NEWSLETTER -->
<section class="section-padding">
    <div class="container">
        <div class="newsletter">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2>Get Fashion Updates</h2>
                    <p class="mb-lg-0">
                        নতুন Collection, Discount ও Special Offer
                        সবার আগে জানতে Subscribe করুন।
                    </p>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0">
                    <div class="subscribe">
                        <input type="email" placeholder="Enter your email address">
                        <button>Subscribe</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Hero Slider Background Script
    const hero = document.querySelector('.hero');
    let images = [
        "url('https://images.unsplash.com/photo-1445205170230-053b83016050?auto=format&fit=crop&w=1800&q=90')",
        "url('https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=1800&q=90')",
        "url('https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?auto=format&fit=crop&w=1800&q=90')"
    ];

    // Attempt to use dynamic hero banners from backend if they exist
    @if(isset($heroBanners) && count($heroBanners) > 0)
        images = [
            @foreach($heroBanners as $banner)
                "url('{{ asset('storage/' . str_replace('\\', '/', $banner)) }}')",
            @endforeach
        ];
        hero.style.backgroundImage = `linear-gradient(100deg, rgba(20,33,61,.95) 0%, rgba(111,66,193,.80) 47%, rgba(232,62,140,.35) 100%), ${images[0]}`;
    @endif

    let currentIndex = 0;
    hero.style.transition = "background-image 1s ease-in-out";
    
    if(images.length > 1) {
        setInterval(() => {
            currentIndex = (currentIndex + 1) % images.length;
            hero.style.backgroundImage = `linear-gradient(100deg, rgba(20,33,61,.95) 0%, rgba(111,66,193,.80) 47%, rgba(232,62,140,.35) 100%), ${images[currentIndex]}`;
        }, 3000);
    }

    // Simple countdown logic for Flash Sale
    const countDownDate = new Date().getTime() + (2 * 24 * 60 * 60 * 1000) + (15 * 60 * 60 * 1000); // ~2 days 15 hours from now
    const x = setInterval(function() {
        const now = new Date().getTime();
        const distance = countDownDate - now;

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("days").innerHTML = days < 10 ? '0' + days : days;
        document.getElementById("hours").innerHTML = hours < 10 ? '0' + hours : hours;
        document.getElementById("minutes").innerHTML = minutes < 10 ? '0' + minutes : minutes;
        document.getElementById("seconds").innerHTML = seconds < 10 ? '0' + seconds : seconds;

        if (distance < 0) {
            clearInterval(x);
        }
    }, 1000);

    // Auto Slide Helper Function
    function setupAutoSlide(slider, interval = 3000) {
        if (!slider || !slider.firstElementChild) return;
        
        setInterval(() => {
            // scroll amount = card width + gap approx
            const scrollAmount = slider.firstElementChild.offsetWidth + 24; 
            
            // Check if reached end (added 10px buffer)
            if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 10) {
                slider.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        }, interval);
    }

    // Category Slider Navigation
    const catSlider = document.querySelector('.category-slider');
    const catPrev = document.querySelector('.cat-prev');
    const catNext = document.querySelector('.cat-next');

    if (catSlider) {
        setupAutoSlide(catSlider);
        if (catPrev && catNext) {
            catPrev.addEventListener('click', () => {
                catSlider.scrollBy({ left: -(catSlider.firstElementChild.offsetWidth + 24), behavior: 'smooth' });
            });
            catNext.addEventListener('click', () => {
                catSlider.scrollBy({ left: catSlider.firstElementChild.offsetWidth + 24, behavior: 'smooth' });
            });
        }
    }

    // Flash Sale Slider Navigation
    const fsSlider = document.querySelector('.flash-sale-slider');
    const fsPrev = document.querySelector('.fs-prev');
    const fsNext = document.querySelector('.fs-next');

    if (fsSlider) {
        setupAutoSlide(fsSlider);
        if (fsPrev && fsNext) {
            fsPrev.addEventListener('click', () => {
                fsSlider.scrollBy({ left: -(fsSlider.firstElementChild.offsetWidth + 24), behavior: 'smooth' });
            });
            fsNext.addEventListener('click', () => {
                fsSlider.scrollBy({ left: fsSlider.firstElementChild.offsetWidth + 24, behavior: 'smooth' });
            });
        }
    }

    // Load More Category Products
    document.querySelectorAll('.load-more-category-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const categoryId = this.dataset.category;
            let page = parseInt(this.dataset.page);
            const originalText = this.innerText;
            this.innerText = 'Loading...';
            this.disabled = true;

            fetch(`/?category_id=${categoryId}&page=${page}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.html) {
                    document.getElementById(`category-products-${categoryId}`).insertAdjacentHTML('beforeend', data.html);
                    this.dataset.page = page + 1;
                }
                
                if (!data.has_more) {
                    this.parentElement.style.display = 'none';
                } else {
                    this.innerText = originalText;
                    this.disabled = false;
                }
            })
            .catch(err => {
                console.error(err);
                this.innerText = originalText;
                this.disabled = false;
            });
        });
    });
</script>
@endpush

@endsection
