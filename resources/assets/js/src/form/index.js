import { fromEvent } from 'rxjs'
import { createFileInputs, createFileInput } from './file-input'
import controller from './controller'
import toggle from './toggle'
import { createSelects, createSelect } from './select'
import { createItemPickers, createItemPicker } from './item-picker'
import { createDates, createDate } from './date'
import { createTimes, createTime } from './time'
import { createEditors, removeEditor, processWysiwygEditors } from './wysiwyg'
import { createDragSelects, createDragSelect } from './drag-select'
import { createMediaInputs, createMediaInput } from './media-input'

function registerFormSaveEvents () {
    const savePublishBtn = document.querySelector('.js-save')
    if (!savePublishBtn) {
        return
    }

    fromEvent(savePublishBtn, 'click').subscribe(el => {
        processWysiwygEditors()
    })
}

function initialiseFormElements () {
    toggle()
    const selects = createSelects()
    const itemPickers = createItemPickers()
    const dates = createDates()
    const editors = createEditors()
    const times = createTimes()
    const dragSelects = createDragSelects()
    const mediaItems = createMediaInputs()

    return {
        selects,
        itemPickers,
        dates,
        editors,
        times,
        dragSelects,
        mediaItems
    }
}

function initialiseFormElementsForNewElement (el) {
    const selects = createSelects(el)
    const itemPickers = createItemPickers(el)
    const dates = createDates(el)
    const editors = createEditors(el)
    const times = createTimes(el)
    const dragSelects = createDragSelects(el)
    const mediaItems = createMediaInputs()

    return {
        selects,
        itemPickers,
        dates,
        editors,
        times,
        dragSelects,
        mediaItems
    }
}

function refreshFromElements (el, formElements) {
    if (!formElements) {
        return
    }

    formElements.editors.forEach(el => removeEditor(el))
    formElements.editors = createEditors(el)
}

export {
    initialiseFormElements,
    initialiseFormElementsForNewElement,
    refreshFromElements,
    registerFormSaveEvents
    // createFileInputs,
    // createFileInput,
    // controller,
    // toggle,
    // createSelects,
    // createSelect,
    // createItemPickers,
    // createItemPicker,
    // createDates,
    // createDate,
    // createTimes,
    // createTime,
    // createEditors,
    // createDragSelects,
    // createDragSelect
}
