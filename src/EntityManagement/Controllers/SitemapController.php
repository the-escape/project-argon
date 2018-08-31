<?php

namespace Escape\Argon\EntityManagement\Controllers;

use SimpleXMLElement;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;

class SitemapController extends Controller
{
    protected $entityRepository;

    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    /**
     * Generates an XML sitemap based on all published pages.
     *
     * @return Response
     */
    public function xml()
    {
        // Get all published pages.
        $pages = $this->entityRepository->pages([], [
            'status' => "1"
        ]);

        // Initial XML element.
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" />');

        // Force XML header.
        $headers['Content-Type'] = 'application/xml';

        // Loop through all the pages and attach the relevent XML object.
        foreach ($pages as $page)
        {
            $urlRaw = $page->toPage()->getUrl();

            $url = $xml->addChild('url');
            $url->addChild('loc', url($urlRaw));

            $localisations = $page->getLocalisations();

            if (count($localisations) > 1)
            {
                // Loop through each localisation.
                foreach ($localisations as $localisation)
                {
                    $locale = $localisation->getLocale();
                    $link = $url->addChild('xhtml:link', null, 'xhtml');
                    $link->addAttribute('rel', 'alternate');
                    $link->addAttribute('hreflang', $locale->language->getLanguageCode());
                    // workaround to limit db quiries, since and issue on large sites
                    // $link->addAttribute('href', url($localisation->entity->toPage()->getUrl($locale)));
                    $link->addAttribute('href', url($locale->getSlug().$urlRaw));
                }
            }

            // If the page has an updated date, include it.
            if (!is_null($page->updated_at))
            {
                $url->addChild('lastmod', $page->updated_at->format('Y-m-d'));
            }
        }

        // Return the XML element as a response.
        return response($xml->asXML(), 200, $headers);
    }
}
