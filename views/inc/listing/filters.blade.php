<div class="c-list-filters">
    <form class="o-form c-list-filters__form js-form">
        @if(empty($hideSearch))
            <?php
                if (!empty($request->input('keywords',false)))
                {
                    $showReset = true;
                }
            ?>
            <div class="o-form__group o-form__group--icon-btn">
                <input type="text" name="keywords" placeholder="Search by keyword" value="{{ $request->input('keywords') }}">
                <button>
                    <svg>
                        <use xlink:href="/argon/images/svgicons.svg#search"></use>
                    </svg>
                </button>
            </div>
        @endif

        @if(!empty($filters))
            @foreach($filters as $fieldName => $filterOptions)

                <div class="o-form__group">
                    <select name="{{ $fieldName }}" id="{{ $fieldName }}" class="js-select" onchange="submit()">
                        <option value>Filter by {{ $fieldName }}</option>
                        @foreach($filterOptions as $key => $value)
                            <?php
                                $selected = request($fieldName, false) == $key;
                                if ($selected)
                                {
                                    $showReset = true;
                                }
                            ?>
                            <option value="{{ $key }}" {{ $selected ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

            @endforeach
        @endif

        @if(!empty($resetLinkUrl) && !empty($showReset))
            <a href="{{ $resetLinkUrl }}" class="c-list-filters__clear-btn">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#cross"></use>
                </svg>
                clear all
            </a>
        @endif
    </form>

    @if(!empty($createLink))
        <a href="{{ $createLink['url'] }}" class="o-btn o-btn--xs">{{ $createLink['label'] }}</a>
    @endif
</div>
