<!doctype html>
<html lang="fa">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="google-site-verification" content="KQj6slsJlzQVt0h3pxEoVHcEU_tpXNpQfrJ_0vx2RyU" />
    <meta property="og:type" content="article">
    <meta property="og:title" content="کليک سفر - مرجع مقايسه ي تورهاي مسافرتي">
    <meta property="og:site_name" content="کليک سفر">
    <meta property="og:url" content="https://clicksafar.com/">
    <meta property="og:image" content="https://clicksafar.com/">
    <meta property="article:published_time" content="2018-05-16">
    <meta property="article:author" content="https://clicksafar.com/">

    <meta name="csrf-token" content="{{csrf_token()}}">

    <link rel="shortcut icon" href="img/favicon.ico">
    <!-- type="image/x-icon" -->
    <!-- <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png"> -->
    @yield('meta')
    @include('site.layout.style')
    @yield('head')
    @include('site.layout.mediaStyle')
    <style>
        .border-3 {
            border-width: 3px !important;
        }
    </style>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-144703834-1"></script>

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Article",
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "https://clicksafar.com/"
            },
            "headline": "کليک سفر - مرجعع مقايسه تورهاي مسافرتي",
            "description": "تور خارجي و داخلي کليک سفر خاطره يک سفر رويايي را براي شما به ارمغان خواهند آورد. لحظه آخري مشهد،کيش،اروپا، آفريقا، شرق آسيا يا خاورميانه، گرجستان، استانبول، دبي، فرانسه، ايتاليا، اسپانيا",
            "image": {
                "@type": "ImageObject",
                "url": "https://clicksafar.com/img/favicon.ico",
                "width": 696,
                "height": 512
            },
            "author": {
                "@type": "Organization",
                "name": "clicksafar"
            },
            "publisher": {
                "@type": "Organization",
                "name": "j.k",
                "logo": {
                    "@type": "ImageObject",
                    "url": "https://clicksafar.com/img/logoNew.png",
                    "width": 60,
                    "height": 60
                }
            },
            "datePublished": "2018-08-18",
            "dateModified": "2019-08-18"
        }
    </script>

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-144703834-1');
    </script>

</head>

<body>

    <div id="ivi3">

        {{--<div id="loader">
    <div class="loader">
        <div class="sk-child sk-dot1"></div>
        <div class="sk-child sk-dot2"></div>
    </div>
</div>--}}


        <!-- End Preload -->
        <!-- Mobile menu overlay mask -->
        @include('site.partials.header')
        @yield('content')
        @include('site.partials.footer')


        @yield('extension')
    </div>
    @include('site.layout.script')
    @yield('footer')
</body>

</html>