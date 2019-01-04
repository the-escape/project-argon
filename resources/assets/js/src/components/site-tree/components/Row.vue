<template>
    <div class="o-table__row" :class="{'o-table__row--children': node.children.length}" @mouseover="mouseOver" @mouseout="mouseOut">
        <div class="o-table__data" @dblclick="edit">{{ node.title }}</div>
        <div class="o-table__data o-table--center"><div class="o-status" :class="{'o-status--active': node.data.status, 'o-status--inactive': !node.data.status}"></div></div>
        <div class="o-table__data o-table--end">
            <comfirm-btn
                hideDuplicate="true"
                showAdd="true"
                showView="true"
                :viewUrl="viewUrl"
                :fade-delete="preventDelete"
                @add="toggleAddForm"
                @delete="deleteItem"
                @view="viewError"
            ></comfirm-btn>
        </div>
        <div class="o-table__data"><a :href="editUrl" class="o-btn o-btn--xs">edit post</a></div>
        <add-form v-if="addFormOpen" :input-name="node.data.id" @add="addItem"></add-form>
    </div>
</template>

<script>
import ComfirmBtn from '../../commonComponents/confirm-btn.vue'
import RowMixin from '../mixins/row.vue'
import AddForm from './addForm.vue'

export default {
    name: 'Row',
    props: ['node', 'treeIndex', 'isDragging'],
    components: {
        ComfirmBtn,
        AddForm
    },
    data() {
        return {
            addFormOpen: false,
            isHovering: true
        }
    },
    mixins: [RowMixin],
    methods: {
        mouseOver: function () {
            let dragging = this.$root.$children[0].$refs.tree.reduce((acc, tree) => {
                if(acc){
                    return acc
                }
                return tree.isDragging
            }, false)

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

