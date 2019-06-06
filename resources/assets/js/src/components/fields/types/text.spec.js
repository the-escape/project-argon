import { shallowMount, createLocalVue } from '@vue/test-utils'
import { getStore, processFields } from './store'
import Vuex from 'vuex'
import Text from './text.vue'

const multiTextConfig = [
    {
        id: 1,
        options: {
            typeKey: 'text',
            name: 'multi text',
            settings: {
                required: false,
                multiline: false,
                multiple: true,
                minlength: 0,
                maxlength: 0,
                url: false,
                integer: false,
                float: false,
                email: false,
                phone: false
            }
        },
        helpText: '',
        message: '',
        messageAfter: '',
        values: ['text', 'text 2'],
        errors: []
    }
]

const singleTextConfig = [
    {
        id: 1,
        options: {
            typeKey: 'text',
            name: 'single text',
            settings: {
                required: false,
                multiline: false,
                multiple: false,
                minlength: 0,
                maxlength: 0,
                url: false,
                integer: false,
                float: false,
                email: false,
                phone: false
            }
        },
        helpText: '',
        message: '',
        messageAfter: '',
        values: ['one'],
        errors: []
    }
]

const textareaConfig = [
    {
        id: 1,
        options: {
            typeKey: 'text',
            name: 'textarea',
            settings: {
                required: false,
                multiline: true,
                multiple: true,
                minlength: 0,
                maxlength: 0,
                url: false,
                integer: false,
                float: false,
                email: false,
                phone: false
            }
        },
        helpText: '',
        message: '',
        messageAfter: '',
        values: ['two'],
        errors: ['required']
    }
]

const localVue = createLocalVue()
localVue.use(Vuex)

describe('Single Text Input', () => {
    let store

    beforeEach(() => {
        store = getStore()
        let fields = processFields(singleTextConfig)

        store.commit('setFields', { fields: fields })
    })

    it('shows an text input', () => {
        const wrapper = shallowMount(Text, { store, localVue })

        expect(wrapper.find('input[type=text]')).toBeTruthy()
    })
})
