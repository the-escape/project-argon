<template>
    <ul>
        <li class="block" v-for="entityGroup in entityGroups">
            <div class="block__loading" v-if="loadingId === entityGroup.id"></div>
            <a href="#" class="block__add" @click="addEntityGroup(entityGroup)"></a>
            <div class="block__content">
                <div class="block__img"></div>
                <div class="block__title">{{ entityGroup.name }}</div>
            </div>
        </li>
    </ul>
</template>

<script>
    export default {
        name: 'EntityGroups',
        props: [
            'entityLocalisationId',
            'searchQuery'
        ],
        computed: {
            entityGroups() {
                const self = this
                return this.$store.state.entityGroups.filter(entityGroup => {
                    return entityGroup.name.toLowerCase().indexOf(self.searchQuery.toLowerCase()) !== -1
                })
            }
        },
        methods: {
            addEntityGroup(entityGroup) {
                this.loadingId = entityGroup.id;
                this.$store.dispatch('POST_ENTITY_GROUP_ADD', {
                    entityLocalisationId: this.entityLocalisationId,
                    entityGroup: entityGroup
                }).then(() => {
                    this.loadingId = 0;
                })
            }
        },
        data() {
            return {
                loadingId: 0
            }
        }
    }
</script>
