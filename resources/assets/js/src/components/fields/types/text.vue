<template>
    <component
    v-bind:is="type"
    :field-id="fieldId"
    :combo-id="comboId"
    :combo-item-id="comboItemId"
    :icons="icons"
    type="text"
    ></component>
</template>

<script>
import base from './base/index.vue'
import textarea from './textarea/index.vue'

export default {
    props: ['fieldId', 'comboId', 'comboItemId'],
    components: {
        'base-input': base,
        'textarea-input': textarea
    },
    computed: {
        type: function() {
            let field
            if(this.comboId){
                field = this.$store.getters.getComboField(this.comboId, this.fieldId)
            }else{
                field = this.$store.getters.getField(this.fieldId)
            }

            if(field.options.settings.multiline){
                return 'textarea-input'
            }
            return 'base-input'
        },
        icons: function () {
            let field
            if(this.comboId){
                field = this.$store.getters.getComboField(this.comboId, this.fieldId)
            }else{
                field = this.$store.getters.getField(this.fieldId)
            }

            return {
                preIcon: (field && field.options.preIcon) || false,
                postIcon: (field && field.options.postIcon) || false
            }
        }
    }
}
</script>
