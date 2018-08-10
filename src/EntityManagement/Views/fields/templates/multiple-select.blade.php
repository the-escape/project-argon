<script type="text/template" class="tp-select-multiple">
    <div class="o-drag-select js-drag">
        <input type="hidden" name="{inputName}" data-name="{dataName}" data-json-value class="js-drag-input" value='{value}'>
        <div class="o-drag-select__column-wrap">
            <div class="o-drag-select__title">{name}</div>
            <div class="o-drag-select__column o-drag-select__column--inactive js-drag-inactive">
                {options}
            </div>
        </div>
        <div class="o-drag-select__arrow">
            <svg>
                <use xlink:href="/argon/images/svgicons.svg#arrow-right"></use>
            </svg>
        </div>
        <div class="o-drag-select__column-wrap">
            <div class="o-drag-select__title">Selected {name}</div>
            <div class="o-drag-select__column o-drag-select__column--active js-drag-active"></div>
        </div>
    </div>
</script>

<script type="text/template" class="tp-select-multiple-option">
    <div class="o-drag-select__item" data-value="{key}">
        <div class="o-drag-select__item-wrap">
            <span>{value}</span>
            <svg>
                <use xlink:href="/argon/images/svgicons.svg#move"></use>
            </svg>
        </div>
    </div>
</script>
