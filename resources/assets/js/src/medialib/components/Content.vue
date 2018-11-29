<template>

    <div :class="`folder folder--${layout}`">

        <div class="folder__item folder__item--folder" v-for="child in folders" :key="child.id">

            <div class="folder__icon" v-on:click.stop="folderSelected(child)">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 85.04 56.69"><path d="M79.3 9.77H42.2a5.41 5.41 0 0 1-3.56-1.33L29.88.76a3.1 3.1 0 0 0-2-.76H3.54A3.49 3.49 0 0 0 0 3.42v47.73a5.66 5.66 0 0 0 5.74 5.54H79.3a5.64 5.64 0 0 0 5.7-5.54V15.32a5.64 5.64 0 0 0-5.7-5.55z"/></svg>
            </div>

            <dl class="folder__info">
                <dt>{{ child.name }}</dt>
                <dd><small>Subfolders: </small> {{ child.children.length }}</dd>
                <dd><small>Items: </small> {{ (child.items && child.items.length) || 0  }}</dd>
            </dl>

        </div>

        <div :class="`folder__item folder__item--${item.extension}`" v-for="item in items" :key="`item-${item.id}`" v-on:click="modal(item)">

            <div class="folder__image" >
                <img :src="`/media/${item.id}/${item.slug}.${item.extension}`" :alt="item.filename">
            </div>

            <dl class="folder__info">
                <dt>{{ item.filename }}</dt>
                <dd><small>Dimensions:</small> {{ JSON.parse(item.meta).width }} x {{ JSON.parse(item.meta).height }}</dd>
                <dd><small>Size:</small> {{ item.filesize }}</dd>
            </dl>

        </div>

    </div>

</template>

<script>
    import  { mapState } from 'vuex'
    export default {
        props: ['items', 'folders'],
        computed: {
            ...mapState([
                'layout'
            ])
        },
        methods: {
            folderSelected(folder) {
                this.$store.dispatch('folderSelected', folder)
            },
            modal(item) {
                // TODO: promise with modal callback
                this.$store.dispatch('modal', item)
                $('#myModal').modal()
            }
        }
    }
</script>
