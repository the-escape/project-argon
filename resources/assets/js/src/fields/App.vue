<template>
    <div class="o-form l-container">
        <types v-for="field in fields" :key="field.id" :field="field"></types>
    </div>
</template>

<script>
export default {
    computed: {
        fields: function() {
            return this.$store.state.fields
        }
    }
}
</script>
