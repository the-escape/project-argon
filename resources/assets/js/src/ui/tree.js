import { fromEvent } from 'rxjs'
import { debounceTime } from 'rxjs/operators'
import { post } from '../util'

const Tree = {
    el: null,
    input: null,
    treeContainer: null,
    tree: null,
    id: 0,
    viewItem: _ => {},
    editItem: _ => {},
    addItem: _ => {},
    deleteItem: _ => {},
    editItemNewTab: _ => {}
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
    this.editItemNewTab = editItemNewTab.bind(this)
    this.addItem = addItem.bind(this)
    this.deleteItem = deleteItem.bind(this)
    this.typesSubMenu = setupTypesSubMenu.call(this)

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
                    icon: 'o-tree__icon o-tree__icon--children',
                    submenu: this.typesSubMenu
                    // action: this.addItem
                },
                remove: {
                    _disabled: function (el) {
                        // TODO TomH please refactor :)
                        return !el.reference.parent()[0].dataset.deletable
                    },
                    label: 'Delete',
                    title: 'Delete Page',
                    icon: 'o-tree__icon o-tree__icon--delete',
                    action: this.deleteItem,
                    separator_before: true
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

    this.tree.on('select_node.jstree', (_, data) => {
        if (data && data.event && data.event.altKey) {
            editItemNewTab(data.node)
        }
    })

    this.tree.on('dblclick.jstree', evt => {
        var node = this.tree.jstree(true).get_node(event.target)
        const id = argon.helpers.getIdFromNodeIdString(node.id)
        window.location.href = argon.root() + '/pages/' + id + '/edit'
    })
}

function editItem (data) {
    const obj = this.tree.jstree(true).get_node(data.reference)
    const id = argon.helpers.getIdFromNodeIdString(obj.id)
    console.log(obj, 'edit page')

    window.location.href = argon.root() + '/pages/' + id + '/edit'
}

function editItemNewTab (node) {
    const id = argon.helpers.getIdFromNodeIdString(node.id)
    console.log(node, 'edit page New Window')

    window.open(argon.root() + '/pages/' + id + '/edit')
}

function viewItem (data) {
    const obj = this.tree.jstree(true).get_node(data.reference)
    const id = argon.helpers.getIdFromNodeIdString(obj.id)
    console.log(obj, 'view page')

    window.open(argon.root() + '/pages/' + id + '/preview', '_blank').focus()
}

function addItem (typeId) {
    return data => {
        const obj = this.tree.jstree(true).get_node(data.reference)
        const id = argon.helpers.getIdFromNodeIdString(obj.id)
        console.log(obj, 'add page')

        window.location.href =
            argon.root() + '/pages/' + id + '/addchild/' + typeId
    }
}

function deleteItem (data) {
    const tree = this.tree.jstree(true)
    const obj = tree.get_node(data.reference)
    const id = argon.helpers.getIdFromNodeIdString(obj.id)
    console.log(obj, 'delete page')

    const token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content')

    if (confirm('Are you sure you want to delete this page?')) {
        post(argon.root() + '/pages/' + id, {
            _token: token,
            _method: 'DELETE'
        })
            .then(data => JSON.parse(data))
            .then(data => {
                if (data.success) {
                    tree.delete_node(obj)
                } else {
                    alert('Page could not be deleted...')
                }
            })
            .catch(error => console.log(error))
    }
}

function setupTypesSubMenu () {
    const typesList = JSON.parse(this.el.dataset.types)

    const typeListKeys = Object.keys(typesList)
    return typeListKeys.reduce((acc, key) => {
        const type = typesList[key]
        acc[type.id] = {
            _disabled: false,
            label: type.name,
            title: 'Create new page of type ' + type.name,
            icon: 'o-tree__icon o-tree__icon--add',
            action: this.addItem(type.id)
        }
        return acc
    }, {})
}

function setupEvents () {
    fromEvent(this.input, 'input')
        .pipe(debounceTime(100))
        .subscribe(() => {
            this.tree.jstree(true).search(this.input.value)
        })
}
