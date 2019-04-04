<template>
    <div class="o-form__group">
        <multi :field-id="fieldId" :combo-id="comboId" :combo-item-id="comboItemId" :input-name="inputName">
            <template slot-scope="{ valueObj }">
                <field-location :field-id="fieldId" :combo-id="comboId" :combo-item-id="comboItemId" :value-obj="valueObj" />
            </template>
        </multi>
        <div class="o-form__help-text l-full" v-if="field.helpText" v-html="field.helpText"></div>
    </div>
</template>

<script>
import Validation from '../util/validation.vue'
import Multi from '../util/multi.vue'
import FieldValues from '../mixins/field-values.vue'
import Location from './location.vue'

export default {
    props: ['fieldId', 'comboId', 'comboItemId'],
    mixins: [FieldValues],
    components: {
        'validation': Validation,
        'multi': Multi,
        'field-location': Location
    }
}
</script>
