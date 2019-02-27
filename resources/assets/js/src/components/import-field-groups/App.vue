<template>
    <div class="c-actions__container">
        <div class="c-actions__content c-tab-panel__inner-container l-full">

            <div class="o-form">
                <editor></editor>
                <div class="l-halves l-internal-columns c-import-field-groups">
                    <local-blocks></local-blocks>
                    <blocks-library></blocks-library>
                </div>
            </div>

        </div>
        <div class="c-actions c-actions--no-space">
            <div class="c-actions__group">
                <input type="submit" class="o-btn o-btn--sm o-btn--primary js-import" value="Import" @click.prevent="submit">
                <a class="o-btn o-btn--sm" @click="cancel">Cancel</a>
            </div>
        </div>
    </div>
</template>

<script>
import { fromEvent } from 'rxjs'
import { filter } from 'rxjs/operators'
import Editor from './components/Editor.vue'
import BlocksLibrary from './components/BlocksLibrary.vue'
import LocalBlocks from './components/LocalBlocks.vue'

export default {
    components: {
        Editor,
        BlocksLibrary,
        LocalBlocks
    },
    mounted() {

    },
    methods: {
        submit: function(evt) {
            this.$store.commit('importBlock', null)
        },
        cancel: function() {
            return window.location.href = '/admin/types/' + this.$store.state.type.id + '/edit'
        }
    },
    computed: {

    }
}

</script>