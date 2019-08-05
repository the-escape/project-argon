import { coreMutations, coreGetters } from './core'
import { fieldMutations, fieldGetters } from './fields'
import { comboMutations, comboActions } from './combo'

export const fields = {
    namespaced: true,
    state: {
        groups: {
            /**
             *  { groupID }: {
             *      fields: [],
             *      oldState: [],
             *      header: '',
             *      isShowingActions
             *  }
             */
        }
    },
    getters: {
        ...coreGetters,
        ...fieldGetters
    },
    mutations: {
        ...coreMutations,
        ...fieldMutations,
        ...comboMutations
    },
    actions: {
        ...comboActions
    }
}
