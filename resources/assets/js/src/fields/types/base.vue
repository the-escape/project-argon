<template>
    <div class="o-form__group">
        <validation :status-error="field.errors" :input-name="inputName">
            <label :for="inputName">{{ name }}</label>
            <multi :field-id="fieldId" :input-name="inputName">
                <template slot-scope="{ value }">
                    <input-icon :pre-icon="icons.preIcon" :post-icon="icons.postIcon">
                        <input :type="type" :id="inputName" :name="inputName" v-model="value">
                    </input-icon>
                </template>
            </multi>
        </validation>
        <div class="o-form__help-text l-full" v-if="field.helpText" v-html="field.helpText"></div>
    </div>
</template>

<script>
import InputIcon from './util/input-icon.vue'
import Validation from './util/validation.vue'
import Multi from './util/multi.vue'

import { mapGetters } from 'vuex'

export default {
    props: ['fieldId', 'icons', 'type'],
    components: {
        'input-icon': InputIcon,
        'validation': Validation,
        'multi': Multi
    },
    computed: {
        field: function () {
            return this.$store.getters.getField(this.fieldId)
        },
        inputName: function () {
            return `field[${this.fieldId}]`
        },
        name: function () {
            const field = this.$store.getters.getField(this.fieldId)
            return field.options.name
        }
    }
}
</script>

