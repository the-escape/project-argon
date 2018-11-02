<template>
    <div>
        <div class="o-multi" v-if="options.settings.multiple">
            <div class="o-multi__track">
                <div class="o-multi__item" v-for="value in multiValues" :key="value.id">
                    <div class="o-multi__item-wrap">
                        <button class="o-multi__drag-handle">
                            <div class="o-multi__drag-wrap">
                                <svg>
                                    <use xlink:href="/argon/images/svgicons.svg#reorder"></use>
                                </svg>
                            </div>
                        </button>

                        <slot :value="value.value"></slot>

                        <div class="o-multi__actions">
                            <confirm-btn v-on:delete="deleteValue(value.id)" v-on:duplicate="duplicateValue(value.id)"></confirm-btn>
                        </div>
                    </div>
                </div>
            </div>
            <div class="o-multi__foot">
                <button v-on:click="addValue" class="o-btn o-btn--sm">Add</button>
            </div>
        </div>
        <template v-if="!options.settings.multiple">
            <slot :value="values[0]"></slot>
        </template>
    </div>
</template>

<script>
import ConfirmBtn from './confirm-btn.vue'

export default {
    components:{
        'confirm-btn': ConfirmBtn
    },
    props: ['options', 'values'],
    methods: {
        addValue: function (){
            this.values.push('')
        },
        deleteValue: function(index) {
            this.values.splice(index, 1)
        },
        duplicateValue: function(index) {
            const val = this.values[index]
            let duplicateVal
            if(typeof val === 'object'){
                duplicateVal = Object.assign({}, val)
            }else{
                duplicateVal = val
            }

            this.values.push(duplicateVal)
        }
    },
    computed: {
        multiValues: function () {
            return this.values.map((value, id) => ({
                value,
                id
            }))
        }
    }
}
</script>
