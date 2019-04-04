<template>
    <input-icon :pre-icon="icons.preIcon" :post-icon="icons.postIcon">
        <input :type="type" :id="inputName" :name="inputName" v-model="value">
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
            value: ''
        }
    },
    mounted() {
        this.value = this.valueObj.value
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

