<li class="tabs__item"><a href="{{ $tab->getUrl() }}" class="{{ request()->fullUrl() == $tab->getUrl() ? 'active' : '' }}">{{ strtoupper($tab->getLabel()) }}</a></li>
