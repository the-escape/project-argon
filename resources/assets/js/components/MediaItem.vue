<template>
    <!--
    <div class="media__item">
        <a href="#" data-toggle="modal" data-target="#media-view"
            v-on:click="select()">
            <div class="media__asset"
                 v-bind:style="{ 'background-image': 'url(' + item.thumbUrl + ')' }">
            </div>
            <span class="media__name">{{ item.filename | length }}</span>
        </a>
    </div>
    -->
    <div class="media__item dz-preview dz-file-preview dz-complete">
        <a href="#" data-toggle="modal" data-target="#media-view"
            v-on:click="select">
            <img class="media__asset" data-dz-thumbnail
                 v-bind:src="item.thumbUrl"
                 v-bind:alt="item.filename" />
            <div class="media__name dz-filename"><span data-dz-name>{{ item.filename | length }}</span></div>
            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
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
