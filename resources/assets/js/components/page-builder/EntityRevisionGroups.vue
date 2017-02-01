<template>
    <div class="blocks">
        <div class="form__group">
            <input type="text" class="form__text icon blocks__search" placeholder="Search blocks">
            <span class="icon search"></span>
        </div>
        <div class="block__container">
            <ul class="block__list">
                <li class="block block__revision" v-for="entityRevisionGroup in entityRevisionGroups">
                    <div class="block__loading" v-if="entityRevisionGroupActive === entityRevisionGroup.id"></div>
                    <div class="block__overlay">
                        <a href="#" class="block__edit">Edit block content</a>
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
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                entityRevisionGroupActive: 0
            }
        },
        methods: {
            removeEntityRevisionGroup(entityRevisionGroup) {
                this.entityRevisionGroupActive = entityRevisionGroup.id;

                axios.delete('/admin/api/blocks/'+entityRevisionGroup.id+'/remove')
                    .then((response) => {
                        this.$store.commit('removeEntityRevisionGroup', entityRevisionGroup)
                    })
            }
        },
        computed: {
            entityRevisionGroups() {
                return this.$store.getters.allEntityRevisionGroups
            }
        }
    }
</script>
