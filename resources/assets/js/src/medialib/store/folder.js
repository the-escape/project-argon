export class Folder {

    constructor(id, name, items=[], children=[], parent=null, active=false) {
        this.id = id
        this.name = name
        // this.items = items
        this.setItems(items)
        this.children = children
        this.setChildren(children)
        this.parent = parent
        this.active = active
    }

    setChildren(children) {
        let c = [];
        for (let child of children) {
            let childF = new Folder(child.id, child.name, child.items, child.children, this)
            c.push(childF)
        }
        this.children = c
    }

    setChildrenItems(children) {
        for (let child of this.children) {
            for (let c of children) {
                if (child.id === c.id) {
                    if (!c.items) {
                        child.items = []
                        break;
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

    setItems(items) {
        this.items = items.reduce((a, v) => {
            a.push(new Item(v))
            return a
        }, [])

    }

    isRoot() {
        return this.id === 1
    }

    isSet() {
        if (this.id) {
            return true
        }
        return false
    }

    hasContent() {
        if (this.children.length) {
            return true
        }
        if (this.items.length) {
            return true
        }
        return false
    }

    breadcrumbs(folder) {
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

// export function children(items, parent=null) {
//     let t = []
//
//     for (let item of items) {
//         if (parent === item.parent) {
//             let f = new Folder(item.id, item.name, item.items, children(items, item.id), parents(items, item.parent))
//             t.push(f)
//         }
//     }
//     return t
// }

export function children(items, parent=null) {
    let t = []

    for (let [id, item] of Object.entries(items)){
        if (parent === item.parent) {
            let f = new Folder(item.id, item.name, item.items, children(items, item.id), item.parent)
            t.push(f)
        }
    }
    return t
}


export function parents(items, id=null) {
    if (id === null) {
        return null
    }

    let p = items[id]

    return new Folder(p.id, p.name, p.items, p.children, parents(items, p.parent))
}



export class Item {
    constructor(item) {
        this.item = item
    }

    getName() {
        return `${this.item.filename}.${this.item.extension}`
    }

    getUrl() {
        return `/media/${this.item.id}/${this.item.slug}.${this.item.extension}`
    }

    getWidth(suffix='') {
        return JSON.parse(this.item.meta).width + suffix
    }

    getHeight(suffix='') {
        return JSON.parse(this.item.meta).height + suffix
    }

    getDimensions(suffix='') {
        return `${this.getWidth(suffix)} x ${this.getHeight(suffix)}`
    }

    isSet() {
        if (this.item) {
            return true
        }
        return false
    }
}
