<template>
    <base-input
    :field-id="fieldId"
    :combo-id="comboId"
    :combo-item-id="comboItemId"
    :icons="icons"
    type="text"
    ></base-input>
</template>

<script>
import base from './base.vue'

export default {
    props: ['fieldId', 'comboId', 'comboItemId'],
    components: {
        'base-input': base
    },
    computed: {
        icons: function () {
            const field = this.$store.getters.getField(this.fieldId)

            return {
                preIcon: (field && field.options.preIcon) || false,
                postIcon: (field && field.options.postIcon) || false
            }
        }
    }
}
</script>
