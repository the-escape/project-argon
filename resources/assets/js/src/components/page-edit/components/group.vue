<template>
    <div>
        <template v-if="isShowingActions(groupId)">
            <div class="c-actions__container">
                <div class="c-actions__content c-tab-panel__inner-container l-full">
                    <h2>Editing: <span class="h-text--primary">{{ header(groupId) }}</span></h2>
                    <div class="o-form l-accordion-container">
                        <types v-for="field in fields(groupId)" :key="field.id" :field="field" :group-id="groupId"></types>
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

        <template v-else>
            <h3>{{ header(groupId) }}</h3>
            <div class="o-form l-accordion-container">
                <types v-for="field in fields(groupId)" :key="field.id" :field="field" :group-id="groupId"></types>
            </div>
        </template>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    props: ['groupId'],
    created() {
        this.$store.commit('fields/setOldState', { groupID: this.groupId })
    },
    methods: {
        apply: function (evt) {
            evt.preventDefault()
            this.$store.commit('fields/setOldState', { groupID: this.groupId })
            this.$router.push('/')
        },
        cancel: function (evt) {
            evt.preventDefault()
            this.$store.commit('fields/restoreOldState', { groupID: this.groupId })
            this.$router.push('/')
        }
    },
    computed: {
        ...mapGetters('fields', [
            'fields',
            'header',
            'isShowingActions'
        ])
    }
}
</script>
