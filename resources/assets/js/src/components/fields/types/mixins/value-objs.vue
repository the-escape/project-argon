<script>
export default {
    computed: {
        valuesVals: function() {
            return this.$store.getters['fields/getValues'](this.groupId, [this.fieldId, this.comboId, this.comboItemId])
        },
        singleValue: function() {
            return this.$store.getters['fields/getSingleValue'](this.groupId, [this.fieldId, this.comboId, this.comboItemId])
        },
        values: {
            get() {
                return this.valuesVals
            },
            set(values) {
                if(this.comboId){
                    this.$store.commit('fields/updateComboFieldValues', {
                        groupID: this.groupId,
                        fieldID: this.fieldId,
                        comboID: this.comboId,
                        comboItemId: this.comboItemId,
                        newValues: values
                    })
                }else{
                    this.$store.commit('fields/updateValues', {
                        groupID: this.groupId,
                        id: this.fieldId,
                        newValues: values
                    })
                }

            }
        }
    }
}
</script>
