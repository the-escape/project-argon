import Choices from 'choices.js'

const options = {
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
                            <svg><use xlink:href="/argon/images/svgicons.svg#select"></use></svg>
                        </div>
                    </div>
                `)
        }
    }
}

export function createSelects (context = document) {
    const selectHtmlList = context.querySelectorAll('.js-select')
    let selectList = Array.from(selectHtmlList)
    selectList = selectList.map(el => createSelect(el))
    const plainSelectHtmlList = context.querySelectorAll(
        '.js-plain-submit-select'
    )
    let plainSelectList = Array.from(plainSelectHtmlList)
    plainSelectList = plainSelectList.map(el => createPlainSelect(el))
    return [...selectList, ...plainSelectList]
}

export function createSelect (el) {
    const { value } = el.dataset
    let items = []

    if (value) {
        items = JSON.parse(value)
    }

    const select = new Choices(el, Object.assign({}, options))

    el.choices = select
    select.setValueByChoice(items)
    return select
}

export function createPlainSelect (el) {
    const { value } = el.dataset
    let items = []

    if (value) {
        items = JSON.parse(value)
    }

    const plainOptions = Object.assign({}, options, {
        classNames: {
            containerOuter: 'choices choices--plain'
        }
    })
    const select = new Choices(el, plainOptions)

    el.choices = select
    select.setValueByChoice(items)
    el.addEventListener('change', () => {
        el.closest('form').submit()
    })

    return select
}
