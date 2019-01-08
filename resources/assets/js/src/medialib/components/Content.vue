<template>

    <div :class="`folder folder--${layout}`">

        <div class="folder__item folder__item--folder" v-for="child in folders" :key="child.id">

            <div class="folder__icon" @click.stop="folderSelected(child)">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 85.04 56.69"><path d="M79.3 9.77H42.2a5.41 5.41 0 0 1-3.56-1.33L29.88.76a3.1 3.1 0 0 0-2-.76H3.54A3.49 3.49 0 0 0 0 3.42v47.73a5.66 5.66 0 0 0 5.74 5.54H79.3a5.64 5.64 0 0 0 5.7-5.54V15.32a5.64 5.64 0 0 0-5.7-5.55z"/></svg>
            </div>

            <dl class="folder__info">
                <dt>{{ child.name }}</dt>
                <dd><small>Subfolders: </small> {{ child.children.length }}</dd>
                <dd><small>Items: </small> {{ (child.items && child.items.length) || 0  }}</dd>
            </dl>

        </div>

        <drag class="drag" :effect-allowed="['move']" drop-effect="move" :transfer-data="item" :class="`folder__item folder__item--${item.item.extension}`" v-for="item in items" :key="`item-${item.item.id}`">

            <div slot="image" class="drag-image">
                <ul>
                    <li>Drag</li>
                    <li>Image</li>
                    <li>HTML</li>
                </ul>
            </div>

            <div class="folder__preview">

                <div class="folder__image" @click="modal(item)">
                    <img :src="item.getUrl()" :alt="item.getName()">
                </div>

            </div>

            <div class="folder__details">

                <dl class="folder__info">
                    <dt>{{ item.getName() }}</dt>
                    <dd><small>Dimensions:</small> {{ item.getDimensions() }}</dd>
                    <!--<dd><small>Size:</small> {{ item.filesize }}</dd>-->
                </dl>

                <div class="folder__options">
                    <div class="folder__options-title">Actions: <span class="chevron--bottom"></span></div>
                    <div class="folder__options-list">
                        <button @click="onChange('edit', item)">Edit</button>
                        <button @click="onChange('remove', item)">Remove</button>
                    </div>
                </div>

            </div>

        </drag>

    </div>

</template>

<script>
    import  { mapState } from 'vuex'
    import { Drag } from 'vue-drag-drop'

    export default {
        data () {
            return {
                key: ""
            }
        },
        props: ['items', 'folders'],
        computed: {
            ...mapState([
                'layout'
            ])
        },
        components: {
            Drag
        },
        methods: {
            folderSelected(folder) {
                this.$store.dispatch('folderSelected', folder)
            },
            modal(item) {
                // TODO: promise with modal callback
                this.$store.dispatch('modal', item)
                $('#myModal').modal()
            },
            onChange(event, item) {
                let c = false

                switch (event) {
                    case 'edit':
                        c = confirm("Are you sure?")
                        if (c === true) {
                            console.log("Requested edit of item %d", item.item.id)
                        }
                        break

                    case 'remove':
                        c = confirm("Are you sure?")
                        if (c === true) {
                            this.$store.dispatch('removeItem', item)
                        }
                        break
                }
            }
        }
    }
</script>

<style>
    .drag-image {
        color: #000;
    }
</style>
