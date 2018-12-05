<template>
    <div class="o-confirm-btn__container" :class="{ 'is-active': confirmDelete, 'o-confirm-btn--block': isBlock }">
        <div class="o-confirm-btn__questions">
            <div class="o-confirm-btn" v-if="hideDuplicate"></div>
            <button class="o-confirm-btn" title="Duplicate" v-if="!hideDuplicate" @click="duplicate($event)">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#duplicate"></use>
                </svg>
            </button>
            <button class="o-confirm-btn" title="Delete" @click="toggleConfirmDelete($event)">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#delete"></use>
                </svg>
            </button>
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
    props: ['hideDuplicate', 'isBlock'],
    data() {
        return {
            confirmDelete: false
        }
    },
    methods: {
        toggleConfirmDelete: function(evt) {
            evt.preventDefault()
            this.confirmDelete = !this.confirmDelete;
        },
        duplicate: function(evt) {
            evt.preventDefault()
            this.$emit('duplicate')
        },
        deleteConfirm: function(evt) {
            evt.preventDefault()
            this.$emit('delete')
            this.confirmDelete = false
        }
    }
}
</script>
