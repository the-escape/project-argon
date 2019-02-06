<template>
<div class="o-table o-table--tree o-table--tree-2 l-full">
    <div class="o-table__headers">
        <div class="o-table__header">Title</div>
        <div class="o-table__header o-table--center">Status</div>
        <div class="o-table__header">Actions</div>
        <div class="o-table__header"></div>
    </div>

    <root-row :node="rootNode" v-for="(rootNode, index) in rootNodes" :key="index">
        <tree v-model="rootNode.children" v-if="rootNode.children.length" ref="tree" @drop="drop">
            <template slot="toggle" slot-scope="{ node }">
                <div class="o-table__child-btn o-table__child-btn--tree" :class="{'is-active': node.isExpanded}" v-if="node.children && node.children.length">
                    <svg>
                        <use xlink:href="/argon/images/svgicons.svg#select"></use>
                    </svg>
                </div>
            </template>
            <template slot="title" slot-scope="{ node }">
                <row :node="node" :tree-index="index"></row>
            </template>
        </tree>
    </root-row>
</div>
</template>

<script>
import { fromEvent } from 'rxjs'
import { filter } from 'rxjs/operators'

import RootRow from './components/RootRow.vue'
import Row from './components/Row.vue'
import { Bus } from './util/bus'

export default {
    components: {
        RootRow,
        Row
    },
    data() {
        return {
            rootNodes: [],
            isDragging: false
        }
    },
    created() {
        this.rootNodes = window.sitemap
        breadthFirstSearch(this.rootNodes, childNode => {
            childNode.isExpanded = false
        })

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
    },
    methods: {
        drop: function (node, position) {
            console.log(node[0].title, position.placement, position.node.title)
        },
        removeNode(treeIndex, paths){
            if(!paths.length){
                return
            }
            let transverse = this.rootNodes[treeIndex]
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

function breadthFirstSearch(obj, handler, childrenKey = 'children', reverse) {
    const rootChildren = Array.isArray(obj) ? obj : [obj]
    let stack = rootChildren.map((v, i) => ({item: v, index: i}))
    if (reverse) {
        stack.reverse()
    }
    while (stack.length) {
        const {item, index, parent} = stack.shift()
        const r = handler(item, index, parent)
        if (r === false) {
            // stop
            return
        } else if (r === 'skip children') {
            continue
        } else if (r === 'skip siblings') {
            stack = stack.filter(v => v.parent !== parent)
        }
        if (item.children) {
            let children = item.children
            if (reverse) {
                children = children.slice()
                children.reverse()
            }
            const pushStack = children.map((v, i) => ({item: v, index: i, parent: item}))
            stack.push(...pushStack)
        }
    }
}
</script>

