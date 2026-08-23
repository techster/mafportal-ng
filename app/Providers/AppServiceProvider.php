<?php

namespace App\Providers;

use App\Models\GenSetting;
use App\Models\MenuItem;
use Backpack\PageManager\app\Models\Page;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Получаем переменную меню для всех вьюшек
        if(Schema::hasTable('menu_items')){
            $menu = MenuItem::orderBy('lft', 'asc')->get();
            \View::share('menu', $menu);
        }


        // Получаем контактные данные для всех вьюшек
        if(Schema::hasTable('pages')){
            $contacts = Page::find(5);
            if ($contacts) {
                $this->data['footer_contacts'] = $contacts;
                \View::share($this->data);
            }
        }

        if (Schema::hasTable('gen_settings')) {
            $thumb_image = GenSetting::where('option', 'Meta Settings')->get();
            view()->share('meta_settings', $thumb_image);
        }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
