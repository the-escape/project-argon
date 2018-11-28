<template>
    <component
    v-bind:is="type"
    :field-id="field.id"
    :combo-id="comboId"
    :combo-item-id="comboItemId"
    ></component>
</template>

<script>
import Text from './text.vue'
import Email from './email.vue'
import Phone from './phone.vue'
import combo from './combo.vue'
import select from './select.vue'
import Location from './location.vue'
import Wysiwyg from './wysiwyg.vue'
import Button from './button.vue'
import Switch from './boolean.vue'

const typeMap = {
    'text': 'text-input',
    'email': 'email-input',
    'phone': 'phone-input',
    'combo': 'combo',
    'select': 'select-input',
    'location': 'location-input',
    'wysiwyg': 'wysiwyg-input',
    'button': 'button-input',
    'boolean': 'boolean-input'
}

export default {
    name: 'types',
    props: ['field', 'comboId', 'comboItemId'],
    components: {
        'text-input': Text,
        'email-input': Email,
        'phone-input': Phone,
        combo,
        'select-input': select,
        'location-input': Location,
        'wysiwyg-input': Wysiwyg,
        'button-input': Button,
        'boolean-input': Switch
    },
    computed: {
        type: function () {
            const type = typeMap[this.field.options.typeKey]
            return type || 'text-input'
        }
    }
}
</script>
