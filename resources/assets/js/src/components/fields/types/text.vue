<template>
    <component
    v-bind:is="type"
    :group-id="groupId"
    :field-id="fieldId"
    :combo-id="comboId"
    :combo-item-id="comboItemId"
    :icons="icons"
    type="text"
    ></component>
</template>

<script>
import base from './base/index.vue'
import textarea from './textarea.vue'

export default {
    props: ['groupId', 'fieldId', 'comboId', 'comboItemId'],
    components: {
        'base-input': base,
        'textarea-input': textarea
    },
    computed: {
        type: function() {
            let field = this.$store.getters['fields/getField'](this.groupId, [this.fieldId, this.comboId])
            if(field.options.settings.multiline){
                return 'textarea-input'
            }
            return 'base-input'
        },
        icons: function () {
            let field = this.$store.getters['fields/getField'](this.groupId, [this.fieldId, this.comboId])

            return {
                preIcon: (field && field.options.preIcon) || false,
                postIcon: (field && field.options.postIcon) || false
            }
        }
    }
}
</script>
