<template>
    <div class="o-table__row">
        <button class="o-table__child-btn" v-if="node.children.length" :class="{'is-active': isOpen}" @click="toggleOpen">
            <svg>
                <use xlink:href="/argon/images/svgicons.svg#select"></use>
            </svg>
        </button>
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

        <div class="o-table__children">
            <slot v-if="isOpen"></slot>
        </div>
    </div>
</template>

<script>
import ComfirmBtn from '../../commonComponents/confirm-btn.vue'
import RowMixin from '../mixins/row.vue'
import AddForm from './addForm.vue'

export default {
    name: 'root-row',
    props: ['node'],
    components: {
        ComfirmBtn,
        AddForm
    },
    mixins: [RowMixin],
    data() {
        return {
            isOpen: true,
            addFormOpen: false
        }
    },
    methods: {
        toggleOpen() {
            this.isOpen = !this.isOpen
        }
    }
}
</script>
