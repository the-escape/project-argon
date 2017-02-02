<template>
    <div class="row">
        <div class="col-sm-6">
            <div class="blocks">
                <div class="form__group">
                    <input v-model="searchEntityRevisionGroups" type="text" class="form__text icon blocks__search" placeholder="Search blocks">
                    <span class="icon search"></span>
                </div>
                <div class="blocks__container">
                    <entity-revision-groups
                        v-bind:entity-localisation-id="entityLocalisationId"
                        v-bind:searchQuery="searchEntityRevisionGroups">
                    </entity-revision-groups>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="blocks">
                <div class="form__group">
                    <input v-model="searchEntityGroups" type="text" class="form__text icon blocks__search" placeholder="Search blocks">
                    <span class="icon search"></span>
                </div>
                <div class="blocks__container">
                    <entity-groups
                            v-bind:entity-localisation-id="entityLocalisationId"
                            v-bind:searchQuery="searchEntityGroups">
                    </entity-groups>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import EntityGroups from './EntityGroups.vue'
    import EntityRevisionGroups from './EntityRevisionGroups.vue'

    function fetchEntityRevision (store, entityLocalisationId) {
        return store.dispatch('GET_ENTITY_REVISION', entityLocalisationId)
    }

    export default {
        name: 'PageBuilder',
        components: {
            EntityGroups,
            EntityRevisionGroups
        },
        props: ['entityLocalisationId'],
        computed: {
            entityGroups() {
                return this.$store.getters.entityGroups()
            },
            entityRevisionGroups() {
                return this.$store.getters.entityRevisionGroups()
            }
        },
        preFetch: fetchEntityRevision,
        beforeMount() {
            fetchEntityRevision(this.$store, {
                entityLocalisationId: this.entityLocalisationId
            })
        },
        data() {
            return {
                searchEntityGroups: '',
                searchEntityRevisionGroups: ''
            }
        }
    }
</script>

<style lang="sass" rel="stylesheet/scss">
    @import "../../../sass/includes/settings/_vars.scss";

    .blocks {
        background-color: $color-grey-light;
        border: 1px solid $color-grey-dark;
        float: left;
        margin-top: 30px;
        width: 100%;
    }
    .blocks__container {
        float: left;
        height: 500px;
        overflow: scroll;
        width: 100%;
    }
</style>
