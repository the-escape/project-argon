<template>
    <div class="c-actions__container">
        <div class="c-actions__content c-tab-panel__inner-container l-full">
            <h2>{{ header }}</h2>
            <div class="o-form l-accordion-container">
                <types v-for="field in fields" :key="field.id" :field="field"></types>
            </div>
        </div>
        <div class="c-actions">
            <div class="c-actions__group">
                <button type="submit" class="o-btn o-btn--primary" @click="apply($event)">Apply</button>
                <button type="submit" class="o-btn" @click="cancel($event)">Cancel</button>
            </div>
        </div>
    </div>
</template>

<script>
import { changeTab } from '../../ui/tabs'

export default {
    created() {
        this.$store.commit('setOldState')
    },
    methods: {
        apply: function (evt) {
            evt.preventDefault()
            this.$store.commit('setOldState')
            changeTab('page-content')
        },
        cancel: function (evt) {
            evt.preventDefault()
            this.$store.commit('restoreOldState')
            changeTab('page-content')
        }
    },
    computed: {
        fields: function() {
            return this.$store.state.fields
        },
        header: function () {
            return this.$store.state.header
        }
    }
}
</script>
