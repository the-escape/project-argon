<?php

namespace Escape\Argon\Core\Http;

use Escape\Argon\EntityManagement\Eloquent\Localisation;
use Escape\Argon\Locales\Eloquent\Locale;
use Escape\Argon\Locales\Eloquent\LocaleRepository;
use Illuminate\Http\Request as LaravelRequest;

class Request extends LaravelRequest
{
    protected $argonLocale;

    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    /**
     * @return Locale|null
     */
    public function getArgonLocale()
    {
        if (!isset($this->argonLocale)) {
            $this->parseLocales();
        }
        return $this->argonLocale;
    }

    protected function parseLocales($path=null)
    {
        $path = isset($path) ? $path : parent::path();

        /** @var LocaleRepository $localeRepository */
        $localeRepository = app()->make(LocaleRepository::class);

        if ($path !== '/') {
            $segments = explode('/', $path);

            $first = array_shift($segments);

            $locale = $localeRepository->getBySlug($first);

            if ($locale) {
                $this->argonLocale = $locale;

                $this->pathInfo = implode('/', $segments);
            }
        }

        if ($this->argonLocale === null) {
            $this->argonLocale = $localeRepository->getDefault();
        }
    }

    /**
     * @return string
     */
    public function path()
    {
        if (!isset($this->argonLocale)) {
            $this->parseLocales();
        }
        return parent::path();
    }


    /**
     * Modify request by adjusting locale based on current page url
     */
    public function adjustLocale(Localisation $localisation=null)
    {
        if ($localisation !== null)
        {
            $this->argonLocale = $localisation->getLocale();
        }
        elseif (isset($_SERVER['REQUEST_URI']))
        {
            $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

            if ($path)
            {
                $this->parseLocales($path);
            }
        }
    }

}
