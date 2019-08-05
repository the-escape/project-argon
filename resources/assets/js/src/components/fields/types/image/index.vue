<template>
    <div class="o-form__group">
        <validation :status-error="errors" :input-name="inputName">
            <label :for="inputName + '[alt]'">{{ name }}</label>
            <multi :group-id="groupId" :field-id="fieldId" :combo-id="comboId" :combo-item-id="comboItemId" :input-name="inputName">
                <template slot-scope="{ valueObj }">
                    <field-image :group-id="groupId" :field-id="fieldId" :combo-id="comboId" :combo-item-id="comboItemId" :value-obj="valueObj" />
                </template>
            </multi>
        </validation>
        <div class="o-form__help-text l-full" v-if="field.helpText" v-html="field.helpText"></div>
    </div>
</template>

<script>
import Validation from '../util/validation.vue'
import Multi from '../util/multi.vue'
import FieldValues from '../mixins/field-values.vue'
import Image from './image.vue'

export default {
    props: ['groupId', 'fieldId', 'comboId', 'comboItemId'],
    mixins: [FieldValues],
    components: {
        'validation': Validation,
        'multi': Multi,
        'field-image': Image
    }
}
</script>
