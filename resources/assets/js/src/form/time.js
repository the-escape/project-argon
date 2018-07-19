import flatpickr from 'flatpickr'

export function createTimes (context = document) {
    const timeEles = context.querySelectorAll('.js-time')
    let times = Array.from(timeEles)
    times = times.map(el => createTime(el))
    return times
}

export function createTime (el) {
    const { defaultNow } = el.dataset

    let defaultDate = null
    if (defaultNow) {
        defaultDate = new Date()
    }

    return flatpickr(el, {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'H:i:S',
        altInput: true,
        altFormat: 'h:i K',
        defaultDate,
        mode: 'time'
    })
}

export function cleanContainerTime (el) {
    el.querySelector('.cke').remove()
}
