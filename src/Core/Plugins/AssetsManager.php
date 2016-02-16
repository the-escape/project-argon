<?php

namespace Escape\Argon\Core\Plugins;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AssetsManager
{
    /** @var Collection */
    protected $scripts;

    /** @var Collection */
    protected $styles;

    /** @var Request */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->scripts = new Collection();
        $this->styles = new Collection();
    }

    public function addScript($url, array $paths = ['*'])
    {
        $this->scripts->push(['url' => $url, 'paths' => $paths]);
    }

    public function outputScripts()
    {
        $path = $this->request->path();

        return $this->scripts->filter(function ($script) use ($path) {
            foreach ($script['paths'] as $path) {
                if ($this->request->is($path)) {
                    return true;
                }
            }
            return false;
        })->map(function ($script) {
            return $script['url'];
        });
    }

    public function addStyles($url, array $paths = ['*'])
    {
        $this->styles->push(['url' => $url, 'paths' => $paths]);
    }

    public function outputStyles()
    {
        $path = $this->request->path();

        return $this->styles->filter(function ($styles) use ($path) {
            foreach ($styles['paths'] as $path) {
                if ($this->request->is($path)) {
                    return true;
                }
            }
            return false;
        })->map(function ($styles) {
            return $styles['url'];
        });
    }
}
