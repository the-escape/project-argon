<template>
    <component
    v-bind:is="type"
    :field-id="field.id"
    ></component>
</template>

<script>
import Text from './text.vue'
import Email from './email.vue'
import Phone from './phone.vue'

const typeMap = {
    'text': 'text-input',
    'email': 'email-input',
    'phone': 'phone-input'
}

export default {
    props: ['field'],
    components: {
        'text-input': Text,
        'email-input': Email,
        'phone-input': Phone
    },
    computed: {
        type: function() {
            const type = typeMap[this.field.options.typeKey]
            return type || 'text-input'
        }
    }
}
</script>
