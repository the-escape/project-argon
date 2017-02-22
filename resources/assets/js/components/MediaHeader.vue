<template>
    <div class="media__header">
        <form>
            <div class="form__group">
                <label for="search" class="sr-only">Search library</label>
                <input v-model="search" id="search" type="text" class="form__text icon" placeholder="Search library">
                <span class="icon search"></span>
            </div>
            <div class="form__group">
                <label for="filter" class="sr-only">Media Type</label>
                <select v-model="filter" id="filter" class="form__select">
                    <option></option>
                    <option value="all">All</option>
                    <option value="files">Files</option>
                    <option value="folders">Folders</option>
                </select>
            </div>
        </form>
        <div class="media__actions">
            <h1 v-if="!searching">{{ activeFolder.name }}</h1>
            <h1 v-else>Search: {{ searchFilter }}</h1>
            <button class="form__btn form__btn--small media__upload">UPLOAD MEDIA</button>
        </div>
    </div>
</template>

<script>
    import _ from 'lodash'
    import { mapGetters } from 'vuex'
    import * as types from '../store/mutation-types'

    export default {
        computed: mapGetters({
            activeFolder: 'activeFolder',
            searching: 'searching'
        }),
        data: () => {
            return {
                filter: '',
                search: ''
            }
        },
        mounted () {
            let self = this;
            $('.media__scroll').scrollbar();
            $('.media .form__select').select2({
                placeholder: 'Media type',
                minimumResultsForSearch: Infinity,
                width: '100%'
            }).on('change', function (e) {
                self.filter = $(this).val();
            });
        },
        methods: {
            searchItems: _.debounce(function () {
                this.$store.dispatch('searchItems', this.search)
            }, 500),
        },
        watch: {
            search () {
                //this.$store.dispatch('isLoading', true);

                if (!this.search.length) {
                    this.$store.dispatch('selectFolder', this.activeFolder);
                    return true
                }

                this.searchItems()
            }
        }
    }
</script>
