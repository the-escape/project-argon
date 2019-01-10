import flatpickr from 'flatpickr'

export function createDates (context = document) {
    const dateEls = context.querySelectorAll('.js-date')
    let dates = Array.from(dateEls)
    dates = dates.map(el => createDate(el))
    return dates
}

export function createDate (el) {
    const { time, defaultToday, range } = el.dataset
    const value = el.value

    let altFormat = 'd F, Y'
    if (time === 'true') {
        altFormat = 'd F, Y h:i K'
    }

    let defaultDate = null
    if (defaultToday && !value) {
        defaultDate = new Date()
    }

    let mode = 'single'
    if (range === 'true') {
        mode = 'range'
    }

    return flatpickr(el, {
        enableTime: time === 'true',
        dateFormat: 'Y-m-d H:i:S',
        altInput: true,
        altFormat,
        mode,
        defaultDate
    })
}
