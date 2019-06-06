<template>
<div class="o-table o-table--tree o-table--tree-2 l-full c-sitetree-overlay__container">
    <div class="o-table__headers">
        <div class="o-table__header">Title</div>
        <div class="o-table__header o-table--center">Status</div>
        <div class="o-table__header">Actions</div>
        <div class="o-table__header"></div>
    </div>

    <root-row :node="rootNode" v-for="(rootNode, index) in rootNodes" :key="index">
        <tree v-model="rootNode.children" v-if="rootNode.children.length" ref="tree" @drop="drop" @toggle="toggle">
            <template slot="toggle" slot-scope="{ node }">
                <div class="o-table__child-btn o-table__child-btn--tree" :class="{'is-active': node.isExpanded}" v-if="node.children && node.children.length">
                    <svg>
                        <use xlink:href="/argon/images/svgicons.svg#select"></use>
                    </svg>
                </div>
            </template>
            <template slot="title" slot-scope="{ node }">
                <row :node="node" :tree-index="index" :is-highlight="highlightedNodes[node.pathStr]" :is-error="errorNodes[node.pathStr]"></row>
            </template>
        </tree>
    </root-row>

    <div class="c-sitetree-overlay" :class="{ 'is-active': overlayActive }">
        <div class="c-sitetree-overlay__message typography">
            <h1>Please wait</h1>
            <p>We are moving your page(s)</p>
        </div>
        <div class="c-sitetree-overlay__spinner">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64">
                <g stroke-linecap="square" stroke-width="2" fill="none" stroke="currentColor" stroke-miterlimit="10">
                    <circle cx="32" cy="32" r="30" opacity=".4"/>
                    <path d="M32 2a30 30 0 0 1 30 30" data-color="color-2" stroke-linecap="butt"/>
                </g>
            </svg>
        </div>
    </div>

    <ConfirmModal :options="confirmOptions" />
</div>
</template>

<script>
import { fromEvent } from 'rxjs'
import { filter } from 'rxjs/operators'

import RootRow from './components/RootRow.vue'
import Row from './components/Row.vue'
import ConfirmModal from './components/confirmModal.vue'
import { Bus } from './util/bus'

import Noty from 'noty'
import { post } from '../../util'
import { relative } from 'path';
import { setTimeout } from 'timers';

export default {
    components: {
        RootRow,
        Row,
        ConfirmModal
    },
    data() {
        return {
            rootNodes: [],
            highlightedNodes: {},
            errorNodes: {},
            cloneNodes: [],
            isDragging: false,
            overlayActive: false,
            confirmOptions: {
                isOpen: false,
                title: '',
                message: '',
                rej: _ => {},
                res: _ => {}
            }
        }
    },
    created() {
        this.rootNodes = window.sitemap
        breadthFirstSearch(this.rootNodes, childNode => {
            childNode.isExpanded = false
            childNode.data.isHighlighted = false
            childNode.data.isError = false
        })
        this.cloneNodes = JSON.parse(JSON.stringify(this.rootNodes))

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
        closeConfirm() {
            this.confirmOptions.isOpen = false
            this.confirmOptions.title = ''
            this.confirmOptions.message = ''
            this.confirmOptions.rej = _ => {}
            this.confirmOptions.res = _ => {}
        },
        confirm(title, message) {
            return new Promise((res, rej) => {
                this.confirmOptions.isOpen = true
                this.confirmOptions.title = title
                this.confirmOptions.message = message
                this.confirmOptions.rej = () => {
                    rej()
                    this.closeConfirm()
                }
                this.confirmOptions.res = () => {
                    res()
                    this.closeConfirm()
                }
            })
        },
        toggle: function () {
            this.cloneNodes = JSON.parse(JSON.stringify(this.rootNodes))
        },
        drop: function (node, position) {

            this.overlayActive = true

            const pageId = node[0].data.id
            const otherId = position.node.data.id
            const relation = position.placement

            let newPath = position.node.path
            const nodePath = node[0].path
            const posPath = position.node.path

            if(nodePath.length === posPath.length && nodePath[nodePath.length - 1] < posPath[posPath.length - 1]){
                newPath[newPath.length - 1] -= 1
            }

            if(relation === 'inside') {
                newPath.push(0)
            }else if(nodePath.length < posPath.length && nodePath[nodePath.length - 1] < posPath[nodePath.length - 1]){
                newPath[nodePath.length - 1] -= 1;
            }

            if(relation === 'after') {
                newPath[newPath.length - 1] += 1
            }

            let isMovingParent = nodePath[nodePath.length - 2] !== posPath[posPath.length - 2]
            let isMovingDepth = nodePath.length !== posPath.length
            let hasChildren = node[0].children.length

            let showConfirm = ((!isMovingDepth && isMovingParent) || isMovingDepth) && hasChildren

            const commitChange = () => {
                const pageName = node[0].title

                const url = '/pages/'+pageId+'/move/'+otherId+'/'+relation
                const token = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')

                post(argon.root() + url, {
                        _token: token,
                        _method: 'GET'
                    })
                        .then(data => JSON.parse(data))
                        .then(data => {
                            if (data.success) {
                                new Noty({
                                    layout: 'topCenter',
                                    text: 'Successfully moved ' + pageName,
                                    type: 'success',
                                    timeout: 3500
                                }).show()

                                this.highlightNode(newPath, true)
                            } else {
                                new Noty({
                                    layout: 'topCenter',
                                    text: 'An error occured when moving: ' + pageName,
                                    type: 'error',
                                    timeout: 3500
                                }).show()

                                this.rootNodes = this.cloneNodes
                                this.highlightNode(nodePath, false)
                            }

                            this.$nextTick(() => {
                                this.overlayActive = false
                                this.cloneNodes = JSON.parse(JSON.stringify(this.rootNodes))
                            })
                        })
                        .catch(error => console.log(error))
            }

            if(showConfirm){
                this.confirm(
                        'Warning',
                        'This change might take a while to complete and is potentially dangerous, do you want to continue?'
                    )
                    .then(() => {
                        commitChange()
                    })
                    .catch(() => {
                        this.rootNodes = this.cloneNodes
                        this.highlightNode(nodePath, false)

                        this.$nextTick(() => {
                            this.overlayActive = false
                            this.cloneNodes = JSON.parse(JSON.stringify(this.rootNodes))
                        })
                    })
            } else {
                commitChange()
            }

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
        highlightNode(path, isSuccess, timeout = 1500){
            const exspandParents = function (node, [nextIndex, ...indexes]){
                if(!indexes.length){
                    return
                }
                const nextNode = node.children[nextIndex]
                nextNode.isExpanded = true
                exspandParents(nextNode, indexes, isSuccess)
            }

            const pathName = `[${path}]`

            this.$nextTick(() => {
                exspandParents(this.rootNodes[0], path)
                if(isSuccess){
                    this.highlightedNodes[pathName] = true
                }else{
                    this.errorNodes[pathName] = true
                }
            })

            setTimeout(() => {
                this.$nextTick(() => {
                    this.highlightedNodes[pathName] = false
                    this.errorNodes[pathName] = false
                })
            }, timeout)
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

