import Noty from 'noty'

export function Notifications () {
    if (!window.notifications || !window.notifications.length) {
        return
    }

    return window.notifications.map(notif => {
        return new Noty({
            layout: 'topCenter',
            text: notif.text,
            type: notif.success ? 'success' : 'error',
            timeout: 3500
        }).show()
    })
}
