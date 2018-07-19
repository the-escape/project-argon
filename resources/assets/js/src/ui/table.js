import moment from 'moment'
import { tableAction } from './table-actions'

const Table = {
    el: null,
    container: null,
    classes: {
        header: 'o-table__header',
        data: 'o-table__data',
        tableSize: 'o-table--'
    },
    headerEls: [],
    events: [],
    defaultHeaders: ['Actions', ''],
    actionsTemplate: null,
    data: null,
    dataKeys: null
}

export function tables () {
    const tableEls = document.querySelectorAll('.js-table')
    let tables = Array.from(tableEls)
    tables = tables.map(el => table(el))
    return tables
}

export function table (el) {
    const Obj = Object.create(Table)
    init.call(Obj, el)
    return Obj
}

function init (el) {
    if (!el) {
        return
    }

    this.el = el
    this.actionsTemplate = this.el.querySelector('.js-tale-action-template')
    this.actionsTemplate = createTemplate(this.actionsTemplate)
    this.container = this.el.querySelector('.js-table-container')

    this.data = getData.call(this)
    this.dataKeys = Object.keys(this.data.headers).filter(el => el !== 'id')

    setTableSize.call(this)
    parseData.call(this)
    addHeaders.call(this)
    render.call(this)
    console.log(this)
}

function getData () {
    return window.tableData
}

function createTemplate (templateEl) {
    const html = templateEl.innerHTML
    return () => {
        const div = document.createElement('div')
        div.innerHTML = html
        return Array.from(div.children)
    }
}

function setTableSize () {
    this.container.classList.add(this.classes.tableSize + this.dataKeys.length)
}

function addHeaders () {
    const createHeader = text => {
        const header = document.createElement('div')
        header.classList.add(this.classes.header)
        header.innerHTML = text
        this.headerEls.push(header)
    }

    this.dataKeys.forEach(dataKey => {
        createHeader(this.data.headers[dataKey])
    })

    this.defaultHeaders.forEach(header => {
        createHeader(header)
    })
}

function parseData () {
    const types = getTypes(this.dataKeys, this.data.dataTypes)

    this.data.rows = this.data.rows.map(row => {
        const formattedRow = this.dataKeys.reduce((acc, key) => {
            switch (types[key]) {
            case 'boolean':
                if (
                    typeof this.data.formats[key] !== 'undefined' &&
                        (row[key] === 1 || row[key] === 0)
                ) {
                    acc[key] = this.data.formats[key][row[key]]
                } else {
                    acc[key] = row[key]
                }
                return acc
            case 'date':
                if (typeof this.data.formats[key] !== 'undefined') {
                    row[key] = moment(row[key])
                    acc[key] = row[key].format(this.data.formats[key])
                }
                return acc
            default:
                acc[key] = row[key]
                return acc
            }
        }, {})

        const rowDataEls = this.dataKeys.map(key => {
            const rowData = document.createElement('div')
            rowData.classList.add(this.classes.data)
            rowData.innerHTML = formattedRow[key]
            return rowData
        })

        const actionEls = this.actionsTemplate()
        const dataEls = [...rowDataEls, ...actionEls]

        return {
            id: row.id,
            row,
            formattedRow,
            dataEls,
            delete: () => console.log('delete', row.id),
            duplicate: name => console.log('duplicate', row.id, name)
        }
    })
}

function getTypes (keys, types) {
    return keys.reduce((acc, key) => {
        if (typeof types[key] !== 'undefined') {
            acc[key] = types[key]
        } else {
            acc[key] = 'string'
        }
        return acc
    }, {})
}

function render () {
    this.container.innerHTML = ''
    this.headerEls.forEach(el => {
        this.container.appendChild(el)
    })

    this.data.rows.forEach(row => {
        row.dataEls.forEach(el => {
            this.container.appendChild(el)
        })
    })

    addRowEvents.call(this)
}

function addRowEvents () {
    this.events = this.data.rows.map(row => {
        const action = row.dataEls[row.dataEls.length - 3].querySelector(
            '.js-table-actions'
        )
        const dropdown = row.dataEls[row.dataEls.length - 1]

        return tableAction(action, dropdown, row.duplicate, row.delete)
    })
}
