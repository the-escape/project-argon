import { coreMutations, coreGetters, coreActions } from './core'
import { fieldMutations, fieldGetters } from './fields'
import { comboMutations, comboActions, comboGetters } from './combo'

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
        ...fieldGetters,
        ...comboGetters
    },
    mutations: {
        ...coreMutations,
        ...fieldMutations,
        ...comboMutations
    },
    actions: {
        ...coreActions,
        ...comboActions
    }
}
