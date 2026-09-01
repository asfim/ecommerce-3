@extends('layouts.app')

@section('title', 'Shop')

@section('content')
<div class="page-head py-4" style="background: #f8f9fa;">
  <div class="container-fluid px-2 px-md-4">
    <nav class="breadcrumb-nav mb-2">
        <a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a> / <span class="text-dark fw-semibold">Shop</span>
    </nav>
    <h1 class="fw-bold mb-0" style="font-size: 2rem;">Shop All Products</h1>
  </div>
</div>

<form id="filterForm" action="{{ route('shop') }}" method="GET">
<div class="container-fluid px-2 px-md-4 section-pad pt-4 pb-5">
  <div class="row g-4">
    <!-- Desktop Sidebar -->
    <div class="col-lg-2 d-none d-lg-block">
      <div class="filter-box mb-4 bg-white p-3 rounded shadow-sm border">
        <h6 class="fw-bold mb-3 border-bottom pb-2">Categories</h6>
        @foreach($categories as $category)
            <div class="form-check mb-2">
                <input class="form-check-input auto-submit" type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat{{ $category->id }}" {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                <label class="form-check-label text-muted" for="cat{{ $category->id }}" style="font-size: 14px;">{{ $category->name }}</label>
            </div>
        @endforeach
      </div>

      <div class="filter-box mb-4 bg-white p-3 rounded shadow-sm border">
        <h6 class="fw-bold mb-3 border-bottom pb-2">Price Range (Max)</h6>
        <input type="range" class="form-range auto-submit" name="max_price" min="0" max="100000" value="{{ request('max_price', 100000) }}" id="priceRange">
        <div class="price-range-out mt-2 fw-semibold text-primary" id="priceRangeOut" style="font-size: 14px;">৳0 – ৳{{ request('max_price', 100000) }}</div>
      </div>

      <div class="filter-box mb-4 bg-white p-3 rounded shadow-sm border">
        <h6 class="fw-bold mb-3 border-bottom pb-2">ব্র্যান্ড (Brands)</h6>
        @foreach($brands as $brand)
        <div class="form-check mb-2">
            <input class="form-check-input auto-submit" type="checkbox" name="brands[]" value="{{ $brand->id }}" id="brand{{ $brand->id }}" {{ in_array($brand->id, request('brands', [])) ? 'checked' : '' }}>
            <label class="form-check-label text-muted" for="brand{{ $brand->id }}" style="font-size: 14px;">{{ $brand->name }}</label>
        </div>
        @endforeach
      </div>

      <div class="filter-box mb-4 bg-white p-3 rounded shadow-sm border">
        <h6 class="fw-bold mb-3 border-bottom pb-2">প্রাপ্যতা (Availability)</h6>
        <div class="form-check mb-2">
            <input class="form-check-input auto-submit" type="checkbox" name="availability[]" value="in_stock" id="avail1" {{ in_array('in_stock', request('availability', [])) ? 'checked' : '' }}>
            <label class="form-check-label text-muted" for="avail1" style="font-size: 14px;">স্টকে আছে (In Stock)</label>
        </div>
      </div>

      <a href="{{ route('shop') }}" class="btn btn-outline-primary w-100 rounded-pill fw-semibold" style="font-size: 14px;">Reset Filters</a>
    </div>

    <!-- Main Content -->
    <div class="col-lg-10">
      <div class="toolbar d-flex align-items-center justify-content-between mb-4 bg-white p-2 rounded shadow-sm border">
        <span class="text-muted"><strong class="font-en text-dark">{{ $products instanceof \Illuminate\Pagination\LengthAwarePaginator ? $products->total() : $products->count() }}</strong> Products Found</span>
        
        <div class="d-flex align-items-center gap-3 flex-wrap">
          <button type="button" class="btn btn-outline-primary btn-sm d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
            <i class="bi bi-sliders"></i> Filter
          </button>
          
          <select name="sort" class="form-select sort-select auto-submit" style="width:auto; cursor:pointer;">
            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest Arrivals</option>
            <option value="best_selling" {{ request('sort') == 'best_selling' ? 'selected' : '' }}>Best Selling</option>
            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
          </select>
        </div>
      </div>

      @if($products->isEmpty())
        <div class="text-center py-5 bg-white rounded-3 shadow-sm border">
            <i class="bi bi-box2 text-muted d-block mb-3" style="font-size: 3rem;"></i>
            <h4 class="fw-bold text-muted">No Products Found</h4>
            <p class="text-muted mb-4">We couldn't find any products matching your criteria.</p>
            <a href="{{ route('shop') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold">Reset Filters</a>
        </div>
      @else
        <!-- Products Grid -->
        <div class="row g-3">
          @foreach($products as $product)
              @include('frontend.partials.product_card', ['product' => $product])
          @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-5 d-flex justify-content-center">
            @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {{ $products->withQueryString()->links() }}
            @endif
        </div>
      @endif
    </div>
  </div>
</div>

<!-- Mobile Filter Offcanvas -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="filterOffcanvas">
  <div class="offcanvas-header border-bottom">
    <h5 class="mb-0 fw-bold">Filters</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <div class="filter-box mb-4">
      <h6 class="fw-bold mb-3 border-bottom pb-2">Categories</h6>
      @foreach($categories as $category)
          <div class="form-check mb-2">
              <input class="form-check-input auto-submit" type="checkbox" name="categories[]" value="{{ $category->id }}" id="m_cat{{ $category->id }}" {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
              <label class="form-check-label text-muted" for="m_cat{{ $category->id }}">{{ $category->name }}</label>
          </div>
      @endforeach
    </div>

    <div class="filter-box mb-4">
      <h6 class="fw-bold mb-3 border-bottom pb-2">Price Range (Max)</h6>
      <input type="range" class="form-range auto-submit" name="max_price" min="0" max="100000" value="{{ request('max_price', 100000) }}" id="m_priceRange">
      <div class="price-range-out mt-2 fw-semibold text-primary" id="m_priceRangeOut">৳0 – ৳{{ request('max_price', 100000) }}</div>
    </div>

    <div class="filter-box mb-4">
      <h6 class="fw-bold mb-3 border-bottom pb-2">ব্র্যান্ড (Brands)</h6>
      @foreach($brands as $brand)
      <div class="form-check mb-2">
          <input class="form-check-input auto-submit" type="checkbox" name="brands[]" value="{{ $brand->id }}" id="m_brand{{ $brand->id }}" {{ in_array($brand->id, request('brands', [])) ? 'checked' : '' }}>
          <label class="form-check-label text-muted" for="m_brand{{ $brand->id }}">{{ $brand->name }}</label>
      </div>
      @endforeach
    </div>

    <div class="filter-box mb-4">
      <h6 class="fw-bold mb-3 border-bottom pb-2">প্রাপ্যতা (Availability)</h6>
      <div class="form-check mb-2"><input class="form-check-input auto-submit" type="checkbox" name="availability[]" value="in_stock" id="m_avail1" {{ in_array('in_stock', request('availability', [])) ? 'checked' : '' }}><label class="form-check-label text-muted" for="m_avail1">স্টকে আছে</label></div>
    </div>

    <a href="{{ route('shop') }}" class="btn btn-outline-primary w-100 rounded-pill fw-semibold mb-4">Reset Filters</a>
  </div>
</div>
</form>

<style>
    /* Colorful Price Range Slider */
    input[type="range"] {
        -webkit-appearance: none;
        width: 100%;
        background: transparent;
    }
    input[type="range"]:focus {
        outline: none;
    }
    input[type="range"]::-webkit-slider-runnable-track {
        width: 100%;
        height: 6px;
        cursor: pointer;
        background: linear-gradient(90deg, #ff5521 0%, #ffc107 100%);
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1) inset;
    }
    input[type="range"]::-webkit-slider-thumb {
        height: 20px;
        width: 20px;
        border-radius: 50%;
        background: #ff5521;
        cursor: pointer;
        -webkit-appearance: none;
        margin-top: -7px;
        border: 2px solid #fff;
        box-shadow: 0 2px 5px rgba(255,85,33,0.4);
        transition: transform 0.1s ease;
    }
    input[type="range"]::-webkit-slider-thumb:active {
        transform: scale(1.2);
    }
</style>
<script>
    document.querySelectorAll('input[type="range"]').forEach(slider => {
        slider.addEventListener('input', function() {
            const outId = this.id + 'Out';
            const outEl = document.getElementById(outId);
            if(outEl) outEl.innerText = '৳0 – ৳' + Number(this.value).toLocaleString();
        });
    });

    document.querySelectorAll('.auto-submit').forEach(el => {
        el.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });
</script>
@endsection
