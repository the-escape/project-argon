<template>

    <div>
        <div v-if="active.hasContent()">

            <Content v-bind:items="active.items" v-bind:folders="active.children"/>

        </div>

        <h3 v-else>No content</h3>
    </div>

</template>

<script>
    import  { mapState } from 'vuex'
    import Content from "./Content.vue";

    export default {
        computed: {
            ...mapState([
                'active'
            ])
        },
        components: {
            Content
        }
    }
</script>
