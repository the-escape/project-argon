<template>
    <input-icon :pre-icon="icons.preIcon" :post-icon="icons.postIcon">
        <input :type="type" :id="inputName" :name="inputName" v-model="value">
        {{ valueObj.value }}
    </input-icon>
</template>

<script>
import InputIcon from '../util/input-icon.vue'

export default {
    props: ['icons', 'type', 'valueObj', 'inputName'],
    components: {
        'input-icon': InputIcon
    },
    data() {
        return {
            loading: true,
            value: this.valueObj.value
        }
    },
    mounted() {
        this.loading = false
    },
    watch: {
        value: function (newValue) {
            if(this.loading){
                return
            }
            this.$emit('change', newValue)
        }
    }
}
</script>

