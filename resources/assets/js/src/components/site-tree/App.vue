<template>
<div class="o-table o-table--tree o-table--tree-2 l-full">
    <div class="o-table__headers">
        <div class="o-table__header">Title</div>
        <div class="o-table__header o-table--center">Status</div>
        <div class="o-table__header">Actions</div>
        <div class="o-table__header"></div>
    </div>

    <root-row :data="rootNode" v-for="rootNode in rootNodes" :key="rootNode.pageID">
        <tree :data="rootNode.children" v-if="rootNode.children.length" :indent="45" :space="0" crossTree>
            <template slot-scope="{data, store}">
                <row :data="data" :store="store"></row>
            </template>
        </tree>
    </root-row>
</div>
</template>

<script>
import RootRow from './components/RootRow.vue'
import Row from './components/Row.vue'
import { breadthFirstSearch } from 'tree-helper'

export default {
    components: {
        RootRow,
        Row
    },
    data() {
        return {
            rootNodes: []
        }
    },
    created() {
        this.rootNodes = window.sitemap
    },
    mounted() {
        breadthFirstSearch(this.rootNodes, childNode => {
            childNode.open = false
        })
    },
    methods: {
        drop: function () {
            const sitemapData = this.rootNodes.map(el => {
                el.children = el.children.map(child => this.pure(child, true))
                return el
            })
            console.log(sitemapData)
        },
        pure(node, withChildren, after) {
            const t = Object.assign({}, node)
            delete t._id
            delete t.parent
            delete t.children
            delete t.open
            delete t.active
            delete t.style
            delete t.class
            delete t.innerStyle
            delete t.innerClass
            delete t.innerBackStyle
            delete t.innerBackClass
            for (const key of Object.keys(t)) {
                if (key[0] === '_') {
                delete t[key]
                }
            }
            if (withChildren && node.children) {
                t.children = node.children.slice()
                t.children.forEach((v, k) => {
                t.children[k] = this.pure(v, withChildren)
                })
            }
            if (after) {
                return after(t, node) || t
            }
            return t
        }
    }
}
</script>

