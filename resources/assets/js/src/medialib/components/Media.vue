<template>
    <div class="mlapp o-form">

        <div class="ml">

            <div class="ml__options l-flexcols">

                <div class="ml__options-layout l-flexcols-1">

                    <div class="layout ">
                        <button type="button" class="o-btn o-btn--xs" :class="{ 'active':layout==='tiles'}" v-on:click="setLayout('tiles')">Tiles</button>
                        <button type="button" class="o-btn o-btn--xs" :class="{'active':layout==='list'}" v-on:click="setLayout('list')">List</button>
                    </div>

                </div>

                <div class="l-flexcols-2">
                    <div :class="[search.isLoading() ? 'search--loading' : '', 'search']">
                        <div class="o-multi__item-wrap">
                            <div class="o-form-icon">
                                <span class="o-form-icon__icon">
                                    <template v-if="search.hasKeywords()">
                                        Found {{ search.getResultsCount() }} items
                                    </template>
                                    <template v-else>
                                        Search for...
                                    </template>
                                </span>
                                <input type="text" class="form-control" placeholder="Search for..." v-model="keywords">
                            </div>
                            <button class="o-btn o-btn--xs" type="button" v-on:click="searchReset(search)">Clear</button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="ml__view l-flexcols">

                <div class="ml__tree l-flexcols-1">

                    <div class="panel-heading">
                        Folders Tree
                    </div>

                    <div class="panel-body">
                        <DirectoryTree/>
                    </div>

                </div>

                <div class="ml__preview l-flexcols-2">

                    <div class="panel panel-default">

                        <template v-if="search.hasKeywords()">

                            <div class="panel-heading">
                                Search results for `{{ search.keywords }}`
                            </div>

                            <div class="panel-body">

                                <div class="search-results" v-if="search.hasResults()">
                                    <Content v-bind:items="search.getResults()" v-bind:folders="{}"/>
                                </div>

                                <div class="search-results" v-else>
                                    <p>No results found.</p>
                                </div>

                            </div>

                        </template>

                        <template v-if="!search.hasKeywords()">

                            <div class="panel-heading">

                                <div class="breadcrumbs" v-if="active.isSet()" >

                                    <span class="go go--back btn btn-default btn-sm" v-bind:class="{'disabled': !back.isSet()}" v-on:click="folderSelected(back)" title="Skip between current and previous folder">&#x21C4;</span>

                                    <template v-for="folder of active.breadcrumbs()">
                                        <span class="breadcrumbs__separator" v-if="folder.parent">&gt;</span>

                                        <span class="breadcrumbs__piece" v-bind:class="{'breadcrumbs__child': folder.parent}" v-on:click="folderSelected(folder)">
                                        {{ folder.name }}
                                    </span>
                                    </template>

                                </div>

                            </div>

                            <div class="panel-body">

                                <Folder/>

                            </div>

                        </template>

                    </div>

                </div>
            </div>

        </div>

        <div class="m-details modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" v-if="modal.isSet()">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{ modal.item.filename }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="m-details__content">
                            <div class="m-details__preview">
                                <img :src="`https://www.serco-ese.com/media/${modal.item.id}/${modal.item.slug}.${modal.item.extension}`" :alt="modal.item.filename">
                            </div>
                            <dl class="m-details__info">
                                <dt>{{ modal.item.filename }}</dt>
                                <dd><small>File type:</small> {{ modal.item.extension }}</dd>
                                <dd><small>Uploaded at:</small> {{ modal.item.updated_at }}</dd>
                                <dd><small>Dimensions:</small> {{ JSON.parse(modal.item.meta).width }} x {{ JSON.parse(modal.item.meta).height }}</dd>
                                <dd><small>File Size:</small> {{ modal.item.filesize }}</dd>
                                <dd><small>Uploaded by:</small> {{ modal.item.uploaded_by }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import  { mapState } from 'vuex'
    import DirectoryTree from './DirectoryTree.vue'
    import Folder from "./Folder.vue"
    import Content from "./Content.vue"
    import debounce from "lodash/debounce"

    export default {
        created () {
            this.$store.dispatch('loadLibrary');
        },
        watch: {
            keywords: function () {
                this.searchItems()
            }
        },
        computed: {
            ...mapState([
                'active',
                'back',
                'search',
                'modal',
                'layout'
            ]),
            keywords: {
                set(keywords) {
                    this.$store.dispatch('search', keywords)
                },
                get() {
                    return this.search.keywords
                }
            }
        },
        components: {
            Content,
            Folder,
            DirectoryTree
        },
        methods: {
            searchReset(search) {
                search.reset()
            },
            searchItems: debounce(function () {
                this.$store.dispatch('search', this.keywords)
            }, 700),
            folderSelected(folder) {
                this.$store.dispatch('folderSelected', folder)
            },
            setLayout(layout) {
                this.$store.dispatch('setLayout', layout)
            }
        }
    }
</script>
