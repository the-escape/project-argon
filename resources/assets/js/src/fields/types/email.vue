<template>
    <base-input
    :field-id="fieldId"
    :combo-id="comboId"
    :combo-value-id="comboValueId"
    :icons="icons"
    type="email"
    ></base-input>
</template>

<script>
import base from './base.vue'

export default {
    props: ['fieldId', 'comboId', 'comboValueId'],
    components: {
        'base-input': base
    },
    computed: {
        icons: function() {
            const field = this.$store.getters.getField(this.fieldId)

            return {
                preIcon: (field && field.options.preIcon) || {
                    svg: 'email'
                },
                postIcon: (field && field.options.postIcon) || false
            }
        }
    }
}
</script>
