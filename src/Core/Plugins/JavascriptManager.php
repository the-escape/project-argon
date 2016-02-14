<?php

namespace Escape\Argon\Core\Plugins;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class JavascriptManager
{
    /** @var Collection */
    protected $scripts;

    /** @var Request */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->scripts = new Collection();
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
}
