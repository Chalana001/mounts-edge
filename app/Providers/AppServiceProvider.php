<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $settings = null;

        View::composer('*', function ($view) use (&$settings) {
            $settings ??= Schema::hasTable('site_settings')
                ? SiteSetting::current()
                : new SiteSetting(SiteSetting::DEFAULTS);

            $view->with('siteSettings', $settings);
        });

        // Page views (contact, dining, ...) render the layout's SEO copy
        // visibly via <x-seo-intro>/<x-seo-faq>, but the layout computes
        // $seo after the page view has already been rendered — so the
        // composer supplies it here for every view that asks.
        View::composer(['contact', 'dining', 'experiences', 'gallery', 'luxury-stay', 'weddings', 'welcome'], function ($view) {
            $settings = Schema::hasTable('site_settings')
                ? SiteSetting::current()
                : new SiteSetting(SiteSetting::DEFAULTS);

            $view->with('seo', \App\Support\SeoMeta::forRequest(request(), $settings));
        });
    }
}
