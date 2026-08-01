<?php

namespace App\Http\Controllers;

use App\Models\ClassGroup;
use App\Models\Teacher;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $xmlContent = Cache::remember('sitemap.xml', 3600, function () {
            if (class_exists(Sitemap::class)) {
                $sitemap = Sitemap::create();

                // Static public pages
                $sitemap->add(Url::create(route('home'))->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
                $sitemap->add(Url::create(route('about'))->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
                $sitemap->add(Url::create(route('how-it-works'))->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
                $sitemap->add(Url::create(route('contact'))->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
                $sitemap->add(Url::create(route('apply'))->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

                // Dynamic Teachers loop
                Teacher::whereNotNull('slug')->with('user')->get()->each(function (Teacher $teacher) use ($sitemap) {
                    $url = route('home') . '/teachers/' . $teacher->slug;
                    $sitemap->add(
                        Url::create($url)
                            ->setLastModificationDate($teacher->updated_at ?? now())
                            ->setPriority(0.8)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    );
                });

                // Dynamic ClassGroups (Courses) loop
                ClassGroup::where('is_active', true)->whereNotNull('slug')->get()->each(function (ClassGroup $group) use ($sitemap) {
                    $url = route('home') . '/courses/' . $group->slug;
                    $sitemap->add(
                        Url::create($url)
                            ->setLastModificationDate($group->updated_at ?? now())
                            ->setPriority(0.8)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    );
                });

                return $sitemap->render();
            }

            // Fallback standard XML generator if package is not yet autoloaded
            $urls = [
                ['loc' => route('home'), 'priority' => '1.0', 'freq' => 'daily', 'lastmod' => now()->toAtomString()],
                ['loc' => route('about'), 'priority' => '0.8', 'freq' => 'weekly', 'lastmod' => now()->toAtomString()],
                ['loc' => route('how-it-works'), 'priority' => '0.8', 'freq' => 'weekly', 'lastmod' => now()->toAtomString()],
                ['loc' => route('contact'), 'priority' => '0.7', 'freq' => 'monthly', 'lastmod' => now()->toAtomString()],
                ['loc' => route('apply'), 'priority' => '0.7', 'freq' => 'monthly', 'lastmod' => now()->toAtomString()],
            ];

            foreach (Teacher::whereNotNull('slug')->get() as $teacher) {
                $urls[] = [
                    'loc' => route('home') . '/teachers/' . $teacher->slug,
                    'priority' => '0.8',
                    'freq' => 'weekly',
                    'lastmod' => ($teacher->updated_at ?? now())->toAtomString(),
                ];
            }

            foreach (ClassGroup::where('is_active', true)->whereNotNull('slug')->get() as $group) {
                $urls[] = [
                    'loc' => route('home') . '/courses/' . $group->slug,
                    'priority' => '0.8',
                    'freq' => 'weekly',
                    'lastmod' => ($group->updated_at ?? now())->toAtomString(),
                ];
            }

            $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
            foreach ($urls as $url) {
                $xml .= "  <url>\n";
                $xml .= "    <loc>" . htmlspecialchars($url['loc']) . "</loc>\n";
                $xml .= "    <lastmod>" . $url['lastmod'] . "</lastmod>\n";
                $xml .= "    <changefreq>" . $url['freq'] . "</changefreq>\n";
                $xml .= "    <priority>" . $url['priority'] . "</priority>\n";
                $xml .= "  </url>\n";
            }
            $xml .= '</urlset>';

            return $xml;
        });

        return response($xmlContent, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
