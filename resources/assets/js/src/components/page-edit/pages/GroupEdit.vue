<template>
    <div class="c-tab-panel active">
        <main class="c-tab-panel__container c-container">
            <group :groupId="groupKey" />
        </main>
    </div>
</template>

<script>
import Group from '../components/group.vue'
import { mapGetters } from 'vuex';

export default {
    components: {
        Group
    },
    created () {
        this.$store.dispatch('fields/setupGroup', {
            groupID: this.$route.params.id
        })
    },
    computed: {
        groupKey: function () {
            return this.$route.params.id
        }
    }
}
</script>
