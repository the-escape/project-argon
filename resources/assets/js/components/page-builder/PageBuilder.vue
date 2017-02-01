<template>
    <div class="row">
        <div class="col-sm-6">
            <entity-revision-groups></entity-revision-groups>
        </div>
        <div class="col-sm-6">
            <entity-groups
                v-bind:entity-localisation-id="entityLocalisationId">
            </entity-groups>
        </div>
    </div>
</template>

<script>
    import EntityGroups from './EntityGroups.vue'
    import EntityRevisionGroups from './EntityRevisionGroups.vue'

    export default {
        mounted() {
            this.getEntityRevision()
        },
        props: ['entityLocalisationId'],
        methods: {
            getEntityRevision() {
                axios.get('/admin/api/blocks/'+this.entityLocalisationId)
                    .then((response) => {
                        response.data.data.entityRevisionGroups.data.forEach((entityRevisionGroup) => {
                            this.$store.commit('addEntityRevisionGroup', entityRevisionGroup)
                        });
                        response.data.data.entityGroups.data.forEach((entityGroup) => {
                            this.$store.commit('addEntityGroup', entityGroup)
                        });
                    })
            }
        },
        computed: {
            entityGroups() {
                return this.$store.getters.allEntityGroups()
            },
            entityRevisionGroups() {
                return this.$store.getters.allEntityRevisionGroups()
            }
        },
        components: {
            'entity-groups': EntityGroups,
            'entity-revision-groups': EntityRevisionGroups
        }
    }
</script>
