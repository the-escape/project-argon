import { blockSelect } from './blockSelect'

const { state, mutations, getters } = blockSelect

test('addGroups Mutation groups non sortable groups', () => {
    const groups = [
        {
            id: 'non_sortable_group',
            isRenderable: false,
            isRendering: false,
            isSortable: false,
            name: 'text',
            isTab: false,
            image: ''
        }
    ]

    const testState = Object.assign({}, state)
    mutations.addGroups(testState, { groups })
    expect(testState.nonSortableRenderingGroups).toHaveLength(1)
    expect(testState.nonSortableRenderingGroups[0].id).toBe(
        'non_sortable_group'
    )
})

test('addGroups Mutation groups rendered groups', () => {
    const groups = [
        {
            id: 'rendering_group',
            isRenderable: true,
            isRendering: true,
            isSortable: true,
            name: 'text',
            isTab: false,
            image: ''
        }
    ]

    const testState = Object.assign({}, state)
    mutations.addGroups(testState, { groups })
    expect(testState.renderingGroups).toHaveLength(1)
    expect(testState.renderingGroups[0].id).toBe('rendering_group')
    expect(testState.hasRenderable).toBeTruthy()
})

test('addGroups Mutation groups unrendered groups', () => {
    const groups = [
        {
            id: 'not_rendered_group',
            isRenderable: true,
            isRendering: false,
            isSortable: true,
            name: 'text',
            isTab: false,
            image: ''
        }
    ]

    const testState = Object.assign({}, state)
    mutations.addGroups(testState, { groups })
    expect(testState.blockList).toHaveLength(1)
    expect(testState.blockList[0].id).toBe('not_rendered_group')
})

test('updateRenderingBlockList takes list of groups and sets is rendering to true', () => {
    const blocks = [
        {
            id: 'not_rendered_group',
            isRenderable: true,
            isRendering: false,
            isSortable: true,
            name: 'text',
            isTab: false,
            image: ''
        }
    ]

    const testState = Object.assign({}, state)
    mutations.updateRenderingBlockList(testState, { blocks })
    expect(testState.renderingGroups).toHaveLength(1)
    expect(testState.renderingGroups[0].isRendering).toBeTruthy()
})

test('updateBlockList takes list of groups, and sets is rendering to false', () => {
    const blocks = [
        {
            id: 'rendering_group',
            isRenderable: true,
            isRendering: true,
            isSortable: true,
            name: 'text',
            isTab: false,
            image: ''
        }
    ]

    const testState = Object.assign({}, state)
    mutations.updateBlockList(testState, { blocks })
    expect(testState.blockList).toHaveLength(1)
    expect(testState.blockList[0].isRendering).toBeFalsy()
})

test('addBlockToRendering removes block from blockList and adds it to rendering list, while setting isRendering to true', () => {
    const groups = [
        {
            id: 'not_rendered_group',
            isRenderable: true,
            isRendering: false,
            isSortable: true,
            name: 'text',
            isTab: false,
            image: ''
        }
    ]

    const testState = Object.assign({}, state)
    mutations.addGroups(testState, { groups })
    mutations.addBlockToRendering(testState, { id: groups[0].id })
    expect(testState.blockList).toHaveLength(0)
    expect(testState.renderingGroups).toHaveLength(1)
    expect(testState.renderingGroups[0].isRendering).toBeTruthy()
})

test('removeBlockFromRendering removes block from renderingGroups and adds it to blockList, while setting isRendeing to false', () => {
    const groups = [
        {
            id: 'rendered_group',
            isRenderable: true,
            isRendering: true,
            isSortable: true,
            name: 'text',
            isTab: false,
            image: ''
        }
    ]

    const testState = Object.assign({}, state)
    mutations.addGroups(testState, { groups })
    mutations.removeBlockFromRendering(testState, { id: groups[0].id })
    expect(testState.renderingGroups).toHaveLength(0)
    expect(testState.blockList).toHaveLength(1)
    expect(testState.blockList[0].isRendering).toBeFalsy()
})
