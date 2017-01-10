<li class="tabs__item"><a href="{{ $tab->getUrl() }}" class="{{ $tab->getUrl() === request()->fullUrl() ? 'active' : '' }}">{{ strtoupper($tab->getLabel()) }}</a></li>
