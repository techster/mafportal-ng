<?php

namespace App\Http\Controllers;

use Backpack\PageManager\app\Models\Page;
use Illuminate\Support\Facades\App;

class PageController extends Controller
{
    public function index($slug, $subs = null)
    {
        if ($subs) {
            $sectionSlug = $slug.'/'.$subs;
            $page = Page::findBySlug($sectionSlug);

            if (!$page && $slug === 'mafworldcup-history') {
                $page = Page::findBySlug($subs);
            }
        } else {
            $page = Page::findBySlug($slug);
        }

        if (!$page)
        {
            abort(404, 'Please go back to our <a href="'.url('').'">homepage</a>.');
        }

        $json = json_decode($page->extras);
        if(isset($json->title_rus)) {
            $this->data['title'] = (App::getLocale() == 'ru'?$json->title_rus:$page->title);
        } else {
            $this->data['title'] = $page->title;
        }

        $this->data['page'] = $page->withFakes();

        if(isset($json->meta_title_ru) && isset($json->meta_title)) {
            $this->data['meta_title'] =  (App::getLocale() == 'ru'?$json->meta_title_ru:$json->meta_title);
        } else {
            $this->data['meta_title'] =  (App::getLocale() == 'ru'?$page->meta_title_ru:$page->meta_title_en);
        }
        if(isset($json->meta_description_ru) && isset($json->meta_description)) {
            $this->data['meta_description'] =  (App::getLocale() == 'ru'?$json->meta_description_ru:$json->meta_description);
        } else {
            $this->data['meta_description'] =  (App::getLocale() == 'ru'?$page->meta_description_ru:$page->meta_description_en);
        }
        $this->data['meta_keywords'] =  (App::getLocale() == 'ru'?$page->meta_keywords_ru:$page->meta_keywords_en);
        $this->data['social_meta_title'] =  (App::getLocale() == 'ru'?$page->social_meta_title_ru:$page->social_meta_title_en);
        $this->data['social_meta_description'] =  (App::getLocale() == 'ru'?$page->social_meta_description_ru:$page->social_meta_description_en);

        return view('pages.'.$page->template, $this->data);
    }


}