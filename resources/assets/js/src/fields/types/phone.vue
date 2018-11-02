<template>
    <base-input
    :options="field.options"
    :errors="field.errors"
    :help-text="field.helpText"
    :value="value"
    :icons="icons"
    :input-name="inputName"
    type="tel"
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
        icons: function(){
            return {
                preIcon: this.field.options.preIcon || {
                    svg: 'phone'
                },
                postIcon: this.field.options.postIcon || false
            }
        },
        value: function() {
            return this.field.values[0]
        }
    }
}
</script>
