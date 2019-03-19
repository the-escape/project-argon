<script>
export default {
    computed: {
        singleValue: function() {
            if(this.comboId){
                const comboField = this.$store.getters.getField(this.comboId)
                if(comboField && comboField.values.length){
                    const values = comboField.values.filter(value => value.id === this.comboItemId)
                    if(values.length && values[0][this.fieldId] && values[0][this.fieldId][0]){
                        return values[0][this.fieldId][0]
                    } else {
                        return {
                            id: 0
                        }
                    }
                }
            }

            const field = this.$store.getters.getField(this.fieldId)
            if(field && field.values[0]){
                return field.values[0]
            }
        },
        values: {
            get() {
                if(this.comboId){
                    const comboField = this.$store.getters.getField(this.comboId)
                    if(comboField && comboField.values.length){
                        const values = comboField.values.filter(value => value.id === this.comboItemId)
                        if(values.length && values[0][this.fieldId]){
                            return values[0][this.fieldId]
                        } else {
                            return [{
                                id: 0
                            }]
                        }
                    }
                }

                const field = this.$store.getters.getField(this.fieldId)
                if(field){
                    return field.values
                }
                return []
            },
            set(values) {
                if(this.comboId){
                    this.$store.commit('updateComboFieldValues', {
                        fieldID: this.fieldId,
                        comboID: this.comboId,
                        comboItemId: this.comboItemId,
                        newValues: values
                    })
                }else{
                    this.$store.commit('updateValues', {
                        fieldID: this.fieldId,
                        comboID: this.comboId,
                        comboItemId: this.comboItemId,
                        newValues: values
                    })
                }

            }
        }
    }
}
</script>
