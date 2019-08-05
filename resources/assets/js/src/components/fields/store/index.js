import Vuex from 'vuex'
import { fields } from './field'

// const fieldsExample = [
//     {
//         id: 1,
//         options: {
//             typeKey: 'text',
//             name: 'single text',
//             settings: {
//                 required: false,
//                 multiline: false,
//                 multiple: false,
//                 minlength: 0,
//                 maxlength: 0,
//                 url: false,
//                 integer: false,
//                 float: false,
//                 email: false,
//                 phone: false
//             }
//         },
//         helpText: '',
//         message: '',
//         messageAfter: '',
//         values: ['one'],
//         errors: []
//     },
//     {
//         id: 2,
//         options: {
//             typeKey: 'combo',
//             name: 'Multi Combo',
//             settings: { multiple: true }
//         },
//         helpText: '',
//         message: '',
//         messageAfter: '',
//         fields: [
//             {
//                 id: 3,
//                 options: {
//                     typeKey: 'text',
//                     name: 'single text',
//                     settings: {
//                         required: false,
//                         multiline: false,
//                         multiple: false,
//                         minlength: 0,
//                         maxlength: 0,
//                         url: false,
//                         integer: false,
//                         float: false,
//                         email: false,
//                         phone: false
//                     }
//                 },
//                 helpText: '',
//                 message: '',
//                 messageAfter: ''
//             }
//         ],
//         values: [{ '3': { id: 0, value: 'two' } }],
//         errors: []
//     }
// ]

export function getStore () {
    return new Vuex.Store({
        modules: {
            fields
        }
    })
}
