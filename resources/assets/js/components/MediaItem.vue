<template>
    <div class="media__item">
        <a href="#" data-toggle="modal" data-target="#media-view"
            v-on:click="select()">
            <div class="media__asset"
                 v-bind:style="{ 'background-image': 'url(' + item.thumbUrl + ')' }">
            </div>
            <span class="media__name">{{ item.filename | length }}</span>
        </a>
    </div>
</template>

<script>
    export default {
        props: ['item'],
        methods: {
            select () {
                this.$store.dispatch('selectItem', this.item)
            }
        }
    }
</script>
