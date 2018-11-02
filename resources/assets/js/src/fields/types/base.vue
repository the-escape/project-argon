<template>
    <div class="o-form__group">
        <validation :status-error="errors" :input-name="inputName">
            <label :for="inputName">{{ options.name }}</label>
            <multi :options="options" :values="values">
                <template slot-scope="{ value }">
                    <input-icon :pre-icon="icons.preIcon" :post-icon="icons.postIcon">
                        <input :type="type" :id="inputName" :name="inputName" :value="value">
                    </input-icon>
                </template>
            </multi>
        </validation>
        <div class="o-form__help-text l-full" v-if="helpText" v-html="helpText"></div>
    </div>
</template>

<script>
import InputIcon from './util/input-icon.vue'
import Validation from './util/validation.vue'
import Multi from './util/multi.vue'

export default {
    props: ['options', 'errors', 'helpText', 'values', 'icons', 'type', 'inputName'],
    components: {
        'input-icon': InputIcon,
        'validation': Validation,
        'multi': Multi
    }
}
</script>

