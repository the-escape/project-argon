import { fromEvent } from 'rxjs'
import { debounceTime } from 'rxjs/operators'

const Tree = {
    el: null,
    input: null,
    treeContainer: null,
    tree: null,
    id: 0,
    viewItem: _ => {},
    editItem: _ => {},
    addItem: _ => {}
}

let count = 0

export function trees () {
    const treeEls = document.querySelectorAll('.js-tree')
    let trees = Array.from(treeEls)
    trees = trees.map(el => tree(el))
    return trees
}

export function tree (el) {
    const Obj = Object.create(Tree)
    count++
    init.call(Obj, el, count)
    return Obj
}

function init (el, id) {
    if (!el) {
        return
    }

    this.el = el
    this.id = id
    this.input = this.el.querySelector('.js-tree-search')
    this.treeContainer = this.el.querySelector('.js-tree-container')
    this.viewItem = viewItem.bind(this)
    this.editItem = editItem.bind(this)
    this.addItem = addItem.bind(this)

    createTree.call(this)
    setupEvents.call(this)
}

function createTree () {
    this.tree = $(this.treeContainer).jstree({
        plugins: ['contextmenu', 'dnd', 'search', 'state'],
        core: {
            check_callback: (operation, _, nodeParent) =>
                !(operation === 'move_node' && nodeParent.parent === null),
            themes: {
                stripes: true
            }
        },
        contextmenu: {
            items: {
                edit: {
                    _disabled: false,
                    label: 'Edit',
                    title: 'Edit Page',
                    separator_after: true,
                    icon: 'o-tree__icon o-tree__icon--edit',
                    action: this.editItem
                },
                view: {
                    _disabled: false,
                    label: 'View',
                    title: 'View Page',
                    icon: 'o-tree__icon o-tree__icon--view',
                    action: this.viewItem
                },
                add: {
                    _disabled: false,
                    label: 'Add new page',
                    title: 'Add new page beneath',
                    icon: 'o-tree__icon o-tree__icon--view',
                    action: this.addItem
                }
            }
        },
        dnd: {
            copy: false,
            inside_pos: 'last'
        },
        state: {
            key: 'jstree-' + this.id
        }
    })
}

function editItem (data) {
    const obj = this.tree.jstree(true).get_node(data.reference)
    console.log(obj, 'edit page')
}

function viewItem (data) {
    const obj = this.tree.jstree(true).get_node(data.reference)
    console.log(obj, 'view page')
}

function addItem (data) {
    const obj = this.tree.jstree(true).get_node(data.reference)
    console.log(obj, 'add page')
}

function setupEvents () {
    fromEvent(this.input, 'input')
        .pipe(debounceTime(100))
        .subscribe(() => {
            this.tree.jstree(true).search(this.input.value)
        })
}
