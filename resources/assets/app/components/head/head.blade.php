<?php
$title = isset($title) ? $title : $meta_settings[0]->title;
$title_cont = isset($title_cont) ? $title_cont : $meta_settings[0]->title;
$description = isset($description) ? $description : $meta_settings[0]->description;
$image = isset($image) ? $image : asset($meta_settings[0]->value);

$meta_title = (isset($meta_title) ? $meta_title : $title);
$meta_description = (isset($meta_description) ? $meta_description : $description);
$meta_keywords = (isset($meta_keywords) ? $meta_keywords : 'Maf portal');

$social_meta_title = (isset($social_meta_title) ? $social_meta_title : $meta_title);
$social_meta_description = (isset($social_meta_description) ? $social_meta_description : $meta_description);
?>

        <!DOCTYPE html>
<html ng-app="app">
<head>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $meta_title }}</title>
    <meta name="keywords" content="{{ $meta_keywords }}">
    <meta name="description" content="{{ $meta_description }}">
    <meta name="author" content="Maf Club, Inc.">
    {{--SOC--}}
    <meta property="og:site_name" content="Maf portal">
    <meta property="og:title" content="{{ $social_meta_title }}"/>
    <meta property="og:description" content="{{ $social_meta_description }}"/>
    <meta property="og:url" content="{{url('/')}}"/>
    <meta property="og:image" content="{{ asset($image) }}"/>
    <meta property="vk:image" content="{{ asset($image) }}"/>
    <!--FAVICON-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/build/img/icon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('/build/img/icon/favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('/build/img/icon/favicon-16x16.png') }}" sizes="16x16">
    <link rel="manifest" href="{{ asset('/build/img/icon/manifest.json') }}">
    <link rel="mask-icon" href="{{ asset('/build/img/icon/safari-pinned-tab.svg') }}" color="#000000">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <meta name="theme-color" content="#000000">
    <!--CSS-->
    <link rel="stylesheet" href="{{ asset('/build/css/main.css') }}?ver=3">
    <link rel="stylesheet" href="{{ asset('/build/css/tournament-pagination.css') }}">
    <link rel="stylesheet" href="{{ asset('/build/css/tournament-filters.css') }}">
    <link rel="stylesheet" href="{{ asset('/build/css/header-branding.css') }}">
    <link rel="stylesheet" href="{{ asset('/build/css/croppie.css') }}">
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <!--AWESOME-->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv-printshiv.min.js"></script>
    <![endif]-->
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-N9TDGTD');</script>
    <!-- End Google Tag Manager -->

</head>
<body id="body" class="body">

<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N9TDGTD"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

<p style="display: none;" id="global_loc">{{ Config::get('app.locale') }}</p>


<!--[if lt IE 8]>
<p class="browserupgrade">Your browser is <strong>outdated</strong>. Please update it at <a
        href="http://browsehappy.com/">browsehappy.com</a></p>
<![endif]-->


<div class="hidden_error" style="display: none;">
    @if (session('status'))
        <span class="red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
            {{ session('status') }}
        </span>
    @endif
    @if ($errors->has('email'))
        <span class="red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
            {{ trans('auth.failed') }}
        </span>
    @endif
    @if ($errors->has('password'))
        <span class="red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
            {{ trans('passwords.sent') }}
        </span>
    @endif
</div>

<div class="hidden_errorr" style="display: none;">
    @if (session('status'))
        <span class="red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
            {{ session('status') }}
        </span>
    @endif
    @if ($errors->has('email'))
        <span class="red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
            {{ trans('passwords.user') }}
        </span>
    @endif
    @if ($errors->has('password'))
        <span class="red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
            {{ trans('passwords.sent') }}
        </span>
    @endif
</div>

