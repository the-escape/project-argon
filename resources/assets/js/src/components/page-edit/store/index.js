import Vuex from 'vuex'
import { blockSelect } from './modules/blockSelect'

export function getStore () {
    return new Vuex.Store({
        modules: {
            blockSelect
        }
    })
}
