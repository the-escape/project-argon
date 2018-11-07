import Vuex from 'vuex'

export function getStore () {
    return new Vuex.Store({
        state: {
            fields: []
        },
        getters: {
            getField: state => id => {
                let field = state.fields.filter(field => field.id === id)
                if (field.length) {
                    return field[0]
                }
            }
        },
        mutations: {
            setFields (state, fields) {
                state.fields = fields
            },
            setValues (state, fieldID, values) {
                state.fields.filter(el => el.id === fieldID).map(el => {
                    el.values = values
                    return el
                })
            }
        }
    })
}
