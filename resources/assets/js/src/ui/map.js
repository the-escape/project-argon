let hasRenderedMap = false

export default function init () {
    if (!hasRenderedMap) {
        setTimeout(() => {
            !hasRenderedMap && initMap()
        }, 1250)
    }
}

function initMap () {
    if (typeof window.google === 'undefined') {
        return
    }

    const mapElements = document.querySelector('.js-map')
    if (!mapElements) {
        return
    }

    const { lat, lng } = mapElements.dataset

    const { Map, Marker } = window.google.maps
    const latLng = { lat: +lat || 51.2352025, lng: +lng || -1.119185 }
    let center = {
        lat: latLng.lat,
        lng: latLng.lng
    }
    if (window.innerWidth <= 786) {
        center = latLng
    }
    const customIcon = {
        path:
            'M7,0C3.1,0,0,3.1,0,7s7,13,7,13s7-9.1,7-13S10.9,0,7,0z M7,9.75C5.46,9.75,4.25,8.54,4.25,7S5.46,4.25,7,4.25S9.75,5.46,9.75,7S8.54,9.75,7,9.75z',
        anchor: new window.google.maps.Point(7, 20),
        fillColor: '#df1e24',
        fillOpacity: 1,
        scale: 2.5,
        strokeOpacity: 0
    }

    const map = new Map(mapElements, {
        zoom: 15,
        center: center,
        scrollwheel: false,
        gestureHandling: 'cooperative'
    })

    new Marker({
        position: latLng,
        map,
        title: 'Benyon Estate',
        icon: customIcon
    })

    hasRenderedMap = true
}
window.initMap = initMap
