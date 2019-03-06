<template>
    <div class="o-confirm-btn__container" :class="{ 'is-active': confirmDelete, 'o-confirm-btn--block': isBlock }">
        <div class="o-confirm-btn__questions">
            <button class="o-confirm-btn" :data-balloon="fadeDelete ? false : 'Delete menu item'" title="Delete" :class="{'o-confirm-btn--fade': fadeDelete}" @click="toggleConfirmDelete($event)">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#delete"></use>
                </svg>
            </button>
            <button class="o-confirm-btn js-add-btn" data-balloon="Add child menu item" title="Add"  @click="add($event)">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#add"></use>
                </svg>
            </button>
            <a :href="viewUrl" target="_blank" data-balloon="Preview url" class="o-confirm-btn" @click="view($event)" :class="{'o-confirm-btn--fade': !viewUrl}" title="view">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#see"></use>
                </svg>
            </a>
        </div>
        <div class="o-confirm-btn__decline">
            <button class="o-confirm-btn o-confirm-btn--danger" @click="toggleConfirmDelete($event)">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#cross"></use>
                </svg>
            </button>
        </div>
        <div class="o-confirm-btn__accept">
            <button class="o-confirm-btn o-confirm-btn--success" @click="deleteConfirm($event)">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#tick"></use>
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'comfirm-btn',
    props: ['hideDuplicate', 'fadeDelete', 'isBlock', 'showAdd', 'viewUrl', 'showView', 'tooltipPostfix','extraAction'],
    data() {
        return {
            confirmDelete: false,
            tooltipPostfixValue: '',
        }
    },
    created() {
        this.tooltipPostfixValue = this.tooltipPostfix || this.tooltipPostfixValue
    },
    methods: {
        toggleConfirmDelete: function(evt) {
            evt.preventDefault()
            if(this.fadeDelete){
                this.$emit('delete')
            }else{
                this.confirmDelete = !this.confirmDelete;
            }
        },
        add: function(evt) {
            evt.preventDefault()
            this.$emit('add')
        },
        view: function(evt) {
            if(!this.viewUrl){
                evt.preventDefault()
                this.$emit('view')
            }
        },
        deleteConfirm: function(evt) {
            evt.preventDefault()
            this.$emit('delete')
            this.confirmDelete = false
        }
    }
}
</script>
