<template>
    <div class="o-confirm-btn__container" :class="{ 'is-active': confirmDelete, 'o-confirm-btn--block': isBlock }">
        <div class="o-confirm-btn__questions">
            <div class="o-confirm-btn" v-if="hideDuplicate && !showAdd"></div>
            <button class="o-confirm-btn" :data-balloon="'Duplicate' + tooltipPostfixValue" title="Duplicate" v-if="!hideDuplicate" @click="duplicate($event)">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#duplicate"></use>
                </svg>
            </button>
            <button class="o-confirm-btn" :data-balloon="fadeDelete ? false : 'Delete' + tooltipPostfixValue" title="Delete" :class="{'o-confirm-btn--fade': fadeDelete}" @click="toggleConfirmDelete($event)">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#delete"></use>
                </svg>
            </button>
            <button class="o-confirm-btn js-add-btn" :data-balloon="'Add' + tooltipPostfixValue" title="Add" v-if="showAdd" @click="add($event)">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#add"></use>
                </svg>
            </button>
            <a :href="viewUrl" target="_blank" :data-balloon="'View' + tooltipPostfixValue" class="o-confirm-btn" @click="view($event)" :class="{'o-confirm-btn--fade': !viewUrl}" v-if="showView" title="view">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#see"></use>
                </svg>
            </a>
            <a v-for="(extraAction, index) in extraActions" :key="index" :href="extraAction.url" :data-balloon="extraAction.label" class="o-confirm-btn" :title="extraAction.label" :target="extraActions.target">
                <svg>
                    <use :xlink:href="extraAction.icon"></use>
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
    props: ['hideDuplicate', 'fadeDelete', 'isBlock', 'showAdd', 'viewUrl', 'showView', 'tooltipPostfix','extraActions'],
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
        duplicate: function(evt) {
            evt.preventDefault()
            this.$emit('duplicate')
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
