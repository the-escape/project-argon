<template>
    <div class="o-form l-container">
        <types v-for="field in fieldGroups" :key="field.id" :field="field"></types>
    </div>
</template>

<script>
import types from './types/types.vue'

export default {
    components: {
        types
    },
    data() {
        return {
            fieldGroups: window.fieldGroups[this.$root.$options.fieldGroupName]
        }
    }
}
</script>

<style>
.example {
    color: red;
}
</style>
