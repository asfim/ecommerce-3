<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSetting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class HomepageSettingController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:manage-homepage-settings,admin'),
        ];
    }

    // Section definitions: key => max images
    private array $sections = [
        'hero_banners' => 3,
        'best_selling_banners' => 3,
        'discounted_products_banner' => 1,
        'features' => 0, // 0 means no images
    ];

    public function index()
    {
        $settings = [];
        foreach (array_keys($this->sections) as $key) {
            $settings[$key] = HomepageSetting::get($key, []);
        }

        $settings['hero_badge'] = HomepageSetting::get('hero_badge', '✨ NEW COLLECTION ' . date('Y'));
        $settings['hero_title'] = HomepageSetting::get('hero_title', "বাংলাদেশের\n<span>রঙে</span><br>\nআপনার Fashion");
        $settings['hero_subtitle'] = HomepageSetting::get('hero_subtitle', "Premium Panjabi, Saree, Three Piece, T-Shirt,\nShirt এবং নতুন Fashion Collection এখন এক জায়গায়।");
        
        if (empty($settings['features'])) {
            $settings['features'] = [
                ['icon' => 'bi-truck', 'title' => 'Fast Delivery', 'subtitle' => 'সারাদেশে দ্রুত ডেলিভারি', 'color' => 'icon-orange'],
                ['icon' => 'bi-cash-stack', 'title' => 'Cash on Delivery', 'subtitle' => 'পণ্য পেয়ে মূল্য পরিশোধ', 'color' => 'icon-purple'],
                ['icon' => 'bi-arrow-repeat', 'title' => 'Easy Exchange', 'subtitle' => 'সহজ Size Exchange', 'color' => 'icon-pink'],
                ['icon' => 'bi-shield-check', 'title' => 'Secure Payment', 'subtitle' => 'bKash, Nagad & Card', 'color' => 'icon-green'],
            ];
        }

        return view('backend.settings.homepage', compact('settings'));
    }

    public function update(Request $request, string $section)
    {
        if (! array_key_exists($section, $this->sections)) {
            abort(404);
        }

        if ($section === 'features') {
            $features = [];
            if ($request->has('features')) {
                foreach ($request->input('features') as $index => $feature) {
                    $features[] = [
                        'icon' => $feature['icon'] ?? '',
                        'title' => $feature['title'] ?? '',
                        'subtitle' => $feature['subtitle'] ?? '',
                        'color' => $feature['color'] ?? 'icon-orange',
                    ];
                }
            }
            HomepageSetting::set('features', $features);
        } else {
            $maxImages = $this->sections[$section];
            $existing = HomepageSetting::get($section, []);
            $images = is_array($existing) ? $existing : [];

            // Handle deletions first
            if ($request->has('delete_images')) {
                foreach ($request->delete_images as $path) {
                    $fullPath = storage_path('app/public/'.$path);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                    $images = array_values(array_filter($images, fn ($i) => $i !== $path));
                }
            }

            // Handle new uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    if (count($images) >= $maxImages) {
                        break; // enforce max
                    }
                    $path = $file->store('homepage', 'public');
                    $images[] = $path;
                }
            }

            HomepageSetting::set($section, $images);
        }

        // Handle text fields for hero_banners
        if ($section === 'hero_banners') {
            if ($request->has('hero_badge')) HomepageSetting::set('hero_badge', $request->input('hero_badge'));
            if ($request->has('hero_title')) HomepageSetting::set('hero_title', $request->input('hero_title'));
            if ($request->has('hero_subtitle')) HomepageSetting::set('hero_subtitle', $request->input('hero_subtitle'));
        }

        return redirect()
            ->route('admin.settings.homepage', ['tab' => $section])
            ->with('success', 'Section updated successfully.');
    }
}
