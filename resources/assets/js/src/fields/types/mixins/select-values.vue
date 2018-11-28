<script>
export default {
    computed: {
        options: function() {
            let field
            if(this.comboId){
                field = this.$store.getters.getComboField(this.comboId, this.fieldId)
            }else{
                field = this.$store.getters.getField(this.fieldId)
            }
            const options = field.options.settings.options
            return options.reduce((acc, opt) => {
                for(let key in opt){
                    acc.push({
                        value: key,
                        label: opt[key]
                    })
                }
                return acc
            }, [])
        },
        values: {
            get() {
                let field
                if(this.comboId){
                    const combo = this.$store.getters.getField(this.comboId)
                    const field = this.$store.getters.getComboField(this.comboId, this.fieldId)
                    if(combo && combo.values.length){
                        const values = combo.values.filter(value => value.id === this.comboItemId)

                        if(values.length && values[0][this.fieldId]){
                            if(field.options.settings.multiple){
                                return values[0][this.fieldId].map(value => value.value)
                            }else if(values[0][this.fieldId][0]){
                                return values[0][this.fieldId][0].value
                            }
                        }

                        if(field.options.settings.multiple){
                            return []
                        }
                    }
                }else{
                    field = this.$store.getters.getField(this.fieldId)
                    if(field.options.settings.multiple){
                        return field.values.map(value => value.value)
                    }

                    if(field.values.length){
                        return field.values.map(value => value.value)[0]
                    }
                }

                return ''
            },
            set(values){
                if(!Array.isArray(values)){
                    values = [values]
                }

                const valueObjs = values.map((value, id) => {
                    return {
                        value,
                        id
                    }
                })

                if(this.comboId){
                    this.$store.commit('updateComboFieldValues', {
                        fieldID: this.fieldId,
                        comboID: this.comboId,
                        comboItemId: this.comboItemId,
                        newValues: valueObjs
                    })
                } else {
                    this.$store.commit('updateValues', {
                        fieldID: this.fieldId,
                        newValues: valueObjs
                    })
                }
            }
        }
    },
}
</script>
