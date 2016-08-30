<?php

namespace Escape\Argon\EntityManagement\Controllers;

use Exception;
use SimpleXMLElement;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;

class SitemapController extends Controller
{
    protected $pages;

    public function __construct(EntityRepository $entityRepository)
    {
        $this->pages = $entityRepository->pages()->keyBy('id');
    }

    /**
     * Generates an HTML sitemap based on all published pages.
     *
     * @return View
     */
    public function html(Request $request)
    {
        $pages = $this->pages;

        foreach ($pages as $page) {
            if ($page->parent_id) {
                $pages[$page->parent_id]->addChild($page);
            }
        }

        $pages = $pages->filter(function ($page) {
            return $page->parent_id == null;
        });

        // Get the sitemap view from the config.
        $view = config('argon.sitemap_view');

        // Check to see if the view exists, if not throw an exception.
        if (!view()->exists($view)) {
            throw new Exception('No sitemap view found.');
        }

        return view($view)->with(compact('pages'));
    }

    /**
     * Generates an XML sitemap based on all published pages.
     *
     * @return Response
     */
    public function xml()
    {
        // Get all published pages.
        // TODO: Filter pages that are chosen.
        $pages = $this->pages;

        // Initial XML element.
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" />');

        // Force XML header.
        $headers['Content-Type'] = 'application/xml';

        // Loop through all the pages and attach the relevent XML object.
        foreach ($pages as $page) {
            $url = $xml->addChild('url');
            $url->addChild('loc', url($page->toPage()->getUrl()));

            // If the page has an updated date, include it.
            if (!is_null($page->updated_at)) {
                $url->addChild('lastmod', $page->updated_at->format('Y-m-d'));
            }
        }

        // Return the XML element as a response.
        return response($xml->asXML(), 200, $headers);
    }
}
