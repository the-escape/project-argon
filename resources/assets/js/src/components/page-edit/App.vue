<template>
    <div class="l-halves c-tab-panel__inner">
        <div class="c-block-list__wrap">
            <div class="typography l-space">
                <h3>Page blocks</h3>
                <p>Here you can edit, remove and re-order content</p>
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
                    <draggable class="c-block-list__inner-list" v-model="renderingDragGroup" :options="dragOptions">
                        <block-item v-for="block in filteredRenderList" :key="block.id" :block="block" @delete="removeItem" @edit="editBlock" />
                    </draggable>
                </div>
            </div>
        </div>
        <div class="c-block-list__wrap" v-if="hasRenderable">
            <div class="typography l-space">
                <h3>Unused blocks</h3>
                <p>Add blocks to create you own custom page layout</p>
            </div>
            <div class="c-block-list">
                <div class="c-block-list__search o-form">
                    <input type="text" id="search" name="search" placeholder="Search blocks" v-model="blockSearch">
                    <div class="c-block-list__search-icon">
                        <svg><use xlink:href="/argon/images/svgicons.svg#search"></use></svg>
                    </div>
                </div>
                <div class="c-block-list__container">
                    <draggable class="c-block-list__inner-list" v-model="blockDragList" :options="dragOptions">
                        <block-item v-for="block in filteredBlockList" :key="block.id" :block="block" @add="addItem" />
                    </draggable>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Block from './components/Block.vue'
import { changeTab } from '../../ui/tabs'
import { preventPageLeave } from '../../ui'

export default {
    components: {
        'block-item': Block
    },
    data () {
        return {
            nonSortableRenderingGroups: [],
            renderingGroups: [],
            blockList: [],
            hasRenderable: false,
            dragOptions: {
                group: {
                    name: 'groupEdit',
                    pull: true,
                    put: true
                },
                animation: 75,
                handle: '.c-block__drag-handle'
            },
            renderSearch: '',
            blockSearch: ''
        }
    },
    created: function () {
        this.nonSortableRenderingGroups = window.groups.filter(el => (!el.isRenderable || el.isRendering) && !el.isSortable && !el.isTab)
        this.renderingGroups = window.groups.filter(el => (!el.isRenderable || el.isRendering) && el.isSortable && !el.isTab)
        this.blockList = window.groups.filter(el => el.isRenderable && !el.isRendering)
        this.hasRenderable = !!window.groups.find(group => group.isRenderable)
    },
    computed: {
        renderingDragGroup: {
            get () {
                return this.renderingGroups
            },
            set (values) {
                preventPageLeave()
                this.renderingGroups = values.map(el => {
                    el.isRendering = true
                    return el
                })
            }
        },
        blockDragList: {
            get () {
                return this.blockList
            },
            set (values) {
                preventPageLeave()
                this.blockList = values.map(el => {
                    el.isRendering = false
                    return el
                })
            }
        },
        filteredBlockList: function () {
            return this.blockList.filter(block => {
                return block.name.toLowerCase().includes(this.blockSearch)
            })
        },
        filteredRenderList: function () {
            return this.renderingGroups.filter(block => {
                return block.name.toLowerCase().includes(this.renderSearch)
            })
        },
        filteredRenderNonSortList: function () {
            return this.nonSortableRenderingGroups.filter(block => {
                return block.name.toLowerCase().includes(this.renderSearch)
            })
        },
        renderOrder: function () {
            return this.renderingGroups.map(block => block.id).join(',')
        }
    },
    methods: {
        addItem: function (id) {
            const item = this.blockList.find(el => el.id === id)
            if(!item){
                return
            }
            this.blockList = this.blockList.filter(el => el.id !== id)
            this.renderingDragGroup = [...this.renderingGroups, item]
        },
        removeItem: function (id) {
            const item = this.renderingGroups.find(el => el.id === id)
            if(!item){
                return
            }
            this.renderingGroups = this.renderingGroups.filter(el => el.id !== id)
            this.blockDragList = [...this.blockList, item]
        },
        editBlock: function (id) {
            changeTab(`group-${id}`)
        }
    }
}
</script>
