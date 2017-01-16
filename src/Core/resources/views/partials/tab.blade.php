<li class="tabs__item"><a href="{{ $tab->getUrl() }}" class="{{ str_contains(request()->fullUrl(), $tab->getUrl()) ? 'active' : '' }}">{{ strtoupper($tab->getLabel()) }}</a></li>
