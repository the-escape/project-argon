@if(!empty($deleteUrl))
    <div class="o-confirm-btn__container js-basic-confirm">
        <div class="o-confirm-btn__questions">
            <div class="o-confirm-btn"></div>
            <button class="o-confirm-btn" data-question="delete" title="Delete">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#delete"></use>
                </svg>
            </button>
        </div>
        <div class="o-confirm-btn__decline">
            <button class="o-confirm-btn o-confirm-btn--danger js-confirm-decline">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#cross"></use>
                </svg>
            </button>
        </div>
        <div class="o-confirm-btn__accept">
            <a href="{{ $deleteUrl }}" class="o-confirm-btn o-confirm-btn--success js-confirm-accept">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#tick"></use>
                </svg>
            </a>
        </div>
    </div>
@endif
