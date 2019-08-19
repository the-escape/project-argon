import {
    blockSelect
} from './blockSelect'

const {
    state,
    mutations,
    getters
} = blockSelect

test('addGroups Mutation groups non sortable groups', () => {
    const groups = [{
        id: 'non_sortable_group',
        isRenderable: false,
        isRendering: false,
        isSortable: false,
        name: 'text',
        isTab: false,
        image: ''
    }]

    const testState = Object.assign({}, state)
    mutations.addGroups(testState, {
        groups
    })
    expect(testState.nonSortableRenderingGroups).toHaveLength(1)
    expect(testState.nonSortableRenderingGroups[0].id).toBe(
        'non_sortable_group'
    )
})

test('addGroups Mutation groups rendered groups', () => {
    const groups = [{
        id: 'rendering_group',
        isRenderable: true,
        isRendering: true,
        isSortable: true,
        name: 'text',
        isTab: false,
        image: ''
    }]

    const testState = Object.assign({}, state)
    mutations.addGroups(testState, {
        groups
    })
    expect(testState.renderingGroups).toHaveLength(1)
    expect(testState.renderingGroups[0].id).toBe('rendering_group')
    expect(testState.hasRenderable).toBeTruthy()
})

test('addGroups Mutation groups unrendered groups', () => {
    const groups = [{
        id: 'not_rendered_group',
        isRenderable: true,
        isRendering: false,
        isSortable: true,
        name: 'text',
        isTab: false,
        image: ''
    }]

    const testState = Object.assign({}, state)
    mutations.addGroups(testState, {
        groups
    })
    expect(testState.blockList).toHaveLength(1)
    expect(testState.blockList[0].id).toBe('not_rendered_group')
})

test('updateRenderingBlockList takes list of groups and sets is rendering to true', () => {
    const blocks = [{
        id: 'not_rendered_group',
        isRenderable: true,
        isRendering: false,
        isSortable: true,
        name: 'text',
        isTab: false,
        image: ''
    }]

    const testState = Object.assign({}, state)
    mutations.updateRenderingBlockList(testState, {
        blocks
    })
    expect(testState.renderingGroups).toHaveLength(1)
    expect(testState.renderingGroups[0].isRendering).toBeTruthy()
})

test('updateBlockList takes list of groups, and sets is rendering to false', () => {
    const blocks = [{
        id: 'rendering_group',
        isRenderable: true,
        isRendering: true,
        isSortable: true,
        name: 'text',
        isTab: false,
        image: ''
    }]

    const testState = Object.assign({}, state)
    mutations.updateBlockList(testState, {
        blocks
    })
    expect(testState.blockList).toHaveLength(1)
    expect(testState.blockList[0].isRendering).toBeFalsy()
})

test('addBlockToRendering removes block from blockList and adds it to rendering list, while setting isRendering to true', () => {
    const groups = [{
        id: 'not_rendered_group',
        isRenderable: true,
        isRendering: false,
        isSortable: true,
        name: 'text',
        isTab: false,
        image: ''
    }]

    const testState = Object.assign({}, state)
    mutations.addGroups(testState, {
        groups
    })
    mutations.addBlockToRendering(testState, {
        id: groups[0].id
    })
    expect(testState.blockList).toHaveLength(0)
    expect(testState.renderingGroups).toHaveLength(1)
    expect(testState.renderingGroups[0].isRendering).toBeTruthy()
})

test('removeBlockFromRendering removes block from renderingGroups and adds it to blockList, while setting isRendeing to false', () => {
    const groups = [{
        id: 'rendered_group',
        isRenderable: true,
        isRendering: true,
        isSortable: true,
        name: 'text',
        isTab: false,
        image: ''
    }]

    const testState = Object.assign({}, state)
    mutations.addGroups(testState, {
        groups
    })
    mutations.removeBlockFromRendering(testState, {
        id: groups[0].id
    })
    expect(testState.renderingGroups).toHaveLength(0)
    expect(testState.blockList).toHaveLength(1)
    expect(testState.blockList[0].isRendering).toBeFalsy()
})

test('FilterRenderList, renderSearch string empty', () => {
    const groups = [{
            id: 'rendered_group',
            isRenderable: true,
            isRendering: true,
            isSortable: true,
            name: 'text',
            isTab: false,
            image: ''
        },
        {
            id: 'rendered_group',
            isRenderable: true,
            isRendering: true,
            isSortable: true,
            name: 'text 2',
            isTab: false,
            image: ''
        }
    ]

    const testState = Object.assign({}, state)
    mutations.addGroups(testState, {
        groups
    })
    mutations.setRenderSearch(testState, {
        searchString: ''
    })
    const filteredList = getters.filteredRenderList(testState)
    expect(filteredList).toHaveLength(2)
})

test('FilterRenderList, searchString matches one group', () => {
    const groups = [{
            id: 'rendered_group',
            isRenderable: true,
            isRendering: true,
            isSortable: true,
            name: 'text',
            isTab: false,
            image: ''
        },
        {
            id: 'rendered_group',
            isRenderable: true,
            isRendering: true,
            isSortable: true,
            name: 'text 2',
            isTab: false,
            image: ''
        }
    ]

    const testState = Object.assign({}, state)
    mutations.addGroups(testState, {
        groups
    })
    mutations.setRenderSearch(testState, {
        searchString: '2'
    })
    const filteredList = getters.filteredRenderList(testState)
    expect(filteredList).toHaveLength(1)
})

test('FilterRenderList, searchString matches no groups', () => {
    const groups = [{
            id: 'rendered_group',
            isRenderable: true,
            isRendering: true,
            isSortable: true,
            name: 'text',
            isTab: false,
            image: ''
        },
        {
            id: 'rendered_group',
            isRenderable: true,
            isRendering: true,
            isSortable: true,
            name: 'text 2',
            isTab: false,
            image: ''
        }
    ]

    const testState = Object.assign({}, state)
    mutations.addGroups(testState, {
        groups
    })
    mutations.setRenderSearch(testState, {
        searchString: 'test'
    })
    const filteredList = getters.filteredRenderList(testState)
    expect(filteredList).toHaveLength(0)
})

test('filteredBlockList, renderSearch string empty', () => {
    const groups = [{
            id: 'non_rendered_group',
            isRenderable: true,
            isRendering: false,
            isSortable: true,
            name: 'text',
            isTab: false,
            image: ''
        },
        {
            id: 'non_rendered_group',
            isRenderable: true,
            isRendering: false,
            isSortable: true,
            name: 'text 2',
            isTab: false,
            image: ''
        }
    ]

    const testState = Object.assign({}, state)
    mutations.addGroups(testState, {
        groups
    })
    mutations.setBlockSearch(testState, {
        searchString: ''
    })
    const filteredList = getters.filteredBlockList(testState)
    expect(filteredList).toHaveLength(2)
})

test('filteredBlockList, searchString matches one group', () => {
    const groups = [{
            id: 'non_rendered_group',
            isRenderable: true,
            isRendering: false,
            isSortable: true,
            name: 'text',
            isTab: false,
            image: ''
        },
        {
            id: 'non_rendered_group',
            isRenderable: true,
            isRendering: false,
            isSortable: true,
            name: 'text 2',
            isTab: false,
            image: ''
        }
    ]

    const testState = Object.assign({}, state)
    mutations.addGroups(testState, {
        groups
    })
    mutations.setBlockSearch(testState, {
        searchString: '2'
    })
    const filteredList = getters.filteredBlockList(testState)
    expect(filteredList).toHaveLength(1)
})

test('filteredBlockList, searchString matches no groups', () => {
    const groups = [{
            id: 'non_rendered_group',
            isRenderable: true,
            isRendering: false,
            isSortable: true,
            name: 'text',
            isTab: false,
            image: ''
        },
        {
            id: 'non_rendered_group',
            isRenderable: true,
            isRendering: false,
            isSortable: true,
            name: 'text 2',
            isTab: false,
            image: ''
        }
    ]

    const testState = Object.assign({}, state)
    mutations.addGroups(testState, {
        groups
    })
    mutations.setBlockSearch(testState, {
        searchString: 'test'
    })
    const filteredList = getters.filteredBlockList(testState)
    expect(filteredList).toHaveLength(0)
})

test('renderOrder create a string of rendered groups', () => {
    const groups = [{
            id: '1',
            isRenderable: true,
            isRendering: true,
            isSortable: true,
            name: 'text',
            isTab: false,
            image: ''
        },
        {
            id: '2',
            isRenderable: true,
            isRendering: false,
            isSortable: true,
            name: 'text 2',
            isTab: false,
            image: ''
        },
        {
            id: '3',
            isRenderable: true,
            isRendering: true,
            isSortable: true,
            name: 'text',
            isTab: false,
            image: ''
        },
    ]

    const testState = Object.assign({}, state)
    mutations.addGroups(testState, {
        groups
    })
    const renderOrder = getters.renderOrder(testState)
    expect(renderOrder).toBe('1,3')
})
