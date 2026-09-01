@extends('layouts.backend.app')

@section('title', 'Homepage Settings')

@section('content')
<div class="clearfix mb-4">
  <h4>Homepage Settings</h4>
</div>

@php
  $tab = request('tab', 'hero_banners');
  $tabs = [
    'hero_banners'           => [
      'label' => 'Hero Section Banner',
      'max' => 3,
      'icon' => 'bi-image',
      'recommendation' => 'Recommended size: 900 x 440 px (Perfect fit)'
    ],
    'features'               => [
      'label' => 'Features Section',
      'max' => 0,
      'icon' => 'bi-star',
      'recommendation' => ''
    ],
    // 'best_selling_banners'   => [
    //   'label' => 'Best Selling Banner',
    //   'max' => 3,
    //   'icon' => 'bi-stars',
    //   'recommendation' => 'Recommended size: 394 x 220 px (Aspect ratio ~ 16:9)'
    // ],
    // 'discounted_products_banner' => [
    //   'label' => 'Discounted Products',
    //   'max' => 1,
    //   'icon' => 'bi-lightning',
    //   'recommendation' => 'Recommended size: 285 x 200 px (Aspect ratio ~ 4:3 / 3:2)'
    // ],
  ];
@endphp

<div class="row g-4">

  {{-- Left Tabs --}}
  <div class="col-md-3">
    <div class="stat-card p-0" style="overflow:hidden;">
      <div class="list-group list-group-flush rounded-3">
        @foreach($tabs as $key => $info)
          <a href="{{ route('admin.settings.homepage', ['tab' => $key]) }}"
             class="list-group-item list-group-item-action d-flex align-items-center gap-2 py-3 px-3 {{ $tab === $key ? 'active' : '' }}">
            <i class="bi {{ $info['icon'] }}"></i>
            <span class="small fw-semibold">{{ $info['label'] }}</span>
          </a>
        @endforeach
      </div>
    </div>
  </div>

  {{-- Right Content --}}
  <div class="col-md-9">
    @foreach($tabs as $key => $info)
      @if($tab === $key)
        <div class="stat-card">
          <h5 class="fw-bold mb-1"><i class="bi {{ $info['icon'] }} me-2 text-primary"></i>{{ $info['label'] }}</h5>
          <p class="text-muted small mb-4">Maximum {{ $info['max'] }} {{ $info['max'] > 1 ? 'images' : 'image' }} allowed for this section.</p>

          @if(session('success'))
            <div class="alert alert-success py-2">{{ session('success') }}</div>
          @endif

          {{-- Current Images --}}
          @php $current = $settings[$key] ?? []; @endphp
          @if(count($current) > 0)
            <div class="mb-4">
              <label class="form-label fw-semibold small">Current Images</label>
              <form method="POST" action="{{ route('admin.settings.homepage.update', $key) }}" id="delete-form-{{ $key }}">
                @csrf
                <div class="d-flex flex-wrap gap-3">
                  @foreach($current as $img)
                    <div class="position-relative">
                      <img src="{{ asset('storage/' . $img) }}" alt="Banner"
                           style="height:100px;width:160px;object-fit:cover;border-radius:8px;border:1px solid #ddd;">
                      <button type="submit" name="delete_images[]" value="{{ $img }}"
                              class="btn btn-danger btn-sm position-absolute top-0 end-0 rounded-circle p-0"
                              style="width:22px;height:22px;font-size:11px;line-height:1;"
                              onclick="return confirm('Remove this image?')">
                        <i class="bi bi-x"></i>
                      </button>
                    </div>
                  @endforeach
                </div>
              </form>
            </div>
          @endif

          {{-- Upload Form --}}
          @if(count($current) < $info['max'])
            <form method="POST" action="{{ route('admin.settings.homepage.update', $key) }}"
                  enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                <label class="form-label fw-semibold">
                  Upload {{ $info['max'] > 1 ? 'Images' : 'Image' }}
                  <span class="text-muted fw-normal small">({{ $info['max'] - count($current) }} slot(s) remaining)</span>
                </label>
                <input type="file" name="images[]" class="form-control"
                       accept="image/*"
                       {{ $info['max'] - count($current) > 1 ? 'multiple' : '' }}
                       required style="border-color: #a1a1a1 !important;">
                <div class="form-text d-flex align-items-center gap-1 mt-2 text-secondary">
                  <i class="bi bi-info-circle-fill text-primary"></i>
                  <span>Accepted: JPG, PNG, WebP. <strong>{{ $info['recommendation'] }}</strong></span>
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-sm">
                <i class="bi bi-upload me-1"></i> Save Images
              </button>
            </form>
          @else
            <div class="alert alert-info py-2 small">
              <i class="bi bi-info-circle me-1"></i>
              Maximum images reached. Remove an existing image to upload a new one.
            </div>
          @endif

          @if($key === 'hero_banners')
            <hr class="my-4">
            <h6 class="fw-bold mb-3">Hero Section Texts</h6>
            <form method="POST" action="{{ route('admin.settings.homepage.update', $key) }}">
              @csrf
              <div class="mb-3">
                <label class="form-label fw-semibold">Hero Badge</label>
                <input type="text" name="hero_badge" class="form-control" value="{{ old('hero_badge', $settings['hero_badge'] ?? '') }}">
                <div class="form-text">Example: ✨ NEW COLLECTION 2026</div>
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Hero Title</label>
                <textarea name="hero_title" class="form-control" rows="3">{{ old('hero_title', $settings['hero_title'] ?? '') }}</textarea>
                <div class="form-text">You can use HTML tags like <code>&lt;span&gt;text&lt;/span&gt;</code> for the yellow highlighted text and <code>&lt;br&gt;</code> for line breaks.</div>
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Hero Subtitle</label>
                <textarea name="hero_subtitle" class="form-control" rows="2">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}</textarea>
              </div>
              <button type="submit" class="btn btn-primary btn-sm">
                <i class="bi bi-save me-1"></i> Save Texts
              </button>
            </form>
          @elseif($key === 'features')
            <form method="POST" action="{{ route('admin.settings.homepage.update', $key) }}">
              @csrf
              @php $features = $settings['features'] ?? []; @endphp
              
              <div class="row g-3 mb-4">
                @for($i = 0; $i < 4; $i++)
                  @php $feat = $features[$i] ?? []; @endphp
                  <div class="col-md-6">
                    <div class="border rounded p-3 bg-light">
                      <h6 class="fw-bold mb-3">Feature {{ $i + 1 }}</h6>
                      <div class="mb-2">
                        <label class="form-label small fw-semibold">Icon Class</label>
                        <input type="text" name="features[{{ $i }}][icon]" class="form-control form-control-sm" value="{{ $feat['icon'] ?? '' }}" placeholder="bi-truck">
                      </div>
                      <div class="mb-2">
                        <label class="form-label small fw-semibold">Title</label>
                        <input type="text" name="features[{{ $i }}][title]" class="form-control form-control-sm" value="{{ $feat['title'] ?? '' }}">
                      </div>
                      <div class="mb-2">
                        <label class="form-label small fw-semibold">Subtitle</label>
                        <input type="text" name="features[{{ $i }}][subtitle]" class="form-control form-control-sm" value="{{ $feat['subtitle'] ?? '' }}">
                      </div>
                      <div class="mb-2">
                        <label class="form-label small fw-semibold">Color Class</label>
                        <select name="features[{{ $i }}][color]" class="form-select form-select-sm">
                          <option value="icon-orange" {{ ($feat['color'] ?? '') == 'icon-orange' ? 'selected' : '' }}>Orange</option>
                          <option value="icon-purple" {{ ($feat['color'] ?? '') == 'icon-purple' ? 'selected' : '' }}>Purple</option>
                          <option value="icon-pink" {{ ($feat['color'] ?? '') == 'icon-pink' ? 'selected' : '' }}>Pink</option>
                          <option value="icon-green" {{ ($feat['color'] ?? '') == 'icon-green' ? 'selected' : '' }}>Green</option>
                        </select>
                      </div>
                    </div>
                  </div>
                @endfor
              </div>

              <button type="submit" class="btn btn-primary btn-sm">
                <i class="bi bi-save me-1"></i> Save Features
              </button>
            </form>
          @endif
        </div>
      @endif
    @endforeach
  </div>

</div>
@endsection

@push('styles')
<style>
  .list-group-item.active {
    background-color: #1a73e8 !important;
    border-color: #1a73e8 !important;
    color: #fff !important;
  }
  .list-group-item {
    border-left: none;
    border-right: none;
    transition: background .15s;
  }
  .list-group-item:first-child { border-top: none; }
</style>
@endpush
