<template>
    <div class="blocks">
        <div class="form__group">
            <input type="text" class="form__text icon blocks__search" placeholder="Search blocks">
            <span class="icon search"></span>
        </div>
        <div class="block__container">
            <ul>
                <li class="block" v-for="entityGroup in entityGroups">
                    <div class="block__loading" v-if="entityGroupActive === entityGroup.id"></div>
                    <a href="#" class="block__add" v-on:click="addEntityGroup(entityGroup)"></a>
                    <div class="block__content">
                        <div class="block__img"></div>
                        <div class="block__title">{{ entityGroup.name }}</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['entityLocalisationId'],
        data() {
            return {
                entityGroupActive: 0
            }
        },
        methods: {
            addEntityGroup(entityGroup) {
                this.entityGroupActive = entityGroup.id;

                axios.post('/admin/api/blocks/'+this.entityLocalisationId+'/add', entityGroup)
                    .then((response) => {
                        this.$store.commit('removeEntityGroup', entityGroup);
                        this.$store.commit('addEntityRevisionGroup', response.data.data)
                    })
            }
        },
        computed: {
            entityGroups() {
                return this.$store.getters.allEntityGroups
            }
        }
    }
</script>
