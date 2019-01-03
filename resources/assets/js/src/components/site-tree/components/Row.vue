<template>
    <div class="o-table__row">
        <template v-if="!data.isDragPlaceHolder">
            <button class="o-table__child-btn" :class="{'is-active': data.open}" v-if="data.children && data.children.length" @click="store.toggleOpen(data)">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#select"></use>
                </svg>
            </button>
            <div class="o-table__data" @dblclick="edit">{{ data.title }}</div>
            <div class="o-table__data o-table--center"><div class="o-status" :class="{'o-status--active': data.status, 'o-status--inactive': !data.status}"></div></div>
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
            <add-form v-if="addFormOpen" :input-name="data.id" @add="addItem"></add-form>
        </template>
    </div>
</template>

<script>
import ComfirmBtn from '../../commonComponents/confirm-btn.vue'
import RowMixin from '../mixins/row.vue'
import AddForm from './addForm.vue'

export default {
    name: 'Row',
    props: ['data', 'store'],
    components: {
        ComfirmBtn,
        AddForm
    },
    data() {
        return {
            addFormOpen: false
        }
    },
    mixins: [RowMixin]
}
</script>

