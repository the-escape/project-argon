<template>
    <div class="c-tab-panel active">
        <main class="c-tab-panel__container c-container">
            <div class="c-actions__container">
                <div class="c-actions__content">
                    <div class="l-halves c-tab-panel__inner" :class="{ 'is-dragging': isDragging }">
                        <div class="c-block-list__wrap">
                            <div class="typography l-space">
                                <h3>Active blocks</h3>
                                <input type="hidden" name="group_order" :value="renderOrder">
                            </div>
                            <div class="c-block-list">
                                <div class="c-block-list__search o-form">
                                    <input type="text" id="search" name="search" placeholder="Search blocks" v-model="renderSearch">
                                    <div class="c-block-list__search-icon">
                                        <svg><use xlink:href="/argon/images/svgicons.svg#search"></use></svg>
                                    </div>
                                </div>
                                <div class="c-block-list__container">
                                    <div class="c-block-list__inner-list c-block-list__inner-list--no-grow">
                                        <block-item v-for="block in filteredRenderNonSortList" :key="block.id" :block="block" @edit="editBlock" />
                                    </div>
                                    <draggable class="c-block-list__inner-list" v-model="renderingDragGroup" :options="dragOptions" @start="startDragging" @end="endDragging">
                                        <block-item v-for="block in filteredRenderList" :key="block.id" :block="block" @delete="removeItem" @edit="editBlock" />
                                    </draggable>
                                </div>
                            </div>
                        </div>
                        <div class="c-block-list__wrap" v-if="hasRenderable">
                            <div class="typography l-space">
                                <h3>Inactive blocks</h3>
                            </div>
                            <div class="c-block-list">
                                <div class="c-block-list__search o-form">
                                    <input type="text" id="search" name="search" placeholder="Search blocks" v-model="blockSearch">
                                    <div class="c-block-list__search-icon">
                                        <svg><use xlink:href="/argon/images/svgicons.svg#search"></use></svg>
                                    </div>
                                </div>
                                <div class="c-block-list__container">
                                    <draggable class="c-block-list__inner-list" v-model="blockDragList" :options="dragOptions" @start="startDragging" @end="endDragging">
                                        <block-item v-for="block in filteredBlockList" :key="block.id" :block="block" @add="addItem" />
                                    </draggable>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="c-actions">
                    <div class="c-actions__group">
                        <button type="submit" class="o-btn o-btn--primary" :on.prevent="submit">Save</button>
                        <a href="#previewLink" class="o-btn" target="_blank">Preview</a>
                        <button type="submit" class="o-btn" data-form-action="#saveDraftFormAction">Save draft</button>
                        <a href="#backToPageList" class="o-btn">Cancel</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import Block from '../components/Block.vue'

export default {
    components: {
        'block-item': Block
    },
    data () {
        return {
            isDragging: false,
            dragOptions: {
                group: {
                    name: 'groupEdit',
                    pull: true,
                    put: true
                },
                animation: 75
            }
        }
    },
    computed: {
        renderingDragGroup: {
            get () {
                return this.renderingGroups
            },
            set (values) {
                this.$store.commit('blockSelect/updateRenderingBlockList', {
                    blocks: values
                })
            }
        },
        blockDragList: {
            get () {
                return this.blockList
            },
            set (values) {
                this.$store.commit('blockSelect/updateBlockList', {
                    blocks: values
                })
            }
        },
        renderSearch: {
            get () {
                return this.$store.state.blockSelect.renderSearch
            },
            set (value) {
                this.$store.commit('blockSelect/setRenderSearch', {
                    searchString: value
                })
            }
        },
        blockSearch: {
            get () {
                return this.$store.state.blockSelect.blockSearch
            },
            set (value) {
                this.$store.commit('blockSelect/setBlockSearch',  {
                    searchString: value
                })
            }
        },
        ...mapState('blockSelect', [
            'nonSortableRenderingGroups',
            'renderingGroups',
            'blockList',
            'hasRenderable'
        ]),
        ...mapGetters('blockSelect', [
            'filteredRenderList',
            'filteredBlockList',
            'filteredRenderNonSortList',
            'renderOrder'
        ]),
        ...mapGetters('fields', ['getFieldValues'])
    },
    methods: {
        addItem: function (id) {
            this.$store.commit('blockSelect/addBlockToRendering', { id })
        },
        removeItem: function (id) {
            this.$store.commit('blockSelect/removeBlockFromRendering', { id })
        },
        editBlock: function (id, title) {
            this.$router.push({ path: `/edit/${id}` })
        },
        startDragging: function () {
            this.isDragging = true
        },
        endDragging: function () {
            this.isDragging = false
        },
        submit: function () {
            const fieldValues = this.getFieldValues()
            // const pageAttributes =
            console.log(fieldValues)
        }
    }
}
</script>
