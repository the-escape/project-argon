let hasChanged = false

export function setupPageLeave () {
    window.onbeforeunload = function () {
        if (hasChanged) {
            return 'Changes have been made may not be saved'
        }
    }
}

export function preventPageLeave () {
    hasChanged = true
}

export function allowPageLeave () {
    hasChanged = false
}
