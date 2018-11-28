<template>
    <component
    v-bind:is="type"
    :field-id="fieldId"
    :combo-id="comboId"
    :combo-item-id="comboItemId"
    ></component>
</template>

<script>
import SingleSelect from './single-select.vue'
import MultiSelect from './multi-select.vue'

export default {
    props: ['fieldId', 'comboId', 'comboItemId'],
    components: {
        'single': SingleSelect,
        'multi': MultiSelect
    },
    computed: {
        type: function () {
            let field
            if(this.comboId){
                field = this.$store.getters.getComboField(this.comboId, this.fieldId)
            }else{
                field = this.$store.getters.getField(this.fieldId)
            }

            if(field.options.settings.multiple){
                return 'multi'
            }
            return 'single'
        }
    }
}
</script>
