<template>
    <ul>
        <li class="block block__revision" v-for="entityRevisionGroup in entityRevisionGroups">
            <div class="block__loading" v-if="loadingId === entityRevisionGroup.id"></div>
            <div class="block__overlay">
                <a v-bind:href="getEditUrl(entityRevisionGroup)" class="block__edit">Edit block content</a>
                <div class="block__actions">
                    <a href="#" class="block__delete" v-on:click="removeEntityRevisionGroup(entityRevisionGroup)"></a>
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
            'entityLocalisationId',
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
                this.$store.dispatch('DELETE_ENTITY_REVISION_GROUP_REMOVE', {
                    entityLocalisationId: this.entityLocalisationId,
                    entityRevisionGroup: entityRevisionGroup
                }).then(() => {
                    this.loadingId = 0;
                })
            },
            getEditUrl(entityRevisionGroup) {
                return '/admin/block/' + this.entityLocalisationId + '/' + entityRevisionGroup.id
            }
        },
        data() {
            return {
                loadingId: 0
            }
        },
    }
</script>
