<template>
    <div class="o-table o-table--tree o-table--tree-1 l-full">
        <div class="o-table__headers">
            <div class="o-table__header">Title</div>
            <div class="o-table__header">Actions</div>
            <div class="o-table__header"></div>
        </div>

        <tree v-model="nodes" v-if="nodes && nodes.length" ref="tree" @input="valueChange">
            <template slot="toggle" slot-scope="{ node }">
                <div class="o-table__child-btn o-table__child-btn--tree" :class="{'is-active': node && node.isExpanded}" v-if="node.children && node.children.length">
                    <svg>
                        <use xlink:href="/argon/images/svgicons.svg#select"></use>
                    </svg>
                </div>
            </template>
            <template slot="title" slot-scope="{ node }">
                <row :node="node"></row>
            </template>
        </tree>
    </div>
</template>

<script>
import { fromEvent } from 'rxjs'
import { filter } from 'rxjs/operators'

import Row from './components/Row.vue'
import { Bus } from './util/bus'

export default {
    components: {
        Row
    },
    data() {
        return {
            nodes: [],
            isDragging: false
        }
    },
    created() {
        this.nodes = window.menuJson

        fromEvent(document, 'click')
            .pipe(filter(evt => {
                if(evt.target.classList.contains('js-add-btn')){
                    return false
                }

                let hasParentDropdown = evt.target.closest('.o-table__dropdown-wrap')
                if(!hasParentDropdown){
                    return true
                }
            }))
            .subscribe(() => {
                Bus.$emit('closeAddForm')
            })

        fromEvent(document, 'click')
            .pipe(filter(evt => {
                if(evt.target.classList.contains('js-edit-btn')){
                    return false
                }

                let hasParentDropdown = evt.target.closest('.o-table__dropdown-wrap')
                if(!hasParentDropdown){
                    return true
                }
            }))
            .subscribe(() => {
                Bus.$emit('closeEditForm')
            })
    },
    methods: {
        valueChange(nodes) {
            const menuInputEl = document.querySelector('.js-menu-json')

            menuInputEl.value = JSON.stringify(nodes)
        },
        removeNode(treeIndex, paths){
            if(!paths.length){
                return
            }
            let transverse = this.nodes[treeIndex]
            for(let i = 0; i < paths.length - 1; i++){
                transverse = transverse.children[paths[i]]
            }
            transverse.children.splice(paths[paths.length - 1], 1)
        },
        mouseOver(treeIndex){
            console.log('mouseover')
        }
    }
}

</script>

