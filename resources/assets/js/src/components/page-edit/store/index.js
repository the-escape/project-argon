import Vuex from 'vuex'
import { blockSelect } from './modules/blockSelect'
import { fields } from './modules/field'

export function getStore () {
    return new Vuex.Store({
        modules: {
            blockSelect,
            fields
        }
    })
}
