<template>
    <div class="o-table__row" :class="{'o-table__row--children': node.children.length}" @mouseover="mouseOver" @mouseout="mouseOut">
        <div class="o-table__data">{{ node.data.label }}</div>
        <div class="o-table__data o-table--end">
            <row-actions
                :viewUrl="viewUrl"
                :fade-delete="preventDelete"
                @add="toggleAddForm"
                @delete="deleteItem"
                tooltipPostfix=" menu item"
            ></row-actions>
        </div>
        <div class="o-table__data"><span data-balloon="Edit menu item"><button class="js-edit-btn o-btn o-btn--xs" @click="toggleEditForm($event)">Edit</button></span></div>
        <edit-form v-if="addFormOpen" @add="addItem"></edit-form>
        <edit-form v-if="editFormOpen" @edit="editItem" :node="node"></edit-form>
    </div>
</template>

<script>
import RowActions from './rowActions.vue'
import RowMixin from '../mixins/row.vue'
import EditForm from './editForm.vue'

export default {
    name: 'Row',
    props: ['node', 'treeIndex', 'isDragging'],
    components: {
        RowActions,
        EditForm
    },
    data() {
        return {
            addFormOpen: false,
            editFormOpen: false,
            isHovering: true
        }
    },
    mixins: [RowMixin],
    methods: {
        mouseOver: function () {
            let dragging = this.$root.$children[0].$refs.tree.isDragging

            if(!dragging){
                return
            }

            if(!this.isHovering){
                this.isHovering = true

                setTimeout(() => {
                    if(!this.node.isExpanded && this.isHovering){
                        this.$set(this.node, 'isExpanded', true)
                    }
                }, 300)
            }
        },
        mouseOut: function () {
            this.isHovering = false
        }
    }
}
</script>

