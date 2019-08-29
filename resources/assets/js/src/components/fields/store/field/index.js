import { coreMutations, coreGetters, coreActions } from './core'
import { fieldMutations, fieldGetters } from './fields'
import { comboMutations, comboActions, comboGetters } from './combo'

export const fields = {
    namespaced: true,
    state: {
        useInputNames: false,
        groupOptions: {
            /**
             *  { groupID }: {
             *      fields: [],
             *      oldState: [],
             *      header: '',
             *      isShowingActions
             *  }
             */
        },
        values: {
            /**
             * { groupID }: {
             *   { fieldID }: [...values]
             * }
             */
        },
        oldValues: {
            /**
             * { groupID } : {
             *   used for cancel feature
             * }
             */
        },
        errors: {
            /**
             * { groupID }: {
             *   { fieldID }: [...errors]
             * }
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
