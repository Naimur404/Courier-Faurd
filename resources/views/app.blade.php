<!DOCTYPE html>
@php
    $siteTitle = \App\Models\Setting::get('site_title', config('app.name', 'FraudShield'));
    $siteFavicon = \App\Models\Setting::get('site_favicon');
    $gtmId = \App\Models\Setting::get('google_tag_manager', 'GTM-5TNKX5N9');
    // Default to dark mode if no theme cookie is set
    $theme = request()->cookie('theme');
    $isDark = $theme === null || $theme === 'dark';
@endphp
<html lang="bn" class="{{ $isDark ? 'dark' : '' }}">
<head>
    @if($gtmId)
    <!-- Google Tag Manager - Deferred loading for better performance -->
    <script>
        window.dataLayer = window.dataLayer || [];
        // Defer GTM loading until after page is interactive
        if (typeof requestIdleCallback === 'function') {
            requestIdleCallback(function() { loadGTM(); });
        } else {
            setTimeout(loadGTM, 2000);
        }
        function loadGTM() {
            var gtmScript = document.createElement('script');
            gtmScript.async = true;
            gtmScript.src = 'https://www.googletagmanager.com/gtm.js?id={{ $gtmId }}';
            document.head.appendChild(gtmScript);
            window.dataLayer.push({'gtm.start': new Date().getTime(), event: 'gtm.js'});
        }
    </script>
    <!-- End Google Tag Manager -->
    @endif
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Default SEO Meta Tags (will be overridden by Inertia Head) -->
    <title inertia>{{ $siteTitle }} - কুরিয়ার ফ্রড চেকার</title>
    <meta name="keywords" content="{{ $siteTitle }}, courier fraud, কুরিয়ার ফ্রড, fraud detection, মোবাইল নাম্বার চেক, ডেলিভারি ইতিহাস, বাংলাদেশ কুরিয়ার, courier checker, sundarban courier tracking, কুরিয়ার চেকার, সুন্দরবন কুরিয়ার ট্র্যাকিং">
    <meta name="author" content="Tyrodevs">
    
    <!-- Default OpenGraph Meta Tags -->
    <meta property="og:title" content="{{ $siteTitle }} - কুরিয়ার ফ্রড ডিটেকশন সিস্টেম">
    <meta property="og:description" content="বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://fraudshieldbd.site">
    <meta property="og:site_name" content="{{ $siteTitle }}">
    <meta property="og:locale" content="bn_BD">
    <meta property="og:image" content="{{ asset('assets/og-image.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    
    <!-- Default Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $siteTitle }} - কুরিয়ার ফ্রড ডিটেকশন">
    <meta name="twitter:description" content="বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম">
    <meta name="twitter:image" content="{{ asset('assets/og-image.png') }}">
    
    <!-- Favicon & Icons -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $siteFavicon ? Storage::url($siteFavicon) : asset('assets/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $siteFavicon ? Storage::url($siteFavicon) : asset('assets/favicon.png') }}">
    
    <!-- Apple Touch Icons -->
    <link rel="apple-touch-icon" href="{{ asset('assets/pwa/icon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/pwa/icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/pwa/icon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('assets/pwa/icon-192x192.png') }}">
    
    <!-- PWA Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#4f46e5" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#1e1b4b" media="(prefers-color-scheme: dark)">
    
    <!-- iOS PWA Configuration -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="{{ $siteTitle }}">
    
    <!-- Android PWA Configuration -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="{{ $siteTitle }}">
    
    <!-- Microsoft Tile Configuration -->
    <meta name="msapplication-TileColor" content="#4f46e5">
    <meta name="msapplication-TileImage" content="{{ asset('assets/pwa/icon-144x144.png') }}">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="msapplication-config" content="none">
    
    <!-- Apple Splash Screens for iOS -->
    <link rel="apple-touch-startup-image" href="{{ asset('assets/pwa/icon-512x512.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Bengali Fonts - async loading to prevent render blocking -->
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&family=Hind+Siliguri:wght@400;500;600;700&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet"></noscript>
    <!-- English Fonts - async loading -->
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"></noscript>
    <!-- Bengali Web Fonts - simplified to reduce HTTP requests -->
    <style>
        /* Use system fonts as fallback for better performance */
        :root {
            --font-bengali: 'Noto Sans Bengali', 'Hind Siliguri', 'SolaimanLipi', system-ui, sans-serif;
            --font-english: 'Inter', system-ui, -apple-system, sans-serif;
        }
    </style>
    
    <!-- Scripts -->
    @vite(['resources/js/app.ts'])
    @inertiaHead
    
    <!-- Structured Data for SEO -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "WebApplication",
        "name": "{{ $siteTitle }} - কুরিয়ার ফ্রড ডিটেকশন সিস্টেম",
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
    @if($gtmId)
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif
    
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
