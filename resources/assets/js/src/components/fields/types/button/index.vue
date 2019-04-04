<template>
    <div class="o-form__group">
        <multi :field-id="fieldId" :combo-id="comboId" :combo-item-id="comboItemId" :input-name="inputName">
            <template slot-scope="{valueObj}">
                <field-button :value-obj="valueObj" :field-id="fieldId" :combo-id="comboId" :combo-item-id="comboItemId" />
            </template>
        </multi>
        <div class="o-form__help-text l-full" v-if="field.helpText" v-html="field.helpText"></div>
    </div>
</template>

<script>
import Multi from '../util/multi.vue'
import Button from './button.vue'
import FieldValues from '../mixins/field-values.vue'

export default {
    props: ['fieldId', 'comboId', 'comboItemId'],
    mixins: [FieldValues],
    components: {
        'multi': Multi,
        'field-button': Button
    }
}
</script>
