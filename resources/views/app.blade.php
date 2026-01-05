<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ request()->cookie('theme') === 'dark' ? 'dark' : '' }}">
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-5TNKX5N9');
    </script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-MW75LTD9PG"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-MW75LTD9PG');
    </script>
    <!-- End Google Tag Manager -->
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags - Will be populated by Inertia Head -->
    <title inertia>{{ config('app.name', 'FraudShield') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/favicon.png') }}">
    
    <!-- PWA Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#22c55e">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="FraudShield">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="FraudShield">
    <meta name="msapplication-TileColor" content="#22c55e">
    <meta name="msapplication-tap-highlight" content="no">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/js/app.ts'])
    @inertiaHead
    
    <!-- Structured Data for SEO -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "WebApplication",
        "name": "FraudShield - কুরিয়ার ফ্রড ডিটেকশন সিস্টেম",
        "url": "https://fraudshieldbd.site",
        "description": "বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস দেখুন এবং বিশ্বাসযোগ্যতা যাচাই করুন।",
        "applicationCategory": "BusinessApplication",
        "operatingSystem": "All",
        "offers": {
            "@@type": "Offer",
            "price": "0",
            "priceCurrency": "BDT"
        },
        "author": {
            "@@type": "Organization",
            "name": "Tyrodevs",
            "url": "https://tyrodevs.com"
        }
    }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5TNKX5N9"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    
    @inertia
    
    <!-- Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then((registration) => {
                        console.log('ServiceWorker registered: ', registration.scope);
                    })
                    .catch((error) => {
                        console.log('ServiceWorker registration failed: ', error);
                    });
            });
        }
    </script>
</body>
</html>
