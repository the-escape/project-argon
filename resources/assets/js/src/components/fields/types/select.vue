<template>
    <component
    v-bind:is="type"
    :group-id="groupId"
    :field-id="fieldId"
    :combo-id="comboId"
    :combo-item-id="comboItemId"
    ></component>
</template>

<script>
import SingleSelect from './single-select.vue'
import MultiSelect from './multi-select.vue'

export default {
    props: ['groupId', 'fieldId', 'comboId', 'comboItemId'],
    components: {
        'single': SingleSelect,
        'multi': MultiSelect
    },
    computed: {
        type: function () {
            const settings = this.$store.getters['fields/getFieldOption'](this.groupId, [this.fieldId, this.comboId], 'settings')
            if(!settings){
                return 'single'
            }

            if(settings.multiple || settings.multiple_instances){
                return 'multi'
            }

            return 'single'
        }
    }
}
</script>
