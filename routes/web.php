<?php

// ADMIN
$arr = array(
    'admin',
);
if ((in_array(Request::segment(1),$arr))) {
    $locale = 'en';
    \App::setLocale($locale);
}


Route::group(['prefix' => 'admin', 'middleware' => ['AdminMiddleware'], 'namespace' => 'Admin'], function () {
    CRUD::resource('menu-item',              'MenuItemCrudController');
    Route::get('page/create/{template}',     'PageCrudController@create');
    Route::get('page/{id}/edit/{template}',  'PageCrudController@edit');
    Route::get('page/reorder',               'PageCrudController@reorder');
    Route::get('page/reorder/{lang}',        'PageCrudController@reorder');
    Route::post('page/reorder',              'PageCrudController@saveReorder');
    Route::post('page/reorder/{lang}',       'PageCrudController@saveReorder');
    Route::get('page/{id}/details',          'PageCrudController@showDetailsRow');
    Route::get('page/{id}/translate/{lang}', 'PageCrudController@translateItem');
    Route::resource('page',                  'PageCrudController');
    CRUD::resource('news',                   'NewsCrudController');
    CRUD::resource('product',                'ProductCrudController');
    CRUD::resource('tournament',             'TournamentCrudController');
    CRUD::resource('photo_gallery',          'Photo_galleryCrudController');
    CRUD::resource('video_gallery',          'Video_galleryCrudController');
    CRUD::resource('slide',                  'SlideCrudController');
    CRUD::resource('testimonial',            'TestimonialCrudController');
    CRUD::resource('partner',                'PartnerCrudController');
    CRUD::resource('club',                   'ClubCrudController');
    CRUD::resource('country',                'CountryCrudController');
    CRUD::resource('event',                  'EventCrudController');
    CRUD::resource('contact',                'ContactCrudController');
    CRUD::resource('seasons',                'SeasonCrudController');
    Route::get('options',                    'OptionController@index');
    Route::get('/confirm_user_to_club/{club_id}/{user_id}', 'UserCrudController@confirm_user_to_club');
    Route::get('/cancel_user_to_club/{club_id}/{user_id}',  'UserCrudController@cancel_user_to_club');
});

$locale = Request::segment(1);

if ((!in_array(Request::segment(1),$arr)) && (strlen($locale) > 2 )) {
	if (in_array(Config::get('app.locale'), Config::get('app.available_locales'))){
		$locale = Config::get('app.locale');
		\App::setLocale($locale);
	}
	else {
		$locale = 'en';
		\App::setLocale($locale);
	}

	Route::get(Request::path(), function () {
		$local = Config::get('app.locale');

		return redirect('/'.$local.'/'.Request::path());

	});
}

else {

	if (in_array($locale, Config::get('app.available_locales'))) {

		\App::setLocale($locale);

	}

	else {
		if (in_array(Config::get('app.locale'), Config::get('app.available_locales'))){
			$locale = Config::get('app.locale');
		}
		else {
			$locale = 'en';
		}

	}

	Route::get('/', function () {
		if (in_array(Config::get('app.locale'), Config::get('app.available_locales'))){
			return redirect('/'.Config::get('app.locale'));
		} else {
			return redirect('/en/');
		}

	});
}

Route::get('auth/google',                            'Auth\RegisterController@redirectToGoogle');
Route::get('auth/google/callback',                   'Auth\RegisterController@handleGoogleCallback');
Route::get('auth/facebook',                          'Auth\RegisterController@redirectToFacebook');
Route::get('auth/facebook/callback',                 'Auth\RegisterController@handleFacebookCallback');
Route::get('auth/instagram',                         'Auth\RegisterController@redirectToInstagram');
Route::get('auth/instagram/callback',                'Auth\RegisterController@handleInstagramCallback');

// FRONT
Route::group(['prefix' => $locale], function () {
    Route::get('/all/clubs/rating/',                 'ClubController@allrating')->name('allrating');
    Auth::routes();
	Route::post('/logout/',                             'AccountController@performLogout')->name('performLogout');
    Route::get('/',                                     'IndexController@index')->name('home');
    Route::get('/clubs/',                               'ClubController@index')->name('clubs');
    Route::get('/clubs/global/{id}/rating',             'ClubController@globalRating')->name('club_global_rating');
    Route::get('/clubs/{slug}/',                        'ClubController@single')->name('single_clubs');
    Route::get('/clubs/{slug}/about/' ,                 'ClubController@about')->middleware('club')->name('club_about');
    Route::get('/clubs/{slug}/rating/',                 'ClubController@rating')->middleware('club')->name('club_rating');
    Route::get('/clubs/{slug}/events/' ,                'ClubController@events')->middleware('club')->name('club_events');
    Route::get('/clubs/{slug}/events/{event_slug}',     'ClubController@event')->name('club_single_events');
    Route::get('/clubs/{slug}/gallery/',                'ClubController@gallery')->middleware('club')->name('club_gallery');
    Route::get('/news/',                                'NewsController@index')->name('news');
    Route::get('/news/{slug}/',                         'NewsController@show')->name('single_news');
    Route::get('/tournaments/',                         'TournamentController@index')->name('tournaments');
    Route::post('/tournaments/contactForm',             'TournamentController@contactForm')->name('tournaments.contactForm');
    Route::get('/tournaments/{slug}/',                  'TournamentController@show')->name('single_tournaments');
    Route::get('/tournaments/{slug}/about/',            'TournamentController@about')->name('tournaments_about');
    Route::get('/tournaments/{slug}/rating/',           'TournamentController@rating')->name('tournaments_rating');
    Route::get('/tournaments/{slug}/gallery/',          'TournamentController@gallery')->name('tournaments_gallery');
    Route::get('/tournaments/{slug}/schedule/',         'TournamentController@schedule')->name('tournaments_schedule');
    Route::get('/tournaments/{slug}/live/',             'TournamentController@live')->name('tournaments_live');
    Route::get('/shop/',                                'ProductController@index')->name('shop');
    Route::get('/cart/',                                'ProductController@cart')->name('cart');
    Route::get('/shop/thank/',                          'ProductController@thank')->name('thank');
    Route::get('/shop/cancel/',                         'ProductController@cancel')->name('cancel');
    Route::post('/shop/add_to_cart/',                   'ProductController@add_to_cart')->name('add_to_cart');
    Route::post('/shop/remove_from_cart/',              'ProductController@remove_from_cart')->name('remove_from_cart');
    Route::post('/shop/change_qty_in_cart/',            'ProductController@change_qty_in_cart')->name('change_qty_in_cart');
    Route::post('/shop/send_order/',                    'ProductController@send_order')->name('send_order');
    Route::post('auth/facebook/callback',               'Auth\RegisterController@handleProviderCallback');
    Route::get('/gallery/',                             'PhotoGalleryController@index')->name('gallery');
    Route::get('/gallery/photo/{slug}/',                'PhotoGalleryController@show')->name('single_photo');
    Route::post('/gallery/uploadphoto/',                'PhotoGalleryController@uploadPhoto')->name('upload_photo');
    Route::get('/account/',                             'AccountController@index')->middleware('auth')->name('account');
    Route::post('/image-crop/',                         'AccountController@imageCropPost')->middleware('auth')->name('image-crop');
    Route::post('/image-delete/',                       'AccountController@imageDelete')->middleware('auth')->name('image-delete');
    Route::post('/account/edit_account/',               'AccountController@edit_account')->middleware('auth')->name('edit_account');
    Route::get('/account/my_clubs/',                    'AccountController@clubs')->middleware('auth')->name('account_clubs');
    Route::get('/account/balance/',                     'AccountController@balance')->middleware('auth')->name('account_balance');
    Route::get('/account/games/',                       'AccountController@games')->middleware('auth')->name('games');
    Route::post('/account/apple_club/',                 'AccountController@apple_club')->middleware('auth')->name('apple_club');
    Route::get('/modal/',                               function () { return view('modal'); })->name('modal');
    Route::get('/shop-modal/',                          function () { return view('shop-modal'); })->name('shop-modal');
    Route::post('/register/check_email/',               'IndexController@check_email')->name('checkEmailSame');
    Route::get('/register/verify/{token}/',             'IndexController@verify')->name('registerVerify');
    Route::get('/register/send_confirm_email/',         'IndexController@send_confirm_email')->name('sendConfirmEmail');
    Route::post('/contact/',                            'IndexController@contact')->name('contact');
    Route::get('/api/user/',                            'Admin\UserCrudController@api_index')->name('api_index');
    Route::get('/api/user/{id}/',                       'Admin\UserCrudController@api_show')->name('api_show');
    Route::get('/mafworldcup-history/{slug}/',           ['uses' => 'PageController@index']);
    Route::get('/{page}/{subs?}/',                      ['uses' => 'PageController@index'])->where(['page' => '^((?!admin).)*$', 'subs' => '.*']);

});

Route::get('/club-rating-demo', function () {
    return view('club-rating-demo');
});
