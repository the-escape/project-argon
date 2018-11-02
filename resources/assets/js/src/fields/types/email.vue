<template>
    <base-input
    :options="field.options"
    :errors="field.errors"
    :help-text="field.helpText"
    :values="field.values"
    :icons="icons"
    :input-name="inputName"
    type="email"
    ></base-input>
</template>

<script>
import base from './base.vue'

export default {
    props: ['field', 'inputName'],
    components: {
        'base-input': base
    },
    computed: {
        icons: function() {
            return {
                preIcon: this.field.options.preIcon || {
                    svg: 'email'
                },
                postIcon: this.field.options.postIcon || false
            }
        }
    }
}
</script>
