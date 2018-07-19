import Choices from 'choices.js'

export function createSelects (context = document) {
    const selectHtmlList = context.querySelectorAll('.js-select')
    let selectList = Array.from(selectHtmlList)
    selectList = selectList.map(el => createSelect(el))
    return selectList
}

export function createSelect (el) {
    const { value } = el.dataset
    let items = []

    if (value) {
        items = JSON.parse(value)
    }

    const select = new Choices(el, {
        searchEnabled: false,
        searchChoices: false,
        paste: false,
        shouldSort: false,
        removeItemButton: true,
        placeholderValue: 'select',
        itemSelectText: '',
        callbackOnCreateTemplates: function (template) {
            const classNames = this.config.classNames
            return {
                containerInner: () =>
                    template(`
                    <div class="${classNames.containerInner}">
                        <div class="choices__btn">
                            <svg><use xlink:href="/images/svgicons.svg#select"></use></svg>
                        </div>
                    </div>
                `)
            }
        }
    })

    select.setValueByChoice(items)
    return select
}
