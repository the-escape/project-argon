<template>
    <base-input
    :field-id="fieldId"
    :combo-id="comboId"
    :combo-item-id="comboItemId"
    :icons="icons"
    type="tel"
    ></base-input>
</template>

<script>
import base from './base/index.vue'

export default {
    props: ['fieldId', 'comboId', 'comboItemId'],
    components: {
        'base-input': base
    },
    computed: {
        icons: function(){
            let field
            if(this.comboId){
                field = this.$store.getters.getComboField(this.comboId, this.fieldId)
            }else{
                field = this.$store.getters.getField(this.fieldId)
            }

            return {
                preIcon: (field && field.options.preIcon) || {
                    svg: 'phone'
                },
                postIcon: (field && field.options.postIcon) || false
            }
        }
    }
}
</script>
