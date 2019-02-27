import { easeOutQuad } from '../../../animation'

let maxDuration = 600
let minDuration = 250
let minHeightForMaxDuration = 2500

export function scrollTo (context, element, cb) {
    const startingY = context.scrollTop
    const elementY = element.offsetTop
    const distance = elementY - startingY
    const duration = cacluateDuration(context.scrollHeight, distance)
    let start

    function step (timeStamp) {
        if (!start) {
            start = timeStamp
        }

        const time = timeStamp - start
        let nextScroll = easeOutQuad(time, startingY, distance, duration)
        context.scrollTo(0, nextScroll)

        if (time < duration) {
            requestAnimationFrame(step)
        } else {
            cb && cb()
        }
    }

    requestAnimationFrame(step)
}

function cacluateDuration (scrollHeight, distance) {
    const maxHeight =
        scrollHeight > minHeightForMaxDuration
            ? minHeightForMaxDuration
            : scrollHeight
    const alteredMaxDuration =
        maxDuration * Math.min(scrollHeight / minHeightForMaxDuration, 1)
    distance = Math.abs(distance) > maxHeight ? maxHeight : Math.abs(distance)
    const percent = Math.min(maxHeight / distance, 1)
    return (alteredMaxDuration - minDuration) * percent + minDuration
}
