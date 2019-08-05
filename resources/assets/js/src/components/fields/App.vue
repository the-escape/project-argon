<template>
    <div>
        <group v-for="groupKey in groupKeys" :key="groupKey" :groupId="groupKey" />
    </div>
</template>

<script>
import Group from './Group.vue'
import { mapGetters } from 'vuex';

export default {
    components: {
        Group
    },
    computed: {
        ...mapGetters('fields', ['groupKeys'])
    }
}
</script>
