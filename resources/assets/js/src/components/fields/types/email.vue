<template>
    <base-input
    :field-id="fieldId"
    :combo-id="comboId"
    :combo-item-id="comboItemId"
    :icons="icons"
    type="email"
    ></base-input>
</template>

<script>
import base from './base/index.vue'

export default {
    props: ['groupId', 'fieldId', 'comboId', 'comboItemId'],
    components: {
        'base-input': base
    },
    computed: {
        icons: function() {
            let field = this.$store.getters['fields/getField'](this.groupId, [this.fieldId, this.comboId])

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
