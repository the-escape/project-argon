<template>
    <component
    v-bind:is="type"
    :field-id="field.id"
    :combo-id="comboId"
    :combo-value-id="comboValueId"
    ></component>
</template>

<script>
import Text from './text.vue'
import Email from './email.vue'
import Phone from './phone.vue'
import combo from './combo.vue'

const typeMap = {
    'text': 'text-input',
    'email': 'email-input',
    'phone': 'phone-input',
    'combo': 'combo'
}

export default {
    name: 'types',
    props: ['field', 'comboId', 'comboValueId'],
    components: {
        'text-input': Text,
        'email-input': Email,
        'phone-input': Phone,
        combo
    },
    computed: {
        type: function () {
            const type = typeMap[this.field.options.typeKey]
            return type || 'text-input'
        }
    }
}
</script>
