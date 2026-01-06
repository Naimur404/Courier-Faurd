<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate XML sitemap for the website
     */
    public function index(): Response
    {
        $baseUrl = 'https://fraudshieldbd.site';
        $lastModified = now()->toIso8601String();
        
        $urls = [
            [
                'loc' => $baseUrl . '/',
                'lastmod' => $lastModified,
                'changefreq' => 'daily',
                'priority' => '1.0',
            ],
            [
                'loc' => $baseUrl . '/about',
                'lastmod' => $lastModified,
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ],
            [
                'loc' => $baseUrl . '/pricing',
                'lastmod' => $lastModified,
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ],
            [
                'loc' => $baseUrl . '/download',
                'lastmod' => $lastModified,
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ],
            [
                'loc' => $baseUrl . '/api/documentation',
                'lastmod' => $lastModified,
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ],
            [
                'loc' => $baseUrl . '/login',
                'lastmod' => $lastModified,
                'changefreq' => 'monthly',
                'priority' => '0.5',
            ],
            [
                'loc' => $baseUrl . '/register',
                'lastmod' => $lastModified,
                'changefreq' => 'monthly',
                'priority' => '0.5',
            ],
            [
                'loc' => $baseUrl . '/website-subscriptions',
                'lastmod' => $lastModified,
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ],
        ];
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        
        foreach ($urls as $url) {
            $xml .= '  <url>' . PHP_EOL;
            $xml .= '    <loc>' . htmlspecialchars($url['loc']) . '</loc>' . PHP_EOL;
            $xml .= '    <lastmod>' . $url['lastmod'] . '</lastmod>' . PHP_EOL;
            $xml .= '    <changefreq>' . $url['changefreq'] . '</changefreq>' . PHP_EOL;
            $xml .= '    <priority>' . $url['priority'] . '</priority>' . PHP_EOL;
            $xml .= '  </url>' . PHP_EOL;
        }
        
        $xml .= '</urlset>';
        
        return response($xml, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
