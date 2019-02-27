import moment from 'moment'

export class Folder {
    constructor (
        id,
        name,
        items = [],
        children = [],
        parent = null,
        active = false
    ) {
        this.id = id
        this.name = name
        this.setItems(items)
        this.setChildren(children)
        this.parent = parent
        this.active = active
        this.highlight = false
        this.treeActive = false
        this.treeDragOver = false
        this.dragOver = false
        this.hide = false
        this.editing = false
        this.originalName = name

        if (id === 1) {
            this.treeActive = true
        }
    }

    setChildren (children) {
        let c = []
        for (let child of children) {
            let childF = new Folder(
                child.id,
                child.name,
                child.items,
                child.children,
                this
            )
            c.push(childF)
        }
        this.children = c
    }

    setChildrenItems (children) {
        for (let child of this.children) {
            for (let c of children) {
                if (child.id === c.id) {
                    if (!c.items) {
                        child.items = []
                        break
                    }
                    child.items = c.items.reduce((a, v) => {
                        a.push(new Item(v))
                        return a
                    }, [])
                    break
                }
            }
        }
    }

    setItems (items) {
        this.items = items.reduce((a, v) => {
            a.push(new Item(v))
            return a
        }, [])
    }

    isRoot () {
        return this.id === 1
    }

    isSet () {
        if (this.id) {
            return true
        }
        return false
    }

    hasContent () {
        if (this.children.length) {
            return true
        }
        if (this.items.length) {
            return true
        }
        return false
    }

    breadcrumbs (folder) {
        let pieces = []

        if (!folder) {
            return pieces.concat(this.breadcrumbs(this)).reverse()
        }

        pieces.push(folder)

        if (folder.parent) {
            pieces = pieces.concat(this.breadcrumbs(folder.parent))
        }

        return pieces
    }
}

export function children (folders, parent = null, folderMap = {}) {
    const newFolders = folders.reduce((a, folder) => {
        if (parent === folder.parent) {
            const childFolders = children(folders, folder.id, folderMap)
            folderMap = { ...folderMap, ...childFolders.folderMap }

            let newFolder = new Folder(
                folder.id,
                folder.name,
                folder.items,
                childFolders.newItems,
                folder.parent
            )

            folderMap[newFolder.id] = newFolder
            a.push(newFolder)
        }
        return a
    }, [])
    return {
        newFolders,
        folderMap
    }
}

export function parents (folder, id = null) {
    if (id === null) {
        return null
    }

    if (folder.id === id) {
        return folder
    }

    for (let child of folder.children) {
        if (child.id === id) {
            return child
        }
        let f = parents(child, id)
        if (f) {
            return f
        }
    }
}

export class Item {
    constructor (item) {
        this.highlight = false
        this.dragging = false
        this.hide = false
        this.item = item

        if (item) {
            const date = moment(this.item.updated_at)
            this.item.uploadedDate = `${date.format(
                'DD MMM YYYY'
            )} at ${date.format('HH:mm:ss')}`
        }
    }

    getName () {
        return `${this.item.filename}.${this.item.extension}`
    }

    getUrl () {
        return `/media/${this.item.id}/${this.item.slug}.${this.item.extension}`
    }

    getWidth (suffix = '') {
        return JSON.parse(this.item.meta).width + suffix
    }

    getHeight (suffix = '') {
        return JSON.parse(this.item.meta).height + suffix
    }

    getDimensions (suffix = '') {
        return `${this.getWidth(suffix)} x ${this.getHeight(suffix)}px`
    }

    isSet () {
        if (this.item) {
            return true
        }
        return false
    }

    getBreadcrumbs (folderData) {
        let f = parents(folderData, this.item.folder)
        return f.breadcrumbs()
    }

    getFormattedBreadcrumbs (folderData, glue = ' > ') {
        let breadcrumbs = this.getBreadcrumbs(folderData)

        let trail = breadcrumbs.reduce((a, folder) => {
            a.push(folder.name)
            return a
        }, [])

        return trail.join(glue)
    }
}
