import { fromEvent, merge } from 'rxjs'

const transitionEndEventNames = [
    'webkitTransitionEnd',
    'transitionend',
    'msTransitionEnd',
    'oTransitionEnd'
]
const animationEndEventName = [
    'animationend',
    'webkitAnimationEnd',
    'MSAnimationEnd',
    'oAnimationEnd'
]

const mapEventsToObservable = eventNames => el => {
    const events = eventNames.map(name => fromEvent(el, name))
    return merge.apply(null, events)
}

export const transitionEnd = mapEventsToObservable(transitionEndEventNames)
export const animationEnd = mapEventsToObservable(animationEndEventName)
