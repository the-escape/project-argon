<template>
    <div class="o-confirm-btn__container" :class="{ 'is-active': confirmDelete }">
        <div class="o-confirm-btn__questions">
            <button class="o-confirm-btn" title="Duplicate" v-on:click="duplicate">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#duplicate"></use>
                </svg>
            </button>
            <button class="o-confirm-btn" title="Delete" v-on:click="toggleConfirmDelete">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#delete"></use>
                </svg>
            </button>
        </div>
        <div class="o-confirm-btn__decline">
            <button class="o-confirm-btn o-confirm-btn--danger" v-on:click="toggleConfirmDelete">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#cross"></use>
                </svg>
            </button>
        </div>
        <div class="o-confirm-btn__accept">
            <button class="o-confirm-btn o-confirm-btn--success" v-on:click="deleteConfirm">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#tick"></use>
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            confirmDelete: false
        }
    },
    methods: {
        toggleConfirmDelete: function() {
            this.confirmDelete = !this.confirmDelete;
        },
        duplicate: function() {
            this.$emit('duplicate')
        },
        deleteConfirm: function() {
            this.$emit('delete')
            this.confirmDelete = false
        }
    }
}
</script>
