<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Slide;
use App\Models\News;
use App\Models\Testimonial;
use App\Models\Event;
use App\Models\Tournament;
use App\Models\Contact;
use App\Notifications\ContactNotification;
use Backpack\PageManager\app\Models\Page;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partners = Partner::orderBy('id', 'desc')->get();
        $slides = Slide::orderBy('id', 'desc')->get();
        $news = News::orderBy('id', 'desc')->paginate(10);
        $testimonials = Testimonial::orderBy('id', 'desc')->get();
        $about = Page::find(3);

        $tournaments = Tournament::select(\DB::raw("id, slug, title, description, title_ru, description_ru, created_at, 'tournament' as type"))
            ->whereDate('created_at', '>=', Carbon::now()->format('Y-m-d H:i:s'));

        $events = Event::select(\DB::raw("id, slug, title, description, title_ru, description_ru, created_at, 'event' as type"))
            ->whereDate('created_at', '>=', Carbon::now()->format('Y-m-d H:i:s'))
            ->union($tournaments)
            ->orderBy('created_at', 'asc')
            ->get();


        return view('index', [
            'news' => $news,
            'testimonials' => $testimonials,
            'slides' => $slides,
            'about' => $about->withFakes(),
            'partners' => $partners,
            'events' => $events,
        ]);
    }

    public function contact(Request $request)
    {
        $contact = new Contact;
        $contact->name    = $request->name;
        $contact->email   = $request->email;
        $contact->content = $request->cont;
        $contact->save();

        $contact->notify(new ContactNotification($contact));
        return back();
    }
}
