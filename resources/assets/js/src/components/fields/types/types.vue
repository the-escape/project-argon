<template>
    <component
    v-bind:is="type"
    :group-id="groupId"
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
import Location from './location/index.vue'
import Wysiwyg from './wysiwyg.vue'
import Button from './button/index.vue'
import Switch from './boolean.vue'
import DateTime from './datetime.vue'
import Image from './image/index.vue'
import File from './file.vue'
import Icon from './icon/index.vue'

const typeMap = {
    'text': 'text-input',
    'email': 'email-input',
    'phone': 'phone-input',
    'combo': 'combo',
    'select': 'select-input',
    'location': 'location-input',
    'wysiwyg': 'wysiwyg-input',
    'button': 'button-input',
    'boolean': 'boolean-input',
    'item': 'select-input',
    'menu': 'select-input',
    'datetime' : 'datetime-input',
    'image': 'image-input',
    'file': 'file-input',
    'icon': 'icon-input'
}

export default {
    name: 'types',
    props: ['groupId', 'field', 'comboId', 'comboItemId'],
    components: {
        'text-input': Text,
        'email-input': Email,
        'phone-input': Phone,
        combo,
        'select-input': select,
        'location-input': Location,
        'wysiwyg-input': Wysiwyg,
        'button-input': Button,
        'boolean-input': Switch,
        'datetime-input': DateTime,
        'image-input': Image,
        'file-input': File,
        'icon-input': Icon
    },
    computed: {
        type: function () {
            const type = typeMap[this.field.options.typeKey]
            return type || 'text-input'
        }
    }
}
</script>
