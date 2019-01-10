import { fromEvent, merge } from 'rxjs'
import { filter, map } from 'rxjs/operators'

export const modalController = {
    modalContainer: null,
    modals: {},
    currentOpenModal: null,
    template: null,
    openModal,
    closeModal,
    addModal
}

export function setupModals () {
    const container = document.querySelector('.js-modal-container')
    if (!container) {
        return
    }

    modalController.openModal = modalController.openModal.bind(modalController)
    modalController.closeModal = modalController.closeModal.bind(
        modalController
    )
    modalController.addModal = modalController.addModal.bind(modalController)

    modalController.template = document.querySelector('.js-modal-template')
    if (!modalController.template) {
        return
    }
    modalController.template = modalController.template.innerHTML

    modalController.modalContainer = container
    let modals = modalController.modalContainer.querySelectorAll(
        '[data-modal-item-id]'
    )
    modals = Array.from(modals)
    modals.forEach(el => {
        const key = el.dataset.modalItemId
        modalController.addModal(key, el)
    })

    if (typeof window.modals !== 'undefined') {
        window.modals.forEach(el => {
            if (el.content) {
                modalController.addModal(el.id, el.content)
            }
            if (el.open) {
                modalController.openModal(el.id)
            }
        })
    }

    fromEvent(document, 'click')
        .pipe(
            filter(el => !!el.target.dataset.modalId),
            map(el => el.target.dataset.modalId)
        )
        .subscribe(modalController.openModal)

    merge(
        fromEvent(document, 'click').pipe(
            filter(el => el.target.classList.contains('js-modal-close'))
        )
    )

    fromEvent(modalController.modalContainer, 'click').subscribe(
        modalController.closeModal
    )
}

function openModal (modalID) {
    if (!this.modals[modalID]) {
        console.warn('No Modal find with id: ' + modalID)
        return
    }

    if (!this.modalContainer.classList.contains('active')) {
        this.modalContainer.classList.add('active')
    }

    if (this.currentOpenModal) {
        if (this.currentOpenModal === this.modals[modalID]) {
            return
        } else {
            this.currentOpenModal.classList.remove('active')
        }
    }

    this.currentOpenModal = this.modals[modalID]
    this.currentOpenModal.classList.add('active')
}

function closeModal () {
    this.modalContainer.classList.remove('active')
    this.currentOpenModal.classList.remove('active')
    this.currentOpenModal = null
}

function addModal (key, content) {
    let element
    if (typeof content === 'string') {
        element = createModal(key, content, modalController)
    } else {
        element = content
    }

    modalController.modals[key] = element

    const closeBtn = element.querySelector('.js-modal-close')
    if (closeBtn) {
        fromEvent(closeBtn, 'click').subscribe(modalController.closeModal)
    }

    element.addEventListener('click', evt => {
        evt.stopPropagation()
    })

    if (element.classList.contains('active')) {
        modalController.currentOpenModal = modalController.modals[key]
    }
}

function createModal (id, content, controller) {
    const html = controller.template
        .replace(/{id}/, id)
        .replace(/{content}/, content)
    const div = document.createElement('div')
    div.innerHTML = html
    controller.modalContainer.appendChild(div.firstElementChild)
    return controller.modalContainer.querySelector(
        '[data-modal-item-id=' + id + ']'
    )
}
