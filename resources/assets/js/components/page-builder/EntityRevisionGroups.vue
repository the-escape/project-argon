<template>
    <ul>
        <li class="block block__revision" v-for="entityRevisionGroup in entityRevisionGroups">
            <div class="block__loading" v-if="loadingId === entityRevisionGroup.id"></div>
            <div class="block__overlay">
                <a href="#" class="block__edit">Edit block content</a>
                <div class="block__actions">
                    <a href="#" class="block__delete" @click="removeEntityRevisionGroup(entityRevisionGroup)"></a>
                    <span class="drag"></span>
                </div>
            </div>
            <div class="block__content">
                <div class="block__img"></div>
                <div class="block__title">{{ entityRevisionGroup.name }}</div>
            </div>
        </li>
    </ul>
</template>

<script>
    export default {
        name: 'EntityRevisionGroups',
        props: [
            'searchQuery'
        ],
        computed: {
            entityRevisionGroups() {
                const self = this
                return this.$store.state.entityRevisionGroups.filter(entityRevisionGroup => {
                    return entityRevisionGroup.name.toLowerCase().indexOf(self.searchQuery.toLowerCase()) !== -1
                })
            }
        },
        methods: {
            removeEntityRevisionGroup(entityRevisionGroup) {
                this.loadingId = entityRevisionGroup.id;
                this.$store.dispatch('DELETE_ENTITY_REVISION_GROUP_REMOVE', { entityRevisionGroup }).then(() => {
                    this.loadingId = 0;
                })
            }
        },
        data() {
            return {
                loadingId: 0
            }
        },
    }
</script>
