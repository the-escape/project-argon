<template>
    <div class="o-form">
        <editor></editor>
        <div class="l-halves l-internal-columns c-import-field-groups">
            <local-blocks></local-blocks>
            <blocks-library></blocks-library>
        </div>

        <footer class="c-footer__wrapper">
            <div class="c-footer c-container c-footer--fixed">
                <div class="c-footer__container">

                    <div class="c-footer__buttons">
                        <div></div>
                        <div>
                            <a class="o-btn o-btn--sm" @click="cancel">Cancel</a>
                            <input type="submit" class="o-btn o-btn--sm o-btn--primary js-import" value="Import" @click="submit">
                        </div>
                    </div>

                </div>
            </div>
        </footer>
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
        console.log(this.$store.state)
    },
    methods: {
        submit: function(evt) {
            // todo: import data
            console.log('submit...')
        },
        cancel: function() {
            return window.location.href = '/admin/types/' + this.$store.state.type.id + '/edit'
        }
    },
    computed: {

    }
}

</script>