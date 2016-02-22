<?php

namespace Escape\Argon\Core\Http;

use Escape\Argon\Locales\Eloquent\Locale;
use Illuminate\Http\Request as LaravelRequest;

class Request extends LaravelRequest
{
    /**
     * @return Locale|null
     */
    public function getArgonLocale()
    {
        $localeId = $this->session()->get('locale', 1);
        return Locale::find($localeId);
    }
}
